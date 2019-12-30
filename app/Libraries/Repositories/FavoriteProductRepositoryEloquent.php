<?php

namespace App\Libraries\Repositories;

use App\Libraries\RepositoriesInterfaces\UsersRepository;
use App\Models\FavoriteProducts;
use App\Supports\BaseMainRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class FavoriteProductRepositoryEloquent extends BaseRepository implements UsersRepository
{
    use BaseMainRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FavoriteProducts::class;
    }

    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /** Make common filter for list and getDetailsByInput
     * @param $value
     * @param $input
     */
    protected function commonFilterFn(&$value, $input)
    {
         if (isset($input['search'])) {
            $value = $this->customSearch($value, $input, ['product_id']);
        }

        $this->customRelation($value, $input, []); //'account_detail'
        /** filter by id  */
        if (isset($input['id'])) {
            $value = $value->where('id', $input['id']);
        }
        if (isset($input['ids']) && is_array($input['ids']) && count($input['ids'])) {
            $value = $value->whereIn('id', $input['ids']);
        }

        /** user_id and user_ids wise filter */
        if (isset($input['user_id'])) {
            $value = $value->where('user_id', $input['user_id']);
        }
        if (isset($input['user_ids']) && count($input['user_ids']) > 0) {
            $value = $value->whereIn('user_id', $input['user_ids']);
        }

        /** product_id and product_ids wise filter */
        if (isset($input['product_id'])) {
            $value = $value->where('product_id', $input['product_id']);
        }
        if (isset($input['product_ids']) && count($input['product_ids']) > 0) {
            $value = $value->whereIn('product_id', $input['product_ids']);
        }

        /** date wise records */
        if (isset($input['start_date'])) {
            $value = $value->where('created_at', ">=", $input['start_date']);
        }
    }

    /** get pagination and get data
     * @param $value
     * @param $input
     */
    protected function getCommonPaginationFilterFn(&$value, $input)
    {
        if (isset($input['list'])) {
            $value = $value->select($input['list']);
        }

        if (isset($input['page']) && isset($input['limit'])) {
            $value = $this->customPaginate($value, $input);
        }

        if (isset($input['sort_by']) && count($input['sort_by']) > 0) {
            $value = $value->orderBy($input['sort_by'][0], $input['sort_by'][1]);
        } else {
            $value = $value->ordered();
        }

         if (isset($input['first']) && $input['first'] == true) {
            $value = $value->first();
        } elseif (isset($input['is_deleted']) && $input['is_deleted'] == true) {
            $value = $value->withTrashed()->get();
        } else {
            $value = $value->get();
        }
    }

    /** get details for listing
     * @param null $input
     * @return array
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function getDetails($input = null)
    {
        $value = $this->makeModel();
        $this->commonFilterFn($value, $input);
        $count = $value->count();
        $this->getCommonPaginationFilterFn($value, $input);

        return [
            'count' => $count,
            'list' => $value,
        ];
    }

    /** update some keys
     * @param $input
     * @param $id
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function updateRich($input, $id)
    {
        $value = $this->makeModel();
        $value = $value->whereId($id)->first();

        // $value->fill($input)->update();
        if (isset($value)) {
            $value->fill($input)->update();
            return $value->fresh();
        }
    }

    /** get details by input
     * @param null $input
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function getDetailsByInput($input = null)
    {
        $value = $this->makeModel();

        $this->commonFilterFn($value, $input);

        $this->getCommonPaginationFilterFn($value, $input);

        return $value;
    }

    /** Check key exists in db or not - RESPONSE BOOLEAN
     * @param $key
     * @param $input
     * @return bool
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function checkKeysExist($key, $input)
    {
        $value = $this->makeModel();

        $value = $value->where($key, $input[$key]);
        if ($value->first()) {
            return true;
        } else {
            return false;
        }
    }

    /** get records by input
     * @param $input
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function getRecords($input)
    {
        $value = $this->makeModel();

        if (isset($input['email'])) {
            $value = $value->whereEmail($input['email']);
        }

        if (isset($input['first'])) {
            $value = $value->first();
        } else {
            $value = $value->get();
        }
        return $value;
    }

    public function updateManyByWhere($input, $where)
    {
        $value = $this->makeModel();
        $value = $value->where(array_first(array_keys($where)), array_first(array_values($where)));
        // $value = $value->where('user_id', $where['user_id']);
        $value = $value->update($input);
        return $value;

        /** for return updated object */
        // $value->fill($input)->update();
        return $value->fresh();
    }

    public function deleteWhereIn($key, $array)
    {
        $value = $this->makeModel();
        return $value->whereIn($key, $array)->delete();
    }
}
