<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Models\CategoryModel;

class CategoryController extends Controller
{

    public function index()
    {
        return view('Category.category',
            [
                'categories' => CategoryModel::orderby('created_at', 'desc')->paginate(6)
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate(
            [
                // 'category_name' => 'required|max:255',
                // 'img' => 'mimes:jpg,jpeg,svg,png|max:8192'
            ],
            [
                // 'category_name.required' => 'Название категории обязательное поле!',
                // 'category_name.max' => 'Название категории не должна привышать 255 символов!',
                // 'img.size' => 'Фото категории не должна привышать 8Мб (8192Кб)',
                // 'img.mimes' => 'Фото категории должна соответствовать расширеням: jpg, jpeg, png, svg.',
            ]
        );


        if($request->hasFile('img')){
            $filePath = $request->file('img')->store('public/category_images');
            CategoryModel::create(
                [
                    'category_name' => $request['category_name'],
                    'image_path' => str_replace('public', 'storage', $filePath)
                ]
            );
        }
        else{
            CategoryModel::create(
                [
                    'category_name' => $request['category_name']
                ]
            );
        }


        return back()->with('success', 'Успешно добавлено!');
    }

    public function show($id)
    {
        //
    }

    public function edit(Request $request, $id)
    {
        // dd(request()->all(), 'edit');
        $category = CategoryModel::find($id);
        if ($request->category_name)
            $category->category_name = $request->category_name;

            if ($request->hasFile('img')) {
            $filePath = $request->file('img')->store('public/category_images');
            Storage::delete(str_replace('storage', 'public', $request->image_path));
            $category->image_path = str_replace('public', 'storage', $filePath);
        }
        $category->save();
        return back()->with('success', 'Категория успешно изменена!');
    }

    public function update(Request $request, $id)
    {
        dd(request()->all(), 'update');
    }

    public function updateStatusCategory(Request $request, $id){
        $status = CategoryModel::where('id', $id)->get('status')->first()->status;
        $cat = CategoryModel::where('id', $id)->get('category_name')->first()->category_name;

        if($status === 1){
            CategoryModel::where('id', $id)->update(
                [
                    'status' => 0
                ]
            );

            return back()->with('success', 'Категория ' . $cat . ' успешно диактивирована!');
        }
        else{
            CategoryModel::where('id', $id)->update(
                [
                    'status' => 1
                ]
            );

            return back()->with('success', 'Категория ' . $cat . ' активирована!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
