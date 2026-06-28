# ADR-0003: Port Naming and Inbound/Outbound Organization

## Status

**Accepted** (2026-06-27)

## Context

The application layer exposes contracts for cross-cutting concerns (auth, logging, validation, caching, notifications). These needed to be organized consistently. Two options were considered: flat `Interfaces/` folder vs. Hexagonal Ports & Adapters with `Inbound/` and `Outbound/` split.

## Decision

Use `application/Ports/Inbound/` and `application/Ports/Outbound/` to organize port interfaces, following the Ports & Adapters (Hexagonal Architecture) naming convention.

**Inbound ports** (`Ports/Inbound/`) — interfaces that driving adapters (controllers, CLI) call INTO the application:
- `AuthPortInterface` — check permissions, get user
- `LoggingPortInterface` — info, warning, error logging
- `ValidationPortInterface` — validate data and entities

**Outbound ports** (`Ports/Outbound/`) — interfaces the application calls OUT TO infrastructure:
- `NotificationPortInterface` — send notifications to users/groups
- `CachePortInterface` — get, set, delete, remember cached values

## Alternatives Considered

### 1. Flat `application/Interfaces/` folder
- **Pros**: Simple, no extra nesting.
- **Cons**: No distinction between driving/driven adapters. Loses hexagonal semantics.
- **Verdict**: Rejected.

### 2. Inbound/Outbound split (chosen)
- **Pros**: Clear intent. Inbound = app is the server. Outbound = app is the client.
- **Verdict**: Accepted.

## Consequences

- All cross-cutting concern interfaces live in `Ports/Inbound/` or `Ports/Outbound/`
- Infrastructure implementations are placed in their respective `infrastructure/` subfolders
- Repository interfaces remain in `domain/Repositories/` (not Ports) — they are domain contracts, not application ports

## References

- Alistair Cockburn, *Hexagonal Architecture* — https://alistair.cockburn.us/hexagonal-architecture/
