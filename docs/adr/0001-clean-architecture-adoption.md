# ADR-0001: Adopt Clean Architecture for OpenSID

## Status

**Accepted** (2026-03-17)

## Context

OpenSID is a village information system (Sistem Informasi Desa) used by thousands of villages across Indonesia. The codebase has grown organically over several years, and the current architecture presents significant challenges:

### Current State Problems

1. **Fat Controllers**: Controllers contain business logic, database queries, and presentation logic mixed together. Some controller methods exceed 200 lines of code.

2. **No Service Layer**: Business logic is scattered across controllers, models, and helpers with no clear boundary.

3. **Tight Framework Coupling**: All code is deeply coupled to CodeIgniter. Business logic depends on `$this->db`, `$this->load`, `$this->input`, and other CI-specific constructs.

4. **Difficult to Test**: Unit testing is nearly impossible because business logic requires the full CodeIgniter stack and a live database to run.

5. **Code Duplication**: The same business rules (e.g., validation for Penduduk data) are duplicated across multiple controllers and views.

6. **Regression Risks**: Changes to one feature frequently break unrelated features because there are no clear boundaries between modules.

7. **Slow Onboarding**: New developers struggle to understand the codebase because logic is spread across many files with no clear structure.

8. **No Domain Modeling**: The system uses database-centric models rather than rich domain objects that encapsulate business rules.

## Decision

We will adopt **Clean Architecture** (Robert C. Martin) as the foundational architecture for OpenSID. The implementation will use a three-layer approach:

- **Domain Layer**: Entities, value objects, repository interfaces, domain services
- **Application Layer**: Use cases, application services, DTOs
- **Infrastructure Layer**: Controllers, repository implementations, external integrations

## Alternatives Considered

### 1. Hexagonal Architecture (Ports & Adapters - Strict)

- **Description**: Strict adherence to hexagonal architecture with explicit ports and adapters for every external interaction.
- **Pros**: Very clear boundaries, excellent testability, framework independence.
- **Cons**: Higher initial overhead, more boilerplate, can be over-engineered for a PHP/CI4 application of this size. The strict port/adapter pattern adds complexity without proportional benefit for web-focused applications.
- **Verdict**: Rejected. Too strict for the team experience level and project scope.

### 2. Modular Monolith

- **Description**: Organize code into self-contained modules, each with its own controllers, models, and views, but running in a single process.
- **Pros**: Good separation of features, easier to understand per-module, natural boundaries for future microservice extraction.
- **Cons**: Does not solve the core problem of business logic being tied to the framework. Modules can still have internal architecture problems.
- **Verdict**: Rejected as standalone approach. Some modular principles will be incorporated into the clean architecture approach.

### 3. DDD-Lite (Domain-Driven Design - Light)

- **Description**: Adopt key DDD concepts (entities, value objects, aggregates, repositories) without the full DDD tactical patterns (sagas, domain events, event sourcing).
- **Pros**: Introduces rich domain modeling without the full complexity of DDD. Good middle ground.
- **Cons**: Without the full layer separation, the codebase can still fall into the same pitfalls. DDD-lite alone does not enforce dependency rules.
- **Verdict**: Partially adopted. We use DDD concepts within the Domain layer but rely on Clean Architecture for the overall structure.

### 4. Chosen: Clean Architecture (with DDD concepts in Domain layer)

- **Pros**: Clear layer separation with enforced dependency rules, framework independence for domain logic, excellent testability, well-documented pattern with many resources for the team to learn from.
- **Cons**: Initial effort to migrate, learning curve for team, slight overhead for simple CRUD operations.
- **Verdict**: Accepted. Provides the best balance of structure, flexibility, and pragmatic implementation for OpenSID.

## Consequences

### Positive

1. **Testability**: Domain and application logic can be tested without the framework or database. Unit tests run in milliseconds.

2. **Framework Independence**: If CodeIgniter is replaced in the future, only the Infrastructure layer changes. Domain and Application layers remain untouched.

3. **Clear Boundaries**: Each layer has well-defined responsibilities. Developers know where to put new code.

4. **Reduced Coupling**: Changes in one layer do not cascade to others. Database schema changes only affect repository implementations.

5. **Better Code Reviews**: Changes are focused within layers, making code reviews more targeted and effective.

6. **Incremental Migration**: The Strangler Fig pattern allows migrating one module at a time without stopping development.

### Negative

1. **Initial Effort**: Significant upfront work to set up the architecture and migrate existing modules.

2. **Learning Curve**: The team needs to understand clean architecture principles, dependency inversion, and repository patterns.

3. **More Files**: Each feature requires files across multiple layers (entity, use case, repository interface, repository implementation, controller).

4. **Overhead for Simple CRUD**: Simple operations may feel verbose compared to the current approach. However, the consistency and maintainability benefits outweigh this cost.

5. **Gradual Inconsistency**: During migration, some modules will follow the new architecture while others still use the old pattern, creating temporary inconsistency.

## Mitigation

- Start with one module (Penduduk) as a proof of concept
- Create templates and examples for common patterns
- Document decisions in ADR format
- Regular knowledge-sharing sessions for the team
- Code review checklists that enforce layer boundaries

## References

- Robert C. Martin, *Clean Architecture: A Craftsman Guide to Software Structure and Design* (2017)
- Martin Fowler, *Strangler Fig Application* - https://martinfowler.com/bliki/StranglerFigApplication.html
- Jeffrey Palermo, *Onion Architecture* - https://jeffreypalermo.com/2008/07/the-onion-architecture-part-1/
