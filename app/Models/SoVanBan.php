<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoVanBan extends Model
{
    protected $table = 'sovanbans';
    
    protected $fillable = [
        'type',
        'name',
        'description',
        'donvi_id',
        'status',
        'created_by'
    ];

    public static $types = [
        'vanbanden' => 1,
        'vanbandi' => 2
    ];
    
    public static $statuses = [
        'active' => 1,
        'deactive' => 0
    ];

    public function donvi() {
        return $this->belongsTo(Donvi::class);
    }

    public function vanbans() {
        return $this->hasMany(Vanban::class, 'sovanban_id');
    }

    public function getTypeVanBanAttribute() {
        return ($this->type == SoVanBan::$types['vanbanden'])? 'Văn bản đến' : 'Văn bản đi';
    }

    public function scopeSelectColumns($query) {
        return $query->select(
            'sovanbans.id',
            'sovanbans.type',
            'sovanbans.name',
            'sovanbans.description',
            'sovanbans.donvi_id',
            'sovanbans.status',
            'sovanbans.status'
        );
    }

    public function scopeActive($query) {
        return $query->where('sovanbans.status', SoVanBan::$statuses['active']);
    }

    public function scopeVanBanDen($query) {
        return $query->where('sovanbans.type', SoVanBan::$types['vanbanden']);
    }

    public function scopeVanBanDi($query) {
        return $query->where('sovanbans.type', SoVanBan::$types['vanbandi']);
    }

    public function scopeGetDanhSach($query) {
        return $query->selectColumns('sovanbans.*')->orderBy('name', 'ASC');
    }

    public function scopeGetDanhSachSoVanBanDen($query, $donviId) {
        return $query->getDanhSach($donviId)->vanBanDen()->active();
    }
}
