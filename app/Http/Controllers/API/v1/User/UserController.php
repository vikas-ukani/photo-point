<?php

namespace App\Http\Controllers\API\v1\User;

use App\Http\Controllers\Controller;
use App\Libraries\Repositories\UserDeleveryAddressRepositoryEloquent;
use App\Models\UserDeleveryAddress;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $moduleName = "Delevery Address";
    protected $userDeleveryAddress;

    public function __construct(UserDeleveryAddressRepositoryEloquent $userDeleveryAddress)
    {
        $this->userDeleveryAddress = $userDeleveryAddress;
    }

    public function storeAddress(Request $request)
    {
        $input = $request->all();

        $validator = UserDeleveryAddress::validation($input);
        if ($validator->fails()) {
            return $this->sendBadRequest(null, $validator->errors()->first());
        }

        /** finally create */
        $address = $this->userDeleveryAddress->create($input);

        return $this->sendSuccessResponse($address->fresh(), __('validation.common.created', ['module' => $this->moduleName]));
    }

    public function setToActiveAddress($id)
    {
        $userId = \Auth::id();
        $address = $this->userDeleveryAddress->getDetailsByInput([
            'id' => $id,
            'first' => true,
        ]);
        if (!isset($address)) {
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => $this->moduleName]));
        }

        /** update all default to false */
        $this->userDeleveryAddress->updateManyByWhere(
            [
                'is_default' => false,
            ],
            ['user_id' => $userId]
        );

        $updatedAddress = $this->userDeleveryAddress->updateManyByWhere(
            [
                'is_default' => true,
            ],
            ['id' => $id]
        );

        return $this->sendSuccessResponse($updatedAddress, __('validation.common.saved', ['module' => $this->moduleName]));
    }

}
