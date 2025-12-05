<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

// ====================================================================
// KELOMPOK ADMIN API ROUTE (CRUD & Update Config)
// ... (API routes lainnya dari Modul Setting) ...
$routes->group('api', ['filter' => 'auth_session', 'namespace' => 'App\\Modules\\Setting\\Controllers\\Api'], function($routes){
    $routes->get('setting/general', 'ApiSetting::general');
	$routes->get('setting/app', 'ApiSetting::app');
	
    // Update dan Upload
    $routes->put('setting/update/(:segment)', 'ApiSetting::update/$1');
	$routes->post('setting/upload', 'ApiSetting::upload');

	$routes->put('setting/change/(:segment)', 'ApiSetting::setChange/$1');

    // Data Helper
	$routes->get('setting/kota', 'ApiSetting::kota');
	$routes->get('setting/layout', 'ApiSetting::layout');
});