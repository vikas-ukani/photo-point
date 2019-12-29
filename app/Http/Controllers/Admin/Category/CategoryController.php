<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Libraries\Repositories\MainCategoryRepositoryEloquent;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(MainCategoryRepositoryEloquent $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    function list(Request $request) {
        $input = $request->all();

        $categries = $this->categoryRepository->getDetails($input);
        if ($categries['count'] == 0) {
            return $this->sendBadRequest(null, __("validation.common.details_not_found", ['module' => "Category"]));
        }

        return $this->sendSuccessResponse($categries, __("validation.common.details_found", ['module' => "Category"]));
    }

}
