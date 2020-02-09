<?php

namespace App\Http\Controllers\Admin\Shopper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Repositories\PickupLocationRepositoryEloquent;
use App\Models\PickupLocation;

class PickupLocationController extends Controller
{
    protected $pickupLocationRepository;
    protected $imageController;

    public function __construct(
        PickupLocationRepositoryEloquent $pickupLocationRepository
    ) {
        $this->pickupLocationRepository = $pickupLocationRepository;
    }

    function list(Request $request)
    {
        $input = $request->all();
        $pickupLocations = $this->pickupLocationRepository->getDetails($input);
        if (isset($pickupLocations['count']) && $pickupLocations['count'] == 0) {
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => "Pickup Locations"]));
        }
        return $this->sendSuccessResponse($pickupLocations, __('validation.common.details_found', ['module' => "Pickup Locations"]));
    }

    public function show($id)
    {
        $pickupLocation = $this->pickupLocationRepository->getDetailsByInput([
            'id' => $id,
            'first' => true,
        ]);

        if (!isset($pickupLocation)) {
            return $this->sendBadRequest(null, __("validation.common.details_not_found", ['module' => "Pickup Locations"]));
        }

        return $this->sendSuccessResponse($pickupLocation, __("validation.common.details_found", ["module" => "Pickup Locations"]));
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $data = $this->commonCreateUpdate($input);
        if (isset($data) && $data['flag'] == false) {
            return $this->sendBadRequest($data['data'], $data['message']);
        }

        return $this->sendSuccessResponse($data['data'], $data['message']);
    }

    public function update(Request $request, $id)
    {
        $pickupLocation = $this->pickupLocationRepository->getDetailsByInput([
            'id' => $id,
            'first' => true,
        ]);
        if (!isset($pickupLocation)) {
            return $this->sendBadRequest(null, __("validation.common.details_not_found", ["module" => "Pickup Locations"]));
        }

        $input = $request->all();
        $pickupLocation = $this->commonCreateUpdate($input, $id);
        if ($pickupLocation['flag'] == false) {
            return $this->sendBadRequest(null, $pickupLocation['message']);
        }
        return $this->sendSuccessResponse($pickupLocation['data'], $pickupLocation['message']);
    }

    public function commonCreateUpdate($input, $id = null)
    {
        $validator = PickupLocation::validation($input, $id);
        if ($validator->fails()) {
            return $this->makeError(null, $validator->errors()->first());
        }

        $pickupLocation = $this->pickupLocationRepository->updateOrCreate(['id' => $id], $input);
        if (isset($id)) {
            return $this->makeResponse($pickupLocation, __("validation.common.updated", ['module' => "Pickup Locations"]));
        } else {
            return $this->makeResponse($pickupLocation, __("validation.common.created", ['module' => "Pickup Locations"]));
        }
    }

    public function statusChange(Request $request)
    {
        $input = $request->all();
        $validation = $this->requiredAllKeysValidation(['id', 'is_active'], $input);
        if (isset($validation) && $validation['flag'] == false) {
            return $this->sendBadRequest(null, $validation['message']);
        }

        $pickupLocation = $this->pickupLocationRepository->updateRich([
            'is_active' => $input['is_active'],
        ], $input['id']);

        return $this->sendSuccessResponse($pickupLocation, __('validation.common.updated', ['module' => "Pickup Locations"]));
    }

    public function destory($id)
    {
        $pickupLocation = $this->pickupLocationRepository->delete($id);
        return $this->sendSuccessResponse($pickupLocation, __('validation.common.deleted', ['module' => "Pickup Locations"]));
    }

    public function multipleDelete(Request $request)
    {
        $input = $request->all();
        $validation = $this->requiredAllKeysValidation(['ids'], $input);
        if (isset($validation) && $validation['flag'] == false) {
            return $this->sendBadRequest(null, $validation['message']);
        }
        $pickupLocation = $this->pickupLocationRepository->deleteWhereIn('id', $input['ids']);
        return $this->sendSuccessResponse($pickupLocation, __('validation.common.deleted', ['module' => "Pickup Locations"]));
    }
}
