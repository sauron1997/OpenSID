<?php
declare(strict_types=1);
namespace Donjo\Application\UseCases;
interface UseCaseInterface
{
    public function execute(InputInterface $input): OutputInterface;
}
