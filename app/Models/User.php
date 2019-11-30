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

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, Notifiable, DateConvertor;

    protected $table = "users";

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
            'mobile' => 'required',
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
        return Validator::make($input, User::rules($id), User::messages());
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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

    /**
     * country_detail => relation with user country
     *
     * @return void
     */
    public function country_detail()
    {
        return $this->hasOne(Countries::class, 'id', 'country_id');
    }

}
