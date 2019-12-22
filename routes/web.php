<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
 */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/test', function (Request $request) {
    return view('test');
    // $input = $request->all();

    // $encoded = json_encode($input['amenities_available'] ) ;
});


$router->get('privacy-policy', function () {
    return view('settings.privacy_policy');
});
$router->get('terms-and-conditions', function () {
    return view('settings.terms_and_conditions');
});
$router->get('refund-and-cancellation-policy', function () {
    return view('settings.refund_and_cancellation_policy');
});

$router->get('/verify-email/{id}', "Controller@userEmailVerify");
/** for vue routes */
$router->get('/admin', function () {
    return view('admin');
});

// $router->get('/admin/{route}/', function () {
//     return view('admin');
// });

/** For Image Security display user to show image */
$router->get(UPLOADED_FOLDER_NAME . '{folderName}/{moduleName}/{fileName}', function ($folderName, $moduleName, $fileName) {
    $storagePath = storage_path(UPLOADED_FOLDER_NAME . $folderName . '/' . $moduleName . '/' . $fileName . PNG_EXTENSION);

    if (file_exists($storagePath)) {
        $file = File::get($storagePath);
        $type = File::mimeType($storagePath);
        $response = response()->make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }
    $response = [
        'success' => false,
        'status' => 400,
        'data' => null,
        'message' => ucfirst(strtolower(__('validation.common.image_not_found'))),
    ];
    return response()->json($response);
});
