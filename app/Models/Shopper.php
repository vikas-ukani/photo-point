<?php

namespace App\Models;

use App\Supports\DateConvertor;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Shopper extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, Notifiable, DateConvertor;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', // user name
        'last_name', // user name
        'email', // user verified name
        'password', // user password
        'mobile', // user mobile
        'photo', // user profile pic
        'is_active', // user is active or not.
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'is_seller_requested' => 'boolean',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
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
            'first_name' => $once . 'required|max:100',
            'last_name' => $once . 'required|max:100',
            'email' => $once . "required|email|unique:users,email,{$id}",
            'password' => $once . 'required',
            'mobile' => "required|mobile|unique:users,mobile,{$id}"
        ];
        return $rules;
    }


    /**
     * setNameAttribute => tittle case
     *
     * @param  mixed $value
     *
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * setEmailAttribute => convert email to lower always
     *
     * @param  mixed $value
     *
     * @return void
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }


    /**
     * getPhotoAttribute => append base url to image with unique
     *
     * @param  mixed $value
     *
     * @return void
     */
    public function getPhotoAttribute($value)
    {
        $this->attributes['photo'] = env('APP_URL', url('/')) . $value;
        $arr = array_unique(explode(env('APP_URL', url('/')), $this->attributes['photo']));
        return $this->attributes['photo'] = implode(env('APP_URL', url('/')), $arr);
    }

    protected static function boot()
    {
        parent::boot();

        static::retrieved(function ($query) {
            $query->is_active = $query->is_active == 1 ? true : false;
        });

        static::creating(function ($query) {
            $query->is_active = isset($query->is_active) ? $query->is_active : 1;
        });
    }



    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
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
}
