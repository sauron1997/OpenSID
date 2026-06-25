<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\ListSuratLog;

use Donjo\Application\UseCases\InputInterface;
use Donjo\Application\UseCases\UseCaseInterface;
use Donjo\Domain\Repositories\SuratLogRepositoryInterface;

/**
 * Use case: list SuratLog records with optional filtering.
 *
 * Returns a plain array of SuratLog entities. When both bulan and
 * tahun are supplied the search is narrowed to that month; when
 * only idPend is given the results are limited to one resident.
 */
final class ListSuratLogUseCase implements UseCaseInterface
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
     * @param ListSuratLogInput $input Validated input carrying filter and pagination.
     * @return SuratLog[] Array of SuratLog entities.
     */
    public function execute(InputInterface $input): array
    {
        \assert($input instanceof ListSuratLogInput);

        if ($input->bulan !== null && $input->tahun !== null) {
            return $this->repository->findByBulanTahun($input->bulan, $input->tahun);
        }

        if ($input->idPend !== null) {
            return $this->repository->findByPenduduk($input->idPend);
        }

        return $this->repository->findAll();
    }
}
