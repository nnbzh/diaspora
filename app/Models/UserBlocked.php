<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBlocked extends Model
{
    use HasFactory;

    protected $table = 'user_blocked';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'blocked_user_id'
    ];

    // Relationships
    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function blocked_user() {
        return $this->belongsTo(\App\Models\User::class, 'blocked_user_id');
    }
}
