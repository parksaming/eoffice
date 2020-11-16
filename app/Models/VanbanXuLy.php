<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VanbanXuLy extends Model
{
    protected $table= 'vanban_xulys';
    protected $fillable = [
        'parent_id',
        'vanbanUser_id', // id vanban
        'id_nhan',       // id user nhận
        'ngaychuyentiep',
        'user_tao',
        'noidung_butphe',
        'status',
        'ngayxuly',
        'ngayxem',
        'is_trinhlanhdao',
        'noidung_trinh',
        'type',
        'is_chuyentiep',
        'butphe_id',
        'minhchung',
        'file_minhchung',
        'donvi_nhan_id', // id don vi nhan (don vi cua user luc nhan vb)
        'loaivanban'
    ];

    public $timestamps = false;

    /* Declare values */
    public static $status = [
        'chuaxuly'  => 1,
        'dangxuly'  => 2,
        'daxuly'    => 3
    ];

    public static $type = [
        'chutri'    => 1,
        'phoihop'   => 2
    ];

    /* Relationships */
    public function userNhanVanBan() {
        return $this->belongsTo(User::class, 'id_nhan');
    }

    public function userGuiVanBan() {
        return $this->belongsTo(User::class, 'user_tao');
    }

    public function vanban() {
        return $this->belongsTo(Vanban::class, 'vanbanUser_id');
    }

    public function children() {
        return $this->hasMany(VanbanXuLy::class, 'parent_id', 'id');
    }

    public function notifications() {
        return $this->morphMany(Notification::class, 'notificationable');
    }

    /* Accessors */
    public function getNgaychuyentiepViewAttribute() {
        return $this->ngaychuyentiep? date('d/m/Y H:i', strtotime($this->ngaychuyentiep)) : '';
    }

    /* Local scope */
    public function scopeSelectColumns($query) {
        return $query->select(
            'vanban_xulys.id',
            'vanban_xulys.vanbanUser_id',
            'vanban_xulys.ngaychuyentiep',
            'vanban_xulys.id_nhan',
            'vanban_xulys.user_tao',
            'vanban_xulys.noidung_butphe',
            'vanban_xulys.status',
            'vanban_xulys.ngayxuly',
            'vanban_xulys.ngayxem',
            'vanban_xulys.parent_id',
            'vanban_xulys.noidung_trinh',
            'vanban_xulys.is_chuyentiep'
        );
    }

    public function scopeGetDanhSachDen($query, $userId, $status = 'all', array $options = []) {
        $curDate = (new \DateTime('now', new \DateTimeZone('Asia/Ho_Chi_Minh')))->format('Y'.'-01-01');
        $query->selectColumns()->with([
                    'vanban' => function ($q) {
                        $q->selectColumnsInWith();
                    },
                    'userGuiVanBan' => function ($q) {
                        $q->selectColumnsInWith();
                    },
                    'children' => function ($q) {
                        $q->select('vanban_xulys.id','vanban_xulys.is_chuyentiep', 'vanban_xulys.id_nhan', 'vanban_xulys.parent_id')->with([
                            'userNhanVanBan' => function ($q) {
                                $q->selectColumnsInWith();
                            }
                        ])->isTrinhLanhDao();
                    },
                ])
                ->join('vanbans', 'vanbans.id', '=', 'vanban_xulys.vanbanUser_id')
                ->where('vanbans.book_id', 1);

        if($status == 'ganhethan'){
            $query->where('vanban_xulys.is_chuyentiep', '=',0);
            $query->where('vanban_xulys.status', '<>',3);
            $query->where(function ($q) use ($userId) {
                $q->where('vanbans.usernhan', 'like', '%;'.$userId.';%')
                    ->orWhere('vanbans.userphoihop_ids', 'like', '%;'.$userId.';%')
                    ->orWhere('vanban_xulys.user_tao', '=', $userId);
                $q->whereNotNull('vanbans.hanxuly')
                    ->whereRaw('vanbans.hanxuly <> ""');
            });
            $query->whereBetween(\DB::raw("STR_TO_DATE(vanbans.hanxuly,'%Y-%m-%d')"),array($curDate, date('Y-m-d', strtotime( date('Y-m-d'). ' + 3 days'))));
        }else {
            $query->where('vanban_xulys.id_nhan', $userId);
            $query->whereStatus($status);
        }
        $query->orderBy('vanbans.ngayden', 'DESC')
            ->orderBy('vanbans.soden', 'DESC')
            ->orderByRaw('cast(soden as unsigned) DESC');
        // search
        if (isset($options['tukhoa']) && $options['tukhoa']) {
            $query->where(function ($q) use ($options) {
                $q->where('title', 'like', '%'.$options['tukhoa'].'%')
                  ->orWhere('kyhieu', 'like', '%'.$options['tukhoa'].'%')
                  ->orWhere('soden', 'like', '%'.$options['tukhoa'].'%');
            });
        }
        if  (isset($options['loaivanban']) && $options['loaivanban'] > 0) {
            $query->where('loaivanban_id', $options['loaivanban']);
        }
        if  (isset($options['linhvuc']) && $options['linhvuc'] > 0) {
            $query->where('linhvuc_id', $options['linhvuc']);
        }
        if (!empty($options['ngaybanhanhtu'])) {
            $query->where('ngayky', '>=', date('Y-m-d', strtotime($options['ngaybanhanhtu'])));
        }
        if (!empty($options['ngaybanhanhden'])) {
            $query->where('ngayky', '<=', date('Y-m-d', strtotime($options['ngaybanhanhden'])));
        }
        if (!empty($options['ngayguitu'])) {
            $query->where('ngaygui', '>=', date('Y-m-d', strtotime($options['ngayguitu'])));
        }
        if (!empty($options['ngayguiden'])) {
            $query->where('ngaygui', '<=', date('Y-m-d', strtotime($options['ngayguiden'])));
        }
        return $query;

    }
    public function scopeGetDanhSachVBGanHetHan($query,$userId, $status)
    {
        $curDate = (new \DateTime('now', new \DateTimeZone('Asia/Ho_Chi_Minh')))->format('Y'.'-01-01');
        $query->selectColumns()->with([
            'vanban' => function ($q) {
                $q->selectColumnsInWith();
            },
            'userGuiVanBan' => function ($q) {
                $q->selectColumnsInWith();
            },
            'children' => function ($q) {
                $q->select('vanban_xulys.id','vanban_xulys.is_chuyentiep', 'vanban_xulys.id_nhan', 'vanban_xulys.parent_id')->with([
                    'userNhanVanBan' => function ($q) {
                        $q->selectColumnsInWith();
                    }
                ])->isTrinhLanhDao();
            },
        ])
            ->join('vanbans', 'vanbans.id', '=', 'vanban_xulys.vanbanUser_id')
            ->where('vanbans.book_id', 1);


        $query->where('vanban_xulys.is_chuyentiep', '=',0);
        $query->where('vanban_xulys.status', '<>',3);
        $query->where(function ($q) use ($userId) {
            $q->where('vanbans.usernhan', 'like', '%;'.$userId.';%')
                ->orWhere('vanbans.userphoihop_ids', 'like', '%;'.$userId.';%')
                ->orWhere('vanban_xulys.user_tao', '=', $userId);
            $q->whereNotNull('vanbans.hanxuly')
                ->whereRaw('vanbans.hanxuly <> ""');
        });
        $query->whereBetween(\DB::raw("STR_TO_DATE(vanbans.hanxuly,'%Y-%m-%d')"),array($curDate, date('Y-m-d', strtotime( date('Y-m-d'). ' + 3 days'))));
        $query->orderBy('vanbans.ngayden', 'DESC')
            ->orderBy('vanbans.soden', 'DESC')
            ->orderByRaw('cast(soden as unsigned) DESC');
        // search
        return $query;
    }

    public function scopeGetVBDenNew($query, $userId) {
        return $query->select('vanban_xulys.id', 'vanban_xulys.vanbanUser_id')
                ->whereHas('vanban', function ($q) {
                    $q->where('vanbans.book_id', 1);
                })
                ->where('vanban_xulys.id_nhan', $userId)
                ->whereNull('ngayxem');
    }

    public function scopeGetVBNoiboNew($query, $userId) {
        return $query->select('vanban_xulys.id', 'vanban_xulys.vanbanUser_id')
                ->whereHas('vanban', function ($q) {
                    $q->where('vanbans.book_id', 4);
                })
                ->where('vanban_xulys.id_nhan', $userId)
                ->whereNull('ngayxem');
    }

    public function scopeGetDanhSachNoiBo($query, $userId, $status = 'all', array $options = []) {
        $query->selectColumns()->with([
                    'vanban' => function ($q) {
                        $q->selectColumnsInWith();
                    },
                    'userGuiVanBan' => function ($q) {
                        $q->selectColumnsInWith();
                    },
                    'children' => function ($q) {
                        $q->select('vanban_xulys.id', 'vanban_xulys.id_nhan', 'vanban_xulys.parent_id')->with([
                            'userNhanVanBan' => function ($q) {
                                $q->selectColumnsInWith();
                            }
                        ])->isTrinhLanhDao();
                    },
                ])
                ->join('vanbans', 'vanbans.id', '=', 'vanban_xulys.vanbanUser_id')
                ->where('vanbans.book_id', 4)
                ->where('vanban_xulys.id_nhan', $userId)
                ->whereStatus($status)
                ->orderBy('vanbans.soden', 'DESC');

        // search
        if (isset($options['tukhoa']) && $options['tukhoa']) {
            $query->where(function ($q) use ($options) {
                $q->where('title', 'like', '%'.$options['tukhoa'].'%')
                  ->orWhere('kyhieu', 'like', '%'.$options['tukhoa'].'%');
            });
        }
        if (isset($options['noibanhanh']) && $options['noibanhanh']) {
            $query->where('cq_banhanh', 'like', '%'.$options['noibanhanh'].'%');
        }
        if  (isset($options['loaivanban']) && $options['loaivanban'] > 0) {
            $query->where('loaivanban_id', $options['loaivanban']);
        }
        if  (isset($options['linhvuc']) && $options['linhvuc'] > 0) {
            $query->where('linhvuc_id', $options['linhvuc']);
        }
        if (!empty($options['ngaybanhanhtu'])) {
            $query->where('ngayky', '>=', $options['ngaybanhanhtu']);
        }
        if (!empty($options['ngaybanhanhden'])) {
            $query->where('ngayky', '<=', $options['ngaybanhanhden']);
        }
        if (!empty($options['ngayguitu'])) {
            $query->where('ngaygui', '>=' ,$options['ngayguitu']);
        }
        if (!empty($options['ngayguiden'])) {
            $query->where('ngaygui', '<=' ,$options['ngayguiden']);
        }
		
        return $query;
    }

    // lấy ds văn bản nội bộ đã gửi theo đơn vị (cùng đơn vị thì thấy được văn bản nội bộ đã gửi)
    public function scopeGetDanhSachNoiBoGui($query, $donviId, $status = 'all', array $options = []) {
        $query->selectColumns()->with([
                    'vanban' => function ($q) {
                        $q->selectColumnsInWith();
                    },
                    'userGuiVanBan',
                    'children' => function ($q) {
                        $q->select('vanban_xulys.id', 'vanban_xulys.id_nhan', 'vanban_xulys.parent_id')->with([
                            'userNhanVanBan' => function ($q) {
                                $q->selectColumnsInWith();
                            }
                        ])->isTrinhLanhDao();
                    },
                ])
                ->join('vanbans', 'vanbans.id', '=', 'vanban_xulys.vanbanUser_id')
                ->where('vanbans.book_id', 4)
                ->join('users', 'users.id', '=', 'vanbans.user_id')
                ->where('users.donvi_id', $donviId)
                ->where('vanban_xulys.parent_id', 0)
                ->whereStatus($status)
                ->orderBy('vanbans.ngayden', 'DESC');

        // search
        if (isset($options['tukhoa']) && $options['tukhoa']) {
            $query->where(function ($q) use ($options) {
                $q->where('title', 'like', '%'.$options['tukhoa'].'%')
                  ->orWhere('kyhieu', 'like', '%'.$options['tukhoa'].'%');
            });
        }
        if (isset($options['noibanhanh']) && $options['noibanhanh']) {
            $query->where('cq_banhanh', 'like', '%'.$options['noibanhanh'].'%');
        }
        if  (isset($options['loaivanban']) && $options['loaivanban'] > 0) {
            $query->where('loaivanban_id', $options['loaivanban']);
        }
        if  (isset($options['linhvuc']) && $options['linhvuc'] > 0) {
            $query->where('linhvuc_id', $options['linhvuc']);
        }
        if (!empty($options['ngaybanhanhtu'])) {
            $query->where('ngayky', '>=', date('Y-m-d', strtotime($options['ngaybanhanhtu'])));
        }
        if (!empty($options['ngaybanhanhden'])) {
            $query->where('ngayky', '<=', date('Y-m-d', strtotime($options['ngaybanhanhden'])));
        }
        if (!empty($options['ngayguitu'])) {
            $query->where('ngaygui', '>=', date('Y-m-d', strtotime($options['ngayguitu'])));
        }
        if (!empty($options['ngayguiden'])) {
            $query->where('ngaygui', '<=', date('Y-m-d', strtotime($options['ngayguiden'])));
        }
		
        return $query;
    }

    public function scopeGetDanhSachNoiBoNhan($query, $userId, $status = 'all', array $options = []) {
        $query->selectColumns()->with([
                    'vanban' => function ($q) {
                        $q->selectColumnsInWith();
                    },
                    'userGuiVanBan',
                    'children' => function ($q) {
                        $q->select('vanban_xulys.id', 'vanban_xulys.id_nhan', 'vanban_xulys.parent_id')->with([
                            'userNhanVanBan' => function ($q) {
                                $q->selectColumnsInWith();
                            }
                        ])->isTrinhLanhDao();
                    },
                ])
                ->join('vanbans', 'vanbans.id', '=', 'vanban_xulys.vanbanUser_id')
                ->where('vanbans.book_id', 4)
                ->where('vanban_xulys.id_nhan', $userId)
                ->where('vanban_xulys.parent_id', '>', 0)
                ->whereStatus($status)
                ->orderBy('vanbans.ngayden', 'DESC');

        // search
        if (isset($options['tukhoa']) && $options['tukhoa']) {
            $query->where(function ($q) use ($options) {
                $q->where('title', 'like', '%'.$options['tukhoa'].'%')
                  ->orWhere('kyhieu', 'like', '%'.$options['tukhoa'].'%');
            });
        }
        if (isset($options['noibanhanh']) && $options['noibanhanh']) {
            $query->where('cq_banhanh', 'like', '%'.$options['noibanhanh'].'%');
        }
        if  (isset($options['loaivanban']) && $options['loaivanban'] > 0) {
            $query->where('loaivanban_id', $options['loaivanban']);
        }
        if  (isset($options['linhvuc']) && $options['linhvuc'] > 0) {
            $query->where('linhvuc_id', $options['linhvuc']);
        }
        if (!empty($options['ngaybanhanhtu'])) {
            $query->where('ngayky', '>=', date('Y-m-d', strtotime($options['ngaybanhanhtu'])));
        }
        if (!empty($options['ngaybanhanhden'])) {
            $query->where('ngayky', '<=', date('Y-m-d', strtotime($options['ngaybanhanhden'])));
        }
        if (!empty($options['ngayguitu'])) {
            $query->where('ngaygui', '>=', date('Y-m-d', strtotime($options['ngayguitu'])));
        }
        if (!empty($options['ngayguiden'])) {
            $query->where('ngaygui', '<=', date('Y-m-d', strtotime($options['ngayguiden'])));
        }
		
        return $query;
    }

    public function scopeWhereStatus($query, $status) {
        if (empty($status) || $status == 'all') {
            return $query;
        } else {
            if (isset(VanbanXuLy::$status[$status])) {
                return $query->where('vanban_xulys.status', '=', VanbanXuLy::$status[$status]);
            }

            return $query; 
        }
    }

    public function scopeIsTrinhLanhDao($query) {
        return $query->where('is_trinhlanhdao', 1);
    }

    public function scopeGetVanBanXuLy($query, $vanbanxylyId) {
        return  $query->selectColumns()->with([
                    'vanban' => function ($q) {
                        $q->selectColumnsInWith();
                    },
                    'userGuiVanBan' => function ($q) {
                        $q->selectColumnsInWith();
                    },
                    'userNhanVanBan' => function ($q) {
                        $q->selectColumnsInWith();
                    },
                    'children' => function ($q) {
                        $q->selectColumns()->with([
                            'vanban' => function ($q) {
                                $q->selectColumnsInWith();
                            },
                            'userNhanVanBan' => function ($q) {
                                $q->selectColumnsInWith();
                            },
                            'userGuiVanBan' => function ($q) {
                                $q->selectColumnsInWith();
                            }
                        ])->isTrinhLanhDao();
                    },
                ])
                ->where('vanban_xulys.id', $vanbanxylyId);
    }

    public function scopeGetVanBanXuLyRoot($query, $vanbanId) {
        return $query->selectColumns()
                     ->where('vanban_xulys.parent_id', 0)
                     ->where('vanban_xulys.vanbanUser_id', $vanbanId);
    }

    public function scopeGetVanBanXuLyChuaXem($query, $vanbanxulyRootId) {
        return $query->selectColumns()
                     ->where('vanban_xulys.parent_id', $vanbanxulyRootId)
                     ->whereNull('vanban_xulys.ngayxem');
    }

    /* static function */
    public static function getChildrenIds($parent) {
        $childrendIds = [];
        
        foreach ($parent->children as $ele) {
            $childrendIds[] = $ele->id;

            $childrendIds = array_merge($childrendIds, VanbanXuLy::getChildrenIds($ele));
        }
        
        return $childrendIds;
    }
}
