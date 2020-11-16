<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class VanbanUser extends Model
{
    public $table= "vanban_users";
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'vanban_id',
        'created',
        'datetime',
        'content_butphe',
        'ngayxem',
        'ngaycapnhat',
        'user_capnhat',
        'status'
    ];

}
