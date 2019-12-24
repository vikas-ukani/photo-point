<?php

namespace App\Http\Controllers\API\v1\AuthShopper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Supports\DateConvertor;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ImageHelperController;

use App\Libraries\Repositories\ShopperUserRepositoryEloquent;

class AuthShopperController extends Controller
{

    use DateConvertor;
    protected $shopperUserRepository;

    public function __construct(ShopperUserRepositoryEloquent $shopperUserRepository)
    {
        $this->shopperUserRepository = $shopperUserRepository;
    }

    /**
     * respondWithToken
     * => return response with token
     * @param  mixed $token
     *
     * @return void
     */
    protected function respondWithToken($token)
    {

        return [
            'user' => Auth::guard('shopper_api')->user(),
            // 'user' => \Auth::user()->fresh(),
            'access_token' => $token,
            'token_type' => 'Bearer',
            // 'expires_in' => $this->guard()->factory()->getTTL() * 60
        ];
    }

    /**
     * login for device
     *
     * @param  mixed $request
     *
     * @return void
     */
    public function login(Request $request)
    {
        $input = $request->all();
        $credentials = $request->only('email', 'password');

        /** check email or password */
        $responseError = $this->requiredValidation(['email', 'password'], $input);
        if (isset($responseError) && $responseError['flag'] == false) {
            return $this->sendBadRequest(null, $responseError['message']);
        }
        if ($token = Auth::guard('shopper_api')->attempt($credentials)) {
            $returnDetails = $this->respondWithToken($token);
            return $this->sendSuccessResponse($returnDetails, __('validation.common.login_success'));
        }
        return $this->sendBadRequest(null, __('validation.common.email_password_not_match'), RESPONSE_UNAUTHORIZED_REQUEST);
    }

    /**
     * register => Register New Shopper Account
     *
     * @param  mixed $request
     *
     * @return void
     */
    public function register(Request $request)
    {
        $input = $request->all();

        /** make require validation from input */
        $validation = $this->requiredAllKeysValidation(['first_name', 'last_name', 'email', 'password', 'confirm_password', 'mobile'], $input);
        if (isset($validation) && $validation['flag'] == false) {
            return $this->sendBadRequest(null, $validation['message']);
        }

        /** check email manual validation */
        $emailIsExist = $this->shopperUserRepository->checkEmailOrMobileExistsOrNot(
            [
                'email' => $input['email'],
                'mobile' => $input['mobile'],
                'first' => true,
            ]
        );

        if (!!$emailIsExist) {
            return $this->makeError(null, __('validation.unique', ['attribute' => 'email or password']));
        }

        /** password confirmations */
        if ($input['password'] != $input['confirm_password']) {
            return $this->makeError(null, __('validation.confirmed', ['attribute' => 'password']));
        }

        $shopperUser = $this->shopperUserRepository->create($input);
        return $this->sendSuccessResponse($shopperUser, __('validation.common.register_success'));
    }
}
