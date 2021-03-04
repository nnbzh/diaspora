<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RequestModel;
use App\Models\User;

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

    //Return cities and amount of the posts
    public function citiesAndPosts($country_id){
        return $this->where('country_id', $country_id)->get();
    }

    //Get the quantity of posts according to the CITY
    public function overallPosts(){
        return $this->hasMany(RequestModel::class,'city_id', 'id')->count();
    }

    //Get the active POSTS related to the CITY
    public function activePosts(){
        return $this->hasMany(RequestModel::class, 'city_id', 'id')
            ->where('status', 1)->count();
    }

    //Get the active POSTS related to the CITY
    public function nonActivePosts(){
        return $this->hasMany(RequestModel::class, 'city_id', 'id')
            ->where('status', 0)->count();
    }


}
