<?php

namespace App\Http\Controllers\Admin\Shopper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Repositories\ShopperUserRepositoryEloquent;

class ShopperController extends Controller
{
    protected $moduleName = "Shopper";
    protected $shopperRepository;

    /**
     * ShopperController constructor.
     * @param ShopperUserRepositoryEloquent $shopperRepository
     */
    public function __construct(ShopperUserRepositoryEloquent $shopperRepository)
    {
        $this->shopperRepository = $shopperRepository;
    }


    /**
     * @param Request $request
     */
    public function shopperList(Request $request)
    {
        $input = $request->all();

        $shoppers = $this->shopperRepository->getDetails($input);
        if (isset($shoppers) && $shoppers['count'] == 0) {
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => $this->moduleName]));
        }
        return $this->sendSuccessResponse($shoppers, __('validation.common.details_found', ['module' => $this->moduleName]));
    }

    /**
     * @param Request $request
     */
    public function statusChange(Request $request)
    {
        $input = $request->all();
        $validation = $this->requiredAllKeysValidation(['id'], $input);
        if (isset($validation) && $validation['flag'] == false) {
            return $this->sendBadRequest(null, $validation['message']);
        }

        if (isset($input['is_active'])){
            $key = "is_active";
        }elseif (isset($input['is_approved'])){
            $key = "is_approved";
        }

        $product = $this->shopperRepository->updateRich([
            $key => $input[$key],
        ], $input['id']);


        return $this->sendSuccessResponse($product, __('validation.common.updated', ['module' => $this->moduleName]));
    }
}
