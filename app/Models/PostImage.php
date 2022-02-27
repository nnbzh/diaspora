<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    use HasFactory;

    protected $table = 'post_images';
    protected $primaryKey = 'id';
    protected $fillable = [
        'post_id',
        'image',
    ];

    // Relationships
    public function post() {
        return $this->belongsTo(\App\Models\RequestModel::class, 'post_id', 'id');
    }

    // Accessors
    public function getImageAttribute($src) {
        return cloudlink($src);
    }
}
