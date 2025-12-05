<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

// ====================================================================
// KELOMPOK 1: WEB ROUTE (HALAMAN ADMIN)
// ====================================================================
$routes->group('setting', ['filter' => 'auth_session', 'namespace' => 'App\Modules\Setting\Controllers'], function($routes){ 
    $routes->add('general', 'Setting::general');
    $routes->add('app', 'Setting::app');
    
    // RUTE MENU OTP:
    // Pastikan function 'otpSetup' sudah lo buat di controller 'Setting.php'
    $routes->add('otp-sidang', 'Setting::otpSetup');    
});

// ====================================================================
// KELOMPOK 2: ADMIN API ROUTE (CRUD & Update Config)
// ====================================================================
$routes->group('api', ['filter' => 'auth_session', 'namespace' => 'App\Modules\Setting\Controllers\Api'], function($routes){
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