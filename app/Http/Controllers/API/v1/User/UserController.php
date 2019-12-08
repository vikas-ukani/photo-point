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

    public function getAddressList(Request $request)
    {
        $input = $request->all();

        $addresses = $this->userDeleveryAddress->getDetails($input);
        if (isset($addresses) && $addresses['count'] == 0) {
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => $this->moduleName]));
        }

        return $this->sendSuccessResponse($addresses, __('validation.common.details_found', ['module' => $this->moduleName]));
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

    public function showAddress($id)
    {
        #pass
        $userId = \Auth::id();

        $address = $this->userDeleveryAddress->getDetailsByInput([
            'id' => $id,
            'user_id' => $userId,
            "relation" => ["country", "state", "city"],
            'first' => true,
        ]);
        if (!isset($address)) {
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => $this->moduleName]));
        }

        return $this->sendSuccessResponse($address, __('validation.common.details_found', ['module' => $this->moduleName]));

    }

    public function updateAddress(Request $request, $id)
    {
        # code...
        $input = $request->all();

        $validator = UserDeleveryAddress::validation($input);
        if ($validator->fails()) {
            return $this->sendBadRequest(null, $validator->errors()->first());
        }
        $updatedAddress = $this->userDeleveryAddress->updateRich($input, $id);
        return $this->sendSuccessResponse($updatedAddress, __('validation.common.updated', ['module' => $this->moduleName]));
    }

    public function destroy($id)
    {
        $this->userDeleveryAddress->delete($id);
        return $this->sendSuccessResponse(null, __('validation.common.deleted', ['module' => $this->moduleName]));
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
