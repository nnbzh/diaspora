<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CountryModel as Country;
use App\Models\CityModel as City;
use App\Contracts\UserContract;
use App\Models\User;
use App\Models\UserBlocked;
use App\Models\DeviceToken;

class UserController extends Controller
{
    // [user_statuses => 1 - active, 0 - not_active, 404 - ban, 500 - stop]
    public function __construct()
    {
        $this->contract = new UserContract();
    }

    public function maritial_statues() {
        // $st = collect($this->contract::MARITIAL_STATUSES);
        $data = [];
        foreach ($this->contract::MARITIAL_STATUSES as $key => $val) {
            $data[] = [
                'id' => $key,
                'name' => $val,
            ];
        }
        return $data;
    }

    public function myProfile(Request $req) {
        $user = User::select('users.*', 'users.photo_path as user_image')->where('id', $req->user()->id)->first();
		$user->where_you_fly = City::select('cities.id as city_id', 'cities.city_name', 'cities.country_id', 'countries.country_name')
            ->leftJoin('countries', 'cities.country_id', '=', 'countries.id')
            ->where('cities.id', $req->user()->native_country_id)
            ->first();
		$user->where_you_from = City::select('cities.id as city_id', 'cities.city_name', 'cities.country_id', 'countries.country_name')
            ->leftJoin('countries', 'cities.country_id', '=', 'countries.id')
            ->where('cities.id', $req->user()->city_id)
            ->first();
		return $user;
    }

    public function accountStop(Request $req) {
        User::where('id', $req->user()->id)
            ->update(['status' => 500]);
        return ['message' => true];
    }

    public function userAvatarChange(Request $req) { // image
        if ($req->file('image')) {
            $photo_path = \App\Services\ImageService::saveImages($req->file('image'), 'public/user_images');
        }

        if ($photo_path) {
            $user = User::where('id', $req->user()->id)->first();
            if ($user->photo_path != 'storage/default_images/default_user_icon.png') {
                unlink(storage_path().'/app/'.str_replace('storage', 'public', $user->photo_path));
            }
            // unlink(storage_path().'/app/'.str_replace('storage', 'public', $user->photo_path));
            $user->photo_path = str_replace('public', 'storage', $photo_path);
            $user->save();
        }
        return $user;
    }

    public function userAvatarDelete(Request $req) {
        $user = User::where('id', $req->user()->id)->first();
        if ($user->photo_path != 'storage/default_images/default_user_icon.png') {
            $user->photo_path = 'storage/default_images/default_user_icon.png';
            $user->save();
        }
        return ['message' => true];
    }

    public function userShow(Request $req) {
        if ($req->user_id) {
            $data = User::select($this->contract::SHOW_SELECT_DATA)
                ->leftJoin('cities', 'users.city_id', '=', 'cities.id')
                ->leftJoin('countries', 'cities.country_id', '=', 'countries.id')
                ->leftJoin('cities as native_cities', 'users.native_country_id', '=', 'native_cities.id')
                ->leftJoin('countries as native_countries', 'native_cities.country_id', '=', 'native_countries.id')
                ->where('users.id', $req->user_id)
                ->first() ?? [];
        }

        $where_params = [
            ['user_id', $req->user_id],
            ['blocked_user_id', $req->user()->id]
        ];
        if ( UserBlocked::where($where_params)->exists() ) {
            $data->is_user_blocked_you = true;
        } else $data->is_user_blocked_you = false;

        $where_params = [
            ['user_id', $req->user()->id],
            ['blocked_user_id', $req->user_id]
        ];
        if ( UserBlocked::where($where_params)->exists() ) {
            $data->my_blocked_user = true;
        } else $data->my_blocked_user = false;
        return $data ?? [];
    }

