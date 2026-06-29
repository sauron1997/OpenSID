<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\ListSuratLog;

use Donjo\Application\UseCases\InputInterface;

/**
 * Input DTO for the ListSuratLog use case.
 *
 * Carries optional filtering and pagination parameters. Immutable
 * after construction.
 */
final class ListSuratLogInput implements InputInterface
{
    /**
     * @param int|null $idPend Optional resident identifier filter.
     * @param string|null $bulan Optional month filter.
     * @param string|null $tahun Optional year filter.
     * @param int $limit Maximum number of records to return.
     * @param int $offset Number of records to skip.
     */
    public function __construct(
        public ?int $idPend = null,
        public ?string $bulan = null,
        public ?string $tahun = null,
        public int $limit = 50,
        public int $offset = 0,
    ) {
    }
}
