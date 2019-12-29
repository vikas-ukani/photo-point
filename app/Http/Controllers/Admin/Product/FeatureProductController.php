<?php /** @noinspection ALL */

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Libraries\Repositories\FeatureProductRepositoryEloquent;
use App\Models\FeatureProducts;
use Illuminate\Http\Request;

class FeatureProductController extends Controller
{
    protected $featureProductRepository;
    protected $moduleName = "Feature Products";

    public function __construct(
        FeatureProductRepositoryEloquent $featureProductRepository
    ) {
        $this->featureProductRepository = $featureProductRepository;
    }

    /**
     * @param Request $request
     */
    public function featureProductList(Request $request)
    {
        $input = $request->all();
        $products = $this->featureProductRepository->getDetails($input);
        if (isset($products['count']) && $products['count'] == 0) {
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => $this->moduleName]));
        }

        $products = array_values(array_flatten(collect($products['list'])->pluck('product_details')->all()));

        $productsRes = $this->setProductRating($products);

        return $this->sendSuccessResponse($productsRes, __('validation.common.details_found', ['module' => $this->moduleName]));
    }

    function list(Request $request) {
        $input = $request->all();

        $featureProduct = $this->featureProductRepository->getDetailsByInput($input);

        if (!!!isset($featureProduct)) {
            return $this->sendBadRequest(null, __('validation.common.details_not_found'));
        }

        return $this->sendSuccessResponse($featureProduct, __('validation.common.details_found', ['module' => $this->moduleName]));
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

    public function show($id)
    {
        /**
         * get details by product id not pid
         */
        $featureProduct = $this->featureProductRepository->getDetailsByInput([
            'id' => $id,
            'relation' => [
                "product_detail",
                "product_detail.category",
                "product_detail.customer_rating"
            ],
            'first' => true,
        ]);

        if (!isset($featureProduct)) {
            return $this->sendBadRequest(null, __("validation.common.details_not_found", ['module' => $this->moduleName]));
        }

        return $this->sendSuccessResponse($featureProduct, __("validation.common_details_found", ["module" => $this->moduleName]));

    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = FeatureProducts::validation($input);
        if ($validator->fails()) {
            return $this->sendBadRequest(null, $validator->errors()->first());
        }

        $featureProduct = $this->commonCreateUpdate($input);
        if (isset($featureProduct) && $featureProduct['flag'] == false) {
            return $this->sendBadRequest(null, $featureProduct['message']);
        }

        return $this->sendSuccessResponse($featureProduct['data'], $featureProduct['message']);
    }

    public function update(Request $request, $id)
    {
        $featureProduct = $this->featureProductRepository->getDetailsByInput([
            'id' => $id,
            'first' => true,
        ]);

        if (!isset($featureProduct)) {
            return $this->sendBadRequest(null, __("validation.common.details_not_found", ["module" => $this->moduleName]));
        }

        $input = $request->all();

        $validator = FeatureProducts::validation($input, $id);
        if ($validator->fails()) {
            return $this->sendBadRequest(null, $validator->errors()->first());
        }

        $featureProduct = $this->commonCreateUpdate($input, $id);
        if ($featureProduct['flag'] == false) {
            return $this->sendBadRequest(null, $featureProduct['message']);
        }

        return $this->sendSuccessResponse($featureProduct['data'], $featureProduct['message']);
    }

    public function commonCreateUpdate($input, $id = null)
    {
         $featureProduct = $this->featureProductRepository->updateOrCreate(['id' => $id], $input);

        $featureProduct = $this->featureProductRepository->getDetailsByInput([
            'id' => $featureProduct->id,
            'relation' => [
                "product_detail",
                "product_detail.category",
                "product_detail.customer_rating"
            ],
            'first' => true,
        ]);

        if (isset($id)) {
            return $this->makeResponse($featureProduct, __("validation.common.updated", ['module' => $this->moduleName]));
        } else {
            return $this->makeResponse($featureProduct, __("validation.common.created", ['module' => $this->moduleName]));
        }
    }

    public function statusChange(Request $request)
    {
        $input = $request->all();
        $validation = $this->requiredAllKeysValidation(['id', 'is_active'], $input);
        if (isset($validation) && $validation['flag'] == false) {
            return $this->sendBadRequest(null, $validation['message']);
        }

        $featureProduct = $this->featureProductRepository->updateRich([
            'is_active' => $input['is_active'],
        ], $input['id']);

        return $this->sendSuccessResponse($featureProduct, __('validation.common.updated', ['module' => $this->moduleName]));
    }

    public function destory($id)
    {
        $featureProduct = $this->featureProductRepository->delete($id);
        return $this->sendSuccessResponse($featureProduct, __('validation.common.deleted', ['module' => $this->moduleName]));
    }

    public function multipleDelete(Request $request)
    {
        $input = $request->all();
        $validation = $this->requiredAllKeysValidation(['ids'], $input);
        if (isset($validation) && $validation['flag'] == false) {
            return $this->sendBadRequest(null, $validation['message']);
        }
        $featureProduct = $this->featureProductRepository->deleteWhereIn('id', $input['ids']);
        return $this->sendSuccessResponse($featureProduct, __('validation.common.deleted', ['module' => $this->moduleName]));
    }
}
