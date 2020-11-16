<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class VanBanXuLyDetail extends Model
{
    public $table= "vanbanxulydetails";
    public $timestamps = false;
    protected $fillable = [
        'vanBanXuLy_id',
        'childId'
    ];

}
