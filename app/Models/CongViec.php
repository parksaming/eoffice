<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CongViec extends Model
{
	protected $table = 'congviecs'; 
	protected $fillable = [
        'tencongviec',
        'tinhchat_id',
		'tinhchat',
		'ngaybatdau',
        'ngayketthuc',
		'user_username',
		'ngaygiao',
        'noidung',
		'trangthai',
		'user_id',
        'mucdohoanthanh',
		'ngaycapnhat',
		'created',
		'vanbanchidao',
		'parent_id',
		'bao',
		'macongviec',
		'nguoigiamsat',
		'vanban_id',
		'vanban_donvi_id',
		'vanbanxuly_id',
		'vanbanxuly_donvi_id',
		'nguoiphoihop'
	];
	
	/* Declare values */
	public static $trangthai = [
        'dangthuchien' => 0,
        'dahoanthanh' => 1,
        'tamdung' => 2,
        'huybo' => 3
	];
	
	/* Relationships */
	public function congviecChitiet() {
		return $this->hasMany(CongviecChiTiet::class, 'congviec_id', 'id');
	}

	public function tinhchat() {
   		return $this->belongsTo('App\TinhChat');
   	}

   	public function congviecMessage() {
   		return $this->hasMany(CongviecMessage::class, 'congviec_id', 'id');
   	}

   	public function congviecFile() {
   		return $this->hasMany(CongviecFile::class, 'congviec_id', 'id');
   	}

   	public function congviecBaocao() {
   		return $this->hasManyThrough(Congviec_Baocao::class, CongviecChiTiet::class, 'congviec_id', 'congviec_user_id', 'id', 'id');
	}

	public function vanban() {
		return $this->belongsTo(Vanban::class, 'vanban_id');
	}

	public function vanbandonvi() {
		return $this->belongsTo(VanbanDonvi::class, 'vanban_donvi_id');
	}

	public function vanbanxuly() {
		return $this->belongsTo(VanbanXuLy::class, 'vanbanxuly_id');
	}

	public function vanbanxulydonvi() {
		return $this->belongsTo(VanbanXuLyDonvi::class, 'vanbanxuly_donvi_id');
	}
	
	public function notifications() {
        return $this->morphMany(Notification::class, 'notificationable');
	}
	
	/* Accessors */
	public function getTrangthaiTextAttribute() {
        switch($this->trangthai) {
			case CongViec::$trangthai['dangthuchien']:
				return 'Đang thực hiện';
			case CongViec::$trangthai['dahoanthanh']:
				return 'Đã hoàn thành';
			case CongViec::$trangthai['tamdung']:
				return 'Tạm dừng';
			case CongViec::$trangthai['huybo']:
				return 'Hủy bỏ';
			default:
				return '';
		}
	}
	
    /* Local scope */
	public function scopeSelectColumns($query) {
        return $query->select(
            'congviecs.id',
            'congviecs.tencongviec',
            'congviecs.tinhchat',
            'congviecs.ngaybatdau',
			'congviecs.ngayketthuc',
			'congviecs.user_id',
			'congviecs.noidung',
			'congviecs.vanban_id',
			'congviecs.vanban_donvi_id',
			'congviecs.trangthai',
			'congviecs.vanbanxuly_id',
			'congviecs.vanbanxuly_donvi_id'
        );
    }

	public function scopeGetDanhSach($query, $userId, $options) {
		$query->selectColumns()->orderBy('congviecs.ngaybatdau', 'DESC');
		
		// get danh sách công việc của user
		$query->where(function ($q) use ($userId, $options) {
			$type = isset($options['type'])? $options['type'] : 'all';

			// các công việc đã giao
			if ($type == 'all' || $type == 'da_giao') {
				$q->orWhere('congviecs.user_id', $userId);
			}

			// các công việc được giao
			if ($type == 'all' || $type == 'duoc_giao') {
				$q->orWhereHas('congviecChitiet', function ($q2) use ($userId) {
					$q2->where('congviec_users.user_id', $userId);
				});
			}
		});

		// get danh sách công việc trong vanban
		if (isset($options['vanban_id']) && $options['vanban_id']) {
			$query->where('congviecs.vanban_id', $options['vanban_id']);
		}

		// get danh sách công việc trong vanbandonvi
		if (isset($options['vanban_donvi_id']) && $options['vanban_donvi_id']) {
			$query->where('congviecs.vanban_donvi_id', $options['vanban_donvi_id']);
		}

		// get theo từ khóa search
		if (isset($options['search']) && !empty($options['search'])) {
			$query->where(function ($query) use ($options) {
				$query->orWhere('congviecs.tencongviec', 'like', '%'.$options['search'].'%')->orWhere('congviecs.noidung', 'like', '%'.$options['search'].'%');
			});
		}

		// get trong ngày date
		if (isset($options['date']) && !empty($options['date'])) {
			$query->where(function ($query) use ($options) {
				$query->orWhere('congviecs.ngaybatdau', 'like', $options['date'])->orWhere('congviecs.ngayketthuc', 'like', $options['date']);
			});
		}

		// get theo trạng thái
		if (isset($options['status']) && $options['status'] !== '') {
			$query->where('trangthai', $options['status']);
		}

		return $query;
    }
}
