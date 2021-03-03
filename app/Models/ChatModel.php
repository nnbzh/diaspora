<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatModel extends Model
{
    use HasFactory;

    //Fillable fields
    protected $fillable = ['chat_name'];

    //Name in the DB
    protected $table = 'chat';
}
