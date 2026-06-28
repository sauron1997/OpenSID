<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\ListSuratLog;

use Donjo\Application\UseCases\OutputInterface;
use Donjo\Domain\Entities\SuratLog;

/**
 * Output DTO for the ListSuratLog use case.
 *
 * Wraps a plain array of SuratLog entities so the use case
 * conforms to UseCaseInterface (which requires OutputInterface).
 */
final class ListSuratLogOutput implements OutputInterface
{
    /**
     * @param SuratLog[] $items
     */
    public function __construct(
        public readonly array $items,
    ) {
    }
}
