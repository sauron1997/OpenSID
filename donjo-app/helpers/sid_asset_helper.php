<?php  if (!defined("BASEPATH")) exit("No direct script access allowed");

/**
 * SID Asset Helper
 *
 * Helper untuk memuat asset (CSS/JS/image) dengan cache busting berbasis
 * filemtime() sehingga browser selalu mengambil versi terbaru ketika
 * file berubah, tanpa perlu konfigurasi build tool.
 *
 * Strategi:
 *   base_url("assets/css/admin-style.css")
 *     => http://example.com/assets/css/admin-style.css
 *
 *   sid_asset("assets/css/admin-style.css")
 *     => http://example.com/assets/css/admin-style.css?v=1583385730
 *
 * Berkas ini di-autoload dari donjo-app/config/autoload.php sehingga
 * function sid_asset() tersedia di seluruh view, controller, dan model.
 *
 * @since   OpenSID Fase 1 - Cache Busting
 */

if (!function_exists("sid_asset"))
{
    /**
     * Bangun URL asset dengan cache-busting query string.
     *
     * Jika file ada di filesystem lokal (di bawah FCPATH), query string
     * ?v=<filemtime> ditambahkan. Setiap perubahan pada berkas akan
     * langsung di-bypass oleh cache browser/CDN karena URL dianggap berbeda.
     *
     * Jika file tidak ditemukan, function tetap mengembalikan URL
     * tanpa query string supaya 404 dapat dideteksi secara normal di
     * sisi client (bukan di-silent oleh query string yang menipu cache).
     *
     * @param   string  $path  Path relatif terhadap base_url.
     *                        Boleh dengan atau tanpa leading slash.
     * @return  string  URL absolut siap pakai di tag <link>, <script>, atau <img>.
     */
    function sid_asset($path)
    {
        // Normalisasi: buang leading slash agar konsisten dengan FCPATH (Windows friendly).
        $path = ltrim((string) $path, "/");

        // Path absolut di filesystem server.
        $full_path = FCPATH . $path;

        // Hanya tambahkan cache buster kalau file benar-benar ada,
        // supaya tidak menggembung URL untuk aset yang memang 404.
        if (is_file($full_path))
        {
            return base_url($path . "?v=" . filemtime($full_path));
        }

        return base_url($path);
    }
}

