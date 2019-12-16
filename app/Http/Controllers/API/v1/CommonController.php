<?php

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

    public function getAllActiveMainCategories()
    {
        return $this->mainCategoryRepository->getDetailsByInput([
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
