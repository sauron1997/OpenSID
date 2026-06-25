<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\ListKeuanganMaster;

use Donjo\Application\UseCases\InputInterface;
use Donjo\Application\UseCases\UseCaseInterface;
use Donjo\Domain\Entities\KeuanganMaster;
use Donjo\Domain\Repositories\KeuanganMasterRepositoryInterface;

/**
 * Use case: list KeuanganMaster records with optional filtering.
 *
 * Returns a plain array of KeuanganMaster entities. When a tahun
 * filter is supplied, only the matching fiscal-year record is
 * returned (as a single-element array) or an empty array when
 * not found.
 */
final class ListKeuanganMasterUseCase implements UseCaseInterface
{
    /**
     * @param KeuanganMasterRepositoryInterface $repository KeuanganMaster persistence boundary.
     */
    public function __construct(
        private KeuanganMasterRepositoryInterface $repository,
    ) {
    }

    /**
     * Execute the use case.
     *
     * @param ListKeuanganMasterInput $input Validated input carrying filter and pagination.
     * @return KeuanganMaster[] Array of KeuanganMaster entities.
     */
    public function execute(InputInterface $input): array
    {
        \assert($input instanceof ListKeuanganMasterInput);

        if ($input->tahun !== null) {
            $master = $this->repository->findByTahun($input->tahun);

            return $master !== null ? [$master] : [];
        }

        return $this->repository->findAll();
    }
}
