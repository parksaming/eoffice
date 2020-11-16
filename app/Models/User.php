<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'role',
        'macanbo',
        'username',
        'fullname',
        'firstname',
        'lastname',
        'password',
        'tochuc',
        'hocham_id',
        'hocvi_id',
        'donvi_id',
        'gioitinh',
        'birthday',
        'address',
        'city_id',
        'phone',
        'mobile',
        'fax',
        'email',
        'created',
        'modified',
        'avatar',
        'lastvisitdata',
        'actived',
        'lastlogin',
        'ordering',
        'lanhdao',
        'dinhdanh',
        'cf_email_congvan',
        'cf_email_baocao',
        'cf_email_totrinh',
        'cf_email_tinnhan',
        'cf_email_congviec',
        'cf_sms_congvan',
        'cf_sms_baocao',
        'cf_sms_totrinh',
        'cf_sms_tinnhan',
        'cf_sms_congviec',
        'group_id',
        'delete',
        'function',
        'received',
        'truong',
        'ou',
        'image',
        'user_id',
        'activated_id',
        'azure_id',
        'updated_at',
        'sso_id',
        'chucdanh',
        'duyetlichtuan',
        'vanthudonvi',
        'view_thongke'
    ];

    public $timestamps = false;

    protected $hidden = [
        'password', 'remember_token',
    ];

    /* Declare values */
    public static $roles = [
        'vanthu' => 1,
        'chuyenvien' => 2,
        'lanhdao' => 3,
        'admin' => 4,
        'manager' => 5
    ];

    /* Relationships */
    public function donvi() {
        return $this->belongsTo(Donvi::class, 'donvi_id');
    }

    public function ykiens() {
        return $this->belongsToMany(Ykien::class)->withTimestamps()->withPivot('read_at');
    }

    public function ykiendonvis() {
        return $this->belongsToMany(Ykien::class, 'user_ykien_donvi')->withTimestamps()->withPivot('read_at');
    }

    /* Accessors */
    public function getRoleTextAttribute() {
        switch($this->role) {
            case 1: return 'Văn thư';
            case 2: return 'Chuyên viên';
            case 3: return 'Lãnh đạo';
            case 4: return 'Admin';
            case 5: return 'Manager';
            default: return '';
        }
    }

    /* Local scope */
    public function scopeActive($query) {
        return $query->where('users.actived', 1);
    }

    public function scopeGetList($query) {
        return $query->select('users.*')->with('donvi')->active()->orderBy('users.id', 'ASC');
    }

    public function scopeGetListLanhDao($query) {
        return $query->select('users.*')->withDonVi()->active()->where('users.role', User::$roles['lanhdao'])->orderBy('users.id', 'ASC');
    }

    public function scopeGetListDuyetDangKyLichTuan($query) {
        return $query->select('users.*')->active()->where('users.duyetlichtuan', 1);
    }

    public function scopeWithDonVi($query) {
        return $query->join('donvis', 'donvis.id', '=', 'users.donvi_id')
            ->addSelect('donvis.name as donvi_name', 'donvis.viettat as donvi_viettat');
    }

    public function scopeSelectColumnsInWith($query) {
        return $query->select(
            'users.id',
            'users.username',
            'users.fullname'
        );
    }
}
