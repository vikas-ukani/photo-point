<?php
$router->group(['namespace' => 'Auth'], function () use ($router) {
    $router->post('/login', "AuthController@login");
});

$router->group(['namespace' => 'Category'], function () use ($router) {
    $router->post('/categories-list', "CategoryController@list");
});

/**
 * after login routes access
 */
$router->group(['middleware' => ["auth:api"]], function () use ($router) {
    # pass

    $router->group(['namespace' => 'Product'], function () use ($router) {
        $router->post('/products-list', "ProductController@list");
        $router->post('/products-create', "ProductController@store");
        $router->get('/products-show/{id}', "ProductController@show");
        $router->post('/products-update/{id}', "ProductController@update");
        $router->post('/products-status-change', "ProductController@statusChange");
        $router->delete('/products-delete/{id}', "ProductController@destory");
        $router->post('/products-delete-multiple', "ProductController@multipleDelete");
        // $router->bind('product', 'App\Models\Products');
    });


    $router->group(['namespace' => 'Complaint'], function () use ($router) {
        # pass...
        $router->post('/complaint-category-list', "ComplaintCategoryController@list");
        $router->post('/complaint-category-create', "ComplaintCategoryController@store");
        $router->get('/complaint-category-show/{id}', "ComplaintCategoryController@show");
        $router->put('/complaint-category-update/{id}', "ComplaintCategoryController@update");
        $router->post('/complaint-category-status-change', "ComplaintCategoryController@statusChange");
        $router->delete('/complaint-category-delete/{id}', "ComplaintCategoryController@destory");
        $router->post('/complaint-category-delete-multiple', "ComplaintCategoryController@multipleDelete");
    });
});



$router->group(['namespace' => 'Country'], function () use ($router) {
    $router->post('/countries-list', "CountryController@list");
});
