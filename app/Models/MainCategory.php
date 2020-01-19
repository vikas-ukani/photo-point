<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class MainCategory extends Model
{
    //
    protected $fillable = [
        "parent_id",
        "name",
        "code",
        'image',
        "is_active",
//        "is_child",
        "description"
    ];

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
            'name' => $once . 'required',
            'code' => $once . "required|unique:main_categories,code,{$id}",
            'image' => $once . "required",
            'is_active' => $once . 'required',
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

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::retrieved(function ($model) {
            $model->is_active = $model->is_active == 1 ? true : false;
//            $model->is_child = $model->is_child == 1 ? true : false;
        });

        static::creating(function ($model) {
            $model->is_active = $model->is_active == true ? 1 : 0;
//            $model->is_child = $model->is_child == true ? 1 : 0;
        });

        static::updating(function ($model) {
            $model->is_active = $model->is_active == true ? 1 : 0;
//            $model->is_child = $model->is_child == true ? 1 : 0;
        });
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
     * getPhotoAttribute => append base url to image with unique
     *
     * @param  mixed $value
     *
     * @return void|string
     */
    public function getImageAttribute($value)
    {
        $this->attributes['image'] = env('APP_URL', url('/')) . $value;
        $arr = array_unique(explode(env('APP_URL', url('/')), $this->attributes['image']));
        return $this->attributes['image'] = implode(env('APP_URL', url('/')), $arr);
    }

    public function attributes_detail()
    {
        return $this->hasOne(CommonProductAttributes::class, 'subcategory_id', 'id');
    }

    public function subcategory()
    {
            return $this->hasOne(MainCategory::class,'id', 'parent_id');
    }

    public function childcategory()
    {
        return $this->hasOne(MainCategory::class,'id', 'parent_id');
    }

}
