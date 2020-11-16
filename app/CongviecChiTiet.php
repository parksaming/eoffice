<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CongviecChiTiet extends Model
{
    public $table = "congviec_users";

    public function congviec()
    {
    	return $this->belongsTo('App\CongViec','congviec_id','id');
    }
    
    public function user()
    {
    	return $this->belongTo('App\Models\User');
    }

    public function congviec_baocao()
    {
    	return $this->hasOne('App\Congviec_Baocao','congviec_user_id','id');
    }
}
