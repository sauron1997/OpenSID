<?php

declare(strict_types=1);

namespace Donjo\Domain\Entities;

use Donjo\Domain\ValueObjects\NIK;
use Donjo\Domain\ValueObjects\JenisKelamin;

/**
 * Penduduk — Resident/ Citizen entity.
 * Represents a single row from tweb_penduduk table.
 */
final class Penduduk
{
    public ?int $id = null;
    public string $nama = '';
    public ?NIK $nik = null;
    public ?string $tempatLahir = null;
    public ?string $tanggalLahir = null;
    public ?int $jenisKelamin = null;
    public ?int $agamaId = null;
    public ?int $pekerjaanId = null;
    public ?int $pendidikanId = null;
    public ?int $statusKawinId = null;
    public ?int $idCluster = null;
    public ?int $idKk = null;
    public int $statusDasar = 1;

    /**
     * Hydrate entity from database row array.
     *
     * @param array<string, mixed> $data
     */
    public function __construct(array $data = [])
    {
        if (isset($data['id'])) {
            $this->id = (int) $data['id'];
        }
        if (isset($data['nama'])) {
            $this->nama = (string) $data['nama'];
        }
        if (isset($data['nik']) && $data['nik'] !== '') {
            try {
                $this->nik = new NIK((string) $data['nik']);
            } catch (\Throwable $e) {
                $this->nik = null;
            }
        }
        $this->tempatLahir = $data['tempatlahir'] ?? null;
        $this->tanggalLahir = $data['tanggallahir'] ?? null;
        $this->jenisKelamin = isset($data['sex']) ? (int) $data['sex'] : null;
        $this->idCluster = isset($data['id_cluster']) ? (int) $data['id_cluster'] : null;
        $this->idKk = isset($data['id_kk']) ? (int) $data['id_kk'] : null;
        $this->statusDasar = isset($data['status_dasar']) ? (int) $data['status_dasar'] : 1;
        $this->agamaId = isset($data['id_agama']) ? (int) $data['id_agama'] : null;
        $this->pekerjaanId = isset($data['id_pekerjaan']) ? (int) $data['id_pekerjaan'] : null;
        $this->pendidikanId = isset($data['id_pendidikan']) ? (int) $data['id_pendidikan'] : null;
        $this->statusKawinId = isset($data['id_status_kawin']) ? (int) $data['id_status_kawin'] : null;
    }

    public function isHidup(): bool
    {
        return $this->statusDasar === 1;
    }

    public function isLakiLaki(): bool
    {
        return JenisKelamin::isLakiLaki($this->jenisKelamin);
    }

    public function isPerempuan(): bool
    {
        return JenisKelamin::isPerempuan($this->jenisKelamin);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'nik' => $this->nik !== null ? $this->nik->getValue() : null,
            'tempatlahir' => $this->tempatLahir,
            'tanggallahir' => $this->tanggalLahir,
            'sex' => $this->jenisKelamin,
            'id_cluster' => $this->idCluster,
            'id_kk' => $this->idKk,
            'status_dasar' => $this->statusDasar,
            'id_agama' => $this->agamaId,
            'id_pekerjaan' => $this->pekerjaanId,
            'id_pendidikan' => $this->pendidikanId,
            'id_status_kawin' => $this->statusKawinId,
        ];
    }
}
