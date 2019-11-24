<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

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
        'is_active', // active deactivate user  default true
        'email_verified_at', // date when user verify that email  // default null
        'last_login_at', // set last login date time in utc date
        'country_id', // country id
        'state_id', // state id
        'city_id', // city id
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
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
            'name' => $once . 'required|max:100',
            'email' => $once . "required|email|unique:users,email,{$id}",
            'password' => $once . 'required',
            'mobile' => 'required',
            // 'phone' => $once . 'required|digits_between:10,11',
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

    /**
     * setPasswordAttribute => tittle case
     *
     * @param  mixed $value
     *
     * @return void
     */
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
     * getEmailVerifiedAtAttribute => for verifying email
     *
     * @param  mixed $value
     *
     * @return void
     */
    // public function getEmailVerifiedAtAttribute($value)
    // {
    //     return $this->attributes[ 'email_verified_at'] = $value ?? NULL;
    // }
    // public function getMobileVerifiedAtAttribute($value)
    // {
    //     return $this->attributes[ 'mobile_verified_at'] = $value ?? NULL;
    // }

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
