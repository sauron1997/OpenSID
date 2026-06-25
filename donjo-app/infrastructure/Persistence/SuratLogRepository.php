<?php

declare(strict_types=1);

namespace Donjo\Infrastructure\Persistence;

use Donjo\Domain\Entities\SuratLog;
use Donjo\Domain\Repositories\SuratLogRepositoryInterface;

final class SuratLogRepository implements SuratLogRepositoryInterface
{
    private $db;

    private const TABLE = 'log_surat';

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id): ?SuratLog
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
    public function findByPenduduk(int $idPend): array
    {
        $rows = $this->db->where('id_pend', $idPend)->get(self::TABLE)->result_array();
        return array_map([$this, 'hydrate'], $rows);
    }

    /**
     * @inheritDoc
     */
    public function findByBulanTahun(string $bulan, string $tahun): array
    {
        $rows = $this->db
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get(self::TABLE)
            ->result_array();
        return array_map([$this, 'hydrate'], $rows);
    }

    /**
     * @inheritDoc
     */
    public function save(SuratLog $suratLog): SuratLog
    {
        $data = [
            'id_format_surat' => $suratLog->idFormatSurat,
            'id_pend'         => $suratLog->idPend,
            'id_pamong'       => $suratLog->idPamong,
            'id_user'         => $suratLog->idUser,
            'tanggal'         => $suratLog->tanggal,
            'bulan'           => $suratLog->bulan,
            'tahun'           => $suratLog->tahun,
            'no_surat'        => $suratLog->noSurat,
            'nama_surat'      => $suratLog->namaSurat,
            'lampiran'        => $suratLog->lampiran,
            'nik_non_warga'   => $suratLog->nikNonWarga,
            'nama_non_warga'  => $suratLog->namaNonWarga,
            'keterangan'      => $suratLog->keterangan,
        ];

        if ($suratLog->id !== null) {
            $this->db->where('id', $suratLog->id)->update(self::TABLE, $data);
            return $suratLog;
        }

        $this->db->insert(self::TABLE, $data);
        $suratLog->id = (int) $this->db->insert_id();
        return $suratLog;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        return $this->db->where('id', $id)->delete(self::TABLE) !== false;
    }

    /**
     * Hydrate a database row into a SuratLog entity.
     *
     * @param array<string, mixed> $row
     * @return SuratLog
     */
    private function hydrate(array $row): SuratLog
    {
        return new SuratLog($row);
    }
}
