<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CountryModel as Country;
use App\Models\CityModel as City;
use App\Contracts\UserContract;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->contract = new UserContract();
    }

    public function userShow(Request $req) {
        if ($req->user_id) {
            return User::select($this->contract::SHOW_SELECT_DATA)
                ->where('id', $req->user_id)
                ->first() ?? [];
        } else return [];
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
        $user->photo_path           = $req->user_image
                                            ? $req->file('user_image')->store('user_images')
                                            : $user->photo_path;
        $user->email                = $req->email ?? $user->email;
        $user->save();
        return ['message' => true];
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

}
