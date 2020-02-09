<?php

namespace App\Http\Controllers\Admin\Orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Repositories\OrderRepositoryEloquent;
use Exception;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected $orderRepository;

    public function __construct(OrderRepositoryEloquent $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * list => get all orders
     *
     * @param  mixed $request
     *
     * @return void
     */
    public function list(Request $request)
    {
        $input = $request->all();

        try {
            $orders = $this->orderRepository->getDetails($input);
            return $this->sendSuccessResponse($orders, __('validation.common.details_found', ['module' => "Orders"]));
        } catch (Exception $e) {
            //throw $th;
            Log::error($e->getMessage());
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => "Orders"]));
        }
    }



    /**
     * changeStatus => change order status by order id  
     *
     * @param  mixed $request
     *
     * @return void
     */
    public function changeStatus(Request $request)
    {
        $input = $request->all();

        $validation = $this->requiredValidation(['status', 'id'], $input);
        if (isset($validation) && $validation['flag'] == false) {
            return $this->sendBadRequest(null, $validation['message']);
        }

        // $order = $this->orderRepository->getDetailsByInput([
        //     'id' => $input['id'],
        //     'first' => true
        // ]);
        // if (!!!isset($order)) {
        //     return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => 'Order']));
        // }

        //  
        $order = $this->orderRepository->updateRich([
            'status' => $input['status'],
        ], $input['id']);
        // 

        // $order->status = ORDER_STATUS_CANCELED;
        // $order->save();

        return $this->sendSuccessResponse($order, __('validation.common.changed', ['module' => "Order status"]));
    }
}
