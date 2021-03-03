<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryModel extends Model
{
    use HasFactory;

    //Fillable fields
    protected $fillable = ['country_name'];

    //Table in the DB
    protected $table = 'countries';

    //COUNTRY HAS MANY CITIES
    public function city_name(){
        return $this->hasMany(\App\Models\CityModel::class, 'country_id');
    }

    //Get the USERS COUNTRY
    public function user(){
        return $this->belongsTo(\App\Models\User::class);
    }

//    //Get active users only
//    public function active_users(){
//        return $this->hasMany(\App\Models\User::class, 'native_country_id', 'id')->count();
//    }
}
