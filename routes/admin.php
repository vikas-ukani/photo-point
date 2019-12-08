<?php
$router->group(['namespace' => 'Auth'], function () use ($router) {
    $router->post('/login', "AuthController@login");
});

$router->group(['namespace' => 'Category'], function () use ($router) {
    $router->post('/categories-list', "CategoryController@list");
});

$router->group(['namespace' => 'Product'], function () use ($router) {
    $router->post('/products-list', "ProductController@list");
    $router->post('/products-create', "ProductController@store");
    $router->get('/products-show/{id}', "ProductController@show");
    $router->post('/products-update/{id}', "ProductController@update");
    $router->post('/products-update/{id}', "ProductController@update");
    $router->post('/products-status-change', "ProductController@statusChange");
    $router->delete('/products-delete/{id}', "ProductController@destory");
    $router->post('/products-delete-multiple', "ProductController@multipleDelete");
    // $router->bind('product', 'App\Models\Products');

});

$router->group(['namespace' => 'Country'], function () use ($router) {
    $router->post('/countries-list', "CountryController@list");
});
