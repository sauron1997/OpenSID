<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\ListPenduduk;

use Donjo\Application\UseCases\OutputInterface;
use Donjo\Domain\Entities\Penduduk;

/**
 * Output DTO for the ListPenduduk use case.
 *
 * Wraps a plain array of Penduduk entities so the use case
 * conforms to UseCaseInterface (which requires OutputInterface).
 */
final class ListPendudukOutput implements OutputInterface
{
    /**
     * @param Penduduk[] $items
     */
    public function __construct(
        public readonly array $items,
    ) {
    }
}
