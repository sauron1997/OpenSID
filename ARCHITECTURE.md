# OpenSID Clean Architecture

## Overview

OpenSID adalah aplikasi open-source pengelolaan administrasi desa. Arsitektur ini mengadopsi Clean Architecture untuk separation of concerns, testability, dan maintainability.

## Implementation Status

- [x] Phase A -- Graphify codebase mapping
- [x] Phase B -- Domain entities, value objects, repository interfaces, use cases
- [x] Phase C -- Infrastructure persistence, port adapters, middleware
- [x] Phase D -- Dead code cleanup, ADR docs, README updates
- [ ] Phase E -- Controller wiring, composition root, integration tests (TODO)

## Architecture Diagram

```
+------------------------------------------------------------------+
|                     INFRASTRUCTURE                               |
|  Ci3SessionAuth, Ci3Logger, Ci3Validator, FileCache              |
|  PendudukRepo, KeluargaRepo, ClusterRepo, KeuanganMasterRepo     |
|  SuratLogRepo, AuthMiddleware, LoggingMiddleware                  |
|  +------------------------------------------------------------+  |
|  |                  APPLICATION                               |  |
|  |  UseCases: Get* + List* for 5 entities (15 total)          |  |
|  |  Ports/Inbound:  Auth, Logging, Validation                 |  |
|  |  Ports/Outbound: Notification, Cache                       |  |
|  |  +------------------------------------------------------+  |  |
|  |  |                   DOMAIN                             |  |  |
|  |  |  Entities: Penduduk, Keluarga, Cluster,              |  |  |
|  |  |            KeuanganMaster, SuratLog                  |  |  |
|  |  |  ValueObjects: NIK, NomorKK, Tanggal,                |  |  |
|  |  |                Coordinate, MapConfig                  |  |  |
|  |  |  Repositories: 5 interfaces + generic contract        |  |  |
|  |  |  Exceptions:   6 typed domain exceptions             |  |  |
|  |  +------------------------------------------------------+  |  |
|  +------------------------------------------------------------+  |
+------------------------------------------------------------------+
Dependency Rule: Outer -> Inner only. Inner never imports Outer.
```

## Implemented Structure

```
donjo-app/
  domain/                [DONE]
    Entities/            Penduduk, Keluarga, Cluster, KeuanganMaster, SuratLog
    ValueObjects/        NIK, NomorKK, Tanggal, Coordinate, MapConfig
    Repositories/        5 interfaces + RepositoryInterface (generic)
    Exceptions/          6 typed exceptions
  application/           [DONE]
    UseCases/            15 use cases (5xGet + 5xList), each with Input+Output DTOs
    Ports/Inbound/       AuthPortInterface, LoggingPortInterface, ValidationPortInterface
    Ports/Outbound/      NotificationPortInterface, CachePortInterface
  infrastructure/        [DONE]
    Persistence/         BaseRepository + 5 concrete repositories
    Auth/                Ci3SessionAuth
    Logging/             Ci3Logger
    Validation/          Ci3Validator
    Cache/               FileCache
    Middleware/          AuthMiddleware, LoggingMiddleware, CircuitBreakerMiddleware
  docs/adr/              5 ADRs (0001-0005)
```

## Dependency Rules

| Layer | Depends On | Must NOT Depend On |
|---|---|---|
| Domain | Nothing | Everything |
| Application | Domain only | Infrastructure, Framework |
| Infrastructure | Domain + Application | (nothing depends on it) |

## Code Flow Example

```php
// Controller (Infrastructure) -> UseCase (Application) -> Repository (Domain interface)
$useCase = new ListPendudukUseCase(new PendudukRepository($db));
$output  = $useCase->execute(new ListPendudukInput(idCluster: 5));
foreach ($output->items as $penduduk) { echo $penduduk->nama; }
```

## ADR Index

| ADR | Title |
|-----|-------|
| ADR-0001 | Clean Architecture Adoption |
| ADR-0002 | Repository Pattern with BaseRepository |
| ADR-0003 | Port Naming Inbound/Outbound |
| ADR-0004 | CodeIgniter 3 Adapter Strategy |
| ADR-0005 | Graphify Output Exclusion from Version Control |
