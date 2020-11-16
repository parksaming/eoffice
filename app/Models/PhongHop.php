<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class PhongHop extends Model
{
    protected $table= 'phonghop_danhsach';
    protected $fillable = [
        'tenphonghop',
        'diadiem',
        'succhua',
        'dientich',
        'thietbi',
        'sothutu',
        'sudung',
        'status'
    ];
    
    public function scopeSelectColumns($query) {
        return $query->select(
            'phonghop_danhsach.id',
            'phonghop_danhsach.tenphonghop',
            'phonghop_danhsach.diadiem',
            'phonghop_danhsach.succhua',
            'phonghop_danhsach.dientich',
            'phonghop_danhsach.thietbi',
            'phonghop_danhsach.sothutu',
            'phonghop_danhsach.sudung',
            'phonghop_danhsach.status'
        );
    }

    public function scopeGetDanhSachPhongHop($query) {
         return $query->selectColumns('phonghop_danhsach.*')->orderBy('tenphonghop', 'ASC');
    }
}
