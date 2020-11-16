<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CongviecFile extends Model
{
    protected $table = "congviec_files";

    public function congviec()
    {
    	return $this->belongsTo('App\CongViec');
    }
}
