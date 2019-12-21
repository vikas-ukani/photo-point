<?php

namespace App\Http\Controllers\API\v1\Complaints;

use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageHelperController;
use App\Libraries\Repositories\ComplaintCategoryRepositoryEloquent;
use App\Libraries\Repositories\ComplaintRepositoryEloquent;

class ComplaintController extends Controller
{
    protected $complaintRepository;
    protected $complaintCategoryRepository;
    protected $imageController;

    public function __construct(
        ComplaintRepositoryEloquent $complaintRepository,
        ComplaintCategoryRepositoryEloquent $complaintCategoryRepository,
        ImageHelperController $imageController
    ) {
        $this->complaintRepository = $complaintRepository;
        $this->complaintCategoryRepository = $complaintCategoryRepository;
        $this->imageController = $imageController;
    }

    public function list(Request $request)
    {
        $input = $request->all();

        $input['user_id'] = $input['user_id'] ?? \Auth::id();

        /** get list */
        $complaints = $this->complaintRepository->getDetails($input);
        if (isset($complaints) && $complaints['count'] == 0) {
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => "Complaints"]));
        }
        return $this->sendSuccessResponse($complaints, __('validation.common.details_found', ['module' => "complaints"]));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $data = $this->commonCreateUpdate($input);
        if (isset($data) && $data['flag'] == false) return $this->sendBadRequest($data['data'], $data['message']);
        return $this->sendSuccessResponse($data['data'], __('validation.common.created', ['module' => "Complaint"]));
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        /** check complaint is found or not */
        $complaint = $this->complaintRepository->getDetailsByInput([
            'id' => $id,
            'user_id' => \Auth::id(),
            'first' => true
        ]);
        if (!!!isset($complaint)) return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => "Complaint"]));
        $data = $this->commonCreateUpdate($input, $id);
        if (isset($data) && $data['flag'] == false) return $this->sendBadRequest($data['data'], $data['message']);
        return $this->sendSuccessResponse($data['data'], $data['message']);
    }

    public function commonCreateUpdate($input, $id = null)
    {
        /** check model validation */
        $validation = Complaint::validation($input, $id);
        if (isset($validation) && $validation->errors()->count() > 0) {
            return $this->makeError(null, $validation->errors()->first());
        }

        /** upload multiple images */
        if (isset($input['images']) && is_array($input['images']) && count($input['images']) > 0) {
            $imagesArray = [];
            foreach ($input['images'] as $key => $images) {
                /** image upload code */
                $data = $this->imageController->moveFile($images, 'complaints');
                if (isset($data) && $data['flag'] == false) {
                    return $this->makeError(null, $data['message']);
                }
                $imagesArray[] = $data['data']['image'];
            }
            $input['images'] = is_array($imagesArray) ? implode(',', $imagesArray) : $imagesArray;
        } else if (isset($input['image'])) {
            /** image upload code */
            $data = $this->imageController->moveFile($input['image'], 'complaints');
            if (isset($data) && $data['flag'] == false) {
                return $this->makeError(null, $data['message']);
            }
            $input['image'] = $data['data']['image'];
        }

        $complaint = $this->complaintRepository->updateOrCreate(['id' => $id], $input);

        if (isset($id)) {
            return $this->makeResponse($complaint, __("validation.common.updated", ['module' => "complaint"]));
        } else {
            return $this->makeResponse($complaint, __("validation.common.created", ['module' => "complaint"]));
        }
    }

    /**
     * show  => get details by id
     *
     * @param  mixed $id
     *
     * @return void
     */
    public function show($id)
    {
        $complaint = $this->complaintRepository->getDetailsByInput([
            'id' => $id,
            'user_id' => \Auth::id(),
            'first' => true
        ]);

        /** check if complaint not found then return */
        if (!!!isset($complaint)) {
            /** check if complaint not found then return */
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => "complain"]));
        }
        return $this->sendSuccessResponse($complaint, __('validation.common.details_found', ['module' => "complain"]));
    }

    public function destroy($id)
    {
        /** check complaint found or not. */
        $complaint = $this->complaintRepository->getDetailsByInput([
            'id' => $id,
            'user_id' => \Auth::id(),
            'first' => true
        ]);
        if (!!!isset($complaint)) return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => "complaint"]));
        /** final delete. */
        $this->complaintRepository->delete($id);
        return $this->sendSuccessResponse($complaint, __('validation.common.deleted', ['module' => 'complaint']));
    }


    public function complaintCategoriesList(Request $request)
    {
        $input = $request->all();

        $complaintCategoriesList = $this->complaintCategoryRepository->getDetailsByInput($input);

        if (!!!isset($complaintCategoriesList)) return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => "complaint category"]));

        return $this->sendSuccessResponse($complaintCategoriesList, __('validation.common.details_found', ['module' => "complaint category"]));
    }
}
