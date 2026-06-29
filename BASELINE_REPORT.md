# BASELINE REPORT: Frontend Modernization OpenSID

**Tanggal:** 20 Juni 2026  
**Branch:** `frontend-modernization`  
**Commit:** Initial baseline commit  
**Tujuan:** Titik ukur sebelum melakukan modernisasi frontend

---

## 1. Executive Summary

OpenSID memiliki **dua frontend terpisah** dengan stack yang tidak seragam:
- **Panel Admin** — AdminLTE 2.4.0 + Bootstrap 3.3.7 (keduanya **End-of-Life**)
- **Website Publik** — CSS custom berbasis float + Bootstrap parsial, 2 tema (default & hadakewa)

**Total aset frontend:**
| Tipe | Jumlah File | Total Ukuran |
|------|------------|-------------|
| CSS | ~98 file | ~1.1 MB |
| JavaScript | ~120+ file | ~5.34 MB |
| **Total** | **~218 file** | **~6.4 MB** |

---

## 2. Inventaris Library & Versi

### 2.1 Library Utama

| Library | Versi Saat Ini | Status | Target Upgrade |
|---------|---------------|--------|---------------|
| **AdminLTE** | v2.4.0 | 🔴 EOL | v3.2.x |
| **Bootstrap** | v3.3.7 | 🔴 EOL (sejak 2019) | v4.6.x |
| **jQuery** | 3.x | 🟡 Aktif | Tetap |
| **Font Awesome** | v4.x | 🔴 EOL | v6.x |
| **DataTables** | Ada (dimuat tapi tidak dipakai penuh) | 🟡 | Implementasi penuh |
| **TinyMCE** | v4.x (theme 'modern') | 🔴 EOL | v5/6 |
| **Leaflet** | Aktif | 🟢 | Tetap |
| **Highcharts** | Ada | 🟡 | Evaluasi |
| **Select2** | Ada | 🟢 | Tetap |

### 2.2 Library Pendukung Admin

| Library | File | Status |
|---------|------|--------|
| bootstrap-colorpicker | ✅ Ada | Integrasi AdminLTE 2 |
| bootstrap-datepicker | ✅ Ada | Integrasi AdminLTE 2 |
| bootstrap-datetimepicker | ✅ Ada | Integrasi AdminLTE 2 |
| bootstrap-timepicker | ✅ Ada | Integrasi AdminLTE 2 |
| bootstrap-notify | ✅ Ada | Untuk notifikasi |
| daterangepicker | ✅ Ada | moment.js dependency |
| fastclick | ✅ Ada | Mobile optimization |
| slimscroll | ✅ Ada | Scrollbar custom |
| jquery-ui | ✅ Ada | Autocomplete |
| inputmask | ✅ Ada | Input formatting |
| jquery-validate | ✅ Ada | Form validation |
| sweetalert | ✅ Ada | Alert dialog |
| numeral.js | ✅ Ada | Number formatting |

---

## 3. Analisis CSS

### 3.1 File CSS Admin (Custom)

| File | Ukuran | Fungsi |
|------|--------|--------|
| `admin-style.css` | 7.86 KB | Override & style admin global |
| `siteman_styles.css` | 10.76 KB | Style halaman login (siteman) |
| `login-style.css` | 5.41 KB | Layout halaman login |
| `login-form-elements.css` | 2.40 KB | Komponen form login |
| `surat.css` | 1.40 KB | Format surat & cetak |
| `report.css` | 1.37 KB | Laporan & print |
| `ui-buttons.css` | 7.84 KB | Komponen tombol custom |
| `ui-icons.css` | 2.00 KB | Ikon custom |

### 3.2 File CSS Vendor

| File | Ukuran | Keterangan |
|------|--------|-----------|
| `AdminLTE.css` | 108.90 KB | Template admin utama |
| `AdminLTE.min.css` | 89.36 KB | Minified |
| `bootstrap.min.css` | 118.46 KB | Bootstrap 3.3.7 |
| `bootstrap.bar.css` | 144.27 KB | Bootstrap bar variant |
| `_all-skins.css` | 47.29 KB | Skin AdminLTE |
| Leaflet stack | ~53 KB | 3 file CSS peta |
| Print CSS (2 folder) | ~14 KB | Legacy print preview |

### 3.3 File CSS Tema Publik

