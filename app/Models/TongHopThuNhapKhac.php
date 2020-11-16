<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TongHopThuNhapKhac extends Model
{
    protected $table = 'tonghop_thunhap_khac';
    protected $fillable = [
        'user_id',
        'macanbo',
        'fullname',
        'sotiet_tien_giang',
        'tien_giang',
        'hs_quan_ly_phi',
        'quan_ly_phi',
        'hs_luong_tang_them',
        'luong_tang_them',
        'sothang_dienthoai',
        'khoan_dien_thoai',
        'thu_nhap_khac',
        'trutam_ungthue_tncn',
        'thuc_nhan',
        'date',
    ];

    public $timestamps = false;
}
