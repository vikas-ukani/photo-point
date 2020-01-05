<?php

/** @noinspection ALL */

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageHelperController;
use App\Libraries\Repositories\FeatureProductRepositoryEloquent;
use App\Libraries\Repositories\ProductAttributesDetailsRepositoryEloquent;
use App\Libraries\Repositories\ProductRepositoryEloquent;
use App\Models\ProductAttributesDetails;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productRepository;
    protected $featureProductRepository;
    protected $imageController;
    protected $productAttributesDetailsRepository;

    public function __construct(
        ImageHelperController $imageController,
        ProductRepositoryEloquent $productRepository,
        FeatureProductRepositoryEloquent $featureProductRepository,
        ProductAttributesDetailsRepositoryEloquent $productAttributesDetailsRepository
    ) {
        $this->productRepository = $productRepository;
        $this->featureProductRepository = $featureProductRepository;
        $this->imageController = $imageController;
        $this->productAttributesDetailsRepository = $productAttributesDetailsRepository;
    }

    // featureProductList
    /**
     * @param Request $request
     */
    public function featureProductList(Request $request)
    {
        $input = $request->all();
        $products = $this->featureProductRepository->getDetails($input);
        if (isset($products['count']) && $products['count'] == 0) {
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => "Feature Products"]));
        }

        $products = array_values(array_flatten(collect($products['list'])->pluck('product_details')->all()));

        $productsRes = $this->setProductRating($products);

        return $this->sendSuccessResponse($productsRes, __('validation.common.details_found', ['module' => "Feature products"]));
    }

    public function setProductRating(&$products = null)
    {
        if (isset($products)) {
            foreach ($products as $key => &$product) {
                $product['ratting'] = 0;
                $product['ratting_count'] = 0;
                if (isset($product['customer_rating']) && count($product['customer_rating']) > 0) {
                    $sumOfAllRate = collect($product['customer_rating'])->sum('rate');

                    if (isset($sumOfAllRate)) {
                        $product['ratting'] = round($sumOfAllRate / count($product['customer_rating']), 1);
                        $product['ratting_count'] = count($product['customer_rating']);
                    }
                }
                unset($product['customer_rating']);
            }
            return $products;
        }
    }

    function list(Request $request)
    {
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

        /**
         * Multiple Upload
         */
        if (isset($input['images']) && is_array($input['images']) && count($input['images']) > 0) {
            foreach ($input['images'] as $key => $image) {
                $data = $this->imageController->moveFile($image, 'products');
                array_push($input['images'], $data['data']['image']);
                $imagesArray[] = $data['data']['image'];
            }
            $input['image'] = is_array($imagesArray) ? implode(',', $imagesArray) : $imagesArray;
        } else if (isset($input['image'])) {
            /**
             * Single Upload
             */
            $data = $this->imageController->moveFile($input['image'], 'products');
            if (isset($data) && $data['flag'] == false) {
                return $this->makeError(null, $data['message']);
            }
            $input['image'] = $data['data']['image'];
        }

        /** after create an product add their attributes */
        try {
            $attr = [];
            /** check to create or update */
            if (isset($id)) {
                /** update */
                $product = $this->productRepository->update($input, $id);
            } else {
                /** create */
                $product = $this->productRepository->create($input);
            }
            foreach ($input['product_attributes'] as $key => &$value) {
                $value['product_id'] = $product->id;
                // $value['product_id'] = 900;
                $attr[] = $this->productAttributesDetailsRepository->updateOrCreate(
                    [
                        'product_id' => $value['product_id'],
                        'common_product_attribute_id' => $value['common_product_attribute_id']
                    ],
                    $value
                );
            }
        } catch (\Exception $e) {
            /** if any error found then delete created product */
            if (!!!isset($id)) {
                $this->productRepository->delete($product->id);
            }

            \Log::error($e->getMessage());
            return $this->makeError(null, $e->getCode() . "-" . $e->getMessage());
        }

        $product = $this->productRepository->getDetailsByInput([
            'id' => $product->id,
            'relation' => ["category", 'product_attributes'/* , 'product_attributes.common_product_attribute_detail' */],
            'product_attributes_list' => ["product_id",  "common_product_attribute_id", "value", "values"],
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
