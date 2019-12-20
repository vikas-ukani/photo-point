<?php

namespace App\Http\Controllers\API\v1\Complaints;

use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageHelperController;
use App\Libraries\Repositories\ComplaintRepositoryEloquent;

class ComplaintController extends Controller
{
    protected $complaintRepository;
    protected $imageController;

    public function __construct(
        ComplaintRepositoryEloquent $complaintRepository,
        ImageHelperController $imageController
    ) {
        $this->complaintRepository = $complaintRepository;
        $this->imageController = $imageController;
    }


    public function list(Request $request)
    {
        $input = $request->all();

        $input['user_id'] = $input['user_id'] ?? \Auth::id();


        /** get list */
        dd('Listing', $input);
    }


    public function store(Request $request)
    {
        $input = $request->all();

        /** check model validation */
        $validation = Complaint::validation($input);
        if (isset($validation) && $validation->errors()->count() > 0) {
            return $this->makeError(null, $validation->errors()->first());
        }

        /** upload multiple images */
        if (isset($input['images']) && is_array($input['images']) && count($input['images']) > 0) {
            #pass
            $imagesArray = [];
            foreach ($input['images'] as $key => $images) {
                /** image upload code */
                $data = $this->imageController->moveFile($images, 'complaints');
                if (isset($data) && $data['flag'] == false) {
                    return $this->makeError(null, $data['message']);
                }
                // $input['image'] = $data['data']['image'];
                $imagesArray[] = $data['data']['image'];
            }
            $input['images'] = is_array($imagesArray) ? implode(',', $imagesArray) : $imagesArray;
        }

        $complaint = $this->complaintRepository->create($input);

        return $this->sendSuccessResponse($complaint, __('validation.common.created', ['module' => "Complaint"]));
    }
}
