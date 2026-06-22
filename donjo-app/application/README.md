# Application Layer

The **use-case orchestration** layer. Coordinates domain objects to fulfill
each business workflow; defines the ports the outside world plugs into.

## Purpose
Translate user intentions into a sequence of domain operations, while keeping
domain rules intact. This is where the application behavior is described —
not its UI, not its storage.

## What Goes Here
- **UseCase classes** — one class per user action (e.g. `BuatSurat`, `DaftarPenduduk`)
- **Input DTOs** — validated request payloads from the outside world
- **Output DTOs** — presentation-ready results returned by use cases
- **Port Interfaces** — inbound (`*Port`) and outbound (`*RepositoryPort`) contracts
- **Application Exceptions** — workflow-level errors (e.g. `ValidationException`)

## What Does NOT Go Here
- Business rules and invariants (→ `domain/`)
- Framework code, SQL, HTTP, sessions (→ `infrastructure/`)
- HTML, view templates, UI logic (→ `views/`)
- Direct instantiation of infrastructure classes

## Dependency Rules
- Depends **ONLY** on the `domain` layer (and its own DTOs/ports).
- The `infrastructure` layer **implements** these ports; nothing here knows how.

## Namespace
`Donjo\Application\*`

> Aim for the *simplest code that works*: thin use cases, explicit data flow.
