<?php

$routes->get('account', 'Myth\Users\Controllers\AccountController::index', ['as' => 'account']);
$routes->post('account', 'Myth\Users\Controllers\AccountController::save', ['as' => 'account']);

$routes->group('members', ['namespace' => 'Myth\Users\Controllers'], function($routes) {
    $routes->get('(:segment)', 'UserController::show/$1', ['as' => 'profile']);
    $routes->get('(:segment)/(:segment)', 'UserController::show/$1/$2', ['as' => 'profile']);
});
