<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\MessageModel as Message;
use App\Models\ChatModel as Chat;
use App\Models\ChatUser;
use App\Models\ReadMessage;
use App\Models\CityModel as City;
use App\Models\CountryModel as Country;

class ChatController extends Controller
{

    public function getChats(Request $req) {
        // $user_chat = ChatUser::with('chat:chat.*,chat.id  as not_read_messages_count,chat.id as chat_users_count')
        //     ->where( 'user_id', $req->user()->id )
        //     ->get()
        //     ->pluck('chat');

        // $data['user_chats'] = [];
        // foreach ($user_chat as $k => $v) {
        //     if ($v) $data['user_chats'][] = $user_chat[$k];
        // }
        // $data['user_chats'] = collect($data['user_chats']);

        $cities = City::select('cities.id as city_id')
            // ->leftJoin('countries', 'cities.country_id', '=', 'countries.id')
            ->where('cities.id', $req->user()->city_id)
            ->get()
            ->pluck('city_id');

        $data['accesable_chats'] = Chat::select('chat.*', 'chat.id as chat_users_count', 'chat.id as not_read_messages_count')
            // ->whereNotIn('chat.id', $data['user_chats']->pluck('id')->filter() )
            ->where('chat.city_id', $req->user()->native_country_id)
            ->where('chat.country_id',
                Country::select('countries.id')->leftJoin('cities', 'cities.country_id', '=', 'countries.id')->where('cities.id', $req->user()->city_id)->first()->id)
            // ->orWhereIn('chat.city_id', $cities ?? [])
            // ->withCount('chat_users')
            ->orderBy('chat.id', 'desc')
            ->get();
        // dd(Country::select('countries.country_name')->leftJoin('cities', 'cities.country_id', '=', 'countries.id')->where('cities.id', $req->user()->city_id)->first());

        foreach ($data['accesable_chats'] as $k => $v) {
            $where_params = [
                ['chat_id', $v->id],
                ['user_id', $req->user()->id],
            ];
            $checkIsRun = DB::table('chat_users')->where($where_params)->exists();
            $v->is_run = $checkIsRun ? true : false;

            $checkIsLiked = DB::table('chat_liked')->where($where_params)->exists();
            $v->is_liked = $checkIsLiked ? true : false;
        }

        $data['liked_chats'] = Chat::select('chat.*', 'chat.id as chat_users_count', 'chat.id as not_read_messages_count')
            ->leftJoin('chat_liked', 'chat.id', '=', 'chat_liked.chat_id')
            ->whereNotIn('chat.id', $data['accesable_chats']->pluck('id')->filter() )
            ->where('chat_liked.user_id', $req->user()->id)
            // ->withCount('chat_users')
            ->orderBy('chat.id', 'desc')
            ->get();

        foreach ($data['liked_chats'] as $k => $v) {
            $where_params = [
                ['chat_id', $v->id],
                ['user_id', $req->user()->id],
            ];
            $checkIsRun = DB::table('chat_users')->where($where_params)->exists();
            $v->is_run = $checkIsRun ? true : false;

            $checkIsLiked = DB::table('chat_liked')->where($where_params)->exists();
            $v->is_liked = $checkIsLiked ? true : false;
        }

        return $data['accesable_chats']->merge($data['liked_chats']);
    }

    public function chatUsers(Request $req) {
	$chat_users_id = DB::table('chat_users')
	    ->where('chat_id', $req->chat_id)
	    ->get()
	    ->pluck('user_id')
	    ->toArray();
	$users = \App\Models\User::select('users.*', 'users.photo_path as user_image')->whereIn('id', $chat_users_id ?? [])->get();
	return $users->map(function($v) {
	    $v->photo_path = cloudlink($v->photo_path);
	    return $v;
	});
    }

    public function chatRun(Request $req) { // chat_id
        $check_chat_user = ChatUser::where('chat_id', $req->chat_id)
            ->where('user_id', $req->user()->id)
            ->exists();
        if (!$check_chat_user) {
            ChatUser::create([
                'chat_id' => $req->chat_id,
                'user_id' => $req->user()->id,
            ]);

            return ['message' => true];
        } else return ['message' => false];
    }

    public function getChatMessages(Request $req) { // chat_id
        if ($req->chat_id) {
            $chat = Chat::select('chat.*', 'chat.id as chat_users_count', 'chat.id as not_read_messages_count')
                ->where('id', $req->chat_id)
                ->with('messages:*,user_id as user_image')
                // ->withCount('chat_users')
                ->first();

            // ChatUser::where('chat_id', $req->chat_id)
            //     ->where('user_id', $req->user()->id)
            //     ->delete();

            return $chat;
        } else return [];
    }

    public function notReadCount(Request $req) {
        return ReadMessage::where('user_id', $req->user()->id)
            ->count();
    }

    public function chatIsRead(Request $req) {
        if ($req->chat_id) {
            ReadMessage::where('user_id', $req->user()->id)
                ->where('chat_id', $req->chat_id)
                ->delete();

            return ['message' => true];
        } else return ['message' => false];
    }

    public function chatSaveImage(Request $req) {
        if ($req->file('image')) {
            $photo_path = \App\Services\ImageService::saveImages($req->file('image'), 'public/chat_images');
            $photo_path = str_replace('public', 'storage', $photo_path);
            return [
                'message' => true,
                'url' => cloudlink($photo_path),
                'src' => $photo_path,
            ];
        } else return ['message' => false];
    }

    public function getCountryChat(Request $req) { // ??????
        if ($req->user()->country_chat) {
            $data = $req->user()->country_chat->first();
            $data->messages = Message::where('chat_id', $req->user()->country_chat->id)->last();
        }
        return $data ?? [];
    }

    public function countryChatSendMessage(Request $req) {
        if ($req->text) {
            \App\Jobs\CountryChatMessageCreator::dispatch(
                auth()->user(),
                $req->all(),
            );
        }
    }

    public function chatLiked(Request $req) {
        if (!$req->chat_id) {
            return ['message' => 'Не указали чат'];
        }

        $where_params = [
            ['chat_id', $req->chat_id],
            ['user_id', $req->user()->id],
        ];
        $check = DB::table('chat_liked')->where($where_params)->exists();

        if ($check) {
            DB::table('chat_liked')->where($where_params)->delete();
        } else {
            DB::table('chat_liked')->insert([
                'chat_id' => $req->chat_id,
                'user_id' => $req->user()->id,
            ]);
        }

        return ['message' => true];
    }

}
