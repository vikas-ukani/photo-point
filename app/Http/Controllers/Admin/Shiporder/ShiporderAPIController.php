<?php

namespace App\Http\Controllers\Admin\Shiporder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;

class ShiporderAPIController extends Controller
{
    //


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
        return $this->sendSuccessResponse($bodyData, __('validation.common.login_success'));
    }
}
