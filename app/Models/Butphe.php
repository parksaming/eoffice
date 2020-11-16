<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Butphe extends Model
{
    protected $table= 'butphes';
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
            'butphes.id',
            'butphes.vanban_id',
            'butphes.noidung',
            'butphes.receiver_ids',
            'butphes.created_by',
            'butphes.created_at'
        );
    }

    public function scopeGetList($query, $vanbanId) {
        return $query->selectColumns()->with('userTao')
        ->where('butphes.vanban_id', $vanbanId)
        ->orderBy('butphes.id', 'ASC');
    }
}