| Tema | File Utama | Ukuran |
|------|-----------|--------|
| **default** | `first.css` | 34.14 KB |
| **default** | `general.css` | 7.70 KB |
| **hadakewa** | (struktur serupa) | ~ |

### 3.4 Temuan CSS

| # | Temuan | Dampak |
|---|--------|--------|
| 1 | AdminLTE.css dan AdminLTE.min.css ada bersamaan (duplikasi) | Bloat |
| 2 | Bootstrap dimuat 2 versi (`bootstrap.min.css` + `bootstrap.bar.css`) | Konflik potensial |
| 3 | Print CSS ada di 2 folder berbeda (`css/css/` dan `css/print-css/`) | Duplikasi |
| 4 | CSS inline tersebar di views (belum dihitung total) | Maintainability |
| 5 | Skin AdminLTE dimuat via `_all-skins.css` (semua skin sekaligus) | Performance |
| 6 | Tidak ada CSS variables, semua hard-coded | Konsistensi |

---

## 4. Analisis JavaScript

### 4.1 File JS Custom

| File | Ukuran | Baris | Fungsi Utama |
|------|--------|-------|-------------|
| `script.js` | 17.1 KB | 713 | **Admin UI monolitik**: Select2, DataTable, DateTimePicker, file upload, modal, notifikasi |
| `validasi.js` | 4.0 KB | 161 | jQuery Validate wrapper (surat, NIK, nomor urut) |
| `peta.js` | 16.8 KB | 647 | GIS/Leaflet + Turf.js (marker, polygon, GeoJSON) |
| `leaflet-providers.js` | 24.5 KB | ~383 | Tile provider registry |
| `leaflet.filelayer.js` | 11.3 KB | - | Drag-drop file loader |
| `togeojson.js` | 17.7 KB | - | KML/GPX → GeoJSON |
| `togpx.js` | 17.5 KB | - | GeoJSON → GPX |

### 4.2 File JS Vendor (Bootstrap/Plugins)

| File | Ukuran | Keterangan |
|------|--------|-----------|
| `jquery.min.js` | ~87 KB | jQuery 3 |
| `jquery.js` | ~263 KB | Unminified jQuery |
| `bootstrap.min.js` | ~37 KB | Bootstrap 3 JS |
| `bootstrap.js` | ~70 KB | Unminified |
| `adminlte.min.js` | ~14 KB | AdminLTE JS |
| `dataTables.bootstrap.min.js` | ~3 KB | DataTables integration |
| `select2.full.min.js` | ~28 KB | Select2 |
| `jquery-ui.min.js` | ~253 KB | jQuery UI |
| `moment.min.js` | ~57 KB | Date library |

### 4.3 Library Vendored

| Library | Lokasi | Ukuran Total |
|---------|--------|-------------|
| TinyMCE | `assets/js/tinymce/` | ~ |
| Highcharts | `assets/js/highcharts/` | ~ |
| Leaflet plugins | `assets/js/` | ~90 KB |

### 4.4 Analisis script.js (713 baris)

**Pola kode:**
- ❌ **Tidak modular** — semua di satu file, global scope
- ❌ **Tidak ada jQuery noConflict**
- ❌ **Tidak ada module pattern** (IIFE)
- ❌ **Tidak ada lazy loading** — semua diinisialisasi meski halaman tidak butuh
- ✅ Menggunakan jQuery document ready pattern
- ✅ Beberapa validasi terpusat di validasi.js

**Fungsi yang didefinisikan di script.js:**
1. Select2 initialization (dropdown select)
2. DataTable initialization
3. DateTimePicker setup
4. File upload handlers
5. Modal dialogs
6. Notification/alert system
7. Form interactions
8. Print functionality
9. Auto-complete
10. Various event handlers

### 4.5 Analisis validasi.js (161 baris)

Wrapper jQuery Validate untuk:
- Validasi surat (form surat desa)
- Validasi NIK (format 16 digit)
- Validasi nomor urut
- Validasi form umum

### 4.6 Analisis peta.js (647 baris)

Fitur GIS berbasis Leaflet + Turf.js:
- Peta wilayah desa (marker, polygon)
- Layer dusun/RW/RT
- GeoJSON import/export
- Area calculation
- Geocoding/search

### 4.7 Inline JavaScript Audit

