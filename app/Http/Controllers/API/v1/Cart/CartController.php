<?php

namespace App\Http\Controllers\API\v1\Cart;

use App\Http\Controllers\Controller;
use App\Libraries\Repositories\CartRepositoryEloquent;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartRepository;
    protected $userId;

    public function __construct(CartRepositoryEloquent $cartRepository)
    {
        $this->userId = \Auth::id();
        $this->cartRepository = $cartRepository;
    }

    function list(Request $request)
    {
        $input = $request->all();
        $input['user_id'] = $input['user_id'] ?? $this->userId;
        $carts = $this->cartRepository->getDetails($input);
        if (isset($carts) && $carts['count'] === 0) {
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => 'Cart']));
        }
        return $this->sendSuccessResponse($carts, __('validation.common.details_found', ['module' => 'Cart']));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validation = $this->requiredAllKeysValidation(['product_id', 'quantity', 'product_stock_id'], $input);
        if (isset($validation['flag']) && $validation['flag'] === false) {
            return $this->sendBadRequest(null, $validation['message']);
        }

        $input['user_id'] = $input['user_id'] ?? $this->userId;

        $cartDetails = $this->createOrUpdateCartDetails($input);
        if (isset($cartDetails['flag']) && $cartDetails['flag'] == false) {
            return $this->sendBadRequest($cartDetails['data'], $cartDetails['message']);
        }
        return $this->sendSuccessResponse($cartDetails['data'], $cartDetails['message']);
    }

    public function createOrUpdateCartDetails($input)
    {
        /** check if product found or not */
        $cart = $this->cartRepository->getDetailsByInput([
            'user_id' => $this->userId,
            "relation" => ["product", "product.customer_rating", "stock_inventory"],
            // "stock_inventory_list" => ["product_id", "images", "sale_price", "mrp_price"],
            'product_id' => $input['product_id'],
            'product_stock_id' => $input['product_stock_id'],
            'first' => true,
        ]);
        /** check if user product already exists or not */
        if (isset($cart)) {
            /** if found then update quantity + user quantity */
            $cart->quantity = $cart->quantity + (int) ($input['quantity'] ?? 1);
            $cart->save();
        } else {
            /** if not found then create new cart entry */
            $cart = $this->cartRepository->create($input);
            // $cart = $this->cartRepository->create([
            //     'user_id' => $this->userId,
            //     'product_id' => $input['product_id'],
            //     'product_stock_id' => $input['product_stock_id'],
            //     'quantity' => $input['quantity'],
            // ]);
        }

        /** return cart details with relation wise commonly */
        $cart = $this->getCartDetails([
            'id' => $cart->id,
            'relation' => [
                'user', 'product', 'product.customer_rating', 'stock_inventory'
            ],
            // 'stock_inventory_list' => ['product_id', 'images', 'sale_price', 'mrp_price'],
            'first' => true,
        ]);
        return $this->makeResponse($cart, __('validation.common.saved', ['module' => "Cart"]));
    }

    public function getCartDetails($input)
    {
        return $this->cartRepository->getDetailsByInput($input);
    }

    public function destroye($id)
    {
        $this->cartRepository->delete($id);
        return $this->sendSuccessResponse(null, __('validation.common.deleted', ['module' => "cart"]));
    }

    public function substractCartQuantity($id)
    {
        $cart = $this->cartRepository->getDetailsByInput(['id' => $id, 'first' => true]);
        if (!!!isset($cart)) {
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => 'cart']));
        }

        $cart->quantity = $cart->quantity - 1;
        $cart->save();
        $cart = $this->getCartDetails(['id' => $cart->id, 'relation' => ['product', 'stock_inventory', 'user'], 'first' => true]);
        return $this->sendSuccessResponse($cart, __('validation.common.saved', ['module' => 'cart']));
    }

    public function getCartCount()
    {
        $input = [
            'user_id' => $this->userId
        ];
        $count = $this->cartRepository->getCountByInput($input);
        return $this->sendSuccessResponse(['count' => $count], __("validation.common.details_found", ["module" => "Cart count"]));
    }
}
