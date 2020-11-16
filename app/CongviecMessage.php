<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CongviecMessage extends Model
{

    public $table = "congviec_messages";

    public $timestamps = false;

    public $fillable = [
        'congviec_id',
        'user_gui',
        'user_nhan',
        'noidung',
        'ngaygui',
        'ngayxem',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'congviec_id' => 'integer',
        'user_gui' => 'string',
        'user_nhan' => 'string',
        'noidung' => 'text',
        'ngaygui' => 'datetime',
        'ngayxem' => 'datetime',
    ];

    public function congviec()
    {
    	return $this->belongTo(CongViec::class,'congviec_id','id');
    }
}
