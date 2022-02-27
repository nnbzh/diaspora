<?php

namespace App\Http\Controllers\Country;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CountryModel;

class CountryController extends Controller
{
    public function index(Request $req)
    {
        $country = CountryModel::orderby('created_at', 'desc');
        if ($req->q) $country->where('country_name', 'like', '%'.$req->q.'%');
        return view('Country.country',
            [
                'countries' => $country->paginate(6)
            ]
        );
    }

    //Store country to the DB
    public function store(Request $request)
    {
        CountryModel::create($request->validate(
            ['country_name' => 'required'],
            ['country_name.required' => 'Введите название страны!']
        ));

        return back()->with('success', 'Страна успшно добавлено!');
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

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {
        $request->validate(
            ['country_name' => 'required'],
            ['country_name.required' => 'Название страны обязательное поле!']
        );
        CountryModel::where('id', $id)->update(
            [
                'country_name' => $request['country_name']
            ]
        );

        return back()->with('success', 'Успешно обнавлено!');
    }


    public function destroy($id)
    {
        CountryModel::where('id', $id)->delete();
        return back()->with('success', 'Успешно удалено!');
    }
}
