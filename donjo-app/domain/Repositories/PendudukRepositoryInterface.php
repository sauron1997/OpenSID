<?php

declare(strict_types=1);

namespace Donjo\Domain\Repositories;

use Donjo\Domain\Entities\Penduduk;
use Donjo\Domain\ValueObjects\NIK;

/**
 * Penduduk repository contract.
 * Defines persistence operations for Penduduk entities.
 */
interface PendudukRepositoryInterface extends RepositoryInterface
{
    /**
     * @param int $id
     * @return Penduduk|null
     */
    public function findById(int $id): ?Penduduk;

    /**
     * @param NIK $nik
     * @return Penduduk|null
     */
    public function findByNik(NIK $nik): ?Penduduk;

    /**
     * @return Penduduk[]
     */
    public function findAll(): array;

    /**
     * @param int $idCluster
     * @return Penduduk[]
     */
    public function findByCluster(int $idCluster): array;

    /**
     * @param Penduduk $penduduk
     * @return Penduduk
     */
    public function save(Penduduk $penduduk): Penduduk;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
