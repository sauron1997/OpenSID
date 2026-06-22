<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases;

use Donjo\Application\UseCases\InputInterface;
use Donjo\Application\UseCases\OutputInterface;

/**
 * Contract for a single use case (application service).
 *
 * Each use case executes one business operation by transforming a
 * structured InputInterface into a structured OutputInterface.
 * Implementations should be framework-agnostic and depend only on
 * the application and domain layers.
 */
interface UseCaseInterface
{
    /**
     * Execute this use case.
     *
     * @param InputInterface $input Validated input data.
     * @return OutputInterface The result of the operation.
     */
    public function execute(InputInterface $input): OutputInterface;
}