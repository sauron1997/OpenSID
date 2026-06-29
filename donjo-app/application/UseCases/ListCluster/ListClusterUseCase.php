<?php
declare(strict_types=1);
namespace Donjo\Application\UseCases\ListCluster;
use Donjo\Application\UseCases\InputInterface;
use Donjo\Application\UseCases\OutputInterface;
use Donjo\Application\UseCases\UseCaseInterface;
use Donjo\Domain\Repositories\ClusterRepositoryInterface;
final class ListClusterUseCase implements UseCaseInterface
{
    public function __construct(private ClusterRepositoryInterface $repository) {}
    public function execute(InputInterface $input): OutputInterface
    {
        \assert($input instanceof ListClusterInput);
        switch ($input->level) {
            case 'dusun': $items = $this->repository->findAllDusun(); break;
            case 'rw': $items = $this->repository->findRwByDusun((string)$input->dusun); break;
            case 'rt': $items = $this->repository->findRtByRw((string)$input->dusun,(string)$input->rw); break;
            default: $items = $this->repository->findAll();
        }
        return new ListClusterOutput($items);
    }
}
