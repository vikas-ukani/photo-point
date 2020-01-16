<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImageUploadController extends Controller
{
    protected $imageController;

    /**
     * ImageUploadController constructor.
     * @param \App\Http\Controllers\ImageHelperController $imageController
     */
    public function __construct(
        ImageHelperController $imageController
    )
    {
        $this->imageController = $imageController;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadSingleFile(Request $request)
    {
        $input = $request->all();
//        dd("Input", $input, $request);

        /**
         * Validate Image Extensions
         */
        $validator = Validator::make($request->all(), [
            'folder_name' => 'required',
            'image' => 'required',
//            |mimes:pdf,jpg,png
        ]);
        if ($validator->fails()) {
            return $this->sendBadRequest(null, $validator->errors()->all());
        }
        /**
         * Finale Image Upload
         */
        $data = $this->imageController->moveFile($input['image'], $input["folder_name"]);
        if (isset($data) && $data['flag'] == false) {
            return $this->sendBadRequest(null, $data['message']);
        }
        $image = $data['data']['image'];
//        $image = env('APP_URL', url('/')) . $image;
        return $this->sendSuccessResponse($image, __('validation.common.saved', ['module' => "image"]));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadFiles(Request $request)
    {
        $input = $request->all();

        /**
         * Validate Image Extensions
         */
        $validator = Validator::make($request->all(), [
            'folder_name' => 'required',
            'images' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendBadRequest(null, $validator->errors()->all());
        }
        $images = [];


        $allowableExtension = ['pdf', 'jpg', 'png', 'docx'];

        if (isset($input['images'])) {
            foreach ($input['images'] as $file) {
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowableExtension);

                if (isset($check) && $check === false) return $this->sendBadRequest(null, __('validation.common.invalid_key', ['key' => "file extension"]));
                /** Upload Image here */
            }
            return $this->sendSuccessResponse($images, __('validation.common.saved', ['module' => "images"]));
        } else if (isset($input['image'])) {
            /**
             * Finale Image Upload
             */
            $data = $this->imageController->moveFile($input['image'], $input["folder_name"]);
            if (isset($data) && $data['flag'] == false) {
                return $this->sendBadRequest(null, $data['message']);
            }
            $image = $data['data']['image'];
            return $this->sendSuccessResponse($image, __('validation.common.saved', ['module' => "image"]));
        }

        /**
         * Multiple Upload
         */
//        if (isset($input['images']) && is_array($input['images']) && count($input['images']) > 0) {
//            foreach ($input['images'] as $key => $image) {
//                $data = $this->imageController->moveFile($image, 'products');
//                array_push($input['images'], $data['data']['image']);
//                $imagesArray[] = $data['data']['image'];
//            }
//            $input['image'] = is_array($imagesArray) ? implode(',', $imagesArray) : $imagesArray;
//        } else if (isset($input['image'])) {
//            /**
//             * Single Upload
//             */
//            $data = $this->imageController->moveFile($input['image'], 'products');
//            if (isset($data) && $data['flag'] == false) {
//                return $this->makeError(null, $data['message']);
//            }
//            $input['image'] = $data['data']['image'];
//        }
        return $this->sendSuccessResponse($input['image'], __('validation.common.saved', ['module' => "Images"]));
    }
}
