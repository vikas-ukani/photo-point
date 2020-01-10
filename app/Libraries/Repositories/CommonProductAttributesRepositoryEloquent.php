<?php

/** @noinspection ALL */

namespace App\Libraries\Repositories;

use App\Libraries\RepositoriesInterfaces\UsersRepository;
use App\Models\CommonProductAttributes;
use App\Supports\BaseMainRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class CommonProductAttributesRepositoryEloquent extends BaseRepository implements UsersRepository
{
    use BaseMainRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CommonProductAttributes::class;
    }

    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
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

    /**
     * commonFilterFn => make common filter for list and getDetailsByInput
     *
     * @param mixed $value
     * @param mixed $input
     *
     * @return void
     */
    protected function commonFilterFn(&$value, $input)
    {
        /** searching */
        if (isset($input['search'])) {
            $value = $this->customSearch($value, $input, ['name', 'code', 'price', 'description', 'size']);
        }

        $this->customRelation($value, $input, []); //'account_detail'

        /** filter by id and ids  */
        if (isset($input['id'])) {
            $value = $value->where('id', $input['id']);
        }
        if (isset($input['ids']) && is_array($input['ids']) && count($input['ids'])) {
            $value = $value->whereIn('id', $input['ids']);
        }

        /** filter by subcategory_id and subcategory_ids  */
        if (isset($input['subcategory_id'])) {
            $value = $value->where('subcategory_ids', $input['subcategory_id']);
        }
        if (isset($input['subcategory_ids']) && is_array($input['subcategory_ids']) && count($input['subcategory_ids'])) {
            $value = $value->whereRaw("FIND_IN_SET(" . $input['subcategory_ids'] . ",Tags)");
        }

        if (isset($input['parent_id'])) {
            $value = $value->where('parent_id', $input['parent_id']);
        }
        //        parent_id
        if (isset($input['parent_ids']) && is_array($input['parent_ids']) && count($input['parent_ids'])) {
            $value = $value->whereIN('parent_id', $input['parent_ids']);
        }
        if (isset($input['is_parent']) && $input['is_parent'] == true) {
            $value = $value->whereNull('parent_id');
        }

        if (isset($input['name'])) {
            $value = $value->where('name', $input['name']);
        }
        if (isset($input['code'])) {
            $value = $value->where('code', $input['code']);
        }

        if (isset($input['is_active'])) {
            $value = $value->where('is_active', $input['is_active']);
        }

        /** date wise records */
        if (isset($input['start_date'])) {
            $value = $value->where('created_at', ">=", $input['start_date']);
        }
    }

    /**
     * getCommonPaginationFilterFn => get pagination and get data
     *
     * @param mixed $value
     * @param mixed $input
     *
     * @return void
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

    /**
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

    /** check for email is exists or not
     * @param null $input
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function checkEmailExists($input = null)
    {
        $value = $this->makeModel();
        $value = $value->whereEmail($input['email']);
        $value = $value->first();
        return $value;
    }

    /** check records for is deleted or not
     * @param null $input
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function checkEmailRecordDeleted($input = null)
    {
        $value = $this->makeModel();
        $value = $value->whereEmail($input['email']);
        $value = $value->withTrashed()->first();
        return $value;
    }

    /**
     * getUserCountByType => get user  count by their types
     *
     * @return void
     */
    public function getUserCountByType()
    {
        $value = $this->makeModel();

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
