<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\GetCluster;

use Donjo\Application\UseCases\OutputInterface;
use Donjo\Domain\Entities\Cluster;

/**
 * Output DTO for the GetCluster use case.
 *
 * Wraps a single Cluster (Wilayah) entity, or null when no record
 * matches the requested identifier.
 */
final class GetClusterOutput implements OutputInterface
{
    /**
     * @param Cluster|null $cluster The retrieved entity, or null when not found.
     */
    public function __construct(
        public ?Cluster $cluster,
    ) {
    }
}
