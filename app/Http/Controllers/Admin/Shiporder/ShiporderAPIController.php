<?php

namespace App\Http\Controllers\Admin\Shiporder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ShiporderToken;
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
