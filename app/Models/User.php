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

    protected $primaryKey = 'id';

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
        'about_me',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $attributes = [
        'photo_path' => 'storage/default_images/default_user_icon.png'
    ];

    // Mutators
    public function getUserImageAttribute($src)
    {
        return cloudlink($src);
    }

    // Relationships
    public function country_chat()
    {
        return $this->hasManyThrough(
            \App\Models\ChatModel::class,
            \App\Models\CityModel::class,
            'country_id',
            'country_id',
            'native_country_id',
            'id'
        );
    }

    public function messages() {
        return $this->hasMany(\App\Models\MessageModel::class, 'user_id', 'id');
    }

    public function blocked_users() {
        return $this->hasMany(\App\Models\UserBlocked::class, 'user_id');
    }

    public function blocked_me_users() {
        return $this->hasMany(\App\Models\UserBlocked::class, 'blocked_user_id');
    }

    //GET USER NATIVE COUNTRY
    public function country(){
        return $this->hasOne(\App\Models\CountryModel::class, 'id', 'native_country_id')
                    ->get('country_name')->first()->country_name ?? null;
    }

    //GET USER CITY WHERE HE IS CURRENTLY LIVING
    public function city(){
        return $this->hasOne(\App\Models\CityModel::class, 'id', 'city_id')
                    ->get('city_name')->first()->city_name ?? null;
    }

    //Get User's requests
    public function requests(){
        return $this->hasMany(RequestModel::class, 'user_id', 'id')->get();
    }
}
