<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\GetSuratLog;

use Donjo\Application\UseCases\OutputInterface;
use Donjo\Domain\Entities\SuratLog;

/**
 * Output DTO for the GetSuratLog use case.
 */
final class GetSuratLogOutput implements OutputInterface
{
    public function __construct(
        public ?SuratLog $suratLog,
    ) {
    }
}
