<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'creator_id',
        'receivor_id',
        'type',
        'content',
        'read_at',
        'notificationable_id',
        'notificationable_type'
    ];

    /* Declare values */
    public static $types = [
        'nhanvanbanmoi' => 1,
        'nhanvanbanchuyenxuly' => 2,
        'capnhattrangthaivanban' => 3,
        'nhancongviecmoi' => 4,
        'nhanbaocaocongviec' => 5,
        'nhandangkylichtuan' => 6,
        'dangkylichtuandaduocduyet' => 7,
        'dangkylichtuandabituchoi' => 8,
        'nhanvanbannoibo' => 9,
        'nhanvanbannoibochuyenxuly' => 10,
        'nhanvanbanmoi_donvi' => 11,
        'nhanvanbanchuyenxuly_donvi' => 12,
        'capnhattrangthaivanban_donvi' => 13,
        'nhantraodoicongviec_vanbanden' => 14,
        'nhantraodoicongviec_vanbannoibo' => 15,
        'nhantraodoicongviec_vanbandonvi' => 16
    ];

    /* Relationships */
    public function notificationable() {
        return $this->morphTo();
    }

    public function creator() {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /* Accessors */ 

    /* Local scope */
    public function scopeSelectColumns($query) {
        return $query->select(
            'notifications.id',
            'notifications.creator_id',
            'notifications.type',
            'notifications.content',
            'notifications.read_at',
            'notifications.notificationable_id',
            'notifications.notificationable_type',
            'notifications.created_at'
        );
    }

    public function scopeListNotifications($query, $userId) {
        return  $query->selectColumns()
                      ->where('notifications.receivor_id', $userId)
                      ->orderBy('notifications.created_at', 'DESC');
    }

    public function scopeListUnReadNotifications($query, $userId) {
        return  $query->selectColumns()
                      ->whereNull('notifications.read_at')
                      ->where('notifications.receivor_id', $userId);
    }
}
