<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Order extends Model
{
    protected $fillable = [
        "customer_name",
        "user_id",
        'product_id',
        'delevery_address_id', // customer delevery address id
        "address_detail", // store as json data
        'product_details', // single or multiple product details store  at one time only,.
        "status", // default set to pending use constant here
        "quantity", // order quantity
        "total_amount", // order total amounts
        "order_date", // order date
        "expected_date", // add days plus from product add time

        'transaction_id', // transaction id from order
        'transaction_type', // transaction TYPE from order

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
            // 'quantity' => 'required',
            'transaction_id' => 'required',
            'user_id' => 'required',
            // 'customer_name' => $once . 'required',
            'address_detail' => $once . 'required',
            // 'product_details' => $once . 'required',
            'total_amount' => $once . 'required',
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
            /** get to array address */
            $value->address_detail = self::getAddressDetail($value->address_detail);

            /** get to product_details */
            $value->product_details = self::getProductDetail($value->product_details);
        });

        /** before creating */
        static::creating(function ($value) {
            $className = __CLASS__;

            /** set to default order status here */
            $value->status = ORDER_STATUS_PENDING;
            $value->user_id = Auth::id();

            /** store json string address */
            $value->address_detail = $className::setAddressDetail($value->address_detail);

            /** store json string product */
            $value->product_details = $className::setProductDetail($value->product_details);
            // $value->is_active = $value->is_active == true ? 1 : 0;
        });

        static::created(function ($value) {
            $className = __CLASS__;
            /** get to array address */
            $value->address_detail = self::getAddressDetail($value->address_detail);
            /** get to product_details */
            $value->product_details = self::getProductDetail($value->product_details);
        });

        /** before updating */
        static::updating(function ($value) {
            $className = __CLASS__;
            /** store json string address */
            $value->address_detail = self::setAddressDetail($value->address_detail);
            /** update json string product */
            $value->product_details = self::setProductDetail($value->product_details);
        });
    }

    public static function setProductDetail($value)
    {
        // if (isset($value) && is_array($value)) {
        //     $value = array_filter($value);
        //     $value = implode(',', $value);
        // } else {
        //     $value = null;
        // }
        $value = json_encode($value);
        return $value;
    }


    /** get and set Product details */
    public static function getProductDetail($value)
    {
        $value = json_decode($value, true);
        // if (isset($value['stock_inventory_id'])) {
        //     $value['stock_inventory'] = ProductStockInventory::where('id', $value['stock_inventory_id'])->first();
        // }
        return $value;
        // if (isset($value) && is_string($value)) {
        //     $value = explode(',', $value);
        //     $value = array_filter($value);
        // } else {
        //     $value = null;
        // }
        // return $value;
    }


    /** get and set address details */
    public static function getAddressDetail($value)
    {
        // if (isset($value) && is_string($value)) {
        //     $value = explode(',', $value);
        //     $value = array_filter($value);
        // } else {
        //     $value = null;
        // }
        $value = json_decode($value);
        return $value;
    }
    public static function setAddressDetail($value)
    {
        // if (isset($value) && is_array($value)) {
        //     $value = array_filter($value);
        //     $value = implode(',', $value);
        // } else {
        //     $value = null;
        // }
        $value = json_encode($value);
        return $value;
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
        return Validator::make($input, self::rules($id), self::messages());
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
     * setSizesAttribute => convert array to string
     *
     * @param  mixed $value
     *
     * @return void
     */
    // public function setSizesAttribute($value)
    // {
    //     if (isset($value) && is_array($value)) {
    //         $value = array_filter($value);
    //         $value = implode(',', $value);
    //     } else {
    //         $value = null;
    //     }
    //     $this->attributes['sizes'] = $value;
    // }

    /**
     * getSizesAttribute  => convert string to array
     *
     * @param  mixed $value
     *
     * @return void
     */
    // public function getSizesAttribute($value)
    // {
    //     if (isset($value) && is_string($value)) {
    //         $value = explode(',', $value);
    //         $value = array_filter($value);
    //     } else {
    //         $value = null;
    //     }
    //     return $this->attributes['sizes'] = $value;
    // }

    /**
     * getPhotoAttribute => append base url to image with unique
     *
     * @param  mixed $value
     *
     * @return void
     */
    // public function getImageAttribute($value)
    // {
    //     $this->attributes['image'] = env('APP_URL', url('/')) . $value;
    //     $arr = array_unique(explode(env('APP_URL', url('/')), $this->attributes['image']));
    //     return $this->attributes['image'] = implode(env('APP_URL', url('/')), $arr);
    // }

    public function user_detail()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function product()
    {
        return $this->hasOne(Products::class, 'id', 'product_id');
    }

    public function delevery_address()
    {
        return $this->hasOne(UserDeleveryAddress::class, 'id', 'delevery_address_id');
    }
}
