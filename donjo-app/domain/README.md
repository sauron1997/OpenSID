# Domain Layer

The **innermost layer** of the OpenSID clean architecture.

## Status: DONE (Phase B/C)

## Implemented

### Entities
- Penduduk.php, Keluarga.php, Cluster.php, KeuanganMaster.php, SuratLog.php

### Value Objects
- NIK.php, NomorKK.php, Tanggal.php, Coordinate.php, MapConfig.php

### Repository Interfaces
- RepositoryInterface.php (generic)
- PendudukRepositoryInterface.php
- KeluargaRepositoryInterface.php
- ClusterRepositoryInterface.php
- KeuanganMasterRepositoryInterface.php
- SuratLogRepositoryInterface.php

### Exceptions
- AppException, ValidationException, NotFoundException
- ForbiddenException, UnauthorizedException, BusinessRuleException

## Dependency Rules
- This layer depends on NOTHING external.
- All other layers depend on this one, never the reverse.

## Namespace
`Donjo\Domain\*`
