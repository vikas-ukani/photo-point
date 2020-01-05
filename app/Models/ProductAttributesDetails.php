<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class ProductAttributesDetails extends Model
{

    public $className = __CLASS__;

    protected $fillable = [
        'product_id',
        "common_product_attribute_id",
        "value",
        "values",
        // 'is_active',
        // "sequence",
    ];

    /**
     * rules => set Validation Rules
     *
     * @param mixed $id
     *
     * @return array
     */
    public static function rules($id)
    {
        $once = isset($id) ? 'sometimes|' : '';

        return [
            'subcategory_id' => $once . 'required',
            'parent_id' => $once . 'required',
            'name' => $once . 'required',
            'is_active' => $once . 'required',
            'sequence' => $once . 'required',
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
     * @param mixed $input
     * @param mixed $id
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function validation($input, $id = null)
    {
        $className = __CLASS__;
        return Validator::make($input, $className::rules($id), $className::messages());
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
            $model->values = static::convertStringToArray($model->values);
        });
        static::creating(function ($model) {
            $model->values = static::convertArrayToString($model->values);
            // $model->is_active = $model->is_active == true ? 1 : 0;
        });
        static::updating(function ($model) {
            $model->values = static::convertArrayToString($model->values);

            // $model->is_active = $model->is_active == true ? 1 : 0;
        });
    }

    public static function convertArrayToString($arrayData = [])
    {
        if (isset($arrayData) && is_array($arrayData) && count($arrayData) > 0) {
            $arrayData = array_filter($arrayData);
            $arrayData = implode(',', $arrayData);
        } else {
            $arrayData = null;
        }
        return $arrayData;
    }
    public static function convertStringToArray($string)
    {
        // # code...
        if (isset($string) && is_string($string)) {
            $string = explode(',', $string);
            $string = array_filter($string);
        } else {
            $string = null;
        }
        return $string;
    }

    /**
     * scopeOrdered => default sorting on created at as ascending
     *
     * @param mixed $query
     *
     * @return void
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function common_product_attribute_detail()
    {
        return $this->hasMany(CommonProductAttributes::class, 'id', 'common_product_attribute_id');
    }
}
