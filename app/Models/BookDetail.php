<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookDetail extends Model
{
    protected $table= "book_detail";
    protected $fillable = [
        'book_id',
        'donvi_id',
        'donvi_email',
        'user_id',
        'ordering'
    ];

    public $timestamps = false;

    public function donvi() {
        return $this->belongsTo(Donvi::class, 'donvi_id');
    }

    public function getUserIdsAttribute() {
        return ($this->user_id == ';;')? [] : explode(';', trim($this->user_id, ';'));
    }

    public function getEmailsAttribute() {
        return ($this->donvi_email == ';;')? [] : explode(';', trim($this->donvi_email, ';'));
    }

    public function scopeGetList($query, $bookId) {
        return $query->select(
            'book_detail.*',
            'donvis.viettat as donviTenVT',
            'donvis.name as donviName',
            'donvis.id as donviId',
            'book.type as bookType',
            'book.name as bookName'
        )
        ->leftJoin('donvis', 'book_detail.donvi_id', '=', 'donvis.id')
        ->leftJoin('book', 'book_detail.book_id', '=', 'book.id')
        ->where('book_id', $bookId);
    }

    public function scopeGetDanhSachCoQuanCVanDen($query) {
        return $query->with([
            'donvi' => function ($q) {
                $q->selectColumnsInWith();
            }
        ])
        ->where('book_id', 1);
    }
}
