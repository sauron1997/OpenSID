<?php

declare(strict_types=1);

namespace Donjo\Domain\Entities;

/**
 * SuratLog — Service letter issuance log entity.
 *
 * Represents a single row from log_surat table. Each log records one
 * generated letter for a resident (id_pend) using a specific format
 * (id_format_surat) signed by a village official (id_pamong).
 */
final class SuratLog
{
    public ?int $id = null;
    public ?int $idFormatSurat = null;
    public ?int $idPend = null;
    public ?int $idPamong = null;
    public ?int $idUser = null;
    public ?string $tanggal = null;
    public ?string $bulan = null;
    public ?string $tahun = null;
    public ?string $noSurat = null;
    public ?string $namaSurat = null;
    public ?string $lampiran = null;
    public ?string $nikNonWarga = null;
    public ?string $namaNonWarga = null;
    public ?string $keterangan = null;

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
        $this->idFormatSurat = isset($data['id_format_surat']) ? (int) $data['id_format_surat'] : null;
        $this->idPend = isset($data['id_pend']) ? (int) $data['id_pend'] : null;
        $this->idPamong = isset($data['id_pamong']) ? (int) $data['id_pamong'] : null;
        $this->idUser = isset($data['id_user']) ? (int) $data['id_user'] : null;
        $this->tanggal = $data['tanggal'] ?? null;
        $this->bulan = $data['bulan'] ?? null;
        $this->tahun = $data['tahun'] ?? null;
        $this->noSurat = $data['no_surat'] ?? null;
        $this->namaSurat = $data['nama_surat'] ?? null;
        $this->lampiran = $data['lampiran'] ?? null;
        $this->nikNonWarga = $data['nik_non_warga'] ?? null;
        $this->namaNonWarga = $data['nama_non_warga'] ?? null;
        $this->keterangan = $data['keterangan'] ?? null;
    }

    public function isForWarga(): bool
    {
        return $this->idPend !== null;
    }

    public function isForNonWarga(): bool
    {
        return $this->nikNonWarga !== null;
    }

    public function hasNomor(): bool
    {
        return $this->noSurat !== null && $this->noSurat !== '';
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id'              => $this->id,
            'id_format_surat' => $this->idFormatSurat,
            'id_pend'         => $this->idPend,
            'id_pamong'       => $this->idPamong,
            'id_user'         => $this->idUser,
            'tanggal'         => $this->tanggal,
            'bulan'           => $this->bulan,
            'tahun'           => $this->tahun,
            'no_surat'        => $this->noSurat,
            'nama_surat'      => $this->namaSurat,
            'lampiran'        => $this->lampiran,
            'nik_non_warga'   => $this->nikNonWarga,
            'nama_non_warga'  => $this->namaNonWarga,
            'keterangan'      => $this->keterangan,
        ];
    }
}
