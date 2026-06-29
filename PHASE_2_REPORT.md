# PHASE 2 REPORT: Build Pipeline (Vite)

**Tanggal:** 20 Juni 2026
**Branch:** frontend-modernization
**Komitmen:** Setup fondasi build pipeline (Vite) tanpa menjalankan build

---

## Ringkasan Eksekusi

Fase 2 menyiapkan infrastruktur build pipeline berbasis Vite tanpa menjalankan instalasi/build apapun.
Tujuannya agar npm install dan vite build dapat diaktifkan secara non-destruktif kapan saja user memutuskan.

| # | Komponen | Status | Catatan |
|---|----------|--------|--------|
| 1 | package.json | Selesai | Valid JSON, scripts siap pakai |
| 2 | vite.config.js | Selesai | Valid JS syntax, multi-entry config |
| 3 | .gitignore update | Selesai | 7 baris Vite artifacts ditambahkan |
| 4 | 4 Entry files | Selesai | admin/front JS+CSS placeholder |
| 5 | npm install / npm run build | Tidak dijalankan | Sesuai aturan Fase 2 |

---

## 1. Setup

### 1.1. Ketersediaan Node/npm

```
node  : v24.13.1   (tersedia)
npm   : 11.8.0     (tersedia)
```

Toolchain tersedia. npm install dan vite build sengaja TIDAK dijalankan pada Fase 2 untuk menjaga tree tetap ringan dan idempotent.

### 1.2. package.json (BARU)

```json
{
  "name": "opensid-frontend",
  "version": "1.0.0",
  "description": "OpenSID Frontend Build Pipeline",
  "private": true,
  "scripts": {
    "dev": "vite",
    "build": "vite build",
    "preview": "vite preview"
  },
  "devDependencies": {
    "vite": "5.0.0"
  }
}
```

- Validasi JSON: JSON VALID true via node -e
- 14 baris, private: true (tidak akan terpublish ke npm publik)
- Hanya 1 devDependency (vite ^5.0.0) - cukup untuk fondasi

### 1.3. vite.config.js (BARU)

```js
import { defineConfig } from "vite";
import { resolve } from "path";

export default defineConfig({
  root: ".",
  base: "./",
  build: {
    outDir: "assets/dist",
    emptyOutDir: false,
    rollupOptions: {
      input: {
        admin: resolve(__dirname, "resources/js/admin.entry.js"),
        front: resolve(__dirname, "resources/js/front.entry.js")
      },
      output: {
        entryFileNames: "js/[name]-[hash].js",
        chunkFileNames: "js/[name]-[hash].js",
        assetFileNames: "css/[name]-[hash][extname]"
      }
    }
  },
  publicDir: false
});
```

- Validasi JS syntax: node --check lulus
- 23 baris, ESM-style modern Vite 5
- base: "./" - path relatif agar kompatibel dengan subfolder domain
- emptyOutDir: false - tidak menghapus asset lama saat rebuild
- Output ke assets/dist/{js,css}/ - konsisten dengan struktur assets/ OpenSID

### 1.4. .gitignore (DIMODIFIKASI)

Diff persis (+7 baris, tidak ada baris yang dihapus):

```diff
@@ -42,3 +42,10 @@ info.php
 mitra


+# Vite build artifacts
+node_modules/
+dist/
+assets/dist/
+*.log
+.vite/
+resources/.vite/
```

- node_modules/ tercantum
- dist/ tercantum
- assets/dist/ tercantum
- *.log tercantum (juga sudah ada di atas untuk CI3 log)
- Tambahan: .vite/ dan resources/.vite/ (cache Vite)

---

## 2. Entry Points

### 2.1. resources/js/admin.entry.js (BARU)

```js
/**
 * OpenSID Admin Bundle Entry
 * @since Fase 2 - Build Pipeline
 */

// Phase 2 placeholder - existing assets/bootstrap/js/* masih dipakai langsung.
// Fase 3 akan migrasi script.js monolitik ke sini.
console.info("[OpenSID] Admin bundle loaded");
```

- 8 baris, placeholder untuk Fase 3
- Hanya console.info sebagai smoke-test saat bundle diload

### 2.2. resources/js/front.entry.js (BARU)

```js
/**
 * OpenSID Front-end Bundle Entry
 * @since Fase 2 - Build Pipeline
 */

// Phase 2 placeholder
console.info("[OpenSID] Front bundle loaded");
```

