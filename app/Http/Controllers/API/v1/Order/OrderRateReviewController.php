<?php

namespace App\Http\Controllers\API\v1\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Repositories\OrderRateReviewRepositoryEloquent;
use App\Models\OrderRateReview;

class OrderRateReviewController extends Controller
{
    public $userId;
    protected $orderRateReviewRepository;

    public function __construct(OrderRateReviewRepositoryEloquent $orderRateReviewRepository)
    {
        $this->userId = \Auth::id();
        $this->orderRateReviewRepository = $orderRateReviewRepository;
    }


    public function store(Request $request)
    {
        $input = $request->all();

        /** add user id if not exists */
        $input['user_id'] = $input['user_id'] ?? $this->userId;


        /** check model validation */
        $validation = OrderRateReview::validation($input);
        if (isset($validation) && $validation->errors()->count() > 0) {
            return $this->sendBadRequest(null, $validation->errors()->first());
        }

        /** store if all validation applied */
        $orderRateReview = $this->orderRateReviewRepository->create($input);

        return $this->sendSuccessResponse($orderRateReview, __('validation.common.saved', ['module' => "Review"]));
    }
}
