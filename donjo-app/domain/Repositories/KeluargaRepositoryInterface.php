<?php

declare(strict_types=1);

namespace Donjo\Domain\Repositories;

use Donjo\Domain\Entities\Keluarga;
use Donjo\Domain\ValueObjects\NIK;
use Donjo\Domain\ValueObjects\NomorKK;

/**
 * Keluarga repository contract.
 *
 * Defines persistence operations for Keluarga entities.
 */
interface KeluargaRepositoryInterface extends RepositoryInterface
{
    /**
     * @param int $id
     * @return Keluarga|null
     */
    public function findById(int $id): ?Keluarga;

    /**
     * @param NomorKK $noKk
     * @return Keluarga|null
     */
    public function findByNomorKk(NomorKK $noKk): ?Keluarga;

    /**
     * @param NIK $nikKepala
     * @return Keluarga|null
     */
    public function findByNikKepala(NIK $nikKepala): ?Keluarga;

    /**
     * @return Keluarga[]
     */
    public function findAll(): array;

    /**
     * @param int $idCluster
     * @return Keluarga[]
     */
    public function findByCluster(int $idCluster): array;

    /**
     * @param Keluarga $keluarga
     * @return Keluarga
     */
    public function save(Keluarga $keluarga): Keluarga;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
