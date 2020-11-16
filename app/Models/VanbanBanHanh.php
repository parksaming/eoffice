<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VanbanBanHanh extends Model
{
    protected $table= 'vanban_banhanhs';

    protected $fillable = [
        'name',
        'thoigian_banhanh',
        'file',
        'coquan_banhanh_id',
        'donvi_nhan_id',
        'user_nhan_ids',
        'status',
        'created_by'
    ];

    /* Declare values */

    /* Relationships */
    public function donviNhan() {
        return $this->belongsTo(Donvi::class, 'donvi_nhan_id');
    }

    public function donviBanhanh() {
        return $this->belongsTo(Donvi::class, 'coquan_banhanh_id');
    }

    /* Accessors */
    public function getThoigianBanhanhDisplayAttribute() {
        return $this->thoigian_banhanh? date('d/m/Y H:i', strtotime($this->thoigian_banhanh)) : '';
    }

    public function getThoigianBanhanhInputAttribute() {
        return $this->thoigian_banhanh? date('d-m-Y H:i', strtotime($this->thoigian_banhanh)) : '';
    }

    public function getUserNhanIdsArrAttribute() {
        return (!$this->user_nhan_ids || $this->user_nhan_ids == ';;')? [] : explode(';', trim($this->user_nhan_ids, ';'));
    }

    /* Local scope */
    public function scopeGetDanhSach($query, array $option = []) {
        $userId = $option['user_id'];
        $donviId = $option['donvi_id'];

        $query->select('vanban_banhanhs.*')
              ->with('donviNhan', 'donviBanhanh')
              ->orderBy('vanban_banhanhs.id', 'DESC');

        // get danh sách vanbanbanhanh theo loại: gửi - nhận
        if (!isset($option['type']) || $option['type'] == 'nhanvanban') {
            // nhận văn bản: user có nhận mới hiển thị
            $query->where('vanban_banhanhs.user_nhan_ids','LIKE', '%;'.$userId.';%');
        }
        else {
            // gửi văn bản: tất cả users của đơn vị gửi sẽ thấy
            $query->where('vanban_banhanhs.coquan_banhanh_id', $donviId);
        }
        
        // search
        if (isset($option['tukhoa']) && $option['tukhoa']) {
            $query->where('vanban_banhanhs.name', 'like', '%'.$option['tukhoa'].'%');
        }

        if (isset($option['ngaybanhanhtu']) && $option['ngaybanhanhtu']) {
            $query->where('vanban_banhanhs.thoigian_banhanh', '>=', $option['ngaybanhanhtu'].' 00:00:00');
        }

        if (isset($option['ngaybanhanhden']) && $option['ngaybanhanhden']) {
            $query->where('vanban_banhanhs.thoigian_banhanh', '<=', $option['ngaybanhanhden'].' 23:59:59');
        }

        return $query;
    }
}
