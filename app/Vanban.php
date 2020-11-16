<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Vanban extends Model
{
    public $table= "vanbans";
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'vanban_id',
        'book_id',
        'title',
        'loaivanban_id',
        'ngayden',
        'ngaydi',
        'soden',
        'cq_banhanh',
        'kyhieu',
        'ngayky',
        'linhvuc_id',
        'nguoiky',
        'hanxuly',
        'publish_id',
        'note',
        'save',
        'status',
        'vanban_file',
        'urgency',
        'vanban_id',
        'content_butphe',
        'ngaygui',
        'file_dinhkem',
        'usernhan'
    ];
}
