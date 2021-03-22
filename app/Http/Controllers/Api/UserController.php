<?php

namespace App\Http\Controllers\Api;

use App\Contracts\UserContract;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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

}
