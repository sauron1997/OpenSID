<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\GetPenduduk;

use Donjo\Application\UseCases\InputInterface;

/**
 * Input DTO for the GetPenduduk use case.
 *
 * Carries the identifier of the Penduduk entity to be retrieved.
 * Immutable after construction.
 */
final class GetPendudukInput implements InputInterface
{
    /**
     * @param int $pendudukId The unique identifier of the Penduduk.
     */
    public function __construct(
        public int $pendudukId,
    ) {
    }
}
