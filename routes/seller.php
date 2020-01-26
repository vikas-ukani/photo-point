<?php

/** @noinspection ALL */

$router->group(['namespace' => 'Auth'], function () use ($router) {
    $router->post('/login', "AuthController@login");
});

/**
 * after login routes access
 */
$router->group(['middleware' => ["auth:api"]], function () use ($router) {
    $router->group(['namespace' => 'Orders'],  function () use ($router) {
        $router->post('/orders-list', "OrderController@list");
    });
});
