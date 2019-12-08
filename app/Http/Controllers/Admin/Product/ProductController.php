<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageHelperController;
use App\Libraries\Repositories\ProductRepositoryEloquent;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productRepository;
    protected $imageController;

    public function __construct(ProductRepositoryEloquent $productRepository,
        ImageHelperController $imageController) {
        $this->productRepository = $productRepository;
        $this->imageController = $imageController;
    }

    function list(Request $request) {
        $input = $request->all();

        $products = $this->productRepository->getDetails($input);
        if (isset($products['count']) && $products['count'] == 0) {
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => "Products"]));
        }
        return $this->sendSuccessResponse($products, __('validation.common.details_found', ['module' => "products"]));
    }

    public function show($id)
    {
        $product = $this->productRepository->getDetailsByInput([

            'id' => $id,
            'relation', ["category"],
            "category_list" => ["id", 'name'],
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

        $validator = Products::validation($input);
        if ($validator->fails()) {
            return $this->sendBadRequest(null, $validator->errors()->first());
        }

        $product = $this->commonCreateUpdate($input);
        if (isset($product) && $product['flag'] == false) {
            return $this->sendBadRequest(null, $product['message']);
        }

        return $this->sendSuccessResponse($product['data'], $product['message']);
    }

    public function update(Request $request, $id)
    {
        $product = $this->productRepository->getDetailsByInput([
            'id' => $id,
            'first' => true,
        ]);

        if (!isset($product)) {
            return $this->sendBadRequest(null, __("validation.common.details_not_found", ["module" => "Product"]));
        }

        $input = $request->all();

        $validator = Products::validation($input, $id);
        if ($validator->fails()) {
            return $this->sendBadRequest(null, $validator->errors()->first());
        }

        $product = $this->commonCreateUpdate($input, $id);
        if ($product['flag'] == false) {
            return $this->sendBadRequest(null, $product['message']);
        }

        return $this->sendSuccessResponse($product['data'], $product['message']);

    }

    public function commonCreateUpdate($input, $id = null)
    {

        /** image upload code */
        if (isset($input['image'])) {
            $data = $this->imageController->moveFile($input['image'], 'products');
            if (isset($data) && $data['flag'] == false) {
                return $this->makeError(null, $data['message']);
            }
            $input['image'] = $data['data']['image'];
        }

        $product = $this->productRepository->updateOrCreate(['id' => $id], $input);

        $c = $this->productRepository->getDetailsByInput([
            'id' => $product->id,
            'relation' => ["category"],
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

        $product = $this->productRepository->updateRich([
            'is_active' => $input['is_active'],
        ], $input['id']);

        return $this->sendSuccessResponse($product, __('validation.common.updated', ['module' => "Product"]));

    }

    public function destory($id)
    {
        $product = $this->productRepository->delete($id);
        return $this->sendSuccessResponse($product, __('validation.common.deleted', ['module' => "Product"]));
    }

    public function multipleDelete(Request $request)
    {
        $input = $request->all();
        $validation = $this->requiredAllKeysValidation(['ids'], $input);
        if (isset($validation) && $validation['flag'] == false) {
            return $this->sendBadRequest(null, $validation['message']);
        }
        $product = $this->productRepository->deleteWhereIn('id', $input['ids']);
        return $this->sendSuccessResponse($product, __('validation.common.deleted', ['module' => "product"]));
    }
}
