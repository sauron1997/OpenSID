<?php

declare(strict_types=1);

namespace Donjo\Infrastructure\Persistence;

use Donjo\Domain\Entities\Keluarga;
use Donjo\Domain\Repositories\KeluargaRepositoryInterface;
use Donjo\Domain\ValueObjects\NIK;
use Donjo\Domain\ValueObjects\NomorKK;

final class KeluargaRepository implements KeluargaRepositoryInterface
{
    private $db;

    private const TABLE = 'tweb_keluarga';

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
    public function findById(int $id): ?Keluarga
    {
        $row = $this->db->where('id', $id)->get(self::TABLE)->row_array();
        return $row ? $this->hydrate($row) : null;
    }

    /** @inheritDoc */
    public function findByNomorKk(NomorKK $noKk): ?Keluarga
    {
        $row = $this->db->where('no_kk', $noKk->getValue())->get(self::TABLE)->row_array();
        return $row ? $this->hydrate($row) : null;
    }

    /** @inheritDoc */
    public function findByNikKepala(NIK $nikKepala): ?Keluarga
    {
        $row = $this->db->where('nik_kepala', $nikKepala->getValue())->get(self::TABLE)->row_array();
        return $row ? $this->hydrate($row) : null;
    }

    /** @inheritDoc */
    public function findAll(): array
    {
        $rows = $this->db->get(self::TABLE)->result_array();
        return array_map([$this, 'hydrate'], $rows);
    }

    /** @inheritDoc */
    public function findByCluster(int $idCluster): array
    {
        $rows = $this->db->where('id_cluster', $idCluster)->get(self::TABLE)->result_array();
        return array_map([$this, 'hydrate'], $rows);
    }

    /** @inheritDoc */
    public function save(Keluarga $keluarga): Keluarga
    {
        $data = [
            'no_kk'        => $keluarga->nomorKk ? $keluarga->nomorKk->getValue() : null,
            'nik_kepala'   => $keluarga->nikKepala ? $keluarga->nikKepala->getValue() : null,
            'tgl_daftar'   => $keluarga->tanggalDaftar,
            'kelas_sosial' => $keluarga->kelasSosial,
            'tgl_cetak_kk' => $keluarga->tanggalCetakKk,
            'alamat'       => $keluarga->alamat,
            'id_cluster'   => $keluarga->idCluster,
        ];

        if ($keluarga->id !== null) {
            $this->db->where('id', $keluarga->id)->update(self::TABLE, $data);
            return $keluarga;
        }

        $this->db->insert(self::TABLE, $data);
        $keluarga->id = (int) $this->db->insert_id();
        return $keluarga;
    }

    /** @inheritDoc */
    public function delete(int $id): bool
    {
        return $this->db->where('id', $id)->delete(self::TABLE) !== false;
    }

    private function hydrate(array $row): Keluarga
    {
        return new Keluarga($row);
    }
}
 
