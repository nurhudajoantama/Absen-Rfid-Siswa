<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index', ['filter' => 'auth']);

$routes->get('/login', 'Auth::login');
$routes->post('/auth', 'Auth::auth');
$routes->get('/logout', 'Auth::logout');

$routes->get('/pengaturan-akun', 'User::pengaturanAkun', ['filter' => 'auth']);
$routes->patch('/pengaturan-akun/simpan', 'User::simpanPengaturanAkun', ['filter' => 'auth']);
$routes->patch('/pengaturan-akun/ubah-password', 'User::ubahPassword', ['filter' => 'auth']);

$routes->get('/api/scan-rfid', 'Api::scanRFID');
$routes->get('/api/rfid-baru', 'Api::rfidBaru', ['filter' => 'auth:siswa']);
$routes->get('/api/get-privileges', 'Api::getPrivileges', ['filter' => 'auth:user']);

$routes->group('siswa', ['filter' => 'auth:siswa'], function ($routes) {
	$routes->get('/', 'Siswa::index');
	$routes->get('tambah', 'Siswa::tambah');
	$routes->get('(:num)', 'Siswa::detail/$1');
	$routes->post('simpan', 'Siswa::simpan');
	$routes->put('(:num)', 'Siswa::ubah/$1');
	$routes->delete('(:num)', 'Siswa::hapus/$1');
});

$routes->group('alat', ['filter' => 'auth:alat'], function ($routes) {
	$routes->get('/', 'Alat::index');
	$routes->get('tambah', 'Alat::tambah');
	$routes->get('(:num)', 'Alat::detail/$1');
	$routes->post('simpan', 'Alat::simpan');
	$routes->put('(:num)', 'Alat::ubah/$1');
	$routes->patch('ubah-status/(:num)', 'Alat::ubahStatus/$1');
	$routes->delete('(:num)', 'Alat::hapus/$1');
});

$routes->group('absen', ['filter' => 'auth:absensi'], function ($routes) {
	$routes->get('/', 'Absen::index');
	$routes->get('hapus', 'Absen::hapus');
	$routes->get('export-excel', 'Absen::exportExcel');
	$routes->post('get-excel', 'Absen::getExcel');
	$routes->delete('hapus', 'Absen::delete');
	$routes->delete('truncate', 'Absen::truncate');
});

$routes->group('user', ['filter' => 'auth:user'], function ($routes) {
	$routes->get('/', 'User::index');
	$routes->get('tambah', 'User::tambah');
	$routes->patch('(:num)', 'User::ubahPrivileges/$1');
	$routes->delete('(:num)', 'User::hapus/$1');
	$routes->post('simpan', 'User::simpan');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
