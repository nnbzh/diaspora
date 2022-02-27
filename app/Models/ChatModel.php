<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatModel extends Model
{
    use HasFactory;

    //Fillable fields
    protected $fillable = [
        'chat_name',
        'created_user_id',
        'country_id',
        'city_id',
        'chat_room',
    ];

    //Name in the DB
    protected $table = 'chat';

    // Relationships
    public function messages() {
        return $this->hasMany(\App\Models\MessageModel::class, 'chat_id', 'id');
    }

    public function chat_users() {
        return $this->hasMany(\App\Models\ChatUser::class, 'chat_id', 'id');
    }

    public function chat_city() {
        return $this->hasOne(\App\Models\CityModel::class, 'id', 'city_id');
    }

    public function user_not_read_messages() {
        return $this->hasMany(\App\Models\ReadMessage::class, 'user_id', 'user_id');
    }

    // Accessors
    public function getNotReadMessagesCountAttribute($value) {
        return \App\Models\ReadMessage::where(
                'user_id', \App\Models\ChatUser::where('chat_id', $value)->first()->user_id ?? 0
            )->count();
    }

    public function getChatUsersCountAttribute($value) {
        return \App\Models\ChatUser::where('chat_id', (int) $value)->count();
    }

    public function getImageAttribute($value) {
        return $value ? cloudlink($value) : $value;
    }

    // Other methods
    public function generateChatRoom() {
        $chars = generate_chars(16);
        if (self::where('chat_room', $chars)->exists())
            $chars = $this->generateChatRoom();

        return $chars;
    }
}
