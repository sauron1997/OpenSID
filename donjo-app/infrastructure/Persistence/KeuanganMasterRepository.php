<?php

declare(strict_types=1);

namespace Donjo\Infrastructure\Persistence;

use Donjo\Domain\Entities\KeuanganMaster;
use Donjo\Domain\Repositories\KeuanganMasterRepositoryInterface;

final class KeuanganMasterRepository implements KeuanganMasterRepositoryInterface
{
    private $db;

    private const TABLE = 'keuangan_master';

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id): ?KeuanganMaster
    {
        $row = $this->db->where('id', $id)->get(self::TABLE)->row_array();
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
    public function findByTahun(int $tahun): ?KeuanganMaster
    {
        $row = $this->db->where('tahun_anggaran', $tahun)->get(self::TABLE)->row_array();
        return $row ? $this->hydrate($row) : null;
    }

    /**
     * @inheritDoc
     */
    public function findCurrent(): ?KeuanganMaster
    {
        $row = $this->db->where('tahun_anggaran', date('Y'))->get(self::TABLE)->row_array();
        return $row ? $this->hydrate($row) : null;
    }

    /**
     * @inheritDoc
     */
    public function save(KeuanganMaster $master): KeuanganMaster
    {
        $data = [
            'versi_database'  => $master->versiDatabase,
            'tahun_anggaran'  => $master->tahunAnggaran,
            'id_desa'         => $master->idDesa,
            'nama_desa'       => $master->namaDesa,
            'kode_desa'       => $master->kodeDesa,
            'nama_kecamatan'  => $master->namaKecamatan,
            'kode_kecamatan'  => $master->kodeKecamatan,
            'nama_kabupaten'  => $master->namaKabupaten,
            'kode_kabupaten'  => $master->kodeKabupaten,
            'nama_provinsi'   => $master->namaProvinsi,
            'kode_provinsi'   => $master->kodeProvinsi,
            'tanggal_impor'   => $master->tanggalImpor,
        ];

        if ($master->id !== null) {
            $this->db->where('id', $master->id)->update(self::TABLE, $data);
            return $master;
        }

        $this->db->insert(self::TABLE, $data);
        $master->id = (int) $this->db->insert_id();
        return $master;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        return $this->db->where('id', $id)->delete(self::TABLE) !== false;
    }

    /**
     * Hydrate a database row into a KeuanganMaster entity.
     *
     * @param array<string, mixed> $row
     * @return KeuanganMaster
     */
    private function hydrate(array $row): KeuanganMaster
    {
        return new KeuanganMaster($row);
    }
}
