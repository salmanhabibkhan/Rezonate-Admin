<?php
namespace Config;
use CodeIgniter\Router\RouteCollection;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
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
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Auth Routes
 * --------------------------------------------------------------------
 */
$routes->match(['get', 'post'], 'login', 'Auth::login'); // LOGIN PAGE
$routes->match(['get', 'post'], 'register', 'Auth::register'); // REGISTER PAGE
$routes->match(['get', 'post'], 'forgotpassword', 'Auth::forgotPassword'); // FORGOT PASSWORD
$routes->match(['get', 'post'], 'activate/(:num)/(:any)', 'Auth::activateUser/$1/$2'); // INCOMING ACTIVATION TOKEN FROM EMAIL
$routes->match(['get', 'post'], 'resetpassword/(:num)/(:any)', 'Auth::resetPassword/$1/$2'); // INCOMING RESET TOKEN FROM EMAIL
$routes->match(['get', 'post'], 'updatepassword/(:num)', 'Auth::updatepassword/$1'); // UPDATE PASSWORD
$routes->match(['get', 'post'], 'lockscreen', 'Auth::lockscreen'); // LOCK SCREEN
$routes->get('logout', 'Auth::logout'); // LOGOUT



/**
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
