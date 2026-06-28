<?php
declare(strict_types=1);
namespace Donjo\Application\UseCases\ListPenduduk;
use Donjo\Application\UseCases\InputInterface;
use Donjo\Application\UseCases\OutputInterface;
use Donjo\Application\UseCases\UseCaseInterface;
use Donjo\Domain\Repositories\PendudukRepositoryInterface;
final class ListPendudukUseCase implements UseCaseInterface
{
    public function __construct(private PendudukRepositoryInterface $repository) {}
    public function execute(InputInterface $input): OutputInterface
    {
        \assert($input instanceof ListPendudukInput);
        $items = $input->idCluster !== null
            ? $this->repository->findByCluster($input->idCluster)
            : $this->repository->findAll();
        return new ListPendudukOutput($items);
    }
}
