<?php

namespace App\Http\Controllers\Admin\Complaint;

use Illuminate\Http\Request;
use App\Models\ComplaintCategory;
use App\Http\Controllers\Controller;
use App\Libraries\Repositories\ComplaintCategoryRepositoryEloquent;

class ComplaintCategoryController extends Controller
{
    protected $complaintCategoryRepository;
    protected $imageController;

    public function __construct(
        ComplaintCategoryRepositoryEloquent $complaintCategoryRepository
    ) {
        $this->complaintCategoryRepository = $complaintCategoryRepository;
    }

    function list(Request $request)
    {
        $input = $request->all();
        $complaintCategoeries = $this->complaintCategoryRepository->getDetails($input);
        if (isset($complaintCategoeries['count']) && $complaintCategoeries['count'] == 0) {
            return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => "Complaint Categories"]));
        }
        return $this->sendSuccessResponse($complaintCategoeries, __('validation.common.details_found', ['module' => "Complaint Categories"]));
    }

    public function show($id)
    {
        $complaintCategoerie = $this->complaintCategoryRepository->getDetailsByInput([
            'id' => $id,
            'first' => true,
        ]);

        if (!isset($complaintCategoerie)) {
            return $this->sendBadRequest(null, __("validation.common.details_not_found", ['module' => "Complaint Categories"]));
        }

        return $this->sendSuccessResponse($complaintCategoerie, __("validation.common.details_found", ["module" => "Complaint Categories"]));
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $data = $this->commonCreateUpdate($input);
        if (isset($data) && $data['flag'] == false) {
            return $this->sendBadRequest($data['data'], $data['message']);
        }

        return $this->sendSuccessResponse($data['data'], $data['message']);
    }

    public function update(Request $request, $id)
    {
        $complaintCategoerie = $this->complaintCategoryRepository->getDetailsByInput([
            'id' => $id,
            'first' => true,
        ]);
        if (!isset($complaintCategoerie)) {
            return $this->sendBadRequest(null, __("validation.common.details_not_found", ["module" => "Complaint Categories"]));
        }

        $input = $request->all();
        $complaintCategoerie = $this->commonCreateUpdate($input, $id);
        if ($complaintCategoerie['flag'] == false) {
            return $this->sendBadRequest(null, $complaintCategoerie['message']);
        }
        return $this->sendSuccessResponse($complaintCategoerie['data'], $complaintCategoerie['message']);
    }

    public function commonCreateUpdate($input, $id = null)
    {
        $validator = ComplaintCategory::validation($input, $id);
        if ($validator->fails()) {
            return $this->makeError(null, $validator->errors()->first());
        }

        $complaintCategoerie = $this->complaintCategoryRepository->updateOrCreate(['id' => $id], $input);
        if (isset($id)) {
            return $this->makeResponse($complaintCategoerie, __("validation.common.updated", ['module' => "Complaint Categories"]));
        } else {
            return $this->makeResponse($complaintCategoerie, __("validation.common.created", ['module' => "Complaint Categories"]));
        }
    }

    public function statusChange(Request $request)
    {
        $input = $request->all();
        $validation = $this->requiredAllKeysValidation(['id', 'is_active'], $input);
        if (isset($validation) && $validation['flag'] == false) {
            return $this->sendBadRequest(null, $validation['message']);
        }

        $complaintCategoerie = $this->complaintCategoryRepository->updateRich([
            'is_active' => $input['is_active'],
        ], $input['id']);

        return $this->sendSuccessResponse($complaintCategoerie, __('validation.common.updated', ['module' => "Complaint Categories"]));
    }

    public function destory($id)
    {
        $complaintCategoerie = $this->complaintCategoryRepository->delete($id);
        return $this->sendSuccessResponse($complaintCategoerie, __('validation.common.deleted', ['module' => "Complaint Categories"]));
    }

    public function multipleDelete(Request $request)
    {
        $input = $request->all();
        $validation = $this->requiredAllKeysValidation(['ids'], $input);
        if (isset($validation) && $validation['flag'] == false) {
            return $this->sendBadRequest(null, $validation['message']);
        }
        $complaintCategoerie = $this->complaintCategoryRepository->deleteWhereIn('id', $input['ids']);
        return $this->sendSuccessResponse($complaintCategoerie, __('validation.common.deleted', ['module' => "Complaint Categories"]));
    }
}
