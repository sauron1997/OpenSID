# Phase 4 Report — Upgrade AdminLTE 3 + Bootstrap 4

**Date:** 2026-06-21  
**Branch:** `frontend-modernization`  
**Commit:** `6bf423b`  
**Predecessor:** Phase 3 (Modularisasi JS & CSS)

---

## Summary

Upgrade dari **AdminLTE 2.4.0 + Bootstrap 3.3.7** ke **AdminLTE 3.2.0 + Bootstrap 4.6.2**. Migrasi 3 template utama (header/footer/nav) dan konversi bulk BS3→BS4 di **373 file** dengan **2,647 replacements** otomatis via script.

## What Changed

### npm Packages Installed

| Package | Version | Purpose |
|---------|---------|---------|
| `admin-lte` | 3.2.0 | AdminLTE 3 + Bootstrap 4 (bundled) |
| `bootstrap` | 4.6.2 | Bootstrap 4 (peer dep) |
| `@fortawesome/fontawesome-free` | 5.15.4 | Font Awesome 5 |
| `popper.js` | 1.16.1 | Popper (dropdowns, tooltips) |
| `datatables.net` | 1.13.11 | DataTables core |
| `datatables.net-bs4` | 1.13.11 | DataTables BS4 integration |
| `datatables.net-responsive` | 2.5.1 | DataTables Responsive |
| `datatables.net-responsive-bs4` | 2.5.1 | Responsive BS4 integration |
| `select2` | 4.1.0 | Select2 (enhanced select) |
| `sweetalert2` | 11.26.25 | SweetAlert2 |
| `moment` | 2.30.1 | Moment.js + id locale |
| `bootstrap-colorpicker` | 3.4.0 | Colorpicker (BS4 compat) |
| `bootstrap-daterangepicker` | 3.1.0 | Date range picker |
| `jquery-validation` | 1.22.1 | Form validation |

### Template Migration

| File | Changes |
|------|---------|
| `donjo-app/views/header.php` | Complete rewrite: AdminLTE 3 navbar (`main-header navbar navbar-expand`), CSS auto-detected via `glob()`, removed all BS3 CSS refs (bootstrap.min.css, font-awesome.min.css, ionicons.min.css, AdminLTE.min.css, _all-skins.min.css), added `<div class="content-wrapper">` opener, modals updated for BS4 close button structure |
| `donjo-app/views/footer.php` | Complete rewrite: closes `content-wrapper`, loads vendor JS from `assets/dist/vendor/`, removed jQuery duplicate, Bootstrap 3 JS removed, AdminLTE 3 JS from vendor dir, Vite bundle fallback preserved, footer uses `float-right d-none d-sm-block` |
| `donjo-app/views/nav.php` | Complete rewrite: AdminLTE 3 sidebar (`sidebar-dark-primary elevation-4`), brand-link with logo, user-panel with d-flex layout, `nav-pills nav-sidebar` menu, `has-treeview` + `nav-treeview` structure, FA5 icons |

### Bulk BS3→BS4 Conversion (2,647 replacements)

| Pattern | Count | Target |
|---------|-------|--------|
| `control-label` → `col-form-label` | 701 | Form labels |
| `box-body` → `card-body` | 327 | AdminLTE card body |
| `class="box X"` → `class="card X"` | 295 | AdminLTE card wrapper |
| `box-header` → `card-header` | 264 | Card header |
| `box-info` → `card-info` | 211 | Card variant |
| `form-horizontal` → removed | 150 | Removed in BS4 |
| `pull-right` → `float-right` | 139 | Float utility |
| `col-xs-N` → `col-N` | 118 | BS4 column default |
| `box-title` → `card-title` | 116 | Card title |
| `box-footer` → `card-footer` | 80 | Card footer |
| `input-group-addon` → `input-group-text` | 76 | Input group |
| `box-tools` → `card-tools` | 62 | Card tools |
| `box-danger` → `card-danger` | 61 | Card variant |
| `btn-default` → `btn-secondary` | 44 | Button variant |
| `box-primary` → `card-primary` | 31 | Card variant |
| `box-solid` → `card card-solid` | 30 | Card solid |
| `fa-arrow-circle-o-left` → `far fa-arrow-alt-circle-left` | 23 | FA4→FA5 icon |
| `pull-left` → `float-left` | 19 | Float utility |
| Various other | 40+ | Multiple patterns |

