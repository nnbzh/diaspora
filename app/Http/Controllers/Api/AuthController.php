<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;
use App\Services\RequestValidator;

class AuthController extends Controller
{

    public function register(Request $req) {
        $reqAll = $req->all();
        !filter_var($req->phone_or_email, FILTER_VALIDATE_EMAIL)
            ? $reqAll['phone_number'] = $req->phone_or_email
            : $reqAll['email'] = $req->phone_or_email;
        $validator = (new RequestValidator)->registerValidate($reqAll);
        if ($validator->fails()) {
            return response([
                'message' => $validator->errors()->first()
            ], 400);
        }
        $data = [
            'username' => $req->username,
            'password' => Hash::make($req->password),
            'name' => $req->name,
            'surname' => $req->surname,
        ];
        if (!filter_var($req->phone_or_email, FILTER_VALIDATE_EMAIL)) {
            $data['phone_number'] = $req->phone_or_email;
            $data['email'] = Str::random();
        } else {
            $data['email'] = $req->phone_or_email;
        }
        $user = User::create($data);
        return response([
            'user' => $user,
            'access_token' => $user->createToken('authToken')->accessToken,
        ]);
    }

    public function login(Request $req) {
        $user = User::where('username', $req->username)->first();
        $error = ['message' => 'Неверный номер телефона или пароль'];
        if (!$user || !Hash::check($req->password, $user->password)) {
            return response($error, 400);
        }
        return response([
            'user' => $user,
            'access_token' => $user->createToken('authToken')->accessToken,
        ]);
    }

}
