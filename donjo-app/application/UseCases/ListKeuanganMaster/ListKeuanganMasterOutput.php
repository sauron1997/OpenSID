<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\ListKeuanganMaster;

use Donjo\Application\UseCases\OutputInterface;
use Donjo\Domain\Entities\KeuanganMaster;

/**
 * Output DTO for the ListKeuanganMaster use case.
 *
 * Wraps a plain array of KeuanganMaster entities so the use case
 * conforms to UseCaseInterface (which requires OutputInterface).
 */
final class ListKeuanganMasterOutput implements OutputInterface
{
    /**
     * @param KeuanganMaster[] $items
     */
    public function __construct(
        public readonly array $items,
    ) {
    }
}
