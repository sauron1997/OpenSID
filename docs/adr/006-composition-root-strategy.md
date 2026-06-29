# ADR-0006: Composition Root Strategy — Manual ServiceContainer

## Status

**Accepted** (2026-06-28)

## Context

Phase E requires wiring concrete infrastructure classes (repositories, adapters)
to application use cases. Two options were considered:

1. **Manual `ServiceContainer`** — a plain PHP class with one `make*()` factory
   method per use case.
2. **PSR-11 DI container** (e.g. PHP-DI, Pimple) — a full dependency-injection
   container with auto-wiring.

OpenSID runs on CodeIgniter 3, which has no native DI container. Adding a PSR-11
container would introduce a new Composer dependency and require CI3 bootstrap
integration work that is out of scope for Phase E.

## Decision

Use a **manual `ServiceContainer`** class in `donjo-app/infrastructure/ServiceContainer.php`.

Rules:
- One `make*()` method per use case.
- Receives CI3 `$db` object via constructor — no `get_instance()` calls inside.
- Controller instantiates `ServiceContainer` once per request: `new ServiceContainer($this->db)`.
- Add methods domain by domain as each controller is wired (Karpathy: minimum code).

## Alternatives Considered

### PSR-11 DI Container (PHP-DI / Pimple)
- **Pros**: Auto-wiring, cleaner for large apps.
- **Cons**: New Composer dependency, CI3 bootstrap integration overhead.
- **Verdict**: Deferred to Phase F when full framework migration is planned.

### Static factory methods
- **Pros**: No instantiation needed.
- **Cons**: Hard to test (cannot swap `$db` in tests).
- **Verdict**: Rejected.

## Consequences

- `ServiceContainer` grows one `make*()` method per wired use case.
- When the project migrates off CI3, replace `ServiceContainer` with a proper
  PSR-11 container — only `ServiceContainer` needs to change, not controllers.
- New use cases added after this ADR **must** be registered in `ServiceContainer`
  before a controller can use them.

## References

- ADR-0001: Clean Architecture Adoption
- ADR-0004: CodeIgniter 3 Adapter Strategy
- Mark Seemann, *Dependency Injection in .NET* — Composition Root pattern
