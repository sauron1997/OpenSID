<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\GetCluster;

use Donjo\Application\UseCases\InputInterface;
use Donjo\Application\UseCases\OutputInterface;
use Donjo\Application\UseCases\UseCaseInterface;
use Donjo\Domain\Repositories\ClusterRepositoryInterface;

/**
 * Use case: retrieve a single Cluster (Wilayah) by identifier.
 *
 * Delegates persistence to ClusterRepositoryInterface and wraps the
 * result (entity or null) in a GetClusterOutput DTO.
 */
final class GetClusterUseCase implements UseCaseInterface
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
     * @param InputInterface $input Validated input carrying the Cluster id.
     * @return OutputInterface Output wrapping the entity or null.
     */
    public function execute(InputInterface $input): OutputInterface
    {
        \assert($input instanceof GetClusterInput);

        $cluster = $this->repository->findById($input->clusterId);

        return new GetClusterOutput($cluster);
    }
}
