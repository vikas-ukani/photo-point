<?php

namespace App\Http\Controllers\API\v1\Offer;

use App\Models\Offer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Repositories\OfferRepositoryEloquent;

class OfferController extends Controller
{
    protected $offerRepository;

    public function __construct(OfferRepositoryEloquent $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    /**
     * store
     *
     * @param  mixed $request
     *
     * @return void
     */
    public function store(Request $request)
    {
        $input = $request->all();

        /** check model validation */
        $validation = Offer::validation($input);
        if (isset($validation) && $validation->errors()->count() > 0) {
            return $this->sendBadRequest(null, $validation->errors()->first());
        }

        $offer = $this->offerRepository->create($input);
        return $this->sendSuccessResponse($offer, __('validation.common.created', ['module' => "Offer"]));
    }
}
