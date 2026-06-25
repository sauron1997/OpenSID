<?php

declare(strict_types=1);

namespace Donjo\Domain\Entities;

/**
 * KeuanganMaster — Fiscal year master record entity.
 *
 * Represents a single row from keuangan_master table. Each record
 * represents a fiscal year (tahun_anggaran) of village financial
 * data imported from the SiskeuDes system.
 */
final class KeuanganMaster
{
    public ?int $id = null;
    public ?string $versiDatabase = null;
    public ?int $tahunAnggaran = null;
    public ?int $idDesa = null;
    public ?string $namaDesa = null;
    public ?string $kodeDesa = null;
    public ?string $namaKecamatan = null;
    public ?string $kodeKecamatan = null;
    public ?string $namaKabupaten = null;
    public ?string $kodeKabupaten = null;
    public ?string $namaProvinsi = null;
    public ?string $kodeProvinsi = null;
    public ?string $tanggalImpor = null;

    /**
     * Hydrate entity from database row.
     *
     * @param array<string, mixed> $data
     */
    public function __construct(array $data = [])
    {
        if (isset($data['id'])) {
            $this->id = (int) $data['id'];
        }
        $this->versiDatabase = $data['versi_database'] ?? null;
        $this->tahunAnggaran = isset($data['tahun_anggaran']) ? (int) $data['tahun_anggaran'] : null;
        $this->idDesa = isset($data['id_desa']) ? (int) $data['id_desa'] : null;
        $this->namaDesa = $data['nama_desa'] ?? null;
        $this->kodeDesa = $data['kode_desa'] ?? null;
        $this->namaKecamatan = $data['nama_kecamatan'] ?? null;
        $this->kodeKecamatan = $data['kode_kecamatan'] ?? null;
        $this->namaKabupaten = $data['nama_kabupaten'] ?? null;
        $this->kodeKabupaten = $data['kode_kabupaten'] ?? null;
        $this->namaProvinsi = $data['nama_provinsi'] ?? null;
        $this->kodeProvinsi = $data['kode_provinsi'] ?? null;
        $this->tanggalImpor = $data['tanggal_impor'] ?? null;
    }

    public function isCurrent(): bool
    {
        if ($this->tahunAnggaran === null) {
            return false;
        }
        return $this->tahunAnggaran === (int) date('Y');
    }

    public function getFiscalYearLabel(): string
    {
        return $this->tahunAnggaran !== null
            ? 'APBDes ' . $this->tahunAnggaran
            : 'APBDes (tidak diketahui)';
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id'              => $this->id,
            'versi_database'  => $this->versiDatabase,
            'tahun_anggaran'  => $this->tahunAnggaran,
            'id_desa'         => $this->idDesa,
            'nama_desa'       => $this->namaDesa,
            'kode_desa'       => $this->kodeDesa,
            'nama_kecamatan'  => $this->namaKecamatan,
            'kode_kecamatan'  => $this->kodeKecamatan,
            'nama_kabupaten'  => $this->namaKabupaten,
            'kode_kabupaten'  => $this->kodeKabupaten,
            'nama_provinsi'   => $this->namaProvinsi,
            'kode_provinsi'   => $this->kodeProvinsi,
            'tanggal_impor'   => $this->tanggalImpor,
        ];
    }
}
