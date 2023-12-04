<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/login', 'Auth::index');
$routes->post('/login/auth', 'Auth::cek_login');
$routes->get('/logout', 'Auth::logout');
$routes->get('/petugas', 'Petugas::index');
$routes->get('/master/dokter', 'Master::index_dokter');
$routes->post('master/dokter/add', 'Master::add_dokter');
$routes->post('master/dokter/edit/(:segment)', 'Master::edit_dokter/$1');
$routes->get('master/dokter/delete/(:segment)', 'Master::delete_dokter/$1');
$routes->get('/master/nakes', 'Master::index_nakes');
$routes->post('master/nakes/add', 'Master::add_nakes');
$routes->post('master/nakes/edit/(:segment)', 'Master::edit_nakes/$1');
$routes->get('master/nakes/delete/(:segment)', 'Master::delete_nakes/$1');
$routes->get('/master/pasien', 'Master::index_pasien');
$routes->post('master/pasien/add', 'Master::add_pasien');
$routes->post('master/pasien/edit/(:segment)', 'Master::edit_pasien/$1');
$routes->get('master/pasien/delete/(:segment)', 'Master::delete_pasien/$1');
$routes->get('/master/pemilik', 'Master::index_pemilik');
$routes->post('master/pemilik/add', 'Master::add_pemilik');
$routes->post('master/pemilik/edit/(:segment)', 'Master::edit_pemilik/$1');
$routes->get('master/pemilik/delete/(:segment)', 'Master::delete_pemilik/$1');
$routes->get('/master/petugas', 'Master::index_petugas');
$routes->post('master/petugas/add', 'Master::add_petugas');
$routes->post('master/petugas/edit/(:segment)', 'Master::edit_petugas/$1');
$routes->get('master/petugas/delete/(:segment)', 'Master::delete_petugas/$1');
$routes->get('/master/obat', 'Master::index_obat');
$routes->post('master/obat/add', 'Master::add_obat');
$routes->post('master/obat/edit/(:segment)', 'Master::edit_obat/$1');
$routes->get('master/obat/delete/(:segment)', 'Master::delete_obat/$1');
$routes->get('/master/lab', 'Master::index_lab');
$routes->post('master/lab/add', 'Master::add_lab');
$routes->post('master/lab/edit/(:segment)', 'Master::edit_lab/$1');
$routes->get('master/lab/delete/(:segment)', 'Master::delete_lab/$1');
$routes->get('/master/rs', 'Master::index_rs');
$routes->post('master/rs/add', 'Master::add_rs');
$routes->post('master/rs/edit/(:segment)', 'Master::edit_rs/$1');
$routes->get('master/rs/delete/(:segment)', 'Master::delete_rs/$1');
$routes->get('/master/poli', 'Master::index_poli');
$routes->post('master/poli/add', 'Master::add_poli');
$routes->post('master/poli/edit/(:segment)', 'Master::edit_poli/$1');
$routes->get('master/poli/delete/(:segment)', 'Master::delete_poli/$1');
$routes->get('/jadwal/dokter', 'Jadwal::index_dokter');
$routes->get('jadwal/dokter/delete/(:segment)', 'Jadwal::delete_dokter');

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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
