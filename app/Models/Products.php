<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Products extends Model
{
    //

    protected $fillable = [
        "category_id",
        "name",
        'image',
        "price",
        "size",
        "color",
        "description",
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
            'category_id' => $once . 'required',
            'name' => $once . 'required',
            'price' => $once . 'required',
            'image' => $once . "required",
            'size' => $once . 'required',
            'color' => $once . 'required',
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
     * setSizesAttribute => convert array to string
     *
     * @param  mixed $value
     *
     * @return void
     */
    public function setSizesAttribute($value)
    {
        if (isset($value) && is_array($value)) {
            $value = array_filter($value);
            $value = implode(',', $value);
        } else {
            $value = null;
        }
        $this->attributes['sizes'] = $value;
    }

    /**
     * getSizesAttribute  => convert string to array
     *
     * @param  mixed $value
     *
     * @return void
     */
    public function getSizesAttribute($value)
    {
        if (isset($value) && is_string($value)) {
            $value = explode(',', $value);
            $value = array_filter($value);
        } else {
            $value = null;
        }
        return $this->attributes['sizes'] = $value;
    }

    /**
     * getPhotoAttribute => append base url to image with unique
     *
     * @param  mixed $value
     *
     * @return void
     */
    public function getImageAttribute($value)
    {
        if (isset($value) && is_string($value)) {
            $value = explode(',', $value);
            $value = array_filter($value);
            foreach ($value as $key => &$val) {
                $val = env('APP_URL', url('/')) . $val;
                $arr = array_unique(explode(env('APP_URL', url('/')), $val));
                $val = implode(env('APP_URL', url('/')), $arr);
            }
            return $this->attributes['image'] = $value;
        } else {
            $this->attributes['image'] = env('APP_URL', url('/')) . $value;
            $arr = array_unique(explode(env('APP_URL', url('/')), $this->attributes['image']));
            return $this->attributes['image'] = implode(env('APP_URL', url('/')), $arr);
        }
    }

    public function category()
    {
        return $this->hasOne(MainCategory::class, 'id', 'category_id');
    }

    /** get product rate and review */
    public function customer_rating()
    {
        return $this->hasMany(OrderRateReview::class, 'product_id', 'id');
        // return $this->belongsToMany(OrderRateReview::class, Products::class, 'id', 'id');
    }
}
