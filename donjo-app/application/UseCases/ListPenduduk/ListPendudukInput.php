<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\ListPenduduk;

use Donjo\Application\UseCases\InputInterface;

/**
 * Input DTO for the ListPenduduk use case.
 *
 * Carries optional filtering and pagination parameters. Immutable
 * after construction.
 */
final class ListPendudukInput implements InputInterface
{
    /**
     * @param int|null $idCluster Optional cluster (dusun/lingkungan) filter.
     * @param int      $limit     Maximum number of records to return.
     * @param int      $offset    Number of records to skip.
     */
    public function __construct(
        public ?int $idCluster = null,
        public int $limit = 50,
        public int $offset = 0,
    ) {
    }
}
