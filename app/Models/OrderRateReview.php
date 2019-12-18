<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class OrderRateReview extends Model
{
    protected $fillable = [
        "order_id", // ordered id
        "product_id", // product id on review added
        "user_id", // which user add this rate and review
        'review', // customer review
        'rate', // customer rate number between 5
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

        $rules = [
            'order_id' => $once . 'required',
            'product_id' => $once . 'required',
            'user_id' => $once . 'required',
            'rate' => $once . 'required|numeric|between:1,5',
        ];

        return $rules;
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
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
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
        $className = __CLASS__;
        return Validator::make($input, $className::rules($id), $className::messages());
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

    public function user_detail()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function product_detail()
    {
        return $this->hasOne(Products::class, 'id', 'product_id');
    }

    public function customer_detail()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
