<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CityModel;
use App\Models\RequestModel;

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

    //Get quantity of posts related to the COUNTRY, COUNTING ONLY CITY
    protected $activePosts = 0;
    protected $nonActivePosts = 0;
    public function overallPosts(){
        $cityModel = new CityModel();
        $citiesWithAmountOfPosts = $cityModel->citiesAndPosts($this->id);
        $overallPosts = 0;
        foreach($citiesWithAmountOfPosts as $city){
            $overallPosts += $city->overallPosts();
            $this->activePosts += $city->activePosts();
            $this->nonActivePosts += $city->nonActivePosts();
        }
        return $overallPosts;
    }

    //Get the amount of active posts
    public function activePosts(){
        return $this->activePosts;
    }

    //Get the amount of NON ACTIVE posts
    public function nonActivePosts(){
        return $this->nonActivePosts;
    }
}
