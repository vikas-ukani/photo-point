<?php /** @noinspection ALL */

namespace App\Http\Controllers\API\v1\Product;

use App\Http\Controllers\Controller;
use App\Libraries\Repositories\FavoriteProductRepositoryEloquent;
use App\Libraries\Repositories\FeatureProductRepositoryEloquent;
use App\Libraries\Repositories\OrderRateReviewRepositoryEloquent;
use App\Libraries\Repositories\ProductRepositoryEloquent;
use App\Libraries\Repositories\UsersRepositoryEloquent;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $userId;
    protected $orderRateReviewRepository;
    protected $productRepository;
    protected $featureProductRepository;
    protected $userRepository;
    protected $favoriteProductRepository;

    public function __construct(
        OrderRateReviewRepositoryEloquent $orderRateReviewRepository,
        ProductRepositoryEloquent $productRepository,
        FavoriteProductRepositoryEloquent $favoriteProductRepository,
        FeatureProductRepositoryEloquent $featureProductRepository,
        UsersRepositoryEloquent $userRepository
    )
    {
        $this->userId = \Auth::id();
        $this->orderRateReviewRepository = $orderRateReviewRepository;
        $this->productRepository = $productRepository;
        $this->favoriteProductRepository = $favoriteProductRepository;

        $this->featureProductRepository = $featureProductRepository;
        $this->userRepository = $userRepository;
    }

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

            $allFavoriteProductIdByUser = $this->favoriteProductRepository->getDetails([
                'user_id' => $this->userId,
                'list' => ["id", "product_id"]
            ]);

            if (isset($allFavoriteProductIdByUser['count']) && $allFavoriteProductIdByUser['count'] !== 0) {
                  $favoriteProductIds = collect($allFavoriteProductIdByUser['list'])->pluck('product_id')->all();
            }
            foreach ($products as $key => &$product) {

                $product['is_favorite'] = false;
                    if (isset($product) && $favoriteProductIds && in_array($product['id'], $favoriteProductIds)){
                    $product['is_favorite'] = true;

                }



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

    /**
     * @param Request $request
     */
    function list(Request $request)
    {
        $input = $request->all();

        /** if_favorite key for list all favorite product list by user */
        if (isset($input['is_favorite_by_user']) && $input['is_favorite_by_user'] == true) {
            /** 1. first get all favorite product from favorite table */
            $requestFavorite = [
                'user_id' => \Auth::id(),
                'list' => ["id", "product_id"]
            ];

            $favoriteProductIds = $this->favoriteProductRepository->getDetails($requestFavorite);
            if (isset($favoriteProductIds['count']) && $favoriteProductIds['count'] == 0) {
                return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => "Favorite"]));
            }
            $favoriteProductIds = collect($favoriteProductIds['list'])->pluck('product_id')->all();

            $input['ids'] = $favoriteProductIds;
        } else {
            $validation = $this->requiredAllKeysValidation(['category_id'], $input);
            if (isset($validation['flag']) && $validation['flag'] == false) {
                return $this->sendBadRequest(null, $validation['message']);
            }
        }

        $products = $this->productRepository->getDetails($input);
        if (isset($products['count']) && $products['count'] == 0) {
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => "Products"]));
        }

        $products['list'] = $products['list']->toArray();
        $products['list'] = $this->setProductRating($products['list']);

        // foreach ($products['list'] as $key => &$product) {
        //     $product['ratting'] = 0;
        //     $product['ratting_count'] = 0;
        //     if (isset($product['customer_rating']) && count($product['customer_rating']) > 0) {
        //         $sumOfAllRate = collect($product['customer_rating'])->sum('rate');

        //         if (isset($sumOfAllRate)) {
        //             $product['ratting'] = round($sumOfAllRate / count($product['customer_rating']), 1);
        //             $product['ratting_count'] =  count($product['customer_rating']);
        //         }
        //     }
        //     unset($product['customer_rating']);
        // }

        return $this->sendSuccessResponse($products, __('validation.common.details_found', ['module' => "products"]));
    }

    public function show($id)
    {
        $product = $this->productRepository->getDetailsByInput([
            'id' => $id,
            // 'relation' => ["customer_rating.customer_detail"],
            // 'customer_rating_list' => ["id", "product_id", "user_id", "review", "rate", "created_at"],
            // 'customer_rating.customer_detail_list' => ["id", "first_name", "photo", "email", "created_at"],
            'first' => true
        ]);
        if (!isset($product)) {
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => "product"]));
        }
        $product = $product->toArray();
        $product['customer_rating'] = $this->getProductRateReviewByInput([
            'product_id' => $id,
            'relation' => ['customer_detail'],
            'customer_detail_list' => ["id", "first_name", "last_name", "photo", "email", "created_at"],
            'list' => ["id", "product_id", "user_id", "review", "rate", "created_at"],
            'page' => 1,
            'limit' => 5
        ]);

        // $product['customer_rating'] = $this->orderRateReviewRepository->getDetailsByInput([
        //     'product_id' => $id,
        //     'relation'  => ['customer_detail'],
        //     'customer_detail_list' => ["id", "first_name", "photo", "email", "created_at"],
        //     'list' => ["id", "product_id", "user_id", "review", "rate", "created_at"],
        //     'page' => 1,
        //     'limit' => 5
        // ]);

        /** get total sum and toal reviewer */
        $allReviews = $this->orderRateReviewRepository->getDetailsByInput([
            'product_id' => $id,
            'list' => ["id", 'rate']
        ]);
        $sumOfAllRate = collect($allReviews)->sum('rate');

        $product['ratting'] = 0;
        $product['ratting_count'] = 0;
        if (isset($sumOfAllRate) && $sumOfAllRate > 0) {
            $product['ratting'] = round($sumOfAllRate / count($allReviews), 1);
            $product['ratting_count'] = count($allReviews);
        }

        return $this->sendSuccessResponse($product, __('validation.common.details_found', ['module' => "Product"]));
    }

    public function getProductRateReviewByInput($input = null)
    {
        if (isset($input)) {
            $reviews = $this->orderRateReviewRepository->getDetailsByInput(
                $input
            //      [
            //      'product_id' => $id,
            //      'relation'  => ['customer_detail'],
            //      'customer_detail_list' => ["id", "first_name", "photo", "email", "created_at"],
            //      'list' => ["id", "product_id", "user_id", "review", "rate", "created_at"],
            //      'page' => $input['page'] ?? 1,
            //      'limit' => $input['limit'] ?? 5
            //      ]
            );
            return $reviews;
        }
    }

    /**
     * getProductReviews
     *
     * @param mixed $request
     *
     * @return void
     */
    public function getProductReviews(Request $request)
    {
        $input = $request->all();
        $reviews = $this->getProductRateReviewByInput($input);
        if (isset($reviews) && count($reviews) == 0) return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => "review and rate"]));
        return $this->sendSuccessResponse($reviews, __('validation.common.details_found', ['module' => 'review and rate']));
    }
}
