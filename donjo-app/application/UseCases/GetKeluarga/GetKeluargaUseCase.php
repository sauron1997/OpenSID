<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\GetKeluarga;

use Donjo\Application\UseCases\InputInterface;
use Donjo\Application\UseCases\OutputInterface;
use Donjo\Application\UseCases\UseCaseInterface;
use Donjo\Domain\Repositories\KeluargaRepositoryInterface;

/**
 * Use case: retrieve a single Keluarga by identifier.
 */
final class GetKeluargaUseCase implements UseCaseInterface
{
    public function __construct(
        private KeluargaRepositoryInterface $repository,
    ) {
    }

    public function execute(InputInterface $input): OutputInterface
    {
        \assert($input instanceof GetKeluargaInput);

        $keluarga = $this->repository->findById($input->keluargaId);

        return new GetKeluargaOutput($keluarga);
    }
}
