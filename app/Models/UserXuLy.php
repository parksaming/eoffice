<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class UserXuLy extends Model
{
    public $table= "user_xulys";
    public $timestamps = false;
    protected $fillable = [
        'vanban_xuly_id',
        'user_id',
        'type',
        'status'
    ];

}
