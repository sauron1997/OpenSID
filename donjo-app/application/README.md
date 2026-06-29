# Application Layer

The **use-case orchestration** layer.

## Status: DONE (Phase B/D)

## Implemented Use Cases (15 total)

Each folder contains: *UseCase.php + *Input.php + *Output.php

| Use Case | Description |
|----------|-------------|
| GetPenduduk / ListPenduduk | Get or list residents |
| GetKeluarga / ListKeluarga | Get or list family units |
| GetCluster / ListCluster | Get or list wilayah (dusun/rw/rt) |
| GetKeuanganMaster / ListKeuanganMaster | Get or list fiscal year masters |
| GetSuratLog / ListSuratLog | Get or list letter logs |

## Port Interfaces

**Inbound** (Ports/Inbound/):
- AuthPortInterface, LoggingPortInterface, ValidationPortInterface

**Outbound** (Ports/Outbound/):
- NotificationPortInterface, CachePortInterface

## Contracts
- UseCaseInterface: execute(InputInterface): OutputInterface
- InputInterface: marker for validated input DTOs
- OutputInterface: marker for immutable output DTOs

## Dependency Rules
- Depends ONLY on the domain layer.
- Infrastructure layer implements these ports.

## Namespace
`Donjo\Application\*`
