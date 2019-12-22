<?php

namespace App\Http\Controllers\API\v1\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{



    public function getCommonData()
    {
        $response = [];

        $response['support_privacy_policy'] = url('privacy-policy');
        $response['support_terms_and_conditions'] = url('terms-and-conditions');
        $response['support_refund_and_cancellation_policy'] = url('refund-and-cancellation-policy');
        // SETTING_SUPPORT_WEBSITE;

        $response['support_website'] =  env('APP_URL', url('/'));

        $response['support_contact_number'] = SETTING_SUPPORT_CONTACT_NUMBER;

        $response['support_email'] = SETTING_SUPPORT_EMAIL;

        $response['support_days_and_times'] = [
            'support_day' => SETTING_SUPPORT_DAYS,
            'support_time' => SETTING_SUPPORT_TIMES
        ];



        return $this->sendSuccessResponse($response, __('validation.common.details_found', ['module' => "Common settings"]));
    }
}
