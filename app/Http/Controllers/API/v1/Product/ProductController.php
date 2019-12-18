<?php

namespace App\Http\Controllers\API\v1\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Repositories\UsersRepositoryEloquent;
use App\Libraries\Repositories\ProductRepositoryEloquent;

class ProductController extends Controller
{
    protected $productRepository;
    protected $userRepository;

    public function __construct(
        ProductRepositoryEloquent $productRepository,
        UsersRepositoryEloquent $userRepository
    ) {
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
    }

    function list(Request $request)
    {
        $input = $request->all();

        $validation = $this->requiredAllKeysValidation(['category_id'], $input);
        if (isset($validation['flag']) && $validation['flag'] == false) {
            return $this->sendBadRequest(null, $validation['message']);
        }

        $products = $this->productRepository->getDetails($input);
        if (isset($products['count']) && $products['count'] == 0) {
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => "Products"]));
        }

        $products['list'] = $products['list']->toArray();

        foreach ($products['list'] as $key => &$product) {
            $product['ratting'] = 0;
            $product['ratting_count'] = 0;
            if (isset($product['customer_rating']) && count($product['customer_rating']) > 0) {
                $sumOfAllRate = collect($product['customer_rating'])->sum('rate');

                if (isset($sumOfAllRate)) {
                    $product['ratting'] = round($sumOfAllRate / count($product['customer_rating']), 1);
                    $product['ratting_count'] =  count($product['customer_rating']);
                }

                /** get customer details */
                // foreach ($product['customer_rating'] as $key => &$review) {
                //     $review['customer'] = $this->userRepository->getDetailsByInput([
                //         'id' => $review['user_id'],
                //         'list' => ["id", "photo", "first_name", "last_name"],
                //         'first' => true
                //     ]);
                // }


                // dd('cehck data', $sumOfAllRate, count($product['customer_rating']), $product['ratting'], $product);
            }
            unset($product['customer_rating']);
        }

        return $this->sendSuccessResponse($products, __('validation.common.details_found', ['module' => "products"]));
    }


    public function show($id)
    {
        $product = $this->productRepository->getDetailsByInput([
            'id' => $id,
            'relation' => ["customer_rating" => [""]],
            'customer_rating_list' => ["id", "product_id", "user_id", "review", "rate", "created_at"],
            'first' => true
        ]);

        if (!isset($product)) {
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => "product"]));
        }

        dd('check data', (int) $id, $product->toArray());
    }
}
