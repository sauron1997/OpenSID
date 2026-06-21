# Phase 3 Report — Modularisasi JS & CSS

**Date:** 2026-06-21  
**Branch:** `frontend-modernization`  
**Predecessor:** Phase 2 (Build Pipeline)

---

## Summary

Monolithic `assets/js/script.js` (713 lines) dipecah menjadi **7 ES modules** di `resources/js/modules/`. Custom CSS di-deduplikasi dan diorganisasi. Vite build sukses — 10.31 kB admin bundle (3.44 kB gzipped).

## What Changed

### JS Modularization

| # | Module | Lines | Source (script.js) | Exports |
|---|--------|-------|---------------------|---------|
| 1 | `modules/utils.js` | 68 | 1–8, 469–487, 489–492, 583–593, 658–689 | `formatRupiah`, `scrollTampil`, `_calculateAge`, `urlencode`, `notification`, `base_url` |
| 2 | `modules/select2-init.js` | 72 | 63–139 | — (auto-init) |
| 3 | `modules/file-upload.js` | 35 | 141–218 | — (consolidated 5→1 loop) |
| 4 | `modules/datetime-pickers.js` | 89 | 220–364 | — (auto-init) |
| 5 | `modules/datatables-init.js` | 69 | 367–466 | — (auto-init) |
| 6 | `modules/form-helpers.js` | 114 | 494–635 | `checkAll`, `enableHapusTerpilih`, `deleteAllBox`, `aksiBorongan`, `modalBox`, `mapBox`, `formAction`, `cari_nik`, `select_options` |
| 7 | `modules/ui-helpers.js` | 96 | 39–52, 53–61, 349–353, 366, 416, 418, 420–425, 428–445, 637–656, 692–711 | — (auto-init, imports `formatRupiah`) |

**Total:** 543 lines (was 713 → 24% reduction via consolidation)

### Key Improvements

1. **File upload consolidation:** 5 near-identical blocks (78 lines) → 1 loop function (35 lines)
2. **Inter-module imports:** `datatables-init.js` imports `base_url` from `utils.js`; `ui-helpers.js` imports `formatRupiah` from `utils.js`
3. **Window globals preserved:** All legacy-caller functions (`checkAll`, `deleteAllBox`, etc.) still exposed on `window`
4. **jQuery pattern:** Each module uses `const $ = window.jQuery;` — no bundling jQuery into the Vite output

### CSS Consolidation

- **`resources/css/admin-custom.css`:** 421 → ~340 lines
- Duplicate blocks removed: `#op_item` (2 copies), `.table-bordered` (2 copies), `table.head` (2 copies), `.atas` (2 copies)
- Organized into 17 logical sections with comments
- Original `assets/css/admin-style.css` kept as-is (backward compatibility)

### Footer Update

- `donjo-app/views/footer.php` line 42: `script.js` → Vite bundle auto-detection
- Uses `glob()` to find `admin-*.js` in `assets/dist/js/`
- Falls back to `script.js` if Vite hasn't been built yet

## Build Output

```
assets/dist/js/admin-CIY_Xy5i.js   10.31 kB (gzip: 3.44 kB)
assets/dist/js/front-Dl2yyDCA.js   0.05 kB (gzip: 0.07 kB)
```

## Files Created

- `resources/js/modules/utils.js`
- `resources/js/modules/select2-init.js`
- `resources/js/modules/file-upload.js`
- `resources/js/modules/datetime-pickers.js`
- `resources/js/modules/datatables-init.js`
- `resources/js/modules/form-helpers.js`
- `resources/js/modules/ui-helpers.js`
- `PHASE_3_REPORT.md`

## Files Modified

- `resources/js/admin.entry.js` — import all 7 modules
- `resources/css/admin-custom.css` — deduplicated + organized
- `donjo-app/views/footer.php` — Vite bundle with fallback

## Next: Phase 4 — Upgrade AdminLTE 3 + Bootstrap 4

---

## What Was NOT Done (Scope Boundary)

- **Inline JS not extracted:** 202 inline `<script>` blocks (5,253 lines) identified in research but NOT touched — Cat C (PHP-mixed, 3,591 lines) dominates and requires runtime `data-*` attribute migration. This is a Phase 4/5 task.
- **`assets/js/script.js` not deleted:** Kept as backward compatibility fallback. Can be removed after Phase 4 migration is validated.
- **Other CSS files not touched:** `login-style.css`, `report.css`, `siteman_styles.css`, `surat.css`, `ui-buttons.css` remain unchanged — they serve specific pages (login, print, letterhead, public theme).
