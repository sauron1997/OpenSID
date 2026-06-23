<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\ListPenduduk;

use Donjo\Application\UseCases\UseCaseInterface;
use Donjo\Domain\Entities\Penduduk;
use Donjo\Domain\Repositories\PendudukRepositoryInterface;

/**
 * Use case: list Penduduk records with optional filtering.
 *
 * Returns a plain array of Penduduk entities. When an idCluster filter
 * is supplied, only members of that cluster are returned. Full
 * pagination can be added later - keep it simple now.
 */
final class ListPendudukUseCase implements UseCaseInterface
{
    /**
     * @param PendudukRepositoryInterface $repository Penduduk persistence boundary.
     */
    public function __construct(
        private PendudukRepositoryInterface $repository,
    ) {
    }

    /**
     * Execute the use case.
     *
     * @param ListPendudukInput $input Validated input carrying filter and pagination.
     * @return Penduduk[] Array of Penduduk entities.
     */
    public function execute(InputInterface $input): array
    {
        \assert($input instanceof ListPendudukInput);

        if ($input->idCluster !== null) {
            return $this->repository->findByCluster($input->idCluster);
        }

        return $this->repository->findAll();
    }
}
