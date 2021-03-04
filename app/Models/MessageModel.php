<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageModel extends Model
{
    use HasFactory;

    //Fillable fields
    protected $fillable = [
        'user_id',
        'target_user_id',
        'text'
    ];

    //Table in the DB
    protected $table = 'messages';
}
