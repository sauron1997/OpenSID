<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases\GetSuratLog;

use Donjo\Application\UseCases\InputInterface;

final class GetSuratLogInput implements InputInterface
{
    public function __construct(
        public int \$suratLogId,
    ) {
    }
}
