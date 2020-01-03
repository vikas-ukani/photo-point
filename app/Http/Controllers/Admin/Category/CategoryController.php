<?php /** @noinspection ALL */

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageHelperController;
use App\Libraries\Repositories\MainCategoryRepositoryEloquent;
use App\Models\MainCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryRepository;
    protected $moduleName = "category";
    protected $imageController;

    public function __construct(MainCategoryRepositoryEloquent $categoryRepository, ImageHelperController $imageController
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->imageController = $imageController;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    function list(Request $request)
    {
        $input = $request->all();

        $categries = $this->categoryRepository->getDetails($input);
        if ($categries['count'] == 0) {
            return $this->sendBadRequest(null, __("validation.common.details_not_found", ['module' => $this->moduleName]));
        }
        return $this->sendSuccessResponse($categries, __("validation.common.details_found", ['module' => $this->moduleName]));
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = MainCategory::validation($input);
        if ($validator->fails()) {
            return $this->sendBadRequest(null, $validator->errors()->first());
        }

        $category = $this->commonCreateUpdate($input);
        if (isset($category) && $category['flag'] == false) {
            return $this->sendBadRequest(null, $category['message']);
        }

        return $this->sendSuccessResponse($category['data'], $category['message']);
    }

    public function commonCreateUpdate($input, $id = null)
    {

        /**
         * Multiple Upload
         */
        if (isset($input['images']) && is_array($input['images']) && count($input['images']) > 0) {
            foreach ($input['images'] as $key => $image) {
                $data = $this->imageController->moveFile($image, 'categories');
                array_push($input['images'], $data['data']['image']);
                $imagesArray[] = $data['data']['image'];
            }
            $input['image'] = is_array($imagesArray) ? implode(',', $imagesArray) : $imagesArray;
        } else if (isset($input['image'])) {
            /**
             * Single Upload
             */
            $data = $this->imageController->moveFile($input['image'], 'categories');
            if (isset($data) && $data['flag'] == false) {
                return $this->makeError(null, $data['message']);
            }
            $input['image'] = $data['data']['image'];
        }

        $category = $this->categoryRepository->updateOrCreate(['id' => $id], $input);

        $category = $this->categoryRepository->getDetailsByInput([
            'id' => $category->id,
//            'relation' => ["category"],
            'first' => true,
        ]);

        if (isset($id)) {
            return $this->makeResponse($category, __("validation.common.updated", ['module' => $this->moduleName]));
        } else {
            return $this->makeResponse($category, __("validation.common.created", ['module' => $this->moduleName]));
        }
    }

    public function update(Request $request, $id)
    {
        $category = $this->categoryRepository->getDetailsByInput([
            'id' => $id,
            'first' => true,
        ]);

        if (!isset($category)) {
            return $this->sendBadRequest(null, __("validation.common.details_not_found", ["module" => $this->moduleName]));
        }

        $input = $request->all();

        $validator = MainCategory::validation($input, $id);
        if ($validator->fails()) {
            return $this->sendBadRequest(null, $validator->errors()->first());
        }

        $category = $this->commonCreateUpdate($input, $id);
        if ($category['flag'] == false) {
            return $this->sendBadRequest(null, $category['message']);
        }

        return $this->sendSuccessResponse($category['data'], $category['message']);
    }

    public function show($id)
    {
        $product = $this->categoryRepository->getDetailsByInput([

            'id' => $id,
             'first' => true,
        ]);

        if (!isset($product)) {
            return $this->sendBadRequest(null, __("validation.common.details_not_found", ['module' => $this->moduleName]));
        }

        return $this->sendSuccessResponse($product, __("validation.common.details_found", ["module" => $this->moduleName]));

     }


    public function statusChange(Request $request)
    {
        $input = $request->all();
        $validation = $this->requiredAllKeysValidation(['id', 'is_active'], $input);
        if (isset($validation) && $validation['flag'] == false) {
            return $this->sendBadRequest(null, $validation['message']);
        }

        $category = $this->categoryRepository->updateRich([
            'is_active' => $input['is_active'],
        ], $input['id']);

        return $this->sendSuccessResponse($category, __('validation.common.updated', ['module' => $this->moduleName]));
    }

    public function destory($id)
    {
        $category = $this->categoryRepository->delete($id);
        return $this->sendSuccessResponse($category, __('validation.common.deleted', ['module' => $this->moduleName]));
    }

    public function multipleDelete(Request $request)
    {
        $input = $request->all();
        $validation = $this->requiredAllKeysValidation(['ids'], $input);
        if (isset($validation) && $validation['flag'] == false) {
            return $this->sendBadRequest(null, $validation['message']);
        }
        $category = $this->categoryRepository->deleteWhereIn('id', $input['ids']);
        return $this->sendSuccessResponse($category, __('validation.common.deleted', ['module' => "product"]));
    }


}