    public function userEdit(Request $req) {
        $user = User::find((int) $req->user()->id);
        $user->surname              = $req->surname ?? $user->surname;
        $user->name                 = $req->name ?? $user->name;
        $user->gender               = $req->gender ?? $user->gender;
        $user->phone_number         = $req->phone_number ?? $user->phone_number;
        $user->birthday             = $req->birthday ? get_timestamp(strtotime($req->birthday)) : $user->birthday;
        $user->marital_status       = $req->marital_status ?? $user->marital_status;
        $user->whatsapp             = $req->whatsapp ?? $user->whatsapp;
        $user->telegram             = $req->telegram ?? $user->telegram;
        $user->IMO                  = $req->IMO ?? $user->IMO;
        $user->viber                = $req->viber ?? $user->viber;
        $user->instagram            = $req->instagram ?? $user->instagram;
        $user->facebook             = $req->facebook ?? $user->facebook;
        $user->twitter              = $req->twitter ?? $user->twitter;
        $user->city_id              = $req->city_id ?? $user->city_id;
        $user->email                = $req->email ?? $user->email;
        $user->save();

        if ($req->city_id) {
            if ($user->native_country_id) {
                $where_you_from = City::select('cities.id as city_id', 'cities.city_name', 'cities.country_id', 'countries.country_name')
                    ->leftJoin('countries', 'cities.country_id', '=', 'countries.id')
                    ->where('cities.id', $req->city_id)
                    ->first();
                $where_you_fly = City::where('id', $user->native_country_id)->first();

                $chat_exists = \App\Models\ChatModel::where('city_id', $user->native_country_id)
                    ->where('country_id', $where_you_from->country_id ?? 0)
                    ->exists();

                if (!$chat_exists) {
                    \App\Models\ChatModel::create([
                        'chat_name' => $where_you_from->country_name.' - '.$where_you_fly->city_name,
                        'country_id' => $where_you_from->country_id,
                        'city_id' => $user->native_country_id,
                        'chat_room' => (new \App\Models\ChatModel)->generateChatRoom(),
                        'created_user_id' => $user->id,
                    ]);
                }
            }
        }

        $user->user_image = $user->photo_path;
        return $user;
    }

    public function getNativeCountry(Request $req) {
        return City::select('cities.id as city_id', 'cities.city_name', 'cities.country_id', 'countries.country_name')
            ->leftJoin('countries', 'cities.country_id', '=', 'countries.id')
            ->where('cities.id', $req->user()->native_country_id)
            ->first();
    }

    public function saveNativeCountry(Request $req) {
        if ($req->city_id) {
            $user = User::find((int) $req->user()->id);
            $user->native_country_id = $req->city_id;
            $user->save();

            if ($req->city_id) {
                if ($user->city_id) {
                    $where_you_from = City::select('cities.id as city_id', 'cities.city_name', 'cities.country_id', 'countries.country_name')
                        ->leftJoin('countries', 'cities.country_id', '=', 'countries.id')
                        ->where('cities.id', $user->city_id)
                        ->first();
                    $where_you_fly = City::where('id', $user->native_country_id)->first();

                    $chat_exists = \App\Models\ChatModel::where('city_id', $user->native_country_id)
                        ->where('country_id', $where_you_from->country_id ?? 0)
                        ->exists();

                    if (!$chat_exists) {
                        \App\Models\ChatModel::create([
                            'chat_name' => $where_you_from->country_name.' - '.$where_you_fly->city_name,
                            'country_id' => $where_you_from->country_id,
                            'city_id' => $user->native_country_id,
                            'chat_room' => (new \App\Models\ChatModel)->generateChatRoom(),
                            'created_user_id' => $user->id,
                        ]);
                    }
                }
            }

            return ['message' => true];
        } else return ['message' => false];
    }

    public function countryUsers(Request $req) {
        $users = User::select($this->contract::COUNTRY_USERS_SELECT)
            ->where('native_country_id', $req->user()->native_country_id)
            ->get();
        if (!$users) {
            return ['message' => 'Вы не выбрали местоположение'];
        } else return $users;
    }

    public function create_device_token(Request $req) { // device_token
    	if ($req->device_token) {
    	    $dt = DeviceToken::where('user_id', $req->user()->id)
    		->first();
    	    if ($dt) {
        		if ( !$dt->firstWhere('token', $req->device_token) ) {
                    DeviceToken::create([
            		    'user_id' => $req->user()->id,
            		    'token' => $req->device_token
            		]);
        		}
    	    } else {
        		DeviceToken::create([
        		    'user_id' => $req->user()->id,
        		    'token' => $req->device_token
        		]);
    	    }
    	}
    	return ['message' => true];
    }

    public function user_block(Request $req) {
        $where_params = [
            ['user_id', $req->user()->id],
            ['blocked_user_id', $req->user_id]
        ];
        if ( UserBlocked::where($where_params)->exists() ) {
            return response([
                'message' => 'Этот пользователь уже заблокирован вами'
            ], 515);
        } else {
            UserBlocked::create([
                'user_id' => $req->user()->id,
                'blocked_user_id' => $req->user_id
            ]);
            return ['message' => 'Ok'];
        }
    }

    public function user_unlock(Request $req) {
        $where_params = [
            ['user_id', $req->user()->id],
            ['blocked_user_id', $req->user_id]
        ];
        $blocked_user = UserBlocked::where($where_params)->first();
        if ( !$blocked_user ) {
            return response([
                'message' => 'Этот пользователь не заблокирован вами'
            ], 515);
        } else {
            $blocked_user->delete();
            return ['message' => 'Ok'];
        }
    }

    public function blocked_users(Request $req) {
        return UserBlocked::with('blocked_user')
            ->where('user_id', $req->user()->id)
            ->get();
    }

}
