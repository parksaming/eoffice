<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LuongPhuCap extends Model
{
    protected $table= 'thanhtoan_luong_phucap';
    protected $fillable = [
        'user_id',
        'macanbo',
        'fullname',
        'hs_luong_ngach_bac',
        'luong_ngach_bac',
        'hs_phucap_chucvu',
        'phucap_chucvu',
        'tyle_phucap_thamnien_vuotkhung',
        'phucap_thamnien_vuotkhung',
        'tyle_phucap_thamnien_nghe',
        'phucap_thamnien_nghe',
        'tyle_phucap_uudai_nghe',
        'phucap_uudai_nghe',
        'hs_phucap_khac',
        'phucap_khac',
        'hs_phucap_congtac_dang',
        'phucap_congtac_dang',
        'hs_luong_tang_them',
        'luong_tang_them',
        'hs_quan_li_phi',
        'quan_li_phi',
        'tong_thu_nhap',
        'khautru_BHXH',
        'khautru_BHTN',
        'khautru_BHYT',
        'khautru_KPCD',
        'tong_khau_tru',
        'thue_TNCN',
        'tru_tamung',
        'thuclinh',
        'so_taikhoan_canhan',
        'date',
    ];
    
    public $timestamps = false;
}
