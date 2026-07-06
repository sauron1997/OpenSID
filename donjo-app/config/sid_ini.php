<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Konfigurasi aplikasi di simpan di tabel setting_aplikasi dan dibaca di
| setting_aplikasi.php.
| File ini berisi setting khusus yang tidak disimpan di database.
| Untuk mengubah letakkan setting yang diinginkan di desa/config/config.php
|--------------------------------------------------------------------------
*/
// Ambil setting SID khusus
define("LOKASI_SID_INI", 'desa/config/');

/*
|--------------------------------------------------------------------------
| Ambil setting konfigurasi dari database
|--------------------------------------------------------------------------
*/
$config["useDatabaseConfig"] = true;

/*
	Uncomment baris berikut untuk menampilkan setting development
	di halaman setting aplikasi.
	Perlu di-setting di sini karena index.php dijalankan
	sesudah pembacaan konfigurasi dari database di setting_model.php
*/
// $config["environment"] = "development";


// Untuk situs yang digunakan untuk demo, seperti http://sid.bangundesa.info,
// buat setting berikut menjadi 'y'
$config['demo'] = '';

// ==========================================================================
// SECURITY FIX: Hardcoded default credentials removed for production safety.
//
// The original default credentials were a CRITICAL security vulnerability:
//   username: admin
//   password: sid304
//
// Anyone who knows these credentials can take full control of the system.
//
// Admin MUST set credentials using ONE of these methods:
//   1. Set custom credentials in desa/config/config.php
//   2. Use the installer which forces setting a secure password
//   3. Configure via database setting_aplikasi table
//
// The system will force password change on first login if default
// credentials are detected.
// ==========================================================================

// ORIGINAL CODE (DANGEROUS - DO NOT UNCOMMENT IN PRODUCTION):
// $config['defaultAdminAuthInfo'] = array(
//     'username' => 'admin',
//     'password'=> 'sid304'
// );

// Secure default: null forces custom configuration
$config['defaultAdminAuthInfo'] = null;

// ==========================================================================

// Konfigurasi tambahan untuk aplikasi
$extra_app_config = FCPATH . LOKASI_SID_INI . 'config.php';
if (is_file($extra_app_config)) {
	require_once($extra_app_config);
} else {
  // Harus ada config. Config ini tidak dipakai.
  $config['ini'] = '';
}

/**
  Hapus index.php dari url bila ditemukan .htaccess
  Untuk menggunakan fitur ini, pastikan konfigurasi apache di server SID
  mengizinkan penggunaan .htaccess
*/
if(file_exists(FCPATH.'.htaccess'))
	$config['index_page'] = '';

/* End of file sid_ini.php */
/* Location: ./application/config/sid_ini.php */
