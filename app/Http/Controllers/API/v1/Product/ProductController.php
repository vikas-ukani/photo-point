<?php

namespace App\Http\Controllers\API\v1\Product;

use App\Http\Controllers\Controller;
use App\Libraries\Repositories\ProductRepositoryEloquent;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepositoryEloquent $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    function list(Request $request) {
        $input = $request->all();

        $validation = $this->requiredAllKeysValidation(['category_id'], $input);
        if (isset($validation['flag']) && $validation['flag'] == false) {
            return $this->sendBadRequest(null, $validation['message']);
        }

        $products = $this->productRepository->getDetails($input);
        if (isset($products['count']) && $products['count'] == 0) {
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => "Products"]));
        }

        return $this->sendSuccessResponse($products, __('validation.common.details_found', ['module' => "products"]));

    }
}
