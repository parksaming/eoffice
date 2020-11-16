<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plans';
    
    protected $fillable = [
        'id',
        'user_id',
        'username',
        'donvi_id',
        'start_day',
        'end_day',
        'content'
    ];
    
    public $timestamps = false;

}
