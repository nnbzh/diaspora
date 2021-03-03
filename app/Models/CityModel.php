<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityModel extends Model
{
    use HasFactory;


    //Fillable fields
    protected $fillable = [
        'country_id',
        'city_name'
    ];

    //Table in the DB
    protected $table = 'cities';


    //CITY HAS ONLY ONE COUNTRY
    public function country_name(){
        return $this->hasOne(\App\Models\CountryModel::class, 'id');
    }
}
