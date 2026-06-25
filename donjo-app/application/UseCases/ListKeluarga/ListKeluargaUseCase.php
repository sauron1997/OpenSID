<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\ListKeluarga;

use Donjo\Application\UseCases\InputInterface;
use Donjo\Application\UseCases\UseCaseInterface;
use Donjo\Domain\Repositories\KeluargaRepositoryInterface;

/**
 * Use case: list Keluarga records with optional cluster filtering.
 *
 * Returns a plain array of Keluarga entities.
 */
final class ListKeluargaUseCase implements UseCaseInterface
{
    public function __construct(
        private KeluargaRepositoryInterface $repository,
    ) {
    }

    public function execute(InputInterface $input): array
    {
        \assert($input instanceof ListKeluargaInput);

        if ($input->idCluster !== null) {
            return $this->repository->findByCluster($input->idCluster);
        }

        return $this->repository->findAll();
    }
}
