<?php

/** @noinspection ALL */

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


    /** shiporder APIs */
    $router->group(['namespace' => 'Shiporder'], function () use ($router) {
        $router->post('/shiporder-login', "ShiporderAPIController@loginShiporder");
    });



    /**
     * Shoppers
     */
    $router->group(['namespace' => 'Shopper'], function () use ($router) {
        $router->post('/shopper-list', "ShopperController@shopperList");
        $router->post('/shopper-status-change', "ShopperController@statusChange");
    });

    /**
     * Category
     */
    $router->group(['namespace' => 'Category'], function () use ($router) {
        $router->post('̥/category-list', "CategoryController@list");
        $router->post('/category-create', "CategoryController@store");
        $router->get('/category-show/{id}', "CategoryController@show");
        $router->post('/category-update/{id}', "CategoryController@update");
        $router->post('/category-status-change', "CategoryController@statusChange");
        $router->delete('/category-delete/{id}', "CategoryController@destory");
        $router->post('/category-delete-multiple', "CategoryController@multipleDelete");
    });

    $router->group(['namespace' => 'Product'], function () use ($router) {

        $router->post('/common-products-attributes-list', "CommonProductAttributesController@list");
        // $router->post('/products-create', "ProductController@store");
        // $router->get('/products-show/{id}', "ProductController@show");
        // $router->post('/products-update/{id}', "ProductController@update");
        // $router->post('/products-status-change', "ProductController@statusChange");
        // $router->delete('/products-delete/{id}', "ProductController@destory");
        // $router->post('/products-delete-multiple', "ProductController@multipleDelete");

        $router->post('/products-list', "ProductController@list");
        $router->post('/products-create', "ProductController@store");
        $router->get('/products-show/{id}', "ProductController@show");
        $router->post('/products-get-details', "ProductController@getProductDetails");
        $router->post('/products-update/{id}', "ProductController@update");
        $router->post('/products-status-change', "ProductController@statusChange");
        $router->delete('/products-delete/{id}', "ProductController@destory");
        $router->post('/products-delete-multiple', "ProductController@multipleDelete");

        /**
         * Feature Products
         */
        // $router->post('feature-product-list', "FeatureProductController@featureProductList");
        $router->post('feature-product-list', "FeatureProductController@list");
        $router->post('/feature-product-create', "FeatureProductController@store");
        $router->get('/feature-product-show/{id}', "FeatureProductController@show");
        $router->post('/feature-product-update/{id}', "FeatureProductController@update");
        $router->post('/feature-product-status-change', "FeatureProductController@statusChange");
        $router->delete('/feature-product-delete/{id}', "FeatureProductController@destory");
        $router->post('/feature-product-delete-multiple', "FeatureProductController@multipleDelete");
    });

    /**
     * Offer APIs
     */
    $router->group(['namespace' => 'Offer'], function () use ($router) {
        $router->post('/offers-list', "OfferController@list");
        $router->post('/offers-create', "OfferController@store");
        $router->get('/offers-show/{id}', "OfferController@show");
        $router->post('/offers-update/{id}', "OfferController@update");
        $router->post('/offers-status-change', "OfferController@statusChange");
        $router->delete('/offers-delete/{id}', "OfferController@destory");
        $router->post('/offers-delete-multiple', "OfferController@multipleDelete");
    });

    $router->group(['namespace' => 'Complaint'], function () use ($router) {
        $router->post('/complaint-category-list', "ComplaintCategoryController@list");
        $router->post('/complaint-category-create', "ComplaintCategoryController@store");
        $router->get('/complaint-category-show/{id}', "ComplaintCategoryController@show");
        $router->put('/complaint-category-update/{id}', "ComplaintCategoryController@update");
        $router->post('/complaint-category-status-change', "ComplaintCategoryController@statusChange");
        $router->delete('/complaint-category-delete/{id}', "ComplaintCategoryController@destory");
        $router->post('/complaint-category-delete-multiple', "ComplaintCategoryController@multipleDelete");
    });

    $router->group(['namespace' => 'PickupAddress'], function () use ($router) {
        $router->post('/pickup-address-list', "PickupAddressController@list");
        $router->post('/pickup-address-approve', "PickupAddressController@approveAddress");
    });
});

$router->group(['namespace' => 'Country'], function () use ($router) {
    $router->post('/countries-list', "CountryController@list");
});
