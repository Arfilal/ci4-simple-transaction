<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/produk', 'Produk::index');
$routes->get('/produk/create', 'Produk::create');
$routes->post('/produk/store', 'Produk::store');
$routes->get('/produk/edit/(:num)', 'Produk::edit/$1');
$routes->post('/produk/update', 'Produk::update');
$routes->get('/produk/delete/(:num)', 'Produk::delete/$1');

$routes->get('/transaksi', 'Transaksi::index');
$routes->post('/transaksi/store', 'Transaksi::store');
$routes->get('/transaksi/history', 'Transaksi::history');
$routes->get('/transaksi/detail/(:num)', 'Transaksi::detail/$1');

$routes->get('/laporan/(:any)', 'Laporan::index/$1');
$routes->get('/laporan', 'Laporan::index');

$routes->get('/login', 'Login::index');
$routes->get('/login/admin', 'Login::admin');
$routes->get('/login/konsumen', 'Login::konsumen');

// Rute untuk retur
$routes->get('/transaksi/retur/(:num)/(:num)', 'Transaksi::retur/$1/$2');
$routes->post('/transaksi/proses-retur', 'Transaksi::proses_retur');
$routes->get('/transaksi/riwayat-retur', 'Transaksi::riwayat_retur');

// Rute untuk admin
$routes->get('/admin/pengembalian', 'Admin::pengembalian');
$routes->get('/admin/pengembalian/(:num)/proses', 'Admin::proses_pengembalian/$1');