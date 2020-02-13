<?php

namespace App\Http\Controllers\Admin\PickupAddress;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Repositories\PickupLocationRepositoryEloquent;

class PickupAddressController extends Controller
{
    protected $pickupAddressRepository;

    public function __construct(PickupLocationRepositoryEloquent $pickupAddressRepository)
    {
        $this->pickupAddressRepository = $pickupAddressRepository;
    }

    public function list(Request $request)
    {
        $input = $request->all();

        $pickupAddresses = $this->pickupAddressRepository->getDetails($input);
        if (isset($pickupAddresses) && $pickupAddresses['count'] == 0) {
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => "Pickup addresses"]));
        }

        return $this->sendSuccessResponse($pickupAddresses, __('validation.common.details_found', ['module' => "Pickup addresses"]));
    }

    public function approveAddress(Request $request)
    {
        $input = $request->all();

        $approved = $this->pickupAddressRepository->updateRich(
            [
                'is_added_to_shiprocket' => true
            ],
            $input['id']
        );

        return $this->sendSuccessResponse(null, __('validation.common.saved', ['module' => "Pickup address"]));
    }
}
