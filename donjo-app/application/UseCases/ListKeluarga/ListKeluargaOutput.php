<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\ListKeluarga;

use Donjo\Application\UseCases\OutputInterface;
use Donjo\Domain\Entities\Keluarga;

/**
 * Output DTO for the ListKeluarga use case.
 *
 * Wraps a plain array of Keluarga entities so the use case
 * conforms to UseCaseInterface (which requires OutputInterface).
 */
final class ListKeluargaOutput implements OutputInterface
{
    /**
     * @param Keluarga[] $items
     */
    public function __construct(
        public readonly array $items,
    ) {
    }
}
