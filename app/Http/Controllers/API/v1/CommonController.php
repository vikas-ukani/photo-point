<?php /** @noinspection ALL */

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Libraries\Repositories\MainCategoryRepositoryEloquent;
use App\Libraries\Repositories\CountryRepositoryEloquent;
use App\Libraries\Repositories\StateRepositoryEloquent;
use App\Libraries\Repositories\CityRepositoryEloquent;

class CommonController extends Controller
{
    protected $mainCategoryRepository;
    protected $countryRepository;
    protected $stateRepository;
    protected $cityRepository;

    public function __construct(
        MainCategoryRepositoryEloquent $mainCategoryRepository,
        CountryRepositoryEloquent $countryRepository,
        StateRepositoryEloquent $stateRepository,
        CityRepositoryEloquent $cityRepository
    ) {
        $this->mainCategoryRepository = $mainCategoryRepository;
        $this->countryRepository = $countryRepository;
        $this->stateRepository = $stateRepository;
        $this->cityRepository = $cityRepository;
    }

    //

    public function getAllCommonData()
    {
        $response = [];
        $response['main_categories'] = $this->getAllActiveMainCategories();
        return $this->sendSuccessResponse($response, __('validation.common.details_found', ['module' => "Main categories"]));
    }

    public function getMainCategory()
    {
        $mainCategory = $this->mainCategoryRepository->getDetailsByInput([
            'is_parent' => true,
            'is_active' => true,
            'list' => [ 'id', "name", "image"]
        ]);
        if (!!!isset($mainCategory)){
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => "Main Category"]));
        }
        return $this->sendSuccessResponse($mainCategory, __('validation.common.details_found', ['module' => "Main Category"]));
    }

    public function getSubcategoryByMainID($id)
    {
        $subCategory = $this->mainCategoryRepository->getDetailsByInput([
            'parent_id' => $id,
            'is_active' => true,
            'list' => [ 'id', "name", "image"]
        ]);
        if (!!!isset($subCategory)){
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => "Sub Category"]));
        }
        return $this->sendSuccessResponse($subCategory, __('validation.common.details_found', ['module' => "sub Category"]));
    }

    public function getChildcategoryBySubID($id)
    {
        $subCategory = $this->mainCategoryRepository->getDetailsByInput([
            'parent_id' => $id,
            'is_active' => true,
            'list' => [ 'id', "name", "image"]
        ]);
        if (!!!isset($subCategory)){
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => "child Category"]));
        }
        return $this->sendSuccessResponse($subCategory, __('validation.common.details_found', ['module' => "child Category"]));
    }

    public function getAllActiveMainCategories()
    {
        return $this->mainCategoryRepository->getDetailsByInput([
            'is_parent' => true,
            'is_active' => true,
        ]);
    }



    public function getCountryStateCity()
    {
        $response = [];

        /** get country */
        $response['country_list'] = $this->countryRepository->getDetailsByInput([
            'is_active' => true
        ]);

        /** get state  */
        $response['state_list'] =  $this->stateRepository->getDetailsByInput([
            'is_active' => true
        ]);
        /** get city  */
        $response['city_list'] =  $this->cityRepository->getDetailsByInput([
            'is_active' => true
        ]);



        return $this->sendSuccessResponse($response, __('validaiton.common.details_found', ['module' => "country, state, city"]));
    }
}
