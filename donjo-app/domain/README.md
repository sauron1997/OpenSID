# Domain Layer

The **innermost layer** of the OpenSID clean architecture. Contains pure business
logic with **zero framework dependencies**.

## Purpose
Encapsulate the village-information-system domain: rules, invariants, and
contracts that never change regardless of web framework, database, or UI.

## What Goes Here
- **Entities** — objects with identity and lifecycle (e.g. `Penduduk`, `Surat`)
- **Value Objects** — immutable, equality-by-value types (e.g. `NIK`, `Tanggal`)
- **Repository Interfaces** — contracts only, no implementation
- **Domain Services** — business logic that does not fit a single entity
- **Domain Exceptions** — typed errors for rule violations

## What Does NOT Go Here
- Database queries, SQL, ORM models
- HTTP, request/response, session, cookie logic
- CodeIgniter 3 classes (`CI_Controller`, `CI_Model`, etc.)
- Any framework-specific code

## Dependency Rules
- This layer depends on **NOTHING** external (no framework, no DB, no HTTP).
- **All other layers depend on this one** — never the reverse.

## Namespace
`Donjo\Domain\*`

> Aim for the *simplest code that works*: pure PHP, clear naming, no cleverness.
