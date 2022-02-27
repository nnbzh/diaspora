<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\ChatModel as Chat;
use App\Models\MessageModel as Message;
use App\Models\User;
use App\Services\Push\PushNotifications;

class CountryChatMessageCreator implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    private $data;

    public function __construct($user, $data)
    {
        $this->user = $user;
        $this->data = $data;
    }

    public function handle()
    {
        $chat = Chat::where('id', $this->data['chat_id'])->first();

        $message = new Message;
        $message->chat_id = $chat->id;
        $message->user_id = $this->user->id;
        $message->target_user_id = $this->data['target_user_id'] ?? 0;
        $message->text = (string) $this->data['text'];
        $message->image = $this->data['image'] ?? null;
        $message->save();

        $message->room = $chat->chat_room;

        // $event_message_data = $message->toArray();
        \App\Models\ReadMessage::create([
            'chat_id' => $this->data['chat_id'],
            'message_id' => $message->id,
            'user_id' => $this->user->id,
        ]);

	$push = new \App\Services\Push\PushNotifications;
        $users_id = \App\Models\ChatUser::where('chat_id', $chat->id)
	    ->where('user_id', '!=', $this->user->id)
            ->get()
            ->pluck('user_id')
            ->toArray();
        $tokens = \App\Models\DeviceToken::whereIn('user_id', $users_id)
            ->get()
            ->pluck('token')
            ->toArray();
        $send_data = [
            'title' => $chat->chat_name,
            'body' => $this->user->username.': '.$message->text
        ];
        $adt = ['chat_id' => $chat->id];
        try {
	    foreach($tokens as $token) {
                $push->sendPush($token, $send_data, $adt);
	    }
        } catch (\Exception $e) {
            $a = 0;
        }


        // event(new \App\Events\CountryChat($event_message_data));
        if ($message->room) {
            event(new \App\Events\CountryChat([
                'chat_id' => $this->data['chat_id'],
                'user_id' => $this->user->id,
                'text' => $message->text,
                'image' => $message->image,
                'room' => $chat->chat_room
            ]));
        }
    }

}
