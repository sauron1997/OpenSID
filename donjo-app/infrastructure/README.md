# Infrastructure Layer

The **outermost layer** of the OpenSID clean architecture.

## Status: DONE (Phase C)

## Implemented

### Repository Implementations (Persistence/)

| Class | Table |
|-------|-------|
| BaseRepository | abstract helper |
| PendudukRepository | tweb_penduduk |
| KeluargaRepository | tweb_keluarga |
| ClusterRepository | tweb_wil_clusterdesa |
| KeuanganMasterRepository | ta_tahun_anggaran |
| SuratLogRepository | log_surat |

> Note: Concrete repos do not yet extend BaseRepository. See ADR-0002.

### CI3 Adapters

| Adapter | Implements |
|---------|-----------|
| Ci3SessionAuth (Auth/) | AuthPortInterface |
| Ci3Logger (Logging/) | LoggingPortInterface |
| Ci3Validator (Validation/) | ValidationPortInterface |
| FileCache (Cache/) | CachePortInterface |

### Middleware
- AuthMiddleware, LoggingMiddleware, CircuitBreakerMiddleware

## Dependency Rules
- Depends on domain/ and application/ (implements their interfaces).
- Nothing depends on this layer.
- Composition root (Phase E): will wire concrete classes to interfaces.

## Namespace
`Donjo\Infrastructure\*`
