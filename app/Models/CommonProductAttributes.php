<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class CommonProductAttributes extends Model
{
    protected $fillable = [
        'subcategory_ids',
        "parent_id",
        "name",
        "code",
        'is_active',
        "sequence",
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
            'subcategory_ids' => $once . 'required',
            'parent_id' => $once . 'required',
            'name' => $once . 'required',
            'code' => $once . 'required|unique:common_product_attributes,code,{$id}',
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
            $model->is_active = $model->is_active == 1 ? true : false;
        });
        static::creating(function ($model) {
            $model->is_active = $model->is_active == true ? 1 : 0;
        });
        static::updating(function ($model) {
            $model->is_active = $model->is_active == true ? 1 : 0;
        });
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

    /** get parent details */
    public function parent_detail()
    {
        return $this->hasOne(CommonProductAttributes::class, 'id', 'parent_id');
    }

    public function subcategory_details()
    {
        //        dd("Input", $this->hasMany(CommonProductAttributes::class, 'parent_id', 'id'));
        return $this->hasMany(CommonProductAttributes::class, 'parent_id', 'id');
        //            ->where('subcategory_ids', '=', 1);
        //        ->whereRaw("FIND_IN_SET(" . $input['subcategory_ids'] . ",Tags)");
    }
}