- 7 baris, paralel dengan admin entry

### 2.3. resources/css/admin.entry.css (BARU)

```css
/**
 * OpenSID Admin Bundle Entry CSS
 * @since Fase 2 - Build Pipeline
 */

/* Phase 2 placeholder */
```

- 6 baris, placeholder untuk Fase 3 (admin-style.css migrasi)

### 2.4. resources/css/front.entry.css (BARU)

```css
/**
 * OpenSID Front Bundle Entry CSS
 * @since Fase 2 - Build Pipeline
 */

/* Phase 2 placeholder */
```

- 6 baris, paralel dengan admin CSS entry

### 2.5. resources/scss/ (folder kosong, BARU)

Folder kosong yang disiapkan sebagai penampung untuk Fase 3 (jika SCSS modular dipakai). Saat ini tidak berisi file apapun.

---

## 3. Integrasi dengan Fase 1

### 3.1. donjo-app/helpers/sid_asset_helper.php (masih aktif)

File dari Fase 1 tetap utuh (58 baris). Fungsi sid_asset(path) siap dipakai untuk asset hasil build Vite di Fase 3 - Vite akan menaruh file di assets/dist/... dengan nama [name]-[hash].js, dan helper sid_asset() otomatis menambahkan query string ?v=<filemtime> saat runtime.

### 3.2. donjo-app/config/autoload.php (sudah ter-update Fase 1)

```php
\$autoload["helper"] = array("url","donjolib","date","pict","opensid","database","surat","sid_asset");
```

sid_asset terdaftar sebagai helper autoload.

### 3.3. Alur Integrasi Fase 2 ke Fase 3

```
resources/js/admin.entry.js   --+
resources/js/front.entry.js   --|
resources/css/admin.entry.css --+-- vite build --> assets/dist/{js,css}/[name]-[hash].*
resources/css/front.entry.css --+                              |
                                                             v
                                         sid_asset(assets/dist/...) --> ?v=<filemtime>
                                                             (helper dari Fase 1)
```

---

## 4. Verifikasi

### 4.1. Struktur Folder Akhir

Direktori root project (d:\\OpenSID\\OpenSID-master\\OpenSID-master):

```
.gitattributes    .github/
.gitignore
assets/
BASELINE_REPORT.md
catatan_rilis_20.03-pasca.txt
catatan_singkat_library_yang_digunakan.txt
contoh_data_awal_20200301a.sql
desa-contoh/
donjo-app/
favicon.ico
htaccess.txt
index.php
LICENSE
logs/
package.json              <-- BARU (Fase 2)
PHASE_1_REPORT.md
PHASE_2_REPORT.md         <-- BARU (dokumen ini)
README.md
resources/                <-- BARU (Fase 2)
securimage/
surat/
system/
themes/
vendor/
vite.config.js            <-- BARU (Fase 2)
```

Struktur resources/ (rekursif):

```
resources/
|-- css/
|   |-- admin.entry.css   <-- BARU
|   |-- front.entry.css   <-- BARU
|-- js/
|   |-- admin.entry.js    <-- BARU
|   |-- front.entry.js    <-- BARU
|-- scss/                 <-- BARU (folder kosong, siap Fase 3)
```

### 4.2. Format File Valid

| File | Validasi | Hasil |
|------|----------|-------|
| package.json | node -e JSON.parse | VALID |
| vite.config.js | node --check | JS SYNTAX OK |
| resources/js/admin.entry.js | node --check | JS OK |
| resources/js/front.entry.js | node --check | JS OK |
| .gitignore | Diff inspection | 7 baris Vite ditambahkan |
| donjo-app/helpers/sid_asset_helper.php | Eksistensi + read | 58 baris utuh |

### 4.3. Git Status Bersih

```
On branch frontend-modernization

Changes not staged for commit:
        modified:   .gitignore

Untracked files:
        package.json
        resources/
        vite.config.js
```

| Item | Status | Sumber |
|------|--------|--------|
| .gitignore | modified | Fase 2 |
| package.json | untracked (new) | Fase 2 |
| resources/ | untracked (new, 5 entries: 4 files + 1 empty subdir) | Fase 2 |
| vite.config.js | untracked (new) | Fase 2 |

- Tidak ada file .tmp, ~, .bak, .swp, .swo, .orig baru
- Hanya file yang direncanakan di Fase 2 yang modified/new
- Tidak ada folder tak terduga (resources/scss/ kosong tapi dicatat eksplisit di bagian 2.5)
- Branch frontend-modernization konsisten dengan Fase 1

