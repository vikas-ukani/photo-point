<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class FavoriteProducts extends Model
{
    /** @var array  */
    protected $fillable = [
        "user_id",
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
            'user_id' => $once . 'required',
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
            'product_id.required' => "Please, select any product to favorite.",
        ];
    }

    /**
     * @param $input
     * @param null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function validation($input, $id = null)
    {
        $className = __CLASS__;
        return Validator::make($input, $className::rules($id), $className::messages());
    }

    public function user_detail()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }

    public function product_detail()
    {
        return $this->hasOne(Products::class, 'id', 'product_id');
    }
}
