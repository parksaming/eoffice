<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarningType extends Model
{
    protected $table = 'WarningTypes';
    
    public $timestamps = false;

    protected $fillable = [
        'nameVI',
        'nameEN',
        'note',
        'status'
    ];
}
