<?php
declare(strict_types=1);
namespace Donjo\Application\UseCases\ListKeluarga;
use Donjo\Application\UseCases\InputInterface;
use Donjo\Application\UseCases\OutputInterface;
use Donjo\Application\UseCases\UseCaseInterface;
use Donjo\Domain\Repositories\KeluargaRepositoryInterface;
final class ListKeluargaUseCase implements UseCaseInterface
{
    public function __construct(private KeluargaRepositoryInterface $repository) {}
    public function execute(InputInterface $input): OutputInterface
    {
        \assert($input instanceof ListKeluargaInput);
        $items = $input->idCluster !== null
            ? $this->repository->findByCluster($input->idCluster)
            : $this->repository->findAll();
        return new ListKeluargaOutput($items);
    }
}
