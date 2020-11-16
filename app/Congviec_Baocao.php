<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Congviec_Baocao extends Model
{
    public $table = "congviec_baocao"; 

    public $timestamps = false;

    public function congviec_chitiet()
    {
    	return $this->belongsTo('App\CongviecChiTiet','congviec_user_id','id');
    }

}
