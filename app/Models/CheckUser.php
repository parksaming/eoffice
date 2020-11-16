<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class CheckUser extends Model
{
    protected $table = 'check_user';
    
    protected $fillable = [
        'username',
        'madonvi',
        'active'
    ];
}
