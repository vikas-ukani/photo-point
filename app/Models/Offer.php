<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Offer extends Model
{
    protected $fillable = [
        "name", // name of offer
        "code", // uniue offer code
        "discount", // amount of values
        "valid_from", // offer starting from
        "valid_to", // offer starting to
        "description", // offer starting to
        "image", // offer starting to
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
            'description' => $once . 'required',
            'image' => $once . 'required',
            'is_active' => $once . 'required',
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

        static::retrieved(function ($value) {
            $value->is_active = $value->is_active == 1 ? true : false;
        });

        static::creating(function ($value) {
            $value->is_active = $value->is_active == true ? 1 : 0;
        });
        static::updating(function ($value) {
            $value->is_active = $value->is_active == true ? 1 : 0;
        });
        static::saving(function ($value) {
            $value->is_active = $value->is_active == true ? 1 : 0;
        });
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
     * getPhotoAttribute => append base url to image with unique
     *
     * @param  mixed $value
     *
     * @return void
     */
    public function getImageAttribute($value)
    {
        $this->attributes['image'] = env('APP_URL', url('/')) . $value;
        $arr = array_unique(explode(env('APP_URL', url('/')), $this->attributes['image']));
        return $this->attributes['image'] = implode(env('APP_URL', url('/')), $arr);
    }

    /**
     * category_detail => main category wise offer relation
     *
     * @return void
     */
    public function category_detail()
    {
        return $this->hasOne(MainCategory::class, 'id', 'category_id');
    }
}
