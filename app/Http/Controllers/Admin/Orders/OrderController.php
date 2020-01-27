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
}
