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
        $router->post('/orders-status-change', "OrderController@changeStatus");

        $router->post('/orders-list', "OrderController@list");
        $router->post('/orders-list', "OrderController@list");
        $router->post('/orders-list', "OrderController@list");
    });




    // pickup-location
    $router->group(['namespace' => 'PickupLocation'], function () use ($router) {
        $router->post('/pickup-location-list', "PickupLocationController@list");
        $router->post('/pickup-location-create', "PickupLocationController@store");
        $router->get('/pickup-location-show/{id}', "PickupLocationController@show");
        $router->post('/pickup-location-update/{id}', "PickupLocationController@update");
        $router->post('/pickup-location-status-change', "PickupLocationController@statusChange");
        $router->delete('/pickup-location-delete/{id}', "PickupLocationController@destory");
        $router->post('/pickup-location-delete-multiple', "PickupLocationController@multipleDelete");
    });
});
