<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureProducts extends Model
{
    protected $fillable = [
        "product_id",
    ];


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

    /** get product details */
    public function product_details()
    {
        return $this->hasMany(Products::class, 'id', 'product_id');
        // return $this->belongsToMany(OrderRateReview::class, Products::class, 'id', 'id');
    }
}
