<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class OfferApplied extends Model
{

    protected $fillable = [
        "name", // name of offer
        "code", // uniue offer code
        "discount", // amount of values
        "valid_from", // offer starting from
        "valid_to", // offer starting to
        "category_id", // offer apply of this category 
        'is_active', // offer active or not
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_admin' => 'boolean',
        'discount' => 'integer',
        'valid_from' => 'datetime',
        'valid_to' => 'datetime',
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
            'code' => $once . "required|unique:offers,code,{$id}",
            'discount' => $once . 'required|numeric',
            'valid_from' => $once . 'required|date',
            'valid_to' => $once . 'required|date',
            'category_id' => $once . 'required|numeric',
            'is_active' => $once . 'required|boolean',
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
}
