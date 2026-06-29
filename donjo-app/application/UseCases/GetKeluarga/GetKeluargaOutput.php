<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\GetKeluarga;

use Donjo\Application\UseCases\OutputInterface;
use Donjo\Domain\Entities\Keluarga;

/**
 * Output DTO for the GetKeluarga use case.
 *
 * Wraps a single Keluarga entity, or null when no record matches.
 */
final class GetKeluargaOutput implements OutputInterface
{
    /**
     * @param Keluarga|null $keluarga The retrieved entity, or null when not found.
     */
    public function __construct(
        public ?Keluarga $keluarga,
    ) {
    }
}
