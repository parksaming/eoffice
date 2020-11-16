<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CongViec extends Model
{
	public $table = "congviecs"; 

	public function congviecChitiet()
	{
		return $this->hasMany(CongviecChiTiet::class,'congviec_id','id');
	}

	public function tinhchat()
   	{
   		return $this->belongsTo('App\TinhChat');
   	}

   	public function congviecMessage()
   	{
   		return $this->hasMany(CongviecMessage::class,'congviec_id','id');
   	}

   	public function congviecFile()
   	{
   		return $this->hasMany(CongviecFile::class,'congviec_id','id');
   	}

   	public function congviecBaocao()
   	{
   		return $this->hasManyThrough(Congviec_Baocao::class,CongviecChiTiet::class,'congviec_id','congviec_user_id','id','id');
   	}

}
