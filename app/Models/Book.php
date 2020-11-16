<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table= 'book';
    protected $fillable = [
        'type',
        'name',
        'role',
        'user_id'
    ];
    
    public $timestamps = false;

    public function scopeGetList($query) {
        return $query->select('book.*')->orderBy('name', 'ASC');
    }
}
