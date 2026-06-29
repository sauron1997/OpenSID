<?php

declare(strict_types=1);

namespace Donjo\Domain\Repositories;

use Donjo\Domain\Entities\KeuanganMaster;

/**
 * KeuanganMaster repository contract.
 *
 * Manages village fiscal year master records (keuangan_master table).
 */
interface KeuanganMasterRepositoryInterface extends RepositoryInterface
{
    /**
     * @param int $id
     * @return KeuanganMaster|null
     */
    public function findById(int $id): ?KeuanganMaster;

    /**
     * @return KeuanganMaster[]
     */
    public function findAll(): array;

    /**
     * @param int $tahun
     * @return KeuanganMaster|null
     */
    public function findByTahun(int $tahun): ?KeuanganMaster;

    /**
     * @return KeuanganMaster|null
     */
    public function findCurrent(): ?KeuanganMaster;

    /**
     * @param KeuanganMaster $master
     * @return KeuanganMaster
     */
    public function save(KeuanganMaster $master): KeuanganMaster;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
