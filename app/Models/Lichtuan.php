<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Lichtuan extends Model
{
    protected $table= 'lichtuans';

    protected $fillable = [
        'nguoidangky',
        'donvi',
        'sodienthoai',
        'email',
        'noidung',
        'type',
        'time',
        'chutri',
        'songuoithamgia',
        'thanhphan',
        'diadiem', // lichtuandaihocdn
        'phonghop_id', // lichtuancoquan
        'created_by',
        'status',
        'thoigiansua',
        'nguoisua_id'
    ];

    public static $status = [
        'choduyet'  => 0,
        'daduyet'   => 1,
        'datuchoi'  => 2
    ];

    public static $type = [
        'lichtuandaihocdn'  => 1,
        'lichtuancoquan'    => 2
    ];

    public function phonghop() {
        return $this->belongsTo(PhongHop::class, 'phonghop_id');
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function notifications() {
        return $this->morphMany(Notification::class, 'notificationable');
    }
    
    public function getNgayAttribute() {
        $timeStamp = strtotime($this->time);
        $date =  getdate($timeStamp);

        $wday = '';
        switch ($date['wday']) {
            case 0: $wday = 'Chủ nhật'; break;
            case 1: $wday = 'Thứ hai'; break;
            case 2: $wday = 'Thứ ba'; break;
            case 3: $wday = 'Thứ tư'; break;
            case 4: $wday = 'Thứ năm'; break;
            case 5: $wday = 'Thứ sáu'; break;
            case 6: $wday = 'Thứ bảy'; break;
        }

        return $wday.'<br>'.date('d/m/Y', $timeStamp);
    }

    public function getNgayExportAttribute() {
        $timeStamp = strtotime($this->time);
        $date =  getdate($timeStamp);

        $wday = '';
        switch ($date['wday']) {
            case 0: $wday = 'Chủ nhật'; break;
            case 1: $wday = 'Hai'; break;
            case 2: $wday = 'Ba'; break;
            case 3: $wday = 'Tư'; break;
            case 4: $wday = 'Năm'; break;
            case 5: $wday = 'Sáu'; break;
            case 6: $wday = 'Bảy'; break;
        }

        return $wday.' - '.date('d/m', $timeStamp);
    }

    public function getGioAttribute() {
        return date('H', strtotime($this->time)).'h'.date('i', strtotime($this->time));
    }

    public function getCreatedAtAttribute($value) {
        return date('d/m/Y', strtotime($value));
    }
    
    public function getThoigiansuaViewAttribute() {
        return $this->thoigiansua? date('d/m/Y H:i', strtotime($this->thoigiansua)) : '';
    }

    public function getTypeTextAttribute() {
        if ($this->type == Lichtuan::$type['lichtuandaihocdn']) {
            return 'Lịch tuần đại học Đà Nẵng';
        }
        else if ($this->type == Lichtuan::$type['lichtuancoquan']) {
            return 'Lịch tuần Cơ quan';
        }
        else {
            return '';
        }
    }

    public function scopeGetDanhSach($query, array $options = []) {
        $query->with([
            'phonghop',
            'creator' => function ($q) {
                $q->selectColumnsInWith();
            }
        ])->orderBy('lichtuans.time', 'ASC');

        if (isset($options['user_id']) && $options['user_id']) {
            $query->where('lichtuans.created_by', $options['user_id']);
        }

        if (isset($options['type']) && $options['type']) {
            $query->where('lichtuans.type', $options['type']);
        }

        if (isset($options['status']) && $options['status'] !== '') {
            $query->where('lichtuans.status', $options['status']);
        }

        if (isset($options['from_date']) && $options['from_date']) {
            $query->where('lichtuans.time', '>=', $options['from_date'].' 00:00:00');
        }

        if (isset($options['to_date']) && $options['to_date']) {
            $query->where('lichtuans.time', '<=', $options['to_date'].' 23:59:59');
        }

        return $query;
    }
}
