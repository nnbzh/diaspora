<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    use HasFactory;

    //Fillabe fields
    protected $fillable = [
        'role_name'
    ];


    //Table name
    protected $table = 'roles';


}