| Pattern | Jumlah Estimasi | Keterangan |
|---------|----------------|-----------|
| `<script>` tag di views | **Banyak** (belum dihitung persis) | JS inline di PHP views |
| `onclick=` | **Banyak** | Event handler inline |
| `onchange=` | **Banyak** | Form change handler |
| `onsubmit=` | Beberapa | Form submit handler |

### 4.8 Temuan JavaScript

| # | Temuan | Dampak |
|---|--------|--------|
| 1 | jQuery dimuat **dua kali** (header.php:59 + footer.php:10) | Redundant, conflict potensial |
| 2 | `script.js` 713 baris monolitik tanpa modularitas | Maintainability |
| 3 | DataTables dimuat tapi tidak dipakai penuh | Dead code |
| 4 | Banyak inline JS di views (onclick, onchange, dll) | Separation of concerns |
| 5 | Tidak ada build tool (webpack/vite) | Optimasi, cache busting |
| 6 | Tidak ada versioning/cache busting asset | Browser cache issue |
| 7 | jquery.js dan jquery.min.js ada keduanya | Duplikasi |
| 8 | bootstrap.js dan bootstrap.min.js ada keduanya | Duplikasi |

---

## 5. Analisis Template & View

### 5.1 Admin Template Structure

**header.php (176 baris)**
- Meta viewport: ✅ Ada
- CSS yang dimuat: **21 file**
- JS yang dimuat di head: **10 file** (termasuk jQuery pertama)
- AdminLTE layout: sidebar-mini, fixed, sidebar-collapse opsional
- Header navigation dengan user dropdown
- 2 modal dialog (user settings & password warning)

**footer.php (138 baris)**
- JS yang dimuat: **13 file tambahan** (termasuk jQuery kedua!)
- Notification system (success/error)
- Password change reminder modal
- PIN notification
- Auto-refresh komentar & laporan (setiap 3 detik via AJAX)

**nav.php (57 baris)**
- User panel dengan logo desa
- Dynamic menu dari database (`$modul` array)
- Treeview menu dengan sub-menu
- Active state tracking (`$this->modul_ini`, `$act_sub`)

### 5.2 Web Publik Template

**themes/default/template.php**
- Layout berbasis CSS float lawas (`#maincontainer`, `#contentwrapper`, `#rightcolumn`)
- Bootstrap dimuat hanya untuk komponen (navbar, box, btn, pagination)
- Menu atas & menu kiri dari `first_menu_m`
- Widget area, teks berjalan, slider

