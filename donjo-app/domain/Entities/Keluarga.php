<?php

declare(strict_types=1);

namespace Donjo\Domain\Entities;

use Donjo\Domain\ValueObjects\NomorKK;
use Donjo\Domain\ValueObjects\NIK;

/**
 * Keluarga — Family (Kartu Keluarga) entity.
 *
 * Represents a single row from tweb_keluarga table. A keluarga
 * groups one or more Penduduk entities under a single family card
 * with a head-of-family (kepala keluarga).
 */
final class Keluarga
{
    public ?int $id = null;
    public ?NomorKK $nomorKk = null;
    public ?NIK $nikKepala = null;
    public ?string $tanggalDaftar = null;
    public ?int $kelasSosial = null;
    public ?string $tanggalCetakKk = null;
    public ?string $alamat = null;
    public ?int $idCluster = null;

    /**
     * Hydrate entity from a database row.
     *
     * @param array<string, mixed> $data
     */
    public function __construct(array $data = [])
    {
        if (isset($data['id'])) {
            $this->id = (int) $data['id'];
        }
        if (isset($data['no_kk']) && $data['no_kk'] !== '') {
            try {
                $this->nomorKk = new NomorKK((string) $data['no_kk']);
            } catch (\Throwable $e) {
                $this->nomorKk = null;
            }
        }
        if (isset($data['nik_kepala']) && $data['nik_kepala'] !== '') {
            try {
                $this->nikKepala = new NIK((string) $data['nik_kepala']);
            } catch (\Throwable $e) {
                $this->nikKepala = null;
            }
        }
        $this->tanggalDaftar = $data['tgl_daftar'] ?? null;
        $this->kelasSosial = isset($data['kelas_sosial']) ? (int) $data['kelas_sosial'] : null;
        $this->tanggalCetakKk = $data['tgl_cetak_kk'] ?? null;
        $this->alamat = $data['alamat'] ?? null;
        $this->idCluster = isset($data['id_cluster']) ? (int) $data['id_cluster'] : null;
    }

    public function hasKepala(): bool
    {
        return $this->nikKepala !== null;
    }

    public function isSejahtera(): bool
    {
        return $this->kelasSosial !== null && $this->kelasSosial > 0;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id'           => $this->id,
            'no_kk'        => $this->nomorKk !== null ? $this->nomorKk->getValue() : null,
            'nik_kepala'   => $this->nikKepala !== null ? $this->nikKepala->getValue() : null,
            'tgl_daftar'   => $this->tanggalDaftar,
            'kelas_sosial' => $this->kelasSosial,
            'tgl_cetak_kk' => $this->tanggalCetakKk,
            'alamat'       => $this->alamat,
            'id_cluster'   => $this->idCluster,
        ];
    }
}
