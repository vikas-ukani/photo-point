<?php

namespace App\Libraries\Repositories;

use App\Libraries\RepositoriesInterfaces\UsersRepository;
use App\Models\Order;
use App\Supports\BaseMainRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class OrderRepositoryEloquent extends BaseRepository implements UsersRepository
{
    use BaseMainRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Order::class;
    }

    /**
     * boot => Boot up the repository, pushing criteria
     *
     * @return void
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * commonFilterFn => make common filter for list and getDetailsByInput
     *
     * @param  mixed $value
     * @param  mixed $input
     *
     * @return void
     */
    protected function commonFilterFn(&$value, $input)
    {
        /** searching */
        if (isset($input['search'])) {
            $value = $this->customSearch($value, $input, ['customer_name', 'user_id', 'status']);
        }

        $this->customRelation($value, $input, []); //'account_detail'

        /** filter by id  */
        if (isset($input['id'])) {
            $value = $value->where('id', $input['id']);
        }
        if (isset($input['ids']) && is_array($input['ids']) && count($input['ids'])) {
            $value = $value->whereIn('id', $input['ids']);
        }

        /** filter by id  */
        if (isset($input['user_id'])) {
            $value = $value->where('user_id', $input['user_id']);
        }
        if (isset($input['user_ids']) && is_array($input['user_ids']) && count($input['user_ids'])) {
            $value = $value->whereIn('user_id', $input['user_ids']);
        }

        /** product_id and product_ids wise filter */
        if (isset($input['product_id'])) {
            $value = $value->where('product_id', $input['product_id']);
        }
        if (isset($input['product_ids']) && count($input['product_ids']) > 0) {
            $value = $value->whereIn('product_id', $input['product_ids']);
        }

        /** delevery_address_id and delevery_address_ids wise filter */
        if (isset($input['delevery_address_id'])) {
            $value = $value->where('delevery_address_id', $input['delevery_address_id']);
        }
        if (isset($input['delevery_address_ids']) && count($input['delevery_address_ids']) > 0) {
            $value = $value->whereIn('delevery_address_id', $input['delevery_address_ids']);
        }

        if (isset($input['customer_name'])) {
            $value = $value->where('customer_name', $input['customer_name']);
        }

        if (isset($input['status'])) {
            $value = $value->where('status', $input['status']);
        }

        if (isset($input['is_active'])) {
            $value = $value->where('is_active', $input['is_active']);
        }

        if (isset($input['start_order_date'])) {
            $value = $value->where('order_date', ">=", $input['start_order_date']);
        }
        if (isset($input['end_order_date'])) {
            $value = $value->where('order_date', "<=", $input['end_order_date']);
        }

        /** date wise records */
        if (isset($input['start_date'])) {
            $value = $value->where('created_at', ">=", $input['start_date']);
        }

        /** check for user active or not */
        if (isset($input['is_active'])) {
            $value = $value->where('is_active', $input['is_active']);
        }

        /** check if false then don't show current user in listing */
        if (isset($input['is_current_user']) && $input['is_current_user'] == false) {
            $value = $value->where('id', '<>', \Auth::id());
        }

        if (isset($input['facebook'])) {
            $value = $value->where('facebook', $input['facebook']);
        }

        /** country_id and country_ids wise filter */
        if (isset($input['country_id'])) {
            $value = $value->where('country_id', $input['country_id']);
        }
        if (isset($input['country_ids']) && is_array($input['country_ids']) && count($input['country_ids'])) {
            $value = $value->whereIn('country_id', $input['country_ids']);
        }

        if (isset($input['latitude'])) {
            $value = $value->where('latitude', $input['latitude']);
        }
        if (isset($input['longitude'])) {
            $value = $value->where('longitude', $input['longitude']);
        }

        if (isset($input['is_snooze'])) {
            $value = $value->where('is_snooze', $input['is_snooze']);
        }

        /** check for user complete their profile or not */
        if (isset($input['is_profile_complete'])) {
            $value = $value->where('is_profile_complete', $input['is_profile_complete']);
        }
    }

    /**
     * getCommonPaginationFilterFn => get pagination and get data
     *
     * @param  mixed $value
     * @param  mixed $input
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
     * getDetails => get details for listing
     *
     * @param  mixed $input
     *
     * @return void
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
     * updateRich => update some keys
     *
     * @param  mixed $input => updated input
     * @param  mixed $id => update id record
     *
     * @return void
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

    /**
     * getDetailsByInput => get details by input
     *
     * @param  mixed $input
     *
     * @return void
     */
    public function getDetailsByInput($input = null)
    {
        $value = $this->makeModel();

        $this->commonFilterFn($value, $input);

        $this->getCommonPaginationFilterFn($value, $input);

        return $value;
    }

    /**
     * checkKeysExist => Check key exists in db or not - RESPONSE BOOLEAN
     *
     * @param  mixed $key
     * @param  mixed $input
     *
     * @return void
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

    /**
     * getRecords => get records by input
     *
     * @param  mixed $input
     *
     * @return void
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

    /**
     * checkEmailExists => check for email is exists or not
     *
     * @param  mixed $input
     *
     * @return void
     */
    public function checkEmailExists($input = null)
    {
        $value = $this->makeModel();
        $value = $value->whereEmail($input['email']);
        $value = $value->first();
        return $value;
    }

    /**
     * checkEmailRecordDeleted => check records for is deleted or not
     *
     * @param  mixed $input
     *
     * @return void
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
