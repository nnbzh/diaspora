<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentModel extends Model
{
    use HasFactory;

    //Fillable fields
    protected $fillable = [
        'user_id',
        'post_id',
        'comment'
    ];

    //Table in the DB
    protected $table = 'comments';

    // Relationships
    public function post() {
        return $this->belongsTo(\App\Models\RequestModel::class, 'post_id', 'id');
    }

    // Mutators
    public function getUserImageAttribute($src)
    {
        return cloudlink($src);
    }
}
