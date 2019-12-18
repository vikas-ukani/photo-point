<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageHelperController;
use App\Libraries\Repositories\UsersRepositoryEloquent;
use App\Models\User;
use App\Notifications\ChangePasswordNotification;
use App\Supports\DateConvertor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use DateConvertor;
    protected $usersRepository;
    protected $imageController;
    protected $usersSnoozeRepository;

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
     * register => Register New User
     *
     * @param  mixed $request
     *
     * @return void
     */
    public function register(Request $request)
    {
        $input = $request->all();
        /** make require validation from input */
        $validation = $this->requiredValidation(['first_name', 'last_name', 'email', 'password', 'confirm_password', 'mobile'], $input);
        if (isset($validation) && $validation['flag'] == false) {
            return $this->sendBadRequest(null, $validation['message']);
        }

        /**check email manual validation */
        $emailIsExist = $this->usersRepository->getDetailsByInput(
            [
                'email' => $input['email'],
                'first' => true,
            ]
        );
        if (isset($emailIsExist) && $emailIsExist->count() > 0) {
            return $this->makeError(null, __('validation.unique', ['attribute' => 'email']));
        }

        /** password confirmations */
        if ($input['password'] != $input['confirm_password']) {
            return $this->makeError(null, __('validation.confirmed', ['attribute' => 'password']));
        }

        $user = $this->usersRepository->create($input);

        return $this->sendSuccessResponse($user, __('validation.common.register_success'));
    }


    public function getProfileDetails()
    {
        $user = $this->usersRepository->getDetailsByInput([
            'id' => \Auth::id(),
            'first' => true
        ]);

        return $this->sendSuccessResponse($user, __('validation.common.details_found', ['module' => "User"]));
    }

    /**
     * updateUserProfileFn => Update Profile When user signup and step 2
     *
     * @param  mixed $input
     *
     * @return void
     */
    public function updateUserProfileFn(Request $request)
    {
        $input = $request->all();
        /** check profile required validation */
        $validation = $this->requiredAllKeysValidation(['first_name', 'last_name', 'email', 'mobile'], $input);
        if (isset($validation) && $validation['flag'] == false) {
            return $this->sendBadRequest(null, $validation['message']);
        }
        // FIXME Image uploading not working in live server
        if (isset($input['photo'])) {
            try {
                /** file upload */
                $data = $this->imageController->moveFile($input['photo'], 'users');
                if (isset($data) && $data['flag'] == false) {
                    return $this->sendBadRequest(null, $data['message']);
                }
                $input['photo'] = $data['data']['image'];
            } catch (\Exception $exception) {
                \Log::error($exception->getMessage());
                return $this->sendBadRequest(null, $exception->getMessage());
            }
        }

        /** update some info of users */
        $user = $this->usersRepository->updateRich($input, \Auth::id());
        if (!!!$user) {
            return $this->sendBadRequest(null, __('validation.common.invalid_user'));
        }
        $token = Auth::tokenById($user->id);

        $returnResponse = $this->makeAuthTokenResponse($user, $token);
        return $this->sendSuccessResponse($returnResponse, __('validation.common.updated', ['module' => "User"]));
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
            return $this->sendSuccessResponse($returnDetails, __('validation.common.login_success'));
        }
        return $this->sendBadRequest(null, __('validation.common.email_password_not_match'), RESPONSE_UNAUTHORIZED_REQUEST);
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
    public function setLastLoginDatetime()
    {
        try {
            $user = \Auth::user();
            $user->last_login_at = $this->getCurrentDateUTC();
            $user->save();
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
        }
    }

    /**
     * resetPasswordFn => to send mail
     *
     * @param  mixed $request
     *
     * @return void
     */
    public function resetPasswordFn(Request $request)
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
        $url = url();
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
}
