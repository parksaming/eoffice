<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vanban extends Model
{
    protected $table= 'vanbans';
    protected $fillable = [
        'user_id',
        'donvi_creator_id',
        'book_id',
        'title',
        'loaivanban_id',
        'ngayden',
        'ngaydi',
        'soden',
        'cq_banhanh',
        'kyhieu',
        'ngayky',
        'linhvuc_id',
        'nguoiky',
        'hanxuly',
        'publish_id',
        'note',
        'status',
        'vanban_file',
        'urgency',
        'content_butphe',
        'ngaygui',
        'file_dinhkem',
        'usernhan',
        'sovanban_id',
        'fullname',
        'donvi_id',
        'donviphoihop_ids',
        'userphoihop_ids',
        'not_have_chutri',
        'is_publish',
        'donvi_nhan_vbdi',
        'file_vbdis',
        'sovb' // số văn bản: thêm số VB để lấy phần số thôi và order theo số VB này
    ];

    public $timestamps = false;

    /* Declare values */
    public static $dokhans = [
        '1' => 'Bình Thường',
        '2' => 'Khẩn',
        '3' => 'Thượng Khẩn',
        '4' => 'Hỏa Tốc'
    ];

    /* Relationships */
    public function vanbanxulys() {
        return $this->hasMany(VanbanXuLy::class, 'vanbanUser_id');
    }

    public function donviChuTri() {
        return $this->belongsTo(Donvi::class, 'donvi_id');
    }

    public function donviTao() {
        return $this->belongsTo(Donvi::class, 'donvi_creator_id');
    }

    public function donviSoan() {
        return $this->belongsTo(Donvi::class, 'cq_banhanh');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function sovanban() {
        return $this->belongsTo(SoVanBan::class, 'sovanban_id');
    }

    public function loaivanban() {
        return $this->belongsTo(Loaivanban::class, 'loaivanban_id');
    }

    public function linhvuc() {
        return $this->belongsTo(Linhvucs::class, 'linhvuc_id');
    }

    /* Accessors */ 
    public function getUserChuTriIdsAttribute() {
        return (!$this->usernhan || $this->usernhan == ';;')? [] : explode(';', trim($this->usernhan, ';'));
    }

    public function getUserPhoiHopIdsValAttribute() {
        return (!$this->userphoihop_ids || $this->userphoihop_ids == ';;')? [] : explode(';', trim($this->userphoihop_ids, ';'));
    }
    
    public function getDonViPhoiHopIdsValAttribute() {
        return (!$this->donviphoihop_ids || $this->donviphoihop_ids == ';;')? [] : explode(';', trim($this->donviphoihop_ids, ';'));
    }
    
    public function getNgaykyAttribute($value) {
        return $value? date('d/m/Y', strtotime($value)) : '';
    }

    public function getNgaykyValAttribute() {
        return $this->ngayky? date('Y-m-d', strtotime(str_replace('/', '-', $this->ngayky))) : '';
    }

    public function getHanxulyAttribute($value) {
        return $value? date('d/m/Y', strtotime($value)) : '';
    }

    public function getHanxulyValAttribute() {
        return $this->hanxuly;
    }

    public function getPublishTextAttribute() {
        return $this->is_publish == 1? 'Public' : 'Không public';
    }

    public function getUrgencyTextAttribute() {
        return isset(Vanban::$dokhans[$this->urgency])? Vanban::$dokhans[$this->urgency] : '';
    }

    /* Local scope */
    public function scopeSelectColumns($query) {
        return $query->select(
            'vanbans.id',
            'vanbans.user_id',
            'vanbans.title',
            'vanbans.soden',
            'vanbans.cq_banhanh',
            'vanbans.kyhieu',
            'vanbans.ngayky',
            'vanbans.hanxuly',
            'vanbans.note',
            'vanbans.file_dinhkem',
            'donvi_id'
        )->with([
            'donviChuTri' => function ($q) {
                $q->selectColumnsInWith();
            },
            'sovanban' => function ($q) {
                $q->selectColumns();
            }
        ]);
    }

    public function scopeSelectColumnsInWith($query) {
        return $query->select(
            'vanbans.id',
            'vanbans.user_id',
            'vanbans.title',
            'vanbans.soden',
            'vanbans.cq_banhanh',
            'vanbans.kyhieu',
            'vanbans.ngayky',
            'vanbans.hanxuly',
            'vanbans.note',
            'vanbans.file_dinhkem',
            'vanbans.urgency',
            'vanbans.loaivanban_id',
            'donvi_id'
        )->with([
            'donviChuTri' => function ($q) {
                $q->selectColumnsInWith();
            },
            'loaivanban'
        ]);
    }

    public function scopeGetDanhSachVanBanThuocSo($query, $soVanBanId) {
        return $query->where('vanbans.sovanban_id', $soVanBanId);
    }

    public function scopeGetVanBan($query, $vanBanId) {
        return $query->where('vanbans.id', $vanBanId)->with([
            'vanbanxulys' => function ($q) {
                $q->whereNotNull('vanban_xulys.ngayxem');
            }
        ]);
    }

    public function scopeGetVanBanDi($query, $vanbanId) {
        return $query->where('vanbans.id', $vanbanId)->with([
            'linhvuc', 'loaivanban', 'donviTao'
        ]);
    }

    public function scopeGetDanhSachDi($query, $userId, array $options = []) {
        $query->with('donviSoan')
            ->where('vanbans.book_id', 2)
            ->where(function ($q) use ($userId) {
                $q->where('vanbans.is_publish', 1)       // publish thì tất cả đều thấy được
                  ->orWhere('vanbans.user_id', $userId); // không publish thì chỉ người tạo thấy được
            })
            ->orderBy('vanbans.sovb', 'DESC');

        // search
        if (isset($options['tukhoa']) && $options['tukhoa']) {
            $query->where(function ($q) use ($options) {
                $q->where('vanbans.title', 'like', '%'.$options['tukhoa'].'%')
                  ->orWhere('vanbans.kyhieu', 'like', '%'.$options['tukhoa'].'%');
            });
        }
          
        if  (isset($options['donviSoan']) && $options['donviSoan']) {
           $query->leftJoin('donvis', 'donvis.id', '=', 'vanbans.cq_banhanh')->where('donvis.name','like', '%'.$options['donviSoan'].'%');
        }
        if  (isset($options['donvi_nhan_vbdi']) && $options['donvi_nhan_vbdi']) {
            $query->where('vanbans.donvi_nhan_vbdi', 'like', '%'.$options['donvi_nhan_vbdi'].'%');
        }
        if  (isset($options['loaivanban']) && $options['loaivanban'] > 0) {
            $query->where('vanbans.loaivanban_id', $options['loaivanban']);
        }
        if  (isset($options['linhvuc']) && $options['linhvuc'] > 0) {
            $query->where('vanbans.linhvuc_id', $options['linhvuc']);
        }
        if (!empty($options['ngaybanhanhtu'])) {
            $query->where('vanbans.ngayky', '>=', date('Y-m-d', strtotime($options['ngaybanhanhtu'])));
        }
        if (!empty($options['ngaybanhanhden'])) {
            $query->where('vanbans.ngayky', '<=', date('Y-m-d', strtotime($options['ngaybanhanhden'])));
        }
        if (!empty($options['ngayguitu'])) {
            $query->where('vanbans.ngaygui', '>=', date('Y-m-d', strtotime($options['ngayguitu'])));
        }
        if (!empty($options['ngayguiden'])) {
            $query->where('vanbans.ngaygui', '<=', date('Y-m-d', strtotime($options['ngayguiden'])));
        }
        
        return $query;
    }
}
