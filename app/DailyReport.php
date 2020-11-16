<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    public $table = "daily_report"; 

    public $timestamps = false;

    protected $fillable = [
    	'user_id',
    	'username',
    	'fullname',
    	'content',
    	'reportday',
    	'donvi_id',
    	'file',
    	'congviec_user_id',
    ];
}
