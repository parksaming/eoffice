<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publish extends Model
{
    public $table = 'publish';
    public $timestamps = false;

    public function vanban() {
        return $this->belongsTo(Vanban::class);
    }
}