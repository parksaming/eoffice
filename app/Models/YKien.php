<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ykien extends Model
{
    protected $table= 'ykiens';
    protected $fillable = [
        'vanban_id',
        'noidung',
        'file',
        'created_by'
    ];

    /* Declare values */

    /* Relationships */
    public function userTao() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function userNhans() {
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot('read_at');
    }

    /* Accessors */
    public function getCreatedAtAttribute($value) {
        return $value? date('d/m/Y H:i', strtotime($value)) : '';
    }

    public function getUserNhansViewAttribute() {
        $str = '';
        foreach($this->userNhans as $userNhan) {
            $str .= sprintf(
                '<div class="usernhands">
                    <span class="usernhands-name">%s - %s - %s</span>
                    <span class="usernhands-read">%s</span>
                </div>', $userNhan->fullname, $userNhan->chucdanh, $userNhan->email, $userNhan->pivot->read_at? date('d/m/Y H:i', strtotime($userNhan->pivot->read_at)) : ''
            );
        }

        return '<div>'.$str.'</div>';
    }

    public function getUserNhansViewShortTextAttribute() {
        $loggedUser = (object) session('user');

        $str = '';
        if ($this->created_by == $loggedUser->id) {
            $i = 0;
            foreach($this->userNhans as $userNhan) {
                $str .= sprintf('<span class="usernhan-name">%s</span>', $userNhan->fullname);
                
                if (++$i == 2) {
                    break;
                }
            }
        }
        else {
            $str = sprintf('<span class="usernhan-name">%s</span>', $loggedUser->fullname);

            foreach($this->userNhans as $userNhan) {
                if ($userNhan->id != $loggedUser->id) {
                    $str .= sprintf('<span class="usernhan-name">%s</span>', $userNhan->fullname);
                    break;
                }
            }
        }

        if (sizeof($this->userNhans) > 2) {
            $str .= '<span class="three-dot">...</span>';
        }

        return '<div>'.$str.'</div>';
    }

    /* Local scope */
    public function scopeSelectColumns($query) {
        return $query->select(
            'ykiens.id',
            'ykiens.vanban_id',
            'ykiens.noidung',
            'ykiens.file',
            'ykiens.created_by',
            'ykiens.created_at'
        );
    }

    public function scopeSelectColumnsInWith($query) {
        return $query->selectColumns()->with([
            'userTao' => function ($q) {
                $q->selectColumnsInWith();
            }
        ]);
    }

    public function scopeGetList($query, $vanbanId, $userId) {
        return $query->with('userTao', 'userNhans')
                ->where('ykiens.vanban_id', $vanbanId)
                ->where(function($q) use($userId) {
                    $q->where('created_by', $userId)
                      ->orWhereHas('userNhans', function ($q2) use ($userId) {
                        $q2->where('user_id', $userId);
                      });
                })
                ->orderBy('id', 'DESC');
    }

    public function scopeGetListNhanChuaDoc($query, $userId) {
        return $query->where('receiver_id', $userId);
    }
}
