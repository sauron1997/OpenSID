# ADR-0005: Graphify Output Exclusion from Version Control

## Status

**Accepted** (2026-06-27)

## Context

During Phase A of the Clean Architecture conversion, the `graphify` skill was used to map and visualize the OpenSID codebase. Graphify produces output files in `donjo-app/graphify-out/`:
- `graph.json` — full dependency graph (~1.5 MB)
- `graph.html` — interactive visualization (~5 MB)
- `manifest.json` — file hashes and metadata
- `cache/` — AST parse cache

These files were accidentally committed and pushed to the `backend-clean-architecture` branch (see git history). They should not be version-controlled because:
1. They are **generated artifacts**, not source code
2. They are **very large** (graph.html alone is ~5 MB) and bloat the repository
3. They change every time graphify runs, causing noisy diffs
4. They contain full path information about the developer's local machine

## Decision

1. Add `donjo-app/graphify-out/` to `.gitignore`
2. The graphify output directory is a **developer tool artifact** — run locally, never committed
3. If a snapshot of the graph is needed for documentation, export only a screenshot or a trimmed JSON, stored in `docs/architecture/`

## Consequences

- Existing commits containing `graphify-out/` remain in git history (not rewritten to avoid disruption)
- New commits will not include graphify output
- Developers who need the graph run `graphify` locally
- The `docs/architecture/` folder can hold static snapshots if needed for onboarding

## References

- ADR-0001: Clean Architecture Adoption
- Original git history: branch `backend-clean-architecture`, commits containing `graphify-out/`
