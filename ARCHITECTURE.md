# OpenSID Clean Architecture

## Overview

OpenSID (Sistem Informasi Desa) adalah aplikasi open-source untuk pengelolaan administrasi desa di Indonesia. Arsitektur baru ini mengadopsi prinsip **Clean Architecture** untuk memisahkan concerns, meningkatkan testability, dan memudahkan maintenance jangka panjang.

Tujuan utama:

- **Separation of Concerns**: Setiap layer memiliki tanggung jawab yang jelas
- **Testability**: Business logic dapat diuji tanpa dependensi pada framework/database
- **Maintainability**: Perubahan di satu layer tidak memengaruhi layer lain
- **Scalability**: Mudah menambah fitur baru tanpa refactoring besar

## Layer Diagram

\`\`\`
+-----------------------------------------------------------+
|                    INFRASTRUCTURE                          |
|  (Controllers, Repositories, External Services, DB)       |
|                                                            |
|  +---------------------------------------------------+   |
|  |              APPLICATION                            |   |
|  |  (Use Cases, Ports, DTOs)                           |   |
|  |                                                      |   |
|  |  +-------------------------------------------+    |   |
|  |  |           DOMAIN                           |    |   |
|  |  |  (Entities, Value Objects, Repository      |    |   |
|  |  |   Interfaces, Domain Services)             |    |   |
|  |  |                                             |    |   |
|  |  +-------------------------------------------+    |   |
|  |                                                      |   |
|  +---------------------------------------------------+   |
|                                                            |
+-----------------------------------------------------------+

Dependency Rule: Outer layers depend on inner layers, never the reverse.
\`\`\`


## Folder Structure

\`\`\`
donjo-app/
+- domain/                    # Core business logic (innermost layer)
|  +- Entities/              # Business objects (empty -- Phase B pending)
|  +- ValueObjects/          # Immutable value types (empty -- Phase B pending)
|  +- Repositories/          # Repository interfaces (contracts)
|  |  `- RepositoryInterface.php   # Generic repository contract
|  +- Services/              # Domain services (empty -- Phase B pending)
|  +- Exceptions/            # Domain-specific exceptions
|     +- AppException.php
|     +- BusinessRuleException.php
|     +- ForbiddenException.php
|     +- NotFoundException.php
|     +- UnauthorizedException.php
|     `- ValidationException.php
|
+- application/               # Use cases and application logic
|  +- UseCases/              # Use case contracts and I/O interfaces
|  |  +- UseCaseInterface.php
|  |  +- InputInterface.php
|  |  `- OutputInterface.php
|  +- Ports/                 # Port interfaces (Hexagonal / Ports & Adapters)
|  |  +- Inbound/           # Inbound ports (driving adapters call these)
|  |  |  +- AuthPortInterface.php
|  |  |  `- LoggingPortInterface.php
|  |  `- Outbound/          # Outbound ports (infrastructure implements these)
|  |     `- NotificationPortInterface.php
|  `- DTOs/                  # Data Transfer Objects (empty -- Phase B pending)
|
+- infrastructure/            # External concerns (outermost layer)
|  +- Http/                  # Controllers (empty -- Phase B pending)
|  +- Persistence/           # Repository implementations (empty -- Phase B pending)
|  +- External/              # Third-party service integrations (empty -- Phase B pending)
|  +- Auth/                  # Authentication implementations (empty -- Phase B pending)
|
+- config/                    # Configuration files
+- views/                     # Presentation layer (templates)
+- helpers/                   # Utility functions
\`\`\`

## Dependency Rules

### Domain Layer (Innermost)

- [x] **Can depend on**: Nothing (pure PHP, no external dependencies)
- [ ] **Cannot depend on**: Application, Infrastructure, Framework
- **Contains**: Business entities, value objects, domain services, repository interfaces, domain exceptions
- **Implemented**: `RepositoryInterface` (generic contract), exception classes (AppException, ValidationException, etc.)
- **Pending (Phase B)**: Concrete entities (Penduduk, Keluarga), value objects (NIK, Tanggal), domain services

### Application Layer

- [x] **Can depend on**: Domain layer only
- [ ] **Cannot depend on**: Infrastructure, Framework
- **Contains**: Use cases, application services, DTOs, port interfaces
- **Implemented**: `UseCaseInterface`, `InputInterface`, `OutputInterface`, `AuthPortInterface`, `LoggingPortInterface`, `NotificationPortInterface`
- **Pending (Phase B)**: Concrete use cases (CreatePenduduk, etc.), DTOs

### Infrastructure Layer (Outermost)

- [x] **Can depend on**: Domain and Application layers
- [ ] **Cannot be depended on by**: Domain or Application
- **Contains**: Controllers, repository implementations, external services
- **Pending (Phase B)**: Controllers, MySQL repository implementations, third-party integrations, auth adapters

### Key Principle: Dependency Inversion

Repositories are **defined** in the Domain layer as interfaces but **implemented** in the Infrastructure layer. This allows swapping database implementations without changing business logic.

### Port Interfaces

Application-layer interfaces are organized as **Ports** (following the Ports & Adapters / Hexagonal Architecture pattern):

- **Inbound Ports** (`application/Ports/Inbound/`): Interfaces that driving adapters (controllers, CLI, tests) call into the application. Examples: `AuthPortInterface`, `LoggingPortInterface`.
- **Outbound Ports** (`application/Ports/Outbound/`): Interfaces that the application calls and infrastructure implements. Examples: `NotificationPortInterface`.

> **Note**: The ARCHITECTURE.md previously referred to an `application/Interfaces/` folder. The actual code uses `application/Ports/` with `Inbound/` and `Outbound/` subdirectories. This document has been updated to match reality.


## Code Flow Example

### Scenario: Creating a new Penduduk (Resident)

> **Note**: The classes shown below (PendudukController, CreatePendudukUseCase, Penduduk entity, etc.)
> are **illustrative examples** of how the architecture will work once fully implemented.
> They do not yet exist in the codebase. The currently implemented files are listed in
> the Folder Structure section above.

**1. HTTP Request arrives at Controller (Infrastructure)**

\`\`\`php
// donjo-app/infrastructure/Http/PendudukController.php
// [Planned -- Phase B: not yet implemented]
class PendudukController extends CI_Controller {
