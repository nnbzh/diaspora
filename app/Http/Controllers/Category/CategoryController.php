<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
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
                'category_name' => 'required|max:255',
                'img' => 'mimes:jpg,jpeg,svg,png|max:2048'
            ],
            [
                'category_name.required' => 'Название категории обязательное поле!',
                'category_name.max' => 'Название категории не должна привышать 255 символов!',
                'img.size' => 'Фото категории не должна привышать 2Мб (2048Кб)',
                'img.mimes' => 'Фото категории должна соответствовать расширеням: jpg, jpeg, png, svg.',
            ]
        );

        $filePath = $request->file('img')->store('public/category_images');
        if($request->hasFile('img')){
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
