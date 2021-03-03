<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\CityModel;

class RequestModel extends Model
{
    use HasFactory;

    //Fillable fields
    protected $fillable = [
        'user_id',
        'photo_path',
        'description',
        'category_id',
        'city_id',
        'seen',
        'status'
    ];

    //Table name in the DB
    protected $table = 'requests';

    //Default post icon if no image was uploaded
    protected $attributes = [
        'photo_path' => 'storage/default_images/default_post_icon.svg'
    ];

    //Get FUll information about user that sent request
    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id')->get()->first();
    }

    //Get City name
    public function city(){
        return $this->hasOne(CityModel::class, 'id', 'city_id')
            ->get('city_name')->first()->city_name;
    }

}
