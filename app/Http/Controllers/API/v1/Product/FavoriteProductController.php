<?php

namespace App\Http\Controllers\API\v1\Product;

use App\Libraries\Repositories\FavoriteProductRepositoryEloquent;
use App\Libraries\Repositories\UsersRepositoryEloquent;
use App\Models\FavoriteProducts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;

class FavoriteProductController extends Controller
{

    protected $favoriteProductRepository;
    protected $moduleName = "Favorite Product";

    public function __construct(FavoriteProductRepositoryEloquent $favoriteProductRepository)
    {
        $this->favoriteProductRepository = $favoriteProductRepository;
    }

    public function favoriteUnfavoriteProduct(Request $request)
    {
        $input = $request->all();

        /** get user id from token */
        $input['user_id'] = \Auth::id();

        /** make require validation from input */
        $validation = $this->requiredAllKeysValidation(['product_id', 'user_id', 'is_favorite'], $input);
        if (isset($validation) && $validation['flag'] == false) {
            return $this->sendBadRequest(null, $validation['message']);
        }

        if (isset($input) && $input['is_favorite'] == true) {
            /** favorite */
            try {
                $favoriteProduct = $this->commonCreateUpdateFn($input);
            } catch (\Exception $e) {
                return $this->sendBadRequest(null, $e->getCode() . ' - ' . $e->getMessage());
            }

            if (isset($favoriteProduct) && $favoriteProduct['flag'] == false) return $this->sendBadRequest($favoriteProduct['data'], $favoriteProduct['mesasge']);
            return $this->sendSuccessResponse($favoriteProduct['data'], $favoriteProduct['message']);

        } else {
            /** delete record */
            $this->favoriteProductRepository->deleteWhere([
                'user_id' => $input['user_id'],
                'product_id' => $input['product_id']
            ]);
            return $this->sendSuccessResponse(null, __('validation.common.successfully_unfollowed'));
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $favoriteProduct = $this->commonCreateUpdateFn($input);

        if (isset($favoriteProduct) && $favoriteProduct['flag'] == false) return $this->sendBadRequest($favoriteProduct['data'], $favoriteProduct['message']);

        return $this->sendSuccessResponse($favoriteProduct, $favoriteProduct['message']);

    }

    /** create common create and update favorite product
     * @param null $input
     * @param null $id
     * @return array
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function commonCreateUpdateFn($input = null, $id = null)
    {

        /** get user id from token */
        $input['user_id'] = \Auth::id();

        $validation = FavoriteProducts::validation($input);
        if (isset($validation) && $validation->errors()->count() > 0) return $this->makeError(null, $validation->errors()->first());


        /** check already exist or not */
        $requestForFavorite = [
            'user_id' => $input['user_id'],
            'product_id' => $input['product_id'],
            'first' => true
        ];

        if (isset($id)) $requestForFavorite['id'] = $id;

        $alreadyFavoriteProduct = $this->favoriteProductRepository->getDetailsByInput(
            $requestForFavorite
        );

        if (!!!isset($alreadyFavoriteProduct)) {
            $alreadyFavoriteProduct = $this->favoriteProductRepository->create($input);
        } else {

            $alreadyFavoriteProduct->user_id = $input['user_id'];
            $alreadyFavoriteProduct->product_id = $input['product_id'];
            $alreadyFavoriteProduct->save();
        }

        if (isset($id)) return $this->makeResponse($alreadyFavoriteProduct, __('validation.common.successfully_followed'));
        else return $this->makeResponse($alreadyFavoriteProduct, __('validation.common.successfully_followed'));

    }


    public function list(Request $request)
    {
        $input = $request->all();


        $input['user_id'] = isset($input['user_id']) ? $input['user_id'] : \Auth::id();

         try {
            $favoriteProduct = $this->favoriteProductRepository->getDetails($input);
        } catch (\Exception $exception) {
            $message = $exception->getCode() . ' - ' . $exception->getMessage();
            \Log::error($exception->getCode() . ' - ' . $exception->getMessage());
            return $this->sendBadRequest(null, $exception->getCode() . ' - ' . $exception->getMessage());
        }
        if (isset($favoriteProduct) && $favoriteProduct['count'] == 0) return $this->sendBadRequest(null, __('validation.common.details_not_found', ['module' => $this->moduleName]));

        return $this->sendSuccessResponse($favoriteProduct, __('validation.common.details_found', ['module' => $this->moduleName]));
    }


}
