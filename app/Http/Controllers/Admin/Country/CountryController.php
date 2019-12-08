<?php

namespace App\Http\Controllers\Admin\Country;

use App\Http\Controllers\Controller;
use App\Libraries\Repositories\CountryRepositoryEloquent;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    protected $countryRepository;

    public function __construct(CountryRepositoryEloquent $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    function list(Request $request) {
        $input = $request->all();

        $country = $this->countryRepository->getDetails();
        if (isset($country) && $country['count'] == 0) {
            return $this->sendBadRequest(null, "Country Not found.");
        }
        return $this->sendSuccessResponse($country, "Country found");
    }
}
