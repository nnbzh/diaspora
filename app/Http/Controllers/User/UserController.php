<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CityModel;
use App\Models\CountryModel;

class UserController extends Controller
{

    public function index()
    {
        return view('User.user',
            [
                'users' => User::where('role_id', 3)->orderby('created_at', 'desc')->paginate(6)
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    //Update user's status
    public function updateStatus(Request $request, $id){
        $status = User::where('id', $id)->get('status')->first()->status;
        $user = User::where('id', $id)->get('name')->first();
        if($status === 1){
            User::where('id', $id)
                ->update(['status' => 0]);
            return back()->with('success', 'Пользователь ' . $user->name . ' успешно заблокирован!');
        }
        else{
            User::where('id', $id)
                ->update(['status' => 1]);
            return back()->with('success', 'Пользователь ' . $user->name . ' активен!');
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
