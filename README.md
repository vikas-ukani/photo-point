# Photo-Point REST-APIs using Laravel Framework With MySQL.

---

---

This project is developed in Laravel framework with mysql database. The project contains only RESTAPIs and consumed in IOS Mobile Appications.

## Directory Structure

```
├── app
│   ├── Console
│   │   ├── Commands
│   │   └── Kernel.php
│   ├── Events
│   │   ├── Event.php
│   │   └── ExampleEvent.php
│   ├── Exceptions
│   │   └── Handler.php
│   ├── Http
│   │   ├── Controllers
│   │   │   ├── Admin
│   │   │   │   ├── Auth
│   │   │   │   │   └── AuthController.php
│   │   │   │   ├── Category
│   │   │   │   │   └── CategoryController.php
│   │   │   │   ├── Complaint
│   │   │   │   │   └── ComplaintCategoryController.php
│   │   │   │   ├── Country
│   │   │   │   │   └── CountryController.php
│   │   │   │   ├── Offer
│   │   │   │   │   └── OfferController.php
│   │   │   │   ├── Orders
│   │   │   │   │   └── OrderController.php
│   │   │   │   ├── PickupAddress
│   │   │   │   │   └── PickupAddressController.php
│   │   │   │   ├── Product
│   │   │   │   │   ├── CommonProductAttributesController.php
│   │   │   │   │   ├── FeatureProductController.php
│   │   │   │   │   └── ProductController.php
│   │   │   │   ├── Shiporder
│   │   │   │   │   └── ShiporderAPIController.php
│   │   │   │   └── Shopper
│   │   │   │       ├── PickupLocationController.php
│   │   │   │       └── ShopperController.php
│   │   │   ├── API
│   │   │   │   └── v1
│   │   │   │       ├── Auth
│   │   │   │       │   └── AuthController.php
│   │   │   │       ├── AuthShopper
│   │   │   │       │   └── AuthShopperController.php
│   │   │   │       ├── Cart
│   │   │   │       │   └── CartController.php
│   │   │   │       ├── CommonController.php
│   │   │   │       ├── Complaints
│   │   │   │       │   └── ComplaintController.php
│   │   │   │       ├── Offer
│   │   │   │       │   └── OfferController.php
│   │   │   │       ├── Order
│   │   │   │       │   ├── OrderController.php
│   │   │   │       │   └── OrderRateReviewController.php
│   │   │   │       ├── Product
│   │   │   │       │   ├── FavoriteProductController.php
│   │   │   │       │   └── ProductController.php
│   │   │   │       ├── Setting
│   │   │   │       │   └── SettingController.php
│   │   │   │       └── User
│   │   │   │           └── UserController.php
│   │   │   ├── AppController.php
│   │   │   ├── Controller.php
│   │   │   ├── HelperController.php
│   │   │   ├── ImageHelperController.php
│   │   │   ├── ImageUploadController.php
│   │   │   └── Payment
│   │   │       └── RazorpayController.php
│   │   ├── Middleware
│   │   │   ├── Authenticate.php
│   │   │   ├── CheckUserAccount.php
│   │   │   ├── CorsMiddleware.php
│   │   │   └── ExampleMiddleware.php
│   │   └── Requests
│   │       └── StoreUserDeleveryAddress.php
│   ├── Jobs
│   │   ├── ExampleJob.php
│   │   └── Job.php
│   ├── Libraries
│   │   ├── Constants
│   │   │   └── Constants.php
│   │   ├── Repositories
│   │   │   ├── CartRepositoryEloquent.php
│   │   │   ├── CityRepositoryEloquent.php
│   │   │   ├── CommonProductAttributesRepositoryEloquent.php
│   │   │   ├── ComplaintCategoryRepositoryEloquent.php
│   │   │   ├── ComplaintRepositoryEloquent.php
│   │   │   ├── CountryRepositoryEloquent.php
│   │   │   ├── FavoriteProductRepositoryEloquent.php
│   │   │   ├── FeatureProductRepositoryEloquent.php
│   │   │   ├── MainCategoryRepositoryEloquent.php
│   │   │   ├── OfferRepositoryEloquent.php
│   │   │   ├── OrderRateReviewRepositoryEloquent.php
│   │   │   ├── OrderRepositoryEloquent.php
│   │   │   ├── PickupLocationRepositoryEloquent.php
│   │   │   ├── ProductAttributesDetailsRepositoryEloquent.php
│   │   │   ├── ProductRepositoryEloquent.php
│   │   │   ├── ProductStockInventoryRepositoryEloquent.php
│   │   │   ├── ShopperUserRepositoryEloquent.php
│   │   │   ├── StateRepositoryEloquent.php
│   │   │   ├── UserDeleveryAddressRepositoryEloquent.php
│   │   │   └── UsersRepositoryEloquent.php
│   │   └── RepositoriesInterfaces
│   │       └── UsersRepository.php
│   ├── Listeners
│   │   └── ExampleListener.php
│   ├── Models
│   │   ├── Cart.php
│   │   ├── City.php
│   │   ├── CommonProductAttributes.php
│   │   ├── ComplaintCategory.php
│   │   ├── Complaint.php
│   │   ├── Country.php
│   │   ├── FavoriteProducts.php
│   │   ├── FeatureProducts.php
│   │   ├── MainCategory.php
│   │   ├── OfferApplied.php
│   │   ├── Offer.php
│   │   ├── Order.php
│   │   ├── OrderRateReview.php
│   │   ├── PaymentHistory.php
│   │   ├── PickupLocation.php
│   │   ├── ProductAttributesDetails.php
│   │   ├── Products.php
│   │   ├── ProductStockInventory.php
│   │   ├── ShiporderToken.php
│   │   ├── Shopper.php
│   │   ├── State.php
│   │   ├── UserDeleveryAddress.php
│   │   └── User.php
│   ├── Notifications
│   │   ├── ChangePasswordNotification.php
│   │   └── EmailVerificationNotification.php
│   ├── Providers
│   │   ├── AppServiceProvider.php
│   │   ├── AuthServiceProvider.php
│   │   ├── EventServiceProvider.php
│   │   └── RouteBindingServiceProvider.php
│   └── Supports
│       ├── BaseMainRepository.php
│       ├── DateConvertor.php
│       └── MessageClass.php
├── artisan
├── bootstrap
│   └── app.php
├── composer.json
├── composer.lock
├── config
│   ├── api-debugger.php
│   ├── auth.php
│   ├── config.php
│   ├── jwt.php
│   ├── mail.php
│   └── paypal.php
├── database
│   ├── factories
│   │   └── ModelFactory.php
│   ├── migrations
│   │   ├── 2014_10_12_000000_create_users_table.php
│   │   ├── 2014_10_12_100000_create_password_resets_table.php
│   │   ├── 2016_06_01_000001_create_oauth_auth_codes_table.php
│   │   ├── 2016_06_01_000002_create_oauth_access_tokens_table.php
│   │   ├── 2016_06_01_000003_create_oauth_refresh_tokens_table.php
│   │   ├── 2016_06_01_000004_create_oauth_clients_table.php
│   │   ├── 2016_06_01_000005_create_oauth_personal_access_clients_table.php
│   │   ├── 2019_08_19_000000_create_failed_jobs_table.php
│   │   ├── 2019_11_27_160353_create_user_delevery_addresses_table.php
│   │   ├── 2019_11_30_173452_create_countries_table.php
│   │   ├── 2019_11_30_173526_create_states_table.php
│   │   ├── 2019_11_30_173558_create_cities_table.php
│   │   ├── 2019_12_02_160909_create_main_categories_table.php
│   │   ├── 2019_12_02_165508_create_products_table.php
│   │   ├── 2019_12_04_151403_create_carts_table.php
│   │   ├── 2019_12_30_140104_create_favorite_products_table.php
│   │   ├── 2020_01_04_110630_create_common_product_attributes_table.php
│   │   ├── 2020_01_05_082154_create_product_attributes_details_table.php
│   │   ├── 2020_01_12_071523_create_product_stock_inventories_table.php
│   │   ├── 2020_01_26_123751_create_payment_histories_table.php
│   │   └── 2020_02_09_112858_create_pickup_locations_table.php
│   ├── seeds
│   │   └── DatabaseSeeder.php
├── package.json
├── package-lock.json
├── phpunit.xml
├── public
│   ├── css
│   │   └── app.css
│   ├── fonts
│   │   └── vendor
│   │       ├── font-awesome
│   │       │   ├── fontawesome-webfont.eot
│   │       │   ├── fontawesome-webfont.svg
│   │       │   ├── fontawesome-webfont.ttf
│   │       │   ├── fontawesome-webfont.woff
│   │       │   └── fontawesome-webfont.woff2
│   │       └── simple-line-icons
│   │           ├── Simple-Line-Icons.eot
│   │           ├── Simple-Line-Icons.svg
│   │           ├── Simple-Line-Icons.ttf
│   │           ├── Simple-Line-Icons.woff
│   │           └── Simple-Line-Icons.woff2
│   ├── images
│   │   └── logo.png
│   ├── index.php
│   └── js
│       └── app.js
├── README.md
├── resources
│   ├── lang
│   │   └── en
│   │       ├── auth.php
│   │       ├── pagination.php
│   │       ├── passwords.php
│   │       └── validation.php
│   └── views
│       ├── admin.blade.php
│       ├── mail
│       │   └── forgot-password
│       │       └── forgot-password.blade.php
│       ├── settings
│       │   ├── privacy_policy.blade.php
│       │   ├── refund_and_cancellation_policy.blade.php
│       │   └── terms_and_conditions.blade.php
│       └── test.blade.php
├── routes
│   ├── admin.php
│   ├── api.php
│   ├── seller.php
│   └── web.php
├── storage
│   ├── app
│   └── framework
│       ├── cache
│       └── views
├── tests
│   ├── ExampleTest.php
│   └── TestCase.php
└── webpack.mix.js

```

## Installation.

1. Clone this repository using.

```
git clone https://github.com/vikas-ukani/photo-point.git
```

2. Install and update composer

```
    composer install
```

3. Create or COPY `.env` file from `.env.example` file.

```
cp .env.example .env
```

4. Setup you database configuration setting in `.env`

5. Run the migrations.

```
php artisan migrate
```

6. Run the project
```
php artisan serve
```