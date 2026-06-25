<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\ListKeuanganMaster;

use Donjo\Application\UseCases\InputInterface;

/**
 * Input DTO for the ListKeuanganMaster use case.
 *
 * Carries optional filtering and pagination parameters. Immutable
 * after construction.
 */
final class ListKeuanganMasterInput implements InputInterface
{
    /**
     * @param int|null $tahun Optional fiscal year filter.
     * @param int $limit Maximum number of records to return.
     * @param int $offset Number of records to skip.
     */
    public function __construct(
        public ?int $tahun = null,
        public int $limit = 50,
        public int $offset = 0,
    ) {
    }
}
