# ADR-0002: Repository Pattern with BaseRepository

## Status

**Accepted** (2026-06-27)

## Context

During Phase B implementation, five concrete repository classes were created in `infrastructure/Persistence/`:
- `PendudukRepository`
- `KeluargaRepository`
- `ClusterRepository`
- `KeuanganMasterRepository`
- `SuratLogRepository`

A `BaseRepository` abstract class was also created with helper methods (`findOneBy`, `findAllBy`, `insert`, `update`, `deleteById`). However, during Phase D review it was found that no concrete repository actually extends `BaseRepository` — each repository duplicates the same CI3 `$this->db` pattern directly.

## Decision

**Keep `BaseRepository` but refactor concrete repositories to extend it** in the next iteration. For the current phase (Phase D), we document this gap rather than doing a large refactor.

The rationale:
- `BaseRepository` is well-designed and DRY
- Refactoring all 5 repositories to extend it is low-risk but out of scope for Phase D
- Documenting it as a known improvement prevents it from becoming permanent dead code

## Alternatives Considered

### 1. Delete BaseRepository immediately
- **Pros**: Removes unused code now.
- **Cons**: Loses the well-designed helper methods. Future repositories would have to re-implement them.
- **Verdict**: Rejected.

### 2. Refactor all repositories to extend BaseRepository now
- **Pros**: DRY, consistent.
- **Cons**: Large change for Phase D; risk of regression.
- **Verdict**: Deferred to Phase E.

### 3. Keep as-is and document (chosen)
- **Pros**: No risk, fast, transparent.
- **Verdict**: Accepted for Phase D.

## Consequences

- `BaseRepository` remains in codebase as an unused-but-valid helper class
- Phase E task: refactor all concrete repositories to extend `BaseRepository`
- New repositories created after this ADR **must** extend `BaseRepository`

## References

- Martin Fowler, *Patterns of Enterprise Application Architecture* — Repository pattern
