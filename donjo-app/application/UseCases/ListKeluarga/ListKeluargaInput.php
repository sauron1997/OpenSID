<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\ListKeluarga;

use Donjo\Application\UseCases\InputInterface;

/**
 * Input DTO for the ListKeluarga use case.
 *
 * Carries optional cluster filter and pagination parameters.
 */
final class ListKeluargaInput implements InputInterface
{
    /**
     * @param int|null $idCluster Optional cluster filter.
     * @param int      $limit     Maximum records to return.
     * @param int      $offset    Number of records to skip.
     */
    public function __construct(
        public ?int $idCluster = null,
        public int $limit = 50,
        public int $offset = 0,
    ) {
    }
}
