<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class ProductStockInventory extends Model
{
    public $className = __CLASS__;

    protected $fillable = [
        'product_id',
        "common_product_attribute_size_id",
        "common_product_attribute_color_id",
        "images",
        "sale_price",
        "mrp_price",
        "stock_available",
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
//            'product_id' => $once . 'required',
            'common_product_attribute_size_id' => $once . 'required',
            'common_product_attribute_color_id' => $once . 'required',
            'sale_price' => $once . 'required',
            'mrp_price' => $once . 'required',
            'stock_available' => $once . 'required',
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

    public static function convertStringToArray($string)
    {
        if (isset($string) && is_string($string)) {
            $string = explode(',', $string);
            $string = array_filter($string);
        } else {
            $string = null;
        }
        return $string;
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

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        /*static::retrieved(function ($model) {
            $model->values = static::convertStringToArray($model->values);
        });
        static::creating(function ($model) {
            $model->values = static::convertArrayToString($model->values);
        });
        static::updating(function ($model) {
            $model->values = static::convertArrayToString($model->values);
        });*/
    }


    public function getImagesAttribute($value)
    {
        if (isset($value) && is_string($value)) {
            $value = explode(',', $value);
            $value = array_filter($value);
            foreach ($value as $key => &$val) {
                $val = env('APP_URL', url('/')) . $val;
                $arr = array_unique(explode(env('APP_URL', url('/')), $val));
                $val = implode(env('APP_URL', url('/')), $arr);
            }
            return $this->attributes['images'] = $value;
        } else if (isset($value) && is_array($value)) {
            return $this->attributes['images'] = $value;
        } else {
            $this->attributes['images'] = env('APP_URL', url('/')) . $value;
            $arr = array_unique(explode(env('APP_URL', url('/')), $this->attributes['image']));
            return $this->attributes['images'] = implode(env('APP_URL', url('/')), $arr);
        }
    }

    public function setImagesAttribute($value)
    {
        if (isset($value) && is_array($value)) {
            $value = array_filter($value);
            $value = implode(',', $value);
        } else {
            $value = null;
        }
        $this->attributes['images'] = $value;
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

    public function product_detail()
    {
        return $this->hasOne(Products::class, 'id', 'product_id');
    }

    public function common_product_attribute_detail()
    {
        return $this->hasMany(CommonProductAttributes::class, 'id', 'common_product_attribute_id');
    }

    public function common_product_attribute_size_detail()
    {
        return $this->hasOne(CommonProductAttributes::class, 'id', 'common_product_attribute_size_id');
    }

    public function common_product_attribute_color_detail()
    {
        return $this->hasOne(CommonProductAttributes::class, 'id', 'common_product_attribute_size_id');
    }

}
