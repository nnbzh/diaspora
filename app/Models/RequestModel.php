<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\CityModel;
use App\Models\CategoryModel;

class RequestModel extends Model
{
    use HasFactory;

    //Fillable fields
    protected $fillable = [
        'user_id',
        'title',
        'email',
        'phone',
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
        'photo_path' => 'storage/default_images/default_post_icon.png'
    ];

    // Mutators
    public function getPostImageAttribute($src)
    {
        return cloudlink($src);
    }

    public function getUserImageAttribute($src)
    {
        return cloudlink($src);
    }

    public function getFullnameAttribute($src)
    {
        return "{$this->name} {$this->surname}";
    }

    public function getEmailAttribute($src)
    {
        return filter_var($src, FILTER_VALIDATE_EMAIL) ? $src : null;
    }

    // Relationships
    public function comments() {
        return $this->hasMany(\App\Models\CommentModel::class, 'post_id', 'id');
    }

    public function post_images() {
        return $this->hasMany(\App\Models\PostImage::class, 'post_id', 'id');
    }

    //Get FUll information about user that sent request
    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id')->get()->first();
    }

    //Get City name
    public function city(){
        return $this->hasOne(CityModel::class, 'id', 'city_id')
            ->get('city_name')->first()->city_name ?? null;
    }

    //Get POST category
    public function category(){
        return $this->hasOne(CategoryModel::class, 'id', 'category_id')
            ->get('category_name')->first()->category_name ?? null;
    }

}
