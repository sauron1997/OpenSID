# Infrastructure Layer

The **outermost layer** of the OpenSID clean architecture. Contains all
framework-coupled implementations — the adapters that make the app run on
CodeIgniter 3, MySQL, and the web.

## Purpose
Provide concrete implementations of the ports defined in `domain/` and
`application/`. This is where CI3, the DB layer, and external services are
allowed to live — and nowhere else.

## What Goes Here
- **Repository implementations** — MySQL/ORM-backed code behind a `*Repository` interface
- **HTTP controllers** — thin facades that parse input, call a use case, format output
- **Auth adapters** — session, RBAC, and login integration with CI3
- **External service adapters** — APIs, file storage, third-party SDKs
- **Framework bridges** — config, routing, language, helpers

## What Does NOT Go Here
- Business rules or invariants (→ `domain/`)
- Use case orchestration or workflow logic (→ `application/`)
- View templates and presentation markup (→ `views/`)

## Dependency Rules
- **Depends on** `domain/` and `application/` (implements their interfaces).
- **Nothing depends on** this layer. The composition root (CI3 bootstrap) is
  the only place that wires concrete classes to interfaces.

## Namespace
`Donjo\Infrastructure\*`

> Aim for the *simplest code that works*: adapters should be boring and replaceable.
