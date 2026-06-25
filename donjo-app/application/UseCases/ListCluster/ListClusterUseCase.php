<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\ListCluster;

use Donjo\Application\UseCases\InputInterface;
use Donjo\Application\UseCases\UseCaseInterface;
use Donjo\Domain\Entities\Cluster;
use Donjo\Domain\Repositories\ClusterRepositoryInterface;

/**
 * Use case: list Cluster (Wilayah) records with optional filtering.
 *
 * Returns a plain array of Cluster entities. The optional level
 * filter narrows the result to a single tier of the Dusun / RW / RT
 * hierarchy. Additional dusun / rw parameters are required when
 * drilling down to RW or RT level.
 */
final class ListClusterUseCase implements UseCaseInterface
{
    /**
     * @param ClusterRepositoryInterface $repository Cluster persistence boundary.
     */
    public function __construct(
        private ClusterRepositoryInterface $repository,
    ) {
    }

    /**
     * Execute the use case.
     *
     * @param InputInterface $input Validated input carrying filter parameters.
     * @return Cluster[] Array of Cluster entities.
     */
    public function execute(InputInterface $input): array
    {
        \assert($input instanceof ListClusterInput);

        switch ($input->level) {
            case 'dusun':
                return $this->repository->findAllDusun();

            case 'rw':
                return $this->repository->findRwByDusun((string) $input->dusun);

            case 'rt':
                return $this->repository->findRtByRw((string) $input->dusun, (string) $input->rw);

            default:
                return $this->repository->findAll();
        }
    }
}
