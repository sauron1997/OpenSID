<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\ListCluster;

use Donjo\Application\UseCases\InputInterface;

/**
 * Input DTO for the ListCluster use case.
 *
 * Carries optional filtering parameters to narrow the Cluster
 * hierarchy (Dusun, RW, RT) that should be returned. Immutable
 * after construction.
 */
final class ListClusterInput implements InputInterface
{
    /**
     * @param string|null $level Hierarchy level filter (null=all, 'dusun', 'rw', 'rt').
     * @param string|null $dusun Dusun name filter.
     * @param string|null $rw    RW number filter.
     */
    public function __construct(
        public ?string $level = null,
        public ?string $dusun = null,
        public ?string $rw = null,
    ) {
    }
}
