<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageModel extends Model
{
    use HasFactory;

    //Fillable fields
    protected $fillable = [
        'chat_id',
        'user_id',
        'target_user_id',
        'text',
        'image',
    ];

    //Table in the DB
    protected $table = 'messages';

    // Relationships
    public function chat() {
        return $this->belongsTo(\App\Models\ChatModel::class, 'chat_id', 'id');
    }

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    // Accessors
    public function getImageAttribute($src) {
        return  $src ? cloudlink($src) : null;
    }

    public function getUserImageAttribute($user_id) {
        return \App\Models\User::select('photo_path as user_image')
            ->where('id', $user_id)
            ->first()
            ->user_image ?? cloudlink('storage/default_images/default_user_icon.png');
    }
}
