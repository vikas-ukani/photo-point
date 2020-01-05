<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Libraries\Repositories\CommonProductAttributesRepositoryEloquent;
use Illuminate\Http\Request;

class CommonProductAttributesController extends Controller
{
    protected $moduleName = "Common attributes";

    protected $commonProductAttributeRepository;

    public function __construct(CommonProductAttributesRepositoryEloquent $commonProductAttributeRepository)
    {
        $this->commonProductAttributeRepository = $commonProductAttributeRepository;
    }

    function list(Request $request) {
        $input = $request->all();

        $commonProductRepository = $this->commonProductAttributeRepository->getDetails($input);
        if (isset($commonProductRepository) && $commonProductRepository['count'] == 0) {
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => $this->moduleName]));
        }
        return $this->sendSuccessResponse($commonProductRepository, __('validation.common.details_not_found', ['module' => $this->moduleName]));
    }
     
}
