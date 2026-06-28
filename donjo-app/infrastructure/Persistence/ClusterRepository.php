<?php

declare(strict_types=1);

namespace Donjo\Infrastructure\Persistence;

use Donjo\Domain\Entities\Cluster;
use Donjo\Domain\Repositories\ClusterRepositoryInterface;

final class ClusterRepository implements ClusterRepositoryInterface
{
    private $db;

    private const TABLE = 'tweb_wil_clusterdesa';

    public function __construct($db)
    {
        $this->db = $db;
    }

    /** @inheritDoc */
    public function find($id)
    {
        return $this->findById((int) $id);
    }

    /** @inheritDoc */
    public function findById(int $id): ?Cluster
    {
        $row = $this->db->where('id', $id)->get(self::TABLE)->row_array();
        return $row ? $this->hydrate($row) : null;
    }

    /** @inheritDoc */
    public function findAll(): array
    {
        $rows = $this->db->get(self::TABLE)->result_array();
        return array_map([$this, 'hydrate'], $rows);
    }

    /** @inheritDoc */
    public function findAllDusun(): array
    {
        $rows = $this->db
            ->where('rt', '0')
            ->where('rw', '0')
            ->get(self::TABLE)
            ->result_array();
        return array_map([$this, 'hydrate'], $rows);
    }

    /** @inheritDoc */
    public function findRwByDusun(string $dusun): array
    {
        $rows = $this->db
            ->where('dusun', $dusun)
            ->where('rt', '0')
            ->where('rw !=', '0')
            ->get(self::TABLE)
            ->result_array();
        return array_map([$this, 'hydrate'], $rows);
    }

    /** @inheritDoc */
    public function findRtByRw(string $dusun, string $rw): array
    {
        $rows = $this->db
            ->where('dusun', $dusun)
            ->where('rw', $rw)
            ->where('rt !=', '0')
            ->get(self::TABLE)
            ->result_array();
        return array_map([$this, 'hydrate'], $rows);
    }

    /** @inheritDoc */
    public function save(Cluster $cluster): Cluster
    {
        $data = [
            'rt'        => $cluster->rt,
            'rw'        => $cluster->rw,
            'dusun'     => $cluster->dusun,
            'id_kepala' => $cluster->idKepala,
            'lat'       => $cluster->lat,
            'lng'       => $cluster->lng,
            'zoom'      => $cluster->zoom,
            'path'      => $cluster->path,
            'map_tipe'  => $cluster->mapTipe,
        ];

        if ($cluster->id !== null) {
            $this->db->where('id', $cluster->id)->update(self::TABLE, $data);
            return $cluster;
        }

        $this->db->insert(self::TABLE, $data);
        $cluster->id = (int) $this->db->insert_id();
        return $cluster;
    }

    /** @inheritDoc */
    public function delete(int $id): bool
    {
        return $this->db->where('id', $id)->delete(self::TABLE) !== false;
    }

    private function hydrate(array $row): Cluster
    {
        return new Cluster($row);
    }
}
 
