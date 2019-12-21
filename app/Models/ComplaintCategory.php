<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class ComplaintCategory extends Model
{
    protected $fillable = [
        "name", // Main title name
        "code", // code for unique
        "sequence", // for dropdown sequence
        'is_active', // active or not
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'sequence' => 'integer',
        'is_active' => 'boolean',
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
            'code' => $once . 'required|unique:complaint_categories,code,' . $id,
            'is_active' => $once . 'required|boolean'
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
        static::creating(function ($value) {
            // $value->user_id = \Auth::id();
        });
        static::updating(function ($value) {
            // $value->user_id = \Auth::id();
        });
        static::saving(function ($value) {
            // $value->user_id = \Auth::id();
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

    public function order_detail()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
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
