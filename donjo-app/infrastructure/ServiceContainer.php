<?php

declare(strict_types=1);

namespace Donjo\Infrastructure;

use Donjo\Application\UseCases\GetPenduduk\GetPendudukUseCase;
use Donjo\Application\UseCases\ListPenduduk\ListPendudukUseCase;
use Donjo\Infrastructure\Persistence\PendudukRepository;

/**
 * Composition Root — manual service factory.
 *
 * Wires concrete infrastructure classes to application use cases.
 * Receives the CI3 database object via constructor so repositories
 * can be built without calling get_instance() themselves.
 *
 * Scale: add one make*() method per use case as domains are wired.
 */
final class ServiceContainer
{
    public function __construct(
        private $db,
    ) {
    }

    // ----------------------------------------------------------------
    // Penduduk
    // ----------------------------------------------------------------

    public function makePendudukRepository(): PendudukRepository
    {
        return new PendudukRepository($this->db);
    }

    public function makeGetPendudukUseCase(): GetPendudukUseCase
    {
        return new GetPendudukUseCase($this->makePendudukRepository());
    }

    public function makeListPendudukUseCase(): ListPendudukUseCase
    {
        return new ListPendudukUseCase($this->makePendudukRepository());
    }
}
