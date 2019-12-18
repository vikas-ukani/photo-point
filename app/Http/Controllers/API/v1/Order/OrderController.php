<?php

namespace App\Http\Controllers\API\v1\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Repositories\CartRepositoryEloquent;
use App\Libraries\Repositories\OrderRepositoryEloquent;
use App\Libraries\Repositories\ProductRepositoryEloquent;
use App\Models\Order;

class OrderController extends Controller
{
    protected $orderRepository;
    protected $cartRepository;
    protected $productRepository;

    public function __construct(
        OrderRepositoryEloquent $orderRepository,
        ProductRepositoryEloquent $productRepository,
        CartRepositoryEloquent $cartRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->cartRepository = $cartRepository;
    }

    public function list(Request $request)
    {
        $input = $request->all();

        /** get user wise orders */
        $input['user_id'] = $input['user_id'] ?? \Auth::id();

        /** get order details */
        $orders = $this->orderRepository->getDetails($input);
        if (isset($orders['count']) && $orders['count'] == 0) {
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => "Order"]));
        }
        return $this->sendSuccessResponse($orders, __('validation.common.details_found', ['module' => "Order"]));
    }

    public function store(Request $request)
    {
        $input = $request->all();

        /** check model validation */
        $validation = Order::validation($input);
        if (isset($validation) && $validation->errors()->count() > 0) {
            return $this->makeError(null, $validation->errors()->first());
        }

        /** set order date and excepted date*/
        $input['order_date'] = $this->getCurrentDateUTC();
        $input['expected_date'] = $this->addNumberOfDayInCurrentDate(DEFAULT_EXCEPTED_DATE_DAY);

        $order = $this->orderRepository->create($input);

        /** clear all cart details after order has been planced */
        $this->cartRepository->deleteWhere(['user_id' => \Auth::id()]);
        return $this->sendSuccessResponse($order, __('validation.common.order_placed_success'));
    }

    public function getOrderDetailsFromCart(Request $request)
    {
        $input = $request->all();
        $userId = \Auth::id();

        $cartDetails = $this->cartRepository->getDetailsByInput([
            'user_id' => $userId,
        ]);

        $productIds = collect($cartDetails)->pluck('id')->all();

        $products = $this->productRepository->getDetailsByInput([
            'ids' => $productIds
        ]);

        $productTotalAmount = 0;

        /** get product total amount */
        $productTotalAmount = collect($products)->sum('price');

        $productTotalDiscount = 0;
        $productDeliveryCharges = $productTotalAmount != 0 ? DEFAULT_DELIVERY_CHARGE : 0;

        $returnResponse = [
            'total_amount' => $productTotalAmount,
            'discount_amount' => $productTotalDiscount,
            'delivery_charges' => $productDeliveryCharges
        ];
        return $this->sendSuccessResponse($returnResponse, __('validation.common.details_found', ['module' => "Place Order"]));
    }

    public function show($id)
    {
        $orderDetails = $this->orderRepository->getDetailsByInput([
            'user_id' => \Auth::id(),
            'id' => $id,
            'first' => true,
        ]);

        if (!isset($orderDetails)) {
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => "Order"]));
        }
        return $this->sendSuccessResponse($orderDetails, __('validation.common.details_found', ['module' => "Order"]));
    }
}