**themes/hadakewa/**
- Tema alternatif, struktur serupa default

### 5.3 View Pattern Analysis

Pola umum view admin:
```php
$this->load->view('header', $header);
$this->load->view('nav', $nav);
$this->load->view('module/content', $data);
$this->load->view('footer');
```

Setiap view module biasanya berisi:
- Tabel data (kadang DataTable, kadang custom)
- Form input/edit (dengan jQuery Validate)
- Modal dialog (Bootstrap modal)
- AJAX calls inline

---

## 6. Breaking Changes Inventory (BS3 → BS4)

### 6.1 Pola BS3 yang Perlu Dimigrasi

| Pattern BS3 | Jumlah | Contoh File | Pengganti BS4 |
|------------|--------|-------------|--------------|
| `col-xs-*` | Banyak (semua view) | Semua views | `col-*` |
| `.panel` | Banyak | Dashboard, form | `.card` |
| `glyphicon` | Beberapa | Nav, buttons | Font Awesome icon |
| `.pull-left` / `.pull-right` | Banyak | Header, nav, tabel | `.float-left` / `.float-right` |
| `.hidden-*` | Banyak | Conditional display | `.d-none` / `.d-sm-none` |
| `.col-md-offset-*` | Beberapa | Forms | `.offset-md-*` |
| `.btn-default` | Banyak | Semua tombol | `.btn-secondary` / `.btn-light` |
| `.form-group` | Banyak | Semua form | Masih ada di BS4 |
| `.input-group-addon` | Beberapa | Forms | `.input-group-prepend/append` |
| `.nav-pills` | Beberapa | Tab navigation | Struktur berbeda di BS4 |

### 6.2 AdminLTE 2 → 3 Migration Points

| Aspek | AdminLTE 2 | AdminLTE 3 |
|-------|-----------|-----------|
| Wrapper class | `skin-blue` | `layout-navbar-fixed` |
| Sidebar | `sidebar-mini` | `sidebar-mini` (sama) |
| Card vs Box | `.box` | `.card` |
| Info box | `.info-box` | `.info-box` (revised) |
| Small box | `.small-box` | `.small-box` (revised) |
| Widget | `.box-body` | `.card-body` |
| Widget header | `.box-header` | `.card-header` |
| Widget footer | `.box-footer` | `.card-footer` |

---

## 7. Daftar File yang Akan Dimodifikasi

### 7.1 File Template Utama (Prioritas Tinggi)

| File | Status | Perubahan |
|------|--------|----------|
| `donjo-app/views/header.php` | Prioritas tinggi | Upgrade ke AdminLTE 3 |
| `donjo-app/views/footer.php` | Prioritas tinggi | Upgrade ke AdminLTE 3, hapus jQuery duplikat |
| `donjo-app/views/nav.php` | Prioritas tinggi | Upgrade sidebar |
| `themes/default/template.php` | Prioritas medium | Layout responsif |
| `donjo-app/views/siteman.php` | Prioritas medium | Redesign login |

### 7.2 File CSS yang Akan Di-refactor

| File | Status | Perubahan |
|------|--------|----------|
| `assets/css/admin-style.css` | Akan di-refactor | Consolidate, CSS variables |
| `assets/css/siteman_styles.css` | Akan di-refactor | Consolidate |
| `assets/css/surat.css` | Akan di-refactor | Konsolidasi |
| `assets/css/ui-buttons.css` | Akan digabung | Merge ke main stylesheet |
| `assets/css/ui-icons.css` | Akan digabung | Merge ke main stylesheet |

### 7.3 File JS yang Akan Dimodularisasi

| File | Status | Perubahan |
|------|--------|----------|
| `assets/js/script.js` | **Monolit → Modular** | Pecah per domain |
| `assets/js/validasi.js` | Akan di-refactor | Module pattern |
| `assets/js/peta.js` | Akan di-refactor | Module pattern |

---

## 8. Risiko & Mitigasi

| Risiko | Level | Mitigasi |
|--------|-------|----------|
| Breaking semua view saat migrasi BS3→BS4 | 🔴 Tinggi | Migrasi per modul, regresi visual tiap langkah |
| Fungsi JS hilang saat modularisasi | 🟡 Medium | Unit test per fungsi sebelum & sesudah |
| Layout web publik rusak | 🟡 Medium | Tema default dipertahankan, hanya refactor |
| Plugin pihak ketiga tidak kompatibel BS4 | 🟡 Medium | Cek kompatibilitas sebelum upgrade |
| Performance menurun (asset lebih besar) | 🟢 Rendah | Vite build pipeline akan compress |

---

## 9. Roadmap Eksekusi

### Fase 1 — Quick Wins (Risiko Rendah)
- [ ] Hapus duplikasi jQuery
- [ ] Hapus dead code (DataTables tidak terpakai)
- [ ] Cache busting asset

### Fase 2 — Build Pipeline
- [ ] Vite setup
- [ ] Asset manifest & helper PHP

### Fase 3 — Modularisasi
- [ ] Pecah script.js per domain
- [ ] Konsolidasi CSS

### Fase 4 — Upgrade AdminLTE 3
- [ ] Install AdminLTE 3.2.x + Bootstrap 4.6
- [ ] Migrasi header/footer/nav
- [ ] Migrasi per modul (dashboard → kependudukan → surat → web → pengaturan → GIS)
- [ ] Konversi semua breaking changes BS3→BS4

### Fase 5 — Web Publik Responsif
- [ ] Layout float → grid modern
- [ ] Mobile-first responsive

### Fase 6 — Aksesibilitas
- [ ] WCAG 2.2 AA compliance

---

## 10. Success Criteria Per Fase

| Fase | Kriteria Sukses |
|------|----------------|
| 1 | Render identik baseline, tidak ada 404 di network |
| 2 | `npm run build` sukses, asset load dari dist |
| 3 | Modul JS terpisah, console bersih |
| 4 | Setiap modul admin visual + fungsional identik |
| 5 | Responsive di viewport mobile/tablet/desktop |
| 6 | Audit aksesibilitas lulus |

---

*Generated by orchestrator audit process — 20 Juni 2026*
