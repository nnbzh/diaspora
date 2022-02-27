<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
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
            'native_country_id' => 0,
            'ctrunity_id' => 0,
        ];
        if (!filter_var($req->phone_or_email, FILTER_VALIDATE_EMAIL)) {
            $data['phone_number'] = $req->phone_or_email;
            $data['email'] = Str::random();
        } else {
            $data['email'] = $req->phone_or_email;
        }
        $user = User::create($data);

		$user->user_image = env('APP_URL').$user->photo_path;
		// $user->user_image = User::select('photo_path as user_image')->where('id', $user->id)->first()->user_image ?? null;
		unset($user->photo_path);
        return response([
            'user' => $user,
            'access_token' => $user->createToken('authToken')->accessToken,
        ]);
    }

    public function login(Request $req) {
//        !filter_var($req->phone_or_email, FILTER_VALIDATE_EMAIL)
//            ? $params = ['phone', ];
        $user = User::where('username', $req->username)->first();
        $error = ['message' => 'Неверный данные для входа'];
        if (!$user || !Hash::check($req->password, $user->password)) {
            return response($error, 400);
        }
		$user->user_image = env('APP_URL').$user->photo_path;
		// $user->user_image = User::select('photo_path as user_image')->where('id', $user->id)->first()->user_image ?? null;
		unset($user->photo_path);
        return response([
            'user' => $user,
            'access_token' => $user->createToken('authToken')->accessToken,
        ]);
    }

    public function resetPassword(Request $req) {
        $messages = [
            'new_password.required' => 'Пароль не указан',
            'new_password.min' => 'Пароль не должен быть меньше 6 символов',
            'new_password.max' => 'Пароль не должен быть больше 16 символов',
        ];
        $validator = Validator::make($req->all() , [
            'new_password' => 'required|min:6|max:16',
        ], $messages);
        if ($validator->fails()) {
            return response()
                ->json(['message' => $validator->errors()->first()])
                ->setStatusCode(400);
        }
        $user = User::where('email', $req->email)->first();
        if (!$user) {
            return response()
                ->json(['message' => 'Неверный email'])
                ->setStatusCode(400);
        }

        $code = '';
        for ($i=0; $i < 4; $i++) {
            $code .= rand(0, 9);
        }

        $redisData = [
            'user_id' => $user->id,
            'code' => $code,
            'new_password' => $req->new_password,
        ];

        $redisKey = $this->getRedisKeyForResetPassword();
        Redis::set('reset_pass:'. $redisKey, json_encode($redisData));
        Redis::expire('reset_pass:'. $redisKey, 3000);

        Mail::to($req->email)->send(new \App\Mail\ResetPasswordMail([
            'code' => $code
        ]));
        return ['check_key' => $redisKey];
    }

    public function resetPasswordCheckCode(Request $req) {
        $mess = ['message' => 'Неверный код'];
        if ($req->check_key) {
            $key = Redis::get('reset_pass:'. $req->check_key);
            if (!$key) {
                return response(['message' => 'Time limit']);
            }
            $data = json_decode($key, true);

	    // if (!$data) return response($mess, 400);

            if ($data['code'] == $req->code) {
                User::where('id', $data['user_id'])->update([
                    'password' => Hash::make($data['new_password'])
	        ]);
                Redis::expire('reset_pass:'. $req->check_key, -1);
		$user = User::where('id', $data['user_id'])->first();
                return response()->json([
                    'user' => $user,
                    'access_token' => $user->createToken('authToken')->accessToken,
                ]);
            } else {
                return response($mess);
            }

        } else {
            return response($mess);
        }
    }

    // Other methods
    private function getRedisKeyForResetPassword() {
        $key = generate_chars();
        if (Redis::get('reset_pass:'. $key))
            $key = $this->getRedisKeyForResetPassword();
        return $key;
    }

}
