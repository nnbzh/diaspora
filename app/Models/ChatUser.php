<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatUser extends Model
{
    use HasFactory;

    protected $table = 'chat_users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'chat_id',
        'user_id',
    ];

    public function chat() {
        return $this->belongsTo(\App\Models\ChatModel::class, 'chat_id', 'id');
    }

    public function user() {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function chat_not_read_messages() {
        return $this->hasMany(\App\Models\ReadMessage::class, 'chat_id', 'chat_id');
    }

    public function user_not_read_messages() {
        return $this->hasMany(\App\Models\ReadMessage::class, 'user_id', 'user_id');
    }
}
