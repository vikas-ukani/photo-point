<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Libraries\Repositories\MainCategoryRepositoryEloquent;

class CommonController extends Controller
{
    protected $mainCategoryRepository;

    public function __construct(MainCategoryRepositoryEloquent $mainCategoryRepository)
    {
        $this->mainCategoryRepository = $mainCategoryRepository;
    }

    //

    public function getAllCommonData()
    {
        $response = [];

        $response['main_categories'] = $this->getAllActiveMainCategories();

        return $this->sendSuccessResponse($response, __('validation.common.details_found', ['module' => "Main categories"]));
    }

    public function getAllActiveMainCategories()
    {
        return $this->mainCategoryRepository->getDetailsByInput([
            'is_active' => true,
        ]);
    }
}
