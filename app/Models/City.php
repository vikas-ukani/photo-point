<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class City extends Model
{
    protected $fillable = [
        "name",
        "state_id",
        "code",
        "is_active",
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
            'name' => $once . 'required',
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
}
