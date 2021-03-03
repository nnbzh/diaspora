<?php

namespace App\Http\Controllers\City;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CityModel;
use App\Models\CountryModel;
use App\Models\ChatModel;

class CityController extends Controller
{

    public function index()
    {
        return view('City.city',
            [
                'cities' => CityModel::orderby('created_at', 'desc')->paginate(6),
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
