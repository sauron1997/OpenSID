<?php

declare(strict_types=1);

namespace Donjo\Domain\Repositories;

use Donjo\Domain\Entities\Cluster;

/**
 * Cluster repository contract.
 *
 * Manages the Wilayah hierarchy (Dusun, RW, RT) all of which are
 * stored in the same table.
 */
interface ClusterRepositoryInterface extends RepositoryInterface
{
    /**
     * @param int $id
     * @return Cluster|null
     */
    public function findById(int $id): ?Cluster;

    /**
     * @return Cluster[]
     */
    public function findAll(): array;

    /**
     * @return Cluster[] All Dusun-level clusters (rt='0', rw='0').
     */
    public function findAllDusun(): array;

    /**
     * @param string $dusun
     * @return Cluster[] All RW-level clusters within the given Dusun.
     */
    public function findRwByDusun(string $dusun): array;

    /**
     * @param string $dusun
     * @param string $rw
     * @return Cluster[] All RT-level clusters within the given RW.
     */
    public function findRtByRw(string $dusun, string $rw): array;

    /**
     * @param Cluster $cluster
     * @return Cluster
     */
    public function save(Cluster $cluster): Cluster;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
