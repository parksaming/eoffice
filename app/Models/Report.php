<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'daily_report';
    
    protected $fillable = [
        'id',
        'user_id',
        'fullname',
        'username',
        'donvi_id',
        'ma_donvi',
        'content',
        'created_date',
        'updated_date'
    ];
    
    public $timestamps = false;

}
