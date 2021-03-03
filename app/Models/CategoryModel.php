<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    use HasFactory;

    //Fillabe fields
    protected $fillable = ['category_name', 'image_path', 'status'];

    //Default value for the image path if the category photo is empty
    protected $attributes = [
        'image_path' => 'storage/default_images/default_category_icon.svg'
    ];

    //Table name in the DB
    protected $table = 'categories';
}
