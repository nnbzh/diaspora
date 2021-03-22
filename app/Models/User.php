<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

use App\Models\RequestModel;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'surname',
        'username',
        'name',
        'gender',
        'phone_number',
        'birthday',
        'marital_status',
        'whatsapp',
        'telegram',
        'IMO',
        'viber',
        'instagram',
        'facebook',
        'twitter',
        'city_id',
        'photo_path',
        'native_country_id',
        'status_id',
        'role_id',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $attributes = [
        'photo_path' => 'storage/default_images/default_user_icon.svg'
    ];

    // Mutators
    public function getUserImageAttribute($src)
    {
        return cloudlink($src);
    }

    //GET USER NATIVE COUNTRY
    public function country(){
        return $this->hasOne(\App\Models\CountryModel::class, 'id', 'native_country_id')
                    ->get('country_name')->first()->country_name;
    }

    //GET USER CITY WHERE HE IS CURRENTLY LIVING
    public function city(){
        return $this->hasOne(\App\Models\CityModel::class, 'id', 'city_id')
                    ->get('city_name')->first()->city_name;
    }

    //Get User's requests
    public function requests(){
        return $this->hasMany(RequestModel::class, 'user_id', 'id')->get();
    }
}
