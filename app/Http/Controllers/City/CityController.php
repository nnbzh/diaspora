<?php

namespace App\Http\Controllers\City;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CityModel;
use App\Models\CountryModel;
use App\Models\ChatModel;

class CityController extends Controller
{

    public function index(Request $req)
    {
        $city = CityModel::orderby('created_at', 'desc');
        if ($req->q) $city->where('city_name', 'like', '%'.$req->q.'%');
        return view('City.city',
            [
                'cities' => $city->paginate(6),
                'countries' => CountryModel::all()
            ]
        );
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'city_name' => 'required',
                'chat_name' => 'required',
            ],
            [
                'city_name.required' => 'Укажите название города!',
                'chat_name.required' => 'Укажите название чата!'
            ]
        );

        CityModel::create(
            [
                'country_id' => $request['country_id'],
                'city_name' => $request['city_name']
            ]
        );

        ChatModel::create(
            [
                'chat_name' => $request['chat_name']
            ]
        );

        return back()->with('success', 'Город был добавлен, чат создан!');

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


    public function update(Request $request, $id)
    {
        $request->validate(
            ['city_name' => 'required'],
            ['city_name.required' => 'Название страны обязательное поле!']
        );
        CityModel::where('id', $id)->update(
            [
                'city_name' => $request['city_name']
            ]
        );

        return back()->with('success', 'Успешно обнавлено!');
    }


    public function destroy($id)
    {
        CityModel::where('id', $id)->delete();
        return back()->with('success', 'Успешно удалено!');
    }
}
