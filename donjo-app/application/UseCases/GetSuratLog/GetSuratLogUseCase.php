<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\GetSuratLog;

use Donjo\Application\UseCases\InputInterface;
use Donjo\Application\UseCases\OutputInterface;
use Donjo\Application\UseCases\UseCaseInterface;
use Donjo\Domain\Repositories\SuratLogRepositoryInterface;

/**
 * Use case: retrieve a single SuratLog by identifier.
 *
 * Delegates persistence to SuratLogRepositoryInterface and wraps the
 * result (entity or null) in a GetSuratLogOutput DTO.
 */
final class GetSuratLogUseCase implements UseCaseInterface
{
    /**
     * @param SuratLogRepositoryInterface $repository SuratLog persistence boundary.
     */
    public function __construct(
        private SuratLogRepositoryInterface $repository,
    ) {
    }

    /**
     * Execute the use case.
     *
     * @param GetSuratLogInput $input Validated input carrying the SuratLog id.
     * @return GetSuratLogOutput Output wrapping the entity or null.
     */
    public function execute(InputInterface $input): OutputInterface
    {
        \assert($input instanceof GetSuratLogInput);

        $suratLog = $this->repository->findById($input->suratLogId);

        return new GetSuratLogOutput($suratLog);
    }
}
