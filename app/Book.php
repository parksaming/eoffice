<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Book extends Model
{
    public $table= "book";
    public $timestamps = false;
    protected $fillable = [
        'type',
        'name',
        'role',
        'user_id'

    ];
}
