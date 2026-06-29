# ADR-0007: Clean Controller Pattern Standard

## Status

**Accepted** (2026-06-28)

## Context

Phase E introduced `Penduduk_clean` as a pilot controller. Phase F scales
the same pattern to 4 more domains. Without a documented standard, each
controller risks drifting from the pattern (different error formats,
different auth strategies, different JSON shapes).

## Decision

All `*_clean` controllers follow this exact pattern:

### 1. Constructor — wire via ServiceContainer
```php
public function __construct() {
    parent::__construct();
    $this->container = new ServiceContainer($this->db);
}
```

### 2. Auth check — inline helper method
```php
private function checkAuth(string $resource): bool {
    $auth = new Ci3SessionAuth($this->db);
    $middleware = new AuthMiddleware($auth);
    return $middleware->canRead($this->session->userdata('id'), $resource);
}
```

### 3. index() — list endpoint
```php
public function index(): void {
    if (!$this->checkAuth('resource_name')) { $this->forbidden(); return; }
    // build Input DTO from query params
    // call use case
    // map output to array
    // set_output(json_encode(...))
}
```

### 4. detail($id) — single entity endpoint
```php
public function detail(int $id): void {
    if (!$this->checkAuth('resource_name')) { $this->forbidden(); return; }
    // build Input DTO
    // call use case
    // 404 if null
    // set_output(json_encode(...))
}
```

### 5. JSON helpers — two private methods
```php
private function forbidden(): void {
    $this->output->set_status_header(403)
        ->set_content_type('application/json')
        ->set_output(json_encode(['error' => 'Forbidden']));
}

private function notFound(int $id): void {
    $this->output->set_status_header(404)
        ->set_content_type('application/json')
        ->set_output(json_encode(['error' => 'Not found', 'id' => $id]));
}
```

## Alternatives Considered

### Shared base controller (CleanController extends CI_Controller)
- **Pros**: DRY — `checkAuth`, `forbidden`, `notFound` defined once.
- **Cons**: Adds inheritance coupling; CI3 controllers already extend
  `CI_Controller`; PHP single-inheritance limits flexibility.
- **Verdict**: Deferred to Phase G — apply only if > 5 controllers exist
  and duplication becomes a maintenance burden.

### Framework middleware (CI3 hooks)
- **Pros**: Auth check applied globally without touching controllers.
- **Cons**: CI3 hooks are global — hard to apply per-route selectively.
- **Verdict**: Rejected for now; revisit if migrating to CI4 or Laravel.

## Consequences

- All `*_clean` controllers are consistent and readable.
- Adding a new domain = copy pattern, change class/method names only.
- When > 5 controllers exist, extract shared methods to `CleanController`
  base class (Phase G task).

## References

- ADR-0006: Composition Root Strategy
- ADR-0004: CodeIgniter 3 Adapter Strategy
