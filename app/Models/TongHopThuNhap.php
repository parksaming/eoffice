<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TongHopThuNhap extends Model
{
    protected $table= 'tonghop_thunhap';
    protected $fillable = [
        'user_id',
        'macanbo',
        'fullname',
        'luong_ngach_bac',
        'phucap_chucvu',
        'quan_ly_phi',
        'phucap_congtac_dang',
        'luong_tang_them',
        'phucap_thamnien_vuotkhung',
        'phucap_khac',
        //'tienthuong',
        //'thunhap_tangthem',
        'tien_giang',
        'tiencong_nckh',
        'phuc_loi',
        'luongthang_muoi_ba',
        'thunhap_khac',
        'tong_cackhoan_tinhthue',
        'phucap_thamnien_nghe',
        'phucap_uudai_nghe',
        'tongcackhoan_khongtinhthue',
        'baohiem_thatnghiep_truvaoluong',
        'baohiem_xahoi_truvaoluong',
        'baohiem_yte_truvaoluong',
        'kinhphi_congdoan_truvaoluong',
        'tongtien_giamtru_nguoiphuthuoc',
        'giamtru_banthan',
        'tong_cackhoan_giamtru',
        'tong_thunhap_tinhthue',
        'thue_TNCN',
        'chiphiphatsinhkhac',
        'sendMail'
    ];
    
    public $timestamps = false;

}
