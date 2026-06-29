<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\GetKeluarga;

use Donjo\Application\UseCases\InputInterface;

/**
 * Input DTO for the GetKeluarga use case.
 *
 * Carries the identifier of the Keluarga entity to be retrieved.
 */
final class GetKeluargaInput implements InputInterface
{
    /**
     * @param int $keluargaId The unique identifier of the Keluarga.
     */
    public function __construct(
        public int $keluargaId,
    ) {
    }
}
