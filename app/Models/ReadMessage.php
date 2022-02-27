<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadMessage extends Model
{
    use HasFactory;

    protected $table = 'read_messages';
    protected $primaryKey = 'id';
    protected $fillable = [
        'chat_id',
        'message_id',
        'user_id',
    ];
}
