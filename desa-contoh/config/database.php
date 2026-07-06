<?php
// ============================================================
// KONFIGURASI DATABASE OPENSID - HOSTINGER
// ============================================================
//
// SECURITY WARNING: File ini berisi kredensial database sensitif.
// JANGAN pernah commit file ini ke repository publik!
//
// CARA MENGISI:
// 1. Login ke cPanel Hostinger Anda
// 2. Buka "MySQL Databases"
// 3. Buat database baru, buat user baru, lalu hubungkan keduanya
// 4. Isi nilai di bawah sesuai data yang Anda buat di cPanel
//
// CATATAN PENTING:
// - Di Hostinger, username dan database name diawali prefix akun
//   Contoh: u123456789_
// - hostname biasanya 'localhost' (tidak perlu diubah)
// ============================================================

// ---- GANTI NILAI DI BAWAH INI ----

$db['default']['hostname'] = 'localhost';
//  ^ Biasanya 'localhost' di Hostinger. Tidak perlu diubah.

$db['default']['username'] = 'u123456789_opensid';
//  ^ GANTI: Username database dari cPanel MySQL Databases
//    Contoh format Hostinger: u123456789_namauser

$db['default']['password'] = 'GantiDenganPasswordKuat!';
//  ^ GANTI: Password database yang Anda buat di cPanel

$db['default']['database'] = 'u123456789_opensid';
//  ^ GANTI: Nama database dari cPanel MySQL Databases
//    Contoh format Hostinger: u123456789_namadatabase

// ---- JANGAN UBAH DI BAWAH INI ----

$db['default']['dbdriver']   = 'mysqli';
$db['default']['dbprefix']   = '';
$db['default']['pconnect']   = FALSE;
$db['default']['db_debug']   = FALSE;
$db['default']['cache_on']   = FALSE;
$db['default']['cachedir']   = '';
$db['default']['char_set']   = 'utf8mb4';
$db['default']['dbcollat']   = 'utf8mb4_unicode_ci';
$db['default']['swap_pre']   = '';
$db['default']['encrypt']    = FALSE;
$db['default']['compress']   = FALSE;
$db['default']['stricton']   = FALSE;
$db['default']['failover']   = array();
$db['default']['port']       = 3306;
?>
