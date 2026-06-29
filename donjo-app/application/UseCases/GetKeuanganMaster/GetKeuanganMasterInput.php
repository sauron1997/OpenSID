<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\GetKeuanganMaster;

use Donjo\Application\UseCases\InputInterface;

final class GetKeuanganMasterInput implements InputInterface
{
    public function __construct(
        public int \$masterId,
    ) {
    }
}
