<?php
$router->group(['prefix' => 'api'], function () use ($router) {

    /**
     * Authentication related routes
     */
    $router->group(['prefix' => 'auth', 'namespace' => 'Auth'], function () use ($router) {
        $router->post('/login', "AuthController@login");
        $router->post('/register', "AuthController@register");
        $router->post('/forgot-password', "AuthController@resetPasswordFn");
        $router->post('/change-password', "AuthController@changePasswordFn");
        /** FIXME  Remain To Set Change Password From App */
    });

    $router->get('get-all-data', "CommonController@getAllCommonData");
    $router->get('get-country-state-city', "CommonController@getCountryStateCity");

    /**
     * Product Module
     */
    $router->post('product-list', "Product\ProductController@list");
    $router->get('product-detail/{id}', "Product\ProductController@show");
    $router->post('product-detail-review-list', "Product\ProductController@getProductReviews");
    $router->post('feature-product-list', "Product\ProductController@featureProductList");

    /** shopper Authentication */
    $router->group(['prefix' => 'shopper-auth', 'namespace' => 'AuthShopper'], function () use ($router) {
        $router->post('/register', "AuthShopperController@register");
        $router->post('/login', "AuthShopperController@login");
    });

    /**
     * after login routes access
     */
    $router->group(['middleware' => ["auth:api"]], function () use ($router) {

        $router->post('profile-update', 'Auth\AuthController@updateUserProfileFn');
        $router->get('get-profile-detail', 'Auth\AuthController@getProfileDetails');

        $router->group(['prefix' => 'account'], function () use ($router) {

            $router->post('update-password', 'Auth\AuthController@updatePassword');

            $router->post('get-address-list', 'User\UserController@getAddressList');
            $router->post('add-address', 'User\UserController@storeAddress');
            $router->put('update-address/{id}', 'User\UserController@updateAddress');
            $router->get('get-address/{id}', 'User\UserController@showAddress');
            $router->delete('delete-address/{id}', 'User\UserController@destroy');
            $router->get('set-active-address/{id}', 'User\UserController@setToActiveAddress');

            $router->get('want-to-became-saler', 'User\UserController@wantToBecameSaler');
        });

        /**
         * Favorite APIs
         */
        $router->post('favorite-unfavorite-product', 'Product\FavoriteProductController@favoriteUnfavoriteProduct');
        $router->post('favorite-product-list', 'Product\FavoriteProductController@list');


        /**
         * Offers
         */
        $router->post('offer-list', "Offer\OfferController@list");

        /**
         * Cart Module
         */
        $router->post('add-to-cart', "Cart\CartController@store");
        $router->post('cart-list', "Cart\CartController@list");
        $router->post('delete-to-cart/{id}', "Cart\CartController@destroye");
        $router->post('remove-cart-quantity/{id}', "Cart\CartController@substractCartQuantity");

        $router->get('cart-count', "Cart\CartController@getCartCount");

        /**
         * Order related apis
         */
        $router->get('get-order-details-from-cart', 'Order\OrderController@getOrderDetailsFromCart');
        $router->post('place-order', 'Order\OrderController@store');
        $router->post('orders-list', 'Order\OrderController@list');
        $router->get('get-order-details/{id}', 'Order\OrderController@show');

        // $router->post('update-latitude-longitude', "AllInOneController@updateLatLongAPI");

        /**
         * order rating and rate
         */
        $router->post('add-review-on-product', 'Order\OrderRateReviewController@store');

        /**
         * Complaints module
         */
        $router->post('add-complaints', "Complaints\ComplaintController@store");
        $router->post('complaints-list', "Complaints\ComplaintController@list");
        $router->get('get-complaint/{id}', "Complaints\ComplaintController@show");
        $router->post('update-complaint/{id}', "Complaints\ComplaintController@update");
        $router->get('delete-complaint/{id}', "Complaints\ComplaintController@destroy");

        $router->post('complaint-categories-list', "Complaints\ComplaintController@complaintCategoriesList");

        /**
         * Setting Common API
         */
        $router->get('get-setting-common', "Setting\SettingController@getCommonData");
    });
});
