<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\GetCluster;

use Donjo\Application\UseCases\InputInterface;

/**
 * Input DTO for the GetCluster use case.
 *
 * Carries the identifier of the Cluster (Wilayah) entity to be
 * retrieved. Immutable after construction.
 */
final class GetClusterInput implements InputInterface
{
    /**
     * @param int $clusterId The unique identifier of the Cluster.
     */
    public function __construct(
        public int $clusterId,
    ) {
    }
}
