<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\GetPenduduk;

use Donjo\Application\UseCases\UseCaseInterface;
use Donjo\Domain\Repositories\PendudukRepositoryInterface;

/**
 * Use case: retrieve a single Penduduk by identifier.
 *
 * Delegates persistence to PendudukRepositoryInterface and wraps the
 * result (entity or null) in a GetPendudukOutput DTO.
 */
final class GetPendudukUseCase implements UseCaseInterface
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
     * @param GetPendudukInput $input Validated input carrying the Penduduk id.
     * @return GetPendudukOutput Output wrapping the entity or null.
     */
    public function execute(InputInterface $input): OutputInterface
    {
        \assert($input instanceof GetPendudukInput);

        $penduduk = $this->repository->findById($input->pendudukId);

        return new GetPendudukOutput($penduduk);
    }
}
