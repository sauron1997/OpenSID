<?php

declare(strict_types=1);

namespace Donjo\Domain\Repositories;

use Donjo\Domain\Entities\SuratLog;

/**
 * SuratLog repository contract.
 *
 * Manages service letter issuance records (log_surat table).
 */
interface SuratLogRepositoryInterface extends RepositoryInterface
{
    /**
     * @param int $id
     * @return SuratLog|null
     */
    public function findById(int $id): ?SuratLog;

    /**
     * @return SuratLog[]
     */
    public function findAll(): array;

    /**
     * @param int $idPend
     * @return SuratLog[]
     */
    public function findByPenduduk(int $idPend): array;

    /**
     * @param string $bulan
     * @param string $tahun
     * @return SuratLog[]
     */
    public function findByBulanTahun(string $bulan, string $tahun): array;

    /**
     * @param SuratLog $suratLog
     * @return SuratLog
     */
    public function save(SuratLog $suratLog): SuratLog;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}