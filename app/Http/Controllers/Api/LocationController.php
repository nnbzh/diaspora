<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CountryModel as Country;
use App\Models\CityModel as City;

class LocationController extends Controller
{

    public function countryList() {
        return Country::select('id', 'country_name')->get();
    }

    public function cityList(Request $req) {
        if (!$req->country_id) {
            return response(['message' => 'Вы не выбрали страну'], 400);
        }
        return City::select('id', 'city_name')
            ->where('country_id', $req->country_id)->get();
    }

    public function city(Request $req) {
        if ($req->id) {
            $data = City::select('id','city_name')
                ->where('id', $req->id)
                ->first();
        }
        return $data ?? [];
    }

}
