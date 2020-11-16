<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ButpheDonvi extends Model
{
    protected $table= 'butphes_donvi';
    protected $fillable = [
        'vanban_id',
        'noidung',
        'receiver_ids',
        'created_by'
    ];

    /* Declare values */

    /* Relationships */
    public function userTao() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getReceiverIdsArrAttribute() {
        return ($this->receiver_ids == ';;')? [] : explode(';', trim($this->receiver_ids, ';'));
    }
    
    /* Accessors */
    public function getCreatedAtTextAttribute() {
        return $this->created_at? date('d/m/Y H:i', strtotime($this->created_at)) : '';
    }

    /* Local scope */
    public function scopeSelectColumns($query) {
        return $query->select(
            'butphes_donvi.id',
            'butphes_donvi.vanban_id',
            'butphes_donvi.noidung',
            'butphes_donvi.receiver_ids',
            'butphes_donvi.created_by',
            'butphes_donvi.created_at'
        );
    }

    public function scopeGetList($query, $vanbanId) {
        return $query->selectColumns()->with('userTao')
        ->where('butphes_donvi.vanban_id', $vanbanId)
        ->orderBy('butphes_donvi.id', 'ASC');
    }
}
