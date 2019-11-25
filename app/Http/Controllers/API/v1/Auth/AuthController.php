<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageHelperController;
use App\Libraries\Repositories\UsersRepositoryEloquent;
use App\Notifications\ChangePasswordNotification;
use App\Supports\DateConvertor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use DateConvertor;
    protected $usersRepository;
    protected $imageController;

    public function __construct(
        UsersRepositoryEloquent $usersRepository,
        ImageHelperController $imageHelperController
    ) {
        $this->usersRepository = $usersRepository;
        $this->imageController = $imageHelperController;
    }

    /**
     * makeAuthTokenResponse => Make Json Token Response
     *
     * @param  mixed $user
     * @param  mixed $token
     *
     * @return void
     */
    public function makeAuthTokenResponse($user, $token)
    {
        return [
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
            // 'user'=> $this->guard()->user()
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
        if ($token = JWTAuth::attempt($credentials)) {
            $returnDetails = $this->respondWithToken($token);
            /** set last login date to current date */
            // $this->setLastLoginDatetime();
            return $this->sendSuccessResponse($returnDetails, __('validation.common.login_success'));
        }
        return $this->sendBadRequest(null, __('validation.common.email_password_not_match'), RESPONSE_UNAUTHORIZED_REQUEST);
    }

    public function register(Request $request)
    {
        $input = $request->all();
        $responseError = $this->requiredValidation([
            'first_name', 'last_name', 'email', 'password', 'confirm_password', 'mobile'], $input);
        if (isset($responseError) && $responseError['flag'] == false) {
            return $this->sendBadRequest(null, $responseError['message']);
        }

        /** check user already register or not */
        $user = $this->usersRepository->getDetailsByInput([
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'first' => true,
        ]);
        if (isset($user)) {
            return $this->sendBadRequest(null, __('validation.common.email_already_exist', ['key' => 'email']));

        }
        /** check password match */
        if ($input['password'] != $input['confirm_password']) {
            return $this->sendBadRequest(null, __('validation.confirmed', ['attribute' => 'password']));
        }
        $user = $this->usersRepository->create($input);
        if ($token = JWTAuth::attempt(['email' => $input['email'], 'password' => $input['password']])) {
            $response = $this->respondWithToken($token);
            return $this->sendSuccessResponse($response, __('validation.message.successfully_register'));
        }
        return $this->sendBadRequest(null, __('validation.common.failed_to_register'));

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
            'user' => \Auth::user()->fresh(),
            'access_token' => $token,
            'token_type' => 'Bearer',
            // 'expires_in' => $this->guard()->factory()->getTTL() * 60
        ];
    }

    /**
     * setLastLoginDatetime => set Last login Date Time
     *
     * @return void
     */
    // public function setLastLoginDatetime()
    // {
    //     try {
    //         $user = \Auth::user();
    //         $user->last_login_at = $this->getCurrentDateUTC();
    //         $user->save();
    //     } catch (\Exception $exception) {
    //         \Log::error($exception->getMessage());
    //     }
    // }

    /**
     * forgotPassword => to send mail
     *
     * @param  mixed $request
     *
     * @return void
     */
    public function forgotPassword(Request $request)
    {
        $input = $request->all();
        /** check email or password */
        $responseError = $this->requiredValidation(['email'], $input);
        if (isset($responseError) && $responseError['flag'] == false) {
            return $this->sendBadRequest(null, $responseError['message']);
        }

        /** check email is exist or not */
        $user = $this->usersRepository->getDetailsByInput(['email' => $input['email'], 'first' => true]);
        if (!isset($user)) {
            return $this->sendBadRequest(null, __('validation.common.email_not_exist', ['key' => 'email']));
        }

        $url = $this->makeTokenURL($user);
        try {
            // send notification email
            $user->notify(new ChangePasswordNotification($user, $url));
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            return $this->sendSuccessResponse(null, $exception->getMessage());
        }

        return $this->sendSuccessResponse(null, __('validation.common.forgot_password_email_send'));
    }

    /**
     * makeTokenURL => Create Url to send Mail Button
     * @param  mixed $user
     * @return void
     */
    public function makeTokenURL($user)
    {
        //  get user token
        $token = JWTAuth::fromUser($user);
        /** get current url */
        // $url = request()->root();
        $url = url('/');
        $url .= '/auth/change-password?email=' . $user->email;
        $url .= '&token=' . $token;

        return $url;
    }

    /**
     * changePasswordFn => user change password
     *
     * @param  mixed $request
     *
     * @return void
     */
    public function changePasswordFn(Request $request)
    {
        $input = $request->all();
        /** required validation */
        $validation = $this->requiredValidation(['email', 'password', 'confirm_password'], $input);
        if (isset($validation) && $validation['flag'] == false) {
            return $this->sendBadRequest(null, $validation['message']);
        }
        /** password confirmations */
        if ($input['password'] != $input['confirm_password']) {
            return $this->makeError(null, __('validation.confirmed', ['attribute' => 'password']));
        }

        /** make hash password */
        $input['password'] = Hash::make($input['password']);

        $token = null;
        if ($request->header('Authorization')) {
            $key = explode(' ', $request->header('Authorization'));
            $token = $key[1];
        }
        if (!isset($token)) {
            return $this->sendBadRequest(null, __('validation.common.token_required_in_header'));
        }

        /** password change process */
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!isset($user)) {
                return $this->sendBadRequest(null, __('validation.common.token_invalid'));
            }

            /** save user password */
            $user->password = $input['password'];
            $user->save();
            JWTAuth::setToken($token)->invalidate();

            return $this->sendSuccessResponse(null, __('validation.common.password_changed_success'));
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            return $this->sendBadRequest(null, __('validation.common.token_required_in_header'));
        }
    }

    public function updatePasswordFn(Request $request)
    {
        # code...
        $input = $request->all();

        dd('Check user', $input, auth()->user());

        /** required validation */
        $validation = $this->requiredValidation(['password', 'confirm_password'], $input);
        if (isset($validation) && $validation['flag'] == false) {
            return $this->sendBadRequest(null, $validation['message']);
        }

        /** comapre password */
        if ($input['password'] != $input['confirm_password']) {
            return $this->sendBadRequest(null, __('validation.confirmed', ['attribute' => 'password']));
        }

    }
}
