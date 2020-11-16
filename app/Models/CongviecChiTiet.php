<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CongviecChiTiet extends Model
{
    public $table = "congviec_users";

    public function congviec()
    {
    	return $this->belongsTo(CongViec::class,'congviec_id','id');
    }
    
    public function user()
    {
    	return $this->belongTo(User::class);
    }

    public function congviec_baocao()
    {
    	return $this->hasOne('App\Congviec_Baocao','congviec_user_id','id');
    }
}
