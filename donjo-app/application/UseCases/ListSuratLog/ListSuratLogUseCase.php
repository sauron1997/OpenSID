<?php
declare(strict_types=1);
namespace Donjo\Application\UseCases\ListSuratLog;
use Donjo\Application\UseCases\InputInterface;
use Donjo\Application\UseCases\OutputInterface;
use Donjo\Application\UseCases\UseCaseInterface;
use Donjo\Domain\Repositories\SuratLogRepositoryInterface;
final class ListSuratLogUseCase implements UseCaseInterface
{
    public function __construct(private SuratLogRepositoryInterface $repository) {}
    public function execute(InputInterface $input): OutputInterface
    {
        \assert($input instanceof ListSuratLogInput);
        if ($input->bulan !== null && $input->tahun !== null) {
            $items = $this->repository->findByBulanTahun($input->bulan, $input->tahun);
        } elseif ($input->idPend !== null) {
            $items = $this->repository->findByPenduduk($input->idPend);
        } else { $items = $this->repository->findAll(); }
        return new ListSuratLogOutput($items);
    }
}
