<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\GetPenduduk;

use Donjo\Application\UseCases\OutputInterface;
use Donjo\Domain\Entities\Penduduk;

/**
 * Output DTO for the GetPenduduk use case.
 *
 * Wraps a single Penduduk entity, or null when no record matches
 * the requested identifier.
 */
final class GetPendudukOutput implements OutputInterface
{
    /**
     * @param Penduduk|null $penduduk The retrieved entity, or null when not found.
     */
    public function __construct(
        public ?Penduduk $penduduk,
    ) {
    }
}
