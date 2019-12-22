<?php

namespace App\Http\Controllers\Admin\Offer;

use App\Models\Offer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageHelperController;
use App\Libraries\Repositories\OfferRepositoryEloquent;

class OfferController extends Controller
{
    protected $offerRepository;
    protected $imageController;

    public function __construct(
        OfferRepositoryEloquent $offerRepository,
        ImageHelperController $imageController
    ) {
        $this->offerRepository = $offerRepository;
        $this->imageController = $imageController;
    }

    function list(Request $request)
    {
        $input = $request->all();

        $offers = $this->offerRepository->getDetails($input);
        if (isset($offers['count']) && $offers['count'] == 0) {
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => "offers"]));
        }
        return $this->sendSuccessResponse($offers, __('validation.common.details_found', ['module' => "offers"]));
    }

    public function show($id)
    {
        $product = $this->offerRepository->getDetailsByInput([
            'id' => $id,
            'relation', ["category_detail"],
            "category_detail" => ["id", 'name'],
            'first' => true,
        ]);

        if (!isset($product)) {
            return $this->sendBadRequest(null, __("validation.common.details_not_found", ['module' => "Product"]));
        }

        return $this->sendSuccessResponse($product, __("validation.common_details_found", ["module" => "Product"]));

        // $product = $this->;
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $product = $this->commonCreateUpdate($input);
        if (isset($product) && $product['flag'] == false) {
            return $this->sendBadRequest(null, $product['message']);
        }

        return $this->sendSuccessResponse($product['data'], $product['message']);
    }

    public function update(Request $request, $id)
    {
        $product = $this->offerRepository->getDetailsByInput([
            'id' => $id,
            'first' => true,
        ]);

        if (!isset($product)) {
            return $this->sendBadRequest(null, __("validation.common.details_not_found", ["module" => "Product"]));
        }

        $input = $request->all();

        $product = $this->commonCreateUpdate($input, $id);
        if ($product['flag'] == false) {
            return $this->sendBadRequest(null, $product['message']);
        }

        return $this->sendSuccessResponse($product['data'], $product['message']);
    }

    public function commonCreateUpdate($input, $id = null)
    {

        $validator = Offer::validation($input, $id);
        if ($validator->fails()) {
            return $this->makeError(null, $validator->errors()->first());
        }

        /** upload multiple images */
        if (isset($input['image']) && is_array($input['image']) && count($input['image']) > 0) {
            #pass
            $imagesArray = [];
            foreach ($input['image'] as $key => $images) {
                /** image upload code */
                $data = $this->imageController->moveFile($images, 'offers');
                if (isset($data) && $data['flag'] == false) {
                    return $this->makeError(null, $data['message']);
                }
                // $input['image'] = $data['data']['image'];
                $imagesArray[] = $data['data']['image'];
            }
            $input['image'] = is_array($imagesArray) ? implode(',', $imagesArray) : $imagesArray;
        } else if (isset($input['image'])) {
            /** image upload code */
            $data = $this->imageController->moveFile($input['image'], 'offers');
            if (isset($data) && $data['flag'] == false) {
                return $this->makeError(null, $data['message']);
            }
            $input['image'] = $data['data']['image'];
        }

        $product = $this->offerRepository->updateOrCreate(['id' => $id], $input);

        $product = $this->offerRepository->getDetailsByInput([
            'id' => $product->id,
            'relation' => ["category_detail"],
            'first' => true,
        ]);

        if (isset($id)) {
            return $this->makeResponse($product, __("validation.common.updated", ['module' => "Product"]));
        } else {
            return $this->makeResponse($product, __("validation.common.created", ['module' => "Product"]));
        }
    }

    public function statusChange(Request $request)
    {
        $input = $request->all();
        $validation = $this->requiredAllKeysValidation(['id', 'is_active'], $input);
        if (isset($validation) && $validation['flag'] == false) {
            return $this->sendBadRequest(null, $validation['message']);
        }

        $product = $this->offerRepository->updateRich([
            'is_active' => $input['is_active'],
        ], $input['id']);

        return $this->sendSuccessResponse($product, __('validation.common.updated', ['module' => "Product"]));
    }

    public function destory($id)
    {
        $product = $this->offerRepository->delete($id);
        return $this->sendSuccessResponse($product, __('validation.common.deleted', ['module' => "Product"]));
    }

    public function multipleDelete(Request $request)
    {
        $input = $request->all();
        $validation = $this->requiredAllKeysValidation(['ids'], $input);
        if (isset($validation) && $validation['flag'] == false) {
            return $this->sendBadRequest(null, $validation['message']);
        }
        $product = $this->offerRepository->deleteWhereIn('id', $input['ids']);
        return $this->sendSuccessResponse($product, __('validation.common.deleted', ['module' => "product"]));
    }
}
