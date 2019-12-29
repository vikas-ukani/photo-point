<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class FeatureProducts extends Model
{
    protected $fillable = [
        "product_id",
    ];

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
     * rules => set Validation Rules
     *
     * @param  mixed $id
     *
     * @return array
     */
    public static function rules($id)
    {
        $once = isset($id) ? 'sometimes|' : '';

        return [
            'product_id' => $once . 'required',

        ];

    }

    /**
     * messages => Set Error Message
     *
     * @return array
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
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function validation($input, $id = null)
    {
        $className = __CLASS__;
        return Validator::make($input, $className::rules($id), $className::messages());
    }



    /** get product details */
    public function product_details()
    {
        return $this->hasMany(Products::class, 'id', 'product_id');
        // return $this->belongsToMany(OrderRateReview::class, Products::class, 'id', 'id');
    }

    public function product_detail()
    {
        return $this->hasOne(Products::class, 'id', 'product_id');
    }
}
