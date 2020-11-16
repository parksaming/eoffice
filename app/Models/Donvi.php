<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donvi extends Model
{
    public $table = 'donvis';

    public function children() {
        return $this->hasMany(Donvi::class, 'parent_id');
    }

    public function scopeActive($query) {
        return $query->where('donvis.actived', 1);
    }

    public function scopeGetList($query) {
        return $query->select('donvis.*')->active();
    }

    public function scopeSelectColumnsInWith($query) {
        return $query->select(
            'donvis.id',
            'donvis.name',
            'donvis.viettat',
            'donvis.madonvi'
        );
    }
}