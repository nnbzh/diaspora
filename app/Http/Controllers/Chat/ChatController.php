<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatModel;

class ChatController extends Controller
{
    public function index()
    {
        return view('chats',
            [
                'chats' => ChatModel::leftJoin('cities', 'chat.city_id', '=', 'cities.id')
                    ->leftJoin('countries', 'cities.country_id', '=', 'countries.id')
                    ->withCount('chat_users', 'chat_city')
                    ->orderBy('chat.id', 'desc')
                    ->paginate(6),
                'countries' => \App\Models\CountryModel::orderby('country_name', 'asc')->get(),
            ]
        );
    }

    //Store country to the DB
    public function store(Request $request)
    {
        ChatModel::create([
            'chat_name' => $request->chat_name,
            'created_user_id' => 1,
            'country_id' => $request->country_id ?? 0,
            'city_id' => $request->city_id,
            'chat_room' => uniqid(),
        ]);

        return back()->with('success', 'Чат успешно добавлен!');
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
            ['chat_name' => 'required'],
            ['chat_name.required' => 'Название страны обязательное поле!']
        );
        ChatModel::where('id', $id)->update(
            [
                'chat_name' => $request['chat_name'],
                'city_id' => $request['city_id'],
            ]
        );

        return back()->with('success', 'Успешно обновлено!');
    }


    public function destroy($id)
    {
        ChatModel::where('id', $id)->delete();
        return back()->with('success', 'Успешно удалено!');
    }
}
