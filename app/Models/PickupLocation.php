<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PickupLocation extends Model
{

    protected $fillable = [
        "user_id",
        "pickup_location",
        "name",
        "email",
        "phone",
        "address",
        "address_2",
        "city",
        "state",
        "country",
        "pin_code",
        "is_active",
    ];
    // protected $dateFormat = 'U';

    protected $dates = [
        'updated_at',
    ];

    protected $casts = [
        'is_active'  =>  'boolean',
        // 'qty'       =>  'integer'
    ];

    /**
     * rules => set Validation Rules
     *
     * @param  mixed $id
     *
     * @return void
     */
    public static function rules($id)
    {
        $once = isset($id) ? 'sometimes|' : '';

        return [
            // 'user_id' => $once . 'required',
            'pickup_location' => $once . 'required|max:8',
            'name' => $once . 'required',
            'email' => $once . 'required',
            'phone' => $once . 'required',
            'address' => $once . 'required|max:80',
            // 'address_2' => $once . 'required',
            'city' => $once . 'required',
            'state' => $once . 'required',
            'country' => $once . 'required',
            'pin_code' => $once . 'required|numeric',
        ];
    }

    /**
     * messages => Set Error Message
     *
     * @return void
     */
    public static function messages()
    {
        /** set error message in trans files */
        return [
            'required' => __('validation.required'),
        ];
    }

    /**
     * validation => **
     *
     *
     * @param  mixed $input
     * @param  mixed $id
     *
     * @return void
     */
    public static function validation($input, $id = null)
    {
        return Validator::make($input, self::rules($id), self::messages());
    }

    /**
     * scopeOrdered => default sorting on created at as ascending
     *
     * @param  mixed $query
     *
     * @return void
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::retrieved(function ($model) {
            // $model->is_active = $model->is_active == 1 ? true : false;
        });

        static::creating(function ($model) {
            // $model->is_active = $model->is_active == true ? 1 : 0;
            $model->user_id = $model->user_id  ?? Auth::id();
        });

        static::updating(function ($model) {
            // $model->is_active = $model->is_active === true ? 1  :  0;
            // $model->is_active = $model->is_active == true ? 1 : 0;
            $model->user_id = $model->user_id ?? Auth::id();
        });
    }
}
