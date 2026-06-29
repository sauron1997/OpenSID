<?php

declare(strict_types=1);

namespace Donjo\Infrastructure\Persistence;

use Donjo\Domain\Entities\Penduduk;
use Donjo\Domain\Repositories\PendudukRepositoryInterface;
use Donjo\Domain\ValueObjects\NIK;

final class PendudukRepository implements PendudukRepositoryInterface
{
    private $db;

    private const TABLE = 'tweb_penduduk';

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id): ?Penduduk
    {
        $row = $this->db->where('id', $id)->get(self::TABLE)->row_array();
        return $row ? $this->hydrate($row) : null;
    }

    /**
     * @inheritDoc
     */
    public function findByNik(NIK $nik): ?Penduduk
    {
        $row = $this->db->where('nik', $nik->getValue())->get(self::TABLE)->row_array();
        return $row ? $this->hydrate($row) : null;
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        $rows = $this->db->get(self::TABLE)->result_array();
        return array_map([$this, 'hydrate'], $rows);
    }

    /**
     * @inheritDoc
     */
    public function findByCluster(int $idCluster): array
    {
        $rows = $this->db->where('id_cluster', $idCluster)->get(self::TABLE)->result_array();
        return array_map([$this, 'hydrate'], $rows);
    }

    /**
     * @inheritDoc
     */
    public function save(Penduduk $penduduk): Penduduk
    {
        $data = [
            'nik'             => $penduduk->nik ? $penduduk->nik->getValue() : null,
            'nama'            => $penduduk->nama,
            'sex'             => $penduduk->jenisKelamin,
            'tanggallahir'    => $penduduk->tanggalLahir,
            'tempatlahir'     => $penduduk->tempatLahir,
            'id_cluster'      => $penduduk->idCluster,
            'id_kk'           => $penduduk->idKk,
            'status_dasar'    => $penduduk->statusDasar,
            'id_agama'        => $penduduk->agamaId,
            'id_pekerjaan'    => $penduduk->pekerjaanId,
            'id_pendidikan'   => $penduduk->pendidikanId,
            'id_status_kawin' => $penduduk->statusKawinId,
        ];

        if ($penduduk->id !== null) {
            $this->db->where('id', $penduduk->id)->update(self::TABLE, $data);
            return $penduduk;
        }

        $this->db->insert(self::TABLE, $data);
        $penduduk->id = (int) $this->db->insert_id();
        return $penduduk;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        return $this->db->where('id', $id)->delete(self::TABLE) !== false;
    }

    /**
     * Hydrate a database row into a Penduduk entity.
     *
     * @param array<string, mixed> $row
     * @return Penduduk
     */
    private function hydrate(array $row): Penduduk
    {
        return new Penduduk($row);
    }
}
