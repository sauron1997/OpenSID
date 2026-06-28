<?php

declare(strict_types=1);

namespace Donjo\Infrastructure;

use Donjo\Application\UseCases\GetPenduduk\GetPendudukUseCase;
use Donjo\Application\UseCases\ListPenduduk\ListPendudukUseCase;
use Donjo\Application\UseCases\GetKeluarga\GetKeluargaUseCase;
use Donjo\Application\UseCases\ListKeluarga\ListKeluargaUseCase;
use Donjo\Application\UseCases\GetCluster\GetClusterUseCase;
use Donjo\Application\UseCases\ListCluster\ListClusterUseCase;
use Donjo\Application\UseCases\GetKeuanganMaster\GetKeuanganMasterUseCase;
use Donjo\Application\UseCases\ListKeuanganMaster\ListKeuanganMasterUseCase;
use Donjo\Application\UseCases\GetSuratLog\GetSuratLogUseCase;
use Donjo\Application\UseCases\ListSuratLog\ListSuratLogUseCase;
use Donjo\Infrastructure\Persistence\PendudukRepository;
use Donjo\Infrastructure\Persistence\KeluargaRepository;
use Donjo\Infrastructure\Persistence\ClusterRepository;
use Donjo\Infrastructure\Persistence\KeuanganMasterRepository;
use Donjo\Infrastructure\Persistence\SuratLogRepository;

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

    // ----------------------------------------------------------------
    // Keluarga
    // ----------------------------------------------------------------

    public function makeKeluargaRepository(): KeluargaRepository
    {
        return new KeluargaRepository($this->db);
    }

    public function makeGetKeluargaUseCase(): GetKeluargaUseCase
    {
        return new GetKeluargaUseCase($this->makeKeluargaRepository());
    }

    public function makeListKeluargaUseCase(): ListKeluargaUseCase
    {
        return new ListKeluargaUseCase($this->makeKeluargaRepository());
    }

    // ----------------------------------------------------------------
    // Cluster
    // ----------------------------------------------------------------

    public function makeClusterRepository(): ClusterRepository
    {
        return new ClusterRepository($this->db);
    }

    public function makeGetClusterUseCase(): GetClusterUseCase
    {
        return new GetClusterUseCase($this->makeClusterRepository());
    }

    public function makeListClusterUseCase(): ListClusterUseCase
    {
        return new ListClusterUseCase($this->makeClusterRepository());
    }

    // ----------------------------------------------------------------
    // KeuanganMaster
    // ----------------------------------------------------------------

    public function makeKeuanganMasterRepository(): KeuanganMasterRepository
    {
        return new KeuanganMasterRepository($this->db);
    }

    public function makeGetKeuanganMasterUseCase(): GetKeuanganMasterUseCase
    {
        return new GetKeuanganMasterUseCase($this->makeKeuanganMasterRepository());
    }

    public function makeListKeuanganMasterUseCase(): ListKeuanganMasterUseCase
    {
        return new ListKeuanganMasterUseCase($this->makeKeuanganMasterRepository());
    }

    // ----------------------------------------------------------------
    // SuratLog
    // ----------------------------------------------------------------

    public function makeSuratLogRepository(): SuratLogRepository
    {
        return new SuratLogRepository($this->db);
    }

    public function makeGetSuratLogUseCase(): GetSuratLogUseCase
    {
        return new GetSuratLogUseCase($this->makeSuratLogRepository());
    }

    public function makeListSuratLogUseCase(): ListSuratLogUseCase
    {
        return new ListSuratLogUseCase($this->makeSuratLogRepository());
    }
}

