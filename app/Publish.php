<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Publish extends Model
{
    public $table = 'publish';
    public $timestamps = false;

    public function vanban()
    {
        return $this->belongsTo('App\Vanban');
    }
}