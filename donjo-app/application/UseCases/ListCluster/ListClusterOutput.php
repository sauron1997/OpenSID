<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\ListCluster;

use Donjo\Application\UseCases\OutputInterface;
use Donjo\Domain\Entities\Cluster;

/**
 * Output DTO for the ListCluster use case.
 *
 * Wraps a plain array of Cluster entities so the use case
 * conforms to UseCaseInterface (which requires OutputInterface).
 */
final class ListClusterOutput implements OutputInterface
{
    /**
     * @param Cluster[] $items
     */
    public function __construct(
        public readonly array $items,
    ) {
    }
}
