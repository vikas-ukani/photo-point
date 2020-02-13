<?php

namespace App\Http\Controllers\Admin\Shiporder;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\ShiporderToken;
use App\Http\Controllers\Controller;
use App\Libraries\Repositories\CityRepositoryEloquent;
use App\Libraries\Repositories\CountryRepositoryEloquent;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Psr7\Request as Psr7Request;
use App\Libraries\Repositories\PickupLocationRepositoryEloquent;
use App\Libraries\Repositories\ProductStockInventoryRepositoryEloquent;
use App\Libraries\Repositories\StateRepositoryEloquent;
use App\Libraries\Repositories\UsersRepositoryEloquent;
use Exception;

class ShiporderAPIController extends Controller
{
    protected $userId;
    protected $pickupLocationRepository;
    protected $productStockInventoryRepository;
    protected $countryRepository;
    protected $usersRepository;
    protected $stateRepository;
    protected $cityRepository;

    public function __construct(
        PickupLocationRepositoryEloquent $pickupLocationRepository,
        StateRepositoryEloquent $stateRepository,
        ProductStockInventoryRepositoryEloquent $productStockInventoryRepository,
        UsersRepositoryEloquent $usersRepository,
        CountryRepositoryEloquent $countryRepository,
        CityRepositoryEloquent $cityRepository
    ) {
        $this->userId = Auth::id();
        $this->pickupLocationRepository = $pickupLocationRepository;
        $this->productStockInventoryRepository = $productStockInventoryRepository;
        $this->usersRepository = $usersRepository;
        $this->stateRepository = $stateRepository;
        $this->countryRepository = $countryRepository;
        $this->cityRepository = $cityRepository;
    }


    //
    public function createOrder(Request $request)
    {
        $input = $request->all();
        $pickupLocation = $this->pickupLocationRepository->getDetailsByInput([
            'user_id' => $this->userId,
            'first' => true
        ]);
        if (!!!isset($pickupLocation)) {
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => 'pickup address']));
        }

        $shiprocketToken = ShiporderToken::first();
        if (!!!isset($shiprocketToken)) {
            return $this->sendBadRequest(null, "Something went wrong");
        }

        if (isset($input['address_detail']['city_id'])) {
            $input['address_detail']['city_detail'] = $this->cityRepository->getDetailsByInput([
                'id' =>  $input['address_detail']['city_id'],
                'first' => true
            ])->toArray();
        }
        if (isset($input['address_detail']['state_id'])) {
            $input['address_detail']['state_detail'] = $this->stateRepository->getDetailsByInput([
                'id' =>  $input['address_detail']['state_id'],
                'first' => true
            ])->toArray();
        }
        if (isset($input['address_detail']['country_id'])) {
            $input['address_detail']['country_detail'] = $this->countryRepository->getDetailsByInput([
                'id' =>  $input['address_detail']['country_id'],
                'first' => true
            ])->toArray();
        }
        if (isset($input['user_id'])) {
            $input['user_detail'] = $this->usersRepository->getDetailsByInput([
                'id' =>  $input['user_id'],
                'first' => true
            ])->toArray();
        }

        if (isset($input['product_details']['stock_inventory_id'])) {
            $input['stock_inventory_detail'] = $this->productStockInventoryRepository->getDetailsByInput([
                'id'     =>  $input['product_details']['stock_inventory_id'],
                'first'  => true
            ])->toArray();
        }

        // dd('inp', $input);
        $apiinput = [
            'order_id'              => $input['id'], // come from request of order id 
            'order_date'            => $input['order_date'] /* date('d-m-Y', strtotime($user->from_date)) */,
            'pickup_location'       => $pickupLocation->pickup_location, // name of shopper pickup location naem
            'billing_customer_name' => $input['user_detail']['first_name'] ?? null, // customer name
            'billing_last_name'     => $input['user_detail']['last_name'] ?? null, // customer name
            'billing_address'       => $input['address_detail']['line1'] ?? null, // customer address
            'billing_city'          => $input['address_detail']['city_detail']['name'] ?? null, // customer billing_city
            'billing_pincode'       => $input['address_detail']['pincode'] ?? null, // customer billing_pincode
            'billing_state'         => $input['address_detail']['state_detail']['name'] ?? null, // customer billing_state
            'billing_country'       => $input['address_detail']['country_detail']['name'] ?? null, // customer billing_country
            'billing_email'         => $input['user_detail']['email'], // customer billing_email
            'billing_phone'         => $input['user_detail']['mobile'], // customer billing_phone
            'shipping_is_billing'   => true, // same addaress
            'order_items' => [
                [
                    "name"      => $input['product_details']['name'],
                    "sku"       => "stock-" . $input['product_details']['stock_inventory_id'],
                    "units"     => $input['quantity'],
                    "selling_price" => $input['product_details']['sale_price'],
                    "discount"  => "",
                    "tax"       => "",
                    //,  "hsn": 441122
                ]
            ], // same addaress
            'payment_method'    => "Prepaid", // payment_method =>   COD|Prepaid
            'sub_total'         => $input['total_amount'], // payment total amount
            'length' => $input['stock_inventory_detail']['length'] ?? null, // 10
            'breadth' => $input['stock_inventory_detail']['breadth'] ?? null, // 10
            'height' =>  $input['stock_inventory_detail']['height'] ?? null, // 10
            'weight' => $input['stock_inventory_detail']['weight'] ?? null, // 2.5
        ];

        // dd('check data', $apiinput);

        try {
            $client = new \GuzzleHttp\Client();

            // $request = $client->createRequest('POST', 'http://www.browserstack.com/screenshots', [
            $response = $client->request(
                'POST',
                "https://apiv2.shiprocket.in/v1/external/orders/create/adhoc", // API of create an order at shiporder site
                [
                    'headers' => [
                        'Accept'            => 'application/json',
                        'Authorization'     => 'Bearer ' . $shiprocketToken->token,
                    ],
                    'json' =>  $apiinput
                ]
            );
            // $response = $response->getBody()
            //     ->getContents();
            $response = json_decode($response->getBody()->getContents(), true);
            dd('order padyo,. ', $response);
        } catch (Exception $ex) {
            dd('excq', $ex);
            return $this->sendBadRequest(null, $ex->getCode() . " -- " . $ex->getMessage());
        }
    }

    public function loginShiporder(Request $request)
    {
        $input = $request->all();

        $validation = $this->requiredValidation(['email', 'password'], $input);
        if (isset($validation) && $validation['flag'] == false) {
            return $this->sendBadRequest(null, $validation['message']);
        }

        $client = new Client();
        $response = $client->request(
            'POST',
            "https://apiv2.shiprocket.in/v1/external/auth/login",
            [
                'headers' => [
                    'Accept'     => 'application/json',
                ],
                'form_params'   => [
                    'email' => $input['email'],
                    'password' => $input['password'],
                ]
            ]
        );
        $bodyData =  json_decode($response->getBody()->getContents(), true);

        /** store token to database */
        if (isset($bodyData)) {

            /** store token in databases */
            $firstToken = ShiporderToken::first();
            if ($firstToken) {
                $firstToken->token = $bodyData['token'];
                $firstToken->save();
            } else {
                $firstToken = ShiporderToken::create(['token' => $bodyData['token']]);
            }
            return $this->sendSuccessResponse($firstToken, __('validation.common.login_success'));
        } else {
            return $this->sendBadRequest(null, __('validation.common.failed_to_login'));
        }
    }
}
