# ADR-0004: CodeIgniter 3 Adapter Strategy

## Status

**Accepted** (2026-06-27)

## Context

OpenSID runs on CodeIgniter 3 (CI3). The Clean Architecture requires that framework-specific code is isolated to the Infrastructure layer. The challenge is bridging CI3 constructs (`$this->db`, `log_message()`, `get_instance()`, `CI_Form_validation`) with the clean architecture ports and repositories without polluting the domain or application layers.

## Decision

Create thin **CI3 Adapter classes** in `infrastructure/` that implement the port interfaces defined in `application/Ports/`:

| Port Interface | CI3 Adapter | Strategy |
|---|---|---|
| `AuthPortInterface` | `Ci3SessionAuth` | Queries `user` and `tweb_user_akses` tables via CI3 `$db` |
| `LoggingPortInterface` | `Ci3Logger` | Wraps CI3 `log_message()` function |
| `ValidationPortInterface` | `Ci3Validator` | Wraps `CI_Form_validation` via `get_instance()` |
| `CachePortInterface` | `FileCache` | Custom file-based cache; CI-path-aware via `APPPATH` constant |

Repository implementations receive `$db` (CI3 database object) via constructor injection — they do not call `get_instance()` themselves.

## Alternatives Considered

### 1. Use CI3 directly in application layer
- **Pros**: Less code.
- **Cons**: Couples business logic to CI3. Cannot unit-test without full CI3 stack.
- **Verdict**: Rejected.

### 2. Full PSR-11 container (chosen partially)
- **Pros**: Proper DI container.
- **Cons**: CI3 has no native PSR-11 support. Adds heavy dependency.
- **Verdict**: Deferred. Manual wiring via composition root is sufficient for now.

### 3. Thin adapters (chosen)
- **Pros**: Minimal code. Each adapter does one thing. Easy to swap.
- **Verdict**: Accepted.

## Consequences

- All CI3-specific code (`$this->db`, `log_message`, `get_instance`) is confined to `infrastructure/`
- Domain and Application layers have zero CI3 imports
- Swapping CI3 for another framework only requires rewriting the adapter classes
- A composition root (wiring concrete classes to interfaces) is needed — currently absent and deferred to Phase E

## References

- ADR-0001: Clean Architecture Adoption
- ADR-0003: Port Naming and Inbound/Outbound Organization
