<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\GetKeuanganMaster;

use Donjo\Application\UseCases\OutputInterface;
use Donjo\Domain\Entities\KeuanganMaster;

/**
 * Output DTO for the GetKeuanganMaster use case.
 *
 * Wraps a single KeuanganMaster entity, or null when no record
 * matches the requested identifier.
 */
final class GetKeuanganMasterOutput implements OutputInterface
{
    /**
     * @param KeuanganMaster|null $master The retrieved entity, or null when not found.
     */
    public function __construct(
        public ?KeuanganMaster $master,
    ) {
    }
}
