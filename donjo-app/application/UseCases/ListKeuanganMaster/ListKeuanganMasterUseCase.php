<?php
declare(strict_types=1);
namespace Donjo\Application\UseCases\ListKeuanganMaster;
use Donjo\Application\UseCases\InputInterface;
use Donjo\Application\UseCases\OutputInterface;
use Donjo\Application\UseCases\UseCaseInterface;
use Donjo\Domain\Repositories\KeuanganMasterRepositoryInterface;
final class ListKeuanganMasterUseCase implements UseCaseInterface
{
    public function __construct(private KeuanganMasterRepositoryInterface $repository) {}
    public function execute(InputInterface $input): OutputInterface
    {
        \assert($input instanceof ListKeuanganMasterInput);
        if ($input->tahun !== null) {
            $m = $this->repository->findByTahun($input->tahun);
            $items = $m !== null ? [$m] : [];
        } else { $items = $this->repository->findAll(); }
        return new ListKeuanganMasterOutput($items);
    }
}
