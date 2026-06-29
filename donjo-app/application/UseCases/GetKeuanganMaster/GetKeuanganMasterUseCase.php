<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\GetKeuanganMaster;

use Donjo\Application\UseCases\InputInterface;
use Donjo\Application\UseCases\OutputInterface;
use Donjo\Application\UseCases\UseCaseInterface;
use Donjo\Domain\Repositories\KeuanganMasterRepositoryInterface;

/**
 * Use case: retrieve a single KeuanganMaster by identifier.
 *
 * Delegates persistence to KeuanganMasterRepositoryInterface and wraps the
 * result (entity or null) in a GetKeuanganMasterOutput DTO.
 */
final class GetKeuanganMasterUseCase implements UseCaseInterface
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
     * @param GetKeuanganMasterInput $input Validated input carrying the KeuanganMaster id.
     * @return GetKeuanganMasterOutput Output wrapping the entity or null.
     */
    public function execute(InputInterface $input): OutputInterface
    {
        \assert($input instanceof GetKeuanganMasterInput);

        $master = $this->repository->findById($input->masterId);

        return new GetKeuanganMasterOutput($master);
    }
}