### Build Pipeline Updates

**Vite config (`vite.config.js`):**
- Added `external: ['jquery', 'moment']` (don't bundle)
- Added `globals` for external deps
- Added `css.preprocessorOptions`

**CSS entry point (`resources/css/admin-vendor.entry.css`):**
- Imports AdminLTE 3 CSS (includes Bootstrap 4)
- Imports Font Awesome 5
- Imports Select2, DataTables BS4, SweetAlert2, Colorpicker, Daterangepicker CSS

**Admin entry point (`resources/js/admin.entry.js`):**
- Added CSS imports at top (vendor + custom)
- All 7 JS modules from Phase 3 preserved

### Build Output

```
assets/dist/css/admin-DaU0YoSb.css   1,507.13 kB (gzip: 148.24 kB)
assets/dist/js/admin-BguoIC9B.js        10.31 kB (gzip:   3.44 kB)
assets/dist/js/front-Dl2yyDCA.js         0.05 kB (gzip:   0.07 kB)
assets/dist/css/fa-*-*.woff2/.ttf/.eot/.svg   (Font Awesome webfonts)
```

## Files Created

- `resources/css/admin-vendor.entry.css` — CSS entry for Vite bundle
- `assets/dist/vendor/` — Vendor assets (copied from node_modules)
  - `css/` — adminlte.min.css, fontawesome.min.css, select2.min.css, etc.
  - `js/` — adminlte.min.js, select2.min.js, moment.min.js, sweetalert2, etc.
  - `webfonts/` — Font Awesome webfonts

## Files Modified

- `vite.config.js` — External deps, globals, CSS options
- `resources/js/admin.entry.js` — Added CSS imports
- `package.json` — 14 npm dependencies added
- `donjo-app/views/header.php` — Complete AdminLTE 3 rewrite
- `donjo-app/views/footer.php` — Complete AdminLTE 3 rewrite
- `donjo-app/views/nav.php` — Complete AdminLTE 3 rewrite
- **370+ view files** — Bulk BS3→BS4 class conversion

## Git History (frontend-modernization branch)

```
6bf423b Phase 4: Upgrade AdminLTE 3 + Bootstrap 4
927101c Phase 3: Modularisasi JS & CSS
e096605 Phase 2: Build Pipeline
c8dccf0 Phase 1: Quick Wins
422706a Phase 0: Baseline Report
c520f61 Initial baseline commit
```

## What Was NOT Done (Scope Boundary)

- **Inline JS extraction:** 3,591 lines of PHP-mixed inline JS still need `data-*` attribute migration (deferred)
- **Web Publik themes:** `themes/default/` and `themes/hadakewa/` were NOT modified for AdminLTE (only received BS3→BS4 class fixes for shared patterns)
- **DateTimePicker:** Bootstrap-datetimepicker (BS3 only) not replaced with tempusdominus-bootstrap-4 yet (deferred - complex API rewrite)
- **SweetAlert v1→v2:** Some views may still use old Swal API (deferred - needs per-file review)
- **TinyMCE upgrade:** Not part of this phase (deferred)
- **FA4→FA5 full audit:** Common icons converted, but some custom FA4 icons in views may still need manual review
- **`assets/js/script.js` not deleted:** Still kept as fallback

## Next: Phase 5 — Web Publik Responsif

- Refactor `themes/default/template.php` layout float → grid
- Mobile-first responsive design
- Widget modernization

---

*Generated 2026-06-21*
