<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Log extends Model
{
    public $table= "logs";
    public $timestamps = false;
    protected $fillable = [
        'user_create',
        'user_affected',
        'content',
        'created',
        'odering',
        'type',
        'donvi_id',
        'status'
    ];

}
