<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoryModel as Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function categoryList() {
        return Category::select('category_name', 'image_path')
            ->where('status', 1)
            ->get();
    }

}
