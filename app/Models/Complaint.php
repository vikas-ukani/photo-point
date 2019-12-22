<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Complaint extends Model
{
    protected $fillable = [
        "subject", // subject of complaint
        "description", // description of complaint
        "complain_category_id", // complain category id
        "order_id", // order id wise complaint
        "user_id", // user id wise complaint
        'images', // complaint's images
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'order_id' => 'integer',
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
            'subject' => $once . 'required',
            'description' => $once . 'required',
            'complain_category_id' => $once . 'required',
            'order_id' => $once . 'requiredZ|integer',
            'images' => $once . 'required|array',
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
            $value->user_id = \Auth::id();
        });

        static::updating(function ($value) {
            $value->user_id = \Auth::id();
        });

        static::saving(function ($value) {
            $value->user_id = \Auth::id();
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
        } else {
            $this->attributes['images'] = env('APP_URL', url('/')) . $value;
            $arr = array_unique(explode(env('APP_URL', url('/')), $this->attributes['images']));
            return $this->attributes['images'] = implode(env('APP_URL', url('/')), $arr);
        }
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
        return $this->hasOne(ComplaintCategory::class, 'id', 'complain_category_id');
    }
}