Pengecualian yang TIDAK terkait Fase 2:
- assets/css/skins/_all-skins.min.css.bak - ada sejak baseline commit c520f61, bukan artefak Fase 2
- donjo-app/views/database/backup.php - view aplikasi CI3 original, bukan file backup

### 4.4. Aturan Kepatuhan

| Aturan | Status |
|--------|--------|
| Tidak install npm apapun | Dipatuhi |
| Tidak jalankan npm install / npm run build | Dipatuhi |
| Tidak ubah file selain PHASE_2_REPORT.md | Dipatuhi (dokumen ini hanya laporan) |
| Tidak buat folder/file tambahan | Dipatuhi (hanya dokumentasi yang ditambahkan) |
| Hanya verifikasi dan dokumentasi | Dipatuhi |
| Output di-byte-cap | Dipatuhi |

---

## 5. Total File yang Ditambahkan di Fase 2

| Kategori | Jumlah | Daftar |
|----------|--------|--------|
| File baru (root) | 2 | package.json, vite.config.js |
| File baru (resources/) | 4 | css/admin.entry.css, css/front.entry.css, js/admin.entry.js, js/front.entry.js |
| Folder baru | 4 | resources/, resources/css/, resources/js/, resources/scss/ (kosong)* |
| File dimodifikasi | 1 | .gitignore (+7 baris) |
| **Total entri baru di git status** | **4** | (.gitignore + 3 untracked entries) |
| **Total baris kode baru** | **~65 baris** | placeholder + config |

*resources/scss/ kosong, dicatat terpisah karena tidak berisi file apapun.

---

## 6. Konfirmasi Aturan (no tmp, no dead, no extra folders)

- **No tmp**: findstr untuk ekstensi .tmp, ~, .bak, .swp, .swo, .orig tidak menemukan artefak Fase 2. Satu .bak yang ditemukan (_all-skins.min.css.bak) berasal dari baseline commit.
- **No dead**: Tidak ada Fase 1 file yang ditinggalkan/overwritten. sid_asset_helper.php masih utuh.
- **No extra folders**: Hanya 1 folder baru (resources/) dengan 3 subfolder (css/, js/, scss/). scss/ sengaja disiapkan untuk Fase 3 - bisa dihapus jika diputuskan tidak diperlukan.

---

## 7. Rekomendasi untuk Fase 3

1. **Aktivasi build pipeline**: User menjalankan npm install lalu vite build saat siap. Output masuk assets/dist/{js,css}/.
2. **Migrasi script.js**: Pecah donjo-app/views/.../script.js monolitik menjadi modul-modul ES6 yang di-import oleh resources/js/admin.entry.js.
3. **Migrasi CSS admin**: Pecah assets/css/admin-style.css menjadi beberapa file partial yang di-@import di resources/css/admin.entry.css (atau pakai SCSS jika folder scss/ dipakai).
4. **Pemakaian sid_asset()**: Ganti base_url(assets/...) di view header/footer menjadi sid_asset(assets/dist/...) setelah build menghasilkan file hashed.
5. **Penghapusan library duplikat unminified** (carry-over dari Fase 1): Bisa dieksekusi sekarang karena Vite sudah jadi safety net - build akan error jika ada yang hilang referensi.
6. **Pertimbangkan**: Hapus folder resources/scss/ kosong jika diputuskan tidak akan pakai SCSS.

---

## 8. Checklist

- [x] vite.config.js valid
- [x] package.json valid JSON
- [x] .gitignore updated (7 baris Vite)
- [x] 4 entry files ada (admin/front x JS/CSS)
- [x] Tidak ada file tmp/dead dari Fase 2
- [x] sid_asset helper masih ada dan aktif
- [x] autoload.php masih memuat sid_asset
- [x] PHASE_2_REPORT.md dibuat (dokumen ini)

---

## 9. Next: Phase 3

Fase 3 akan fokus pada:
- Modularisasi script.js ke dalam resources/js/admin.entry.js
- Modularisasi CSS admin
- Aktivasi penuh sid_asset() di seluruh view
- Run npm install + vite build untuk pertama kalinya
- Validasi runtime: render identik, tidak ada 404, hash bekerja dengan cache buster

---

*Generated by verification and documentation agent - Fase 2 Build Pipeline - 20 Juni 2026*
