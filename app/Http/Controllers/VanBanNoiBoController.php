<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailNoiBo;
use App\Models\BookDetail;
use App\Models\Butphe;
use App\Models\Donvi;
use App\Models\Linhvucs;
use App\Models\Loaivanban;
use App\Models\Notification;
use App\Models\SoVanBan;
use App\Models\User;
use App\Models\Vanban;
use App\Models\VanbanXuLy;
use App\Models\Ykien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class VanBanNoiBoController extends Controller
{
    public function danh_sach() {
        // get params
        $status = Input::get('status', '');
        $userId = session('user')['id'];
        $noibanhanh = Input::get('noibanhanh', '');
        $tukhoa = Input::get('tukhoa', '');
        $linhvuc = Input::get('linhvuc', '');       
        $loaivanban = Input::get('loaivanban', '');       
        $ngaybanhanhtu = Input::get('ngaybanhanhtu', '');       
        $ngaybanhanhden = Input::get('ngaybanhanhden', '');       
        $ngayguitu = Input::get('ngayguitu', '');       
        $ngayguiden = Input::get('ngayguiden', '');
        $trangthai = Input::get('trangthai', '');

         $type ="nhan";
        // get data: lấy ds nội bộ đã gửi theo đơn vị (cùng đơn vị thì thấy được văn bản nội bộ đã gửi)
        $vanbans = VanbanXuLy::getDanhSachNoiBo($userId, $trangthai? $trangthai : $status, [
            'tukhoa' => $tukhoa,
            'linhvuc' => $linhvuc,
            'noibanhanh' => $noibanhanh,
            'loaivanban' => $loaivanban,
            'ngaybanhanhtu' => $ngaybanhanhtu,
            'ngaybanhanhden' => $ngaybanhanhden,
            'ngayguitu' => $ngayguitu,
            'ngayguiden' => $ngayguiden,
            'trangthai' => $trangthai,
        ])
        ->paginate(30)
        ->appends(Input::except('page'));

        // get data for filter in view
        $linhvucs = Linhvucs::all();
        $loaivanbans = Loaivanban::all();       
        $title = 'Danh sách văn bản nội bộ';
        return view('vanbannoibo.danh_sach', compact('title','type', 'status', 'linhvucs', 'loaivanbans', 'vanbans'));
    }

    public function danh_sach_gui() {
        // get params
        $status = Input::get('status', '');
        $userId = session('user')['id'];
        $tukhoa = Input::get('tukhoa', '');
        $noibanhanh = Input::get('noibanhanh', '');
        $linhvuc = Input::get('linhvuc', '');
        $loaivanban = Input::get('loaivanban', '');       
        $ngaybanhanhtu = Input::get('ngaybanhanhtu', '');       
        $ngaybanhanhden = Input::get('ngaybanhanhden', '');       
        $ngayguitu = Input::get('ngayguitu', '');       
        $ngayguiden = Input::get('ngayguiden', '');
        $trangthai = Input::get('trangthai', '');
         
        // get data: lấy ds nội bộ đã gửi theo đơn vị (cùng đơn vị thì thấy được văn bản nội bộ đã gửi)
        $vanbans = VanbanXuLy::getDanhSachNoiBoGui(session('user')['donvi_id'], $trangthai? $trangthai : $status, [
            'tukhoa' => $tukhoa,
            'linhvuc' => $linhvuc,
            'noibanhanh' => $noibanhanh,
            'loaivanban' => $loaivanban,
            'ngaybanhanhtu' => $ngaybanhanhtu,
            'ngaybanhanhden' => $ngaybanhanhden,
            'ngayguitu' => $ngayguitu,
            'ngayguiden' => $ngayguiden,
            'trangthai' => $trangthai,
        ])
        ->paginate(30)
        ->appends(Input::except('page'));

        // get data for filter in view
        $linhvucs = Linhvucs::all();
        $loaivanbans = Loaivanban::all();

        $title = 'Danh sách văn bản nội bộ đã gửi';
        $type = 'gui';
        return view('vanbannoibo.danh_sach', compact('title', 'type', 'status', 'linhvucs', 'loaivanbans', 'vanbans'));
    }

    public function danh_sach_nhan() {
        // get params
        $type = 'nhan';
        $status = Input::get('status', '');
        $userId = session('user')['id'];
        $noibanhanh = Input::get('noibanhanh', '');
        $tukhoa = Input::get('tukhoa', '');
        $linhvuc = Input::get('linhvuc', '');       
        $loaivanban = Input::get('loaivanban', '');       
        $ngaybanhanhtu = Input::get('ngaybanhanhtu', '');       
        $ngaybanhanhden = Input::get('ngaybanhanhden', '');       
        $ngayguitu = Input::get('ngayguitu', '');       
        $ngayguiden = Input::get('ngayguiden', '');
        $trangthai = Input::get('trangthai', '');

        // get data
        $vanbans = VanbanXuLy::getDanhSachNoiBoNhan($userId, $trangthai? $trangthai : $status, [
            'tukhoa' => $tukhoa,
            'linhvuc' => $linhvuc,
            'noibanhanh' => $noibanhanh,
            'loaivanban' => $loaivanban,
            'ngaybanhanhtu' => $ngaybanhanhtu,
            'ngaybanhanhden' => $ngaybanhanhden,
            'ngayguitu' => $ngayguitu,
            'ngayguiden' => $ngayguiden,
            'trangthai' => $trangthai,
        ])
        ->paginate(30)
        ->appends(Input::except('page'));

        // get data for filter in view
        $linhvucs = Linhvucs::all();
        $loaivanbans = Loaivanban::all();

        $title = 'Danh sách văn bản nội bộ đã nhận';

        return view('vanbannoibo.danh_sach', compact('title', 'type', 'status', 'linhvucs', 'loaivanbans', 'vanbans'));
    }

    public function chi_tiec($id) {
        // get params
        $tab = Input::get('tab', 0);
        $user = session('user');

        // get vanbanxuly
        $checkvanbanXL = VanbanXuLy::where('vanbanUser_id', $id)->where('id_nhan', $user['id'])->first();

        // cập nhật văn bản là đã xem
        if($checkvanbanXL && !$checkvanbanXL->ngayxem) {
            VanbanXuLy::where('vanbanUser_id', $id)->where('id_nhan', $user['id'])->update(array('vanban_xulys.ngayxem' => date('Y-m-d H:i:s')));
        }

        // cập nhật các notification là đã xem
        {
            $vbxlIds = VanbanXuLy::where('vanbanUser_id', $id)->pluck('id')->toArray();
            $test = Notification::where('receivor_id', $user['id'])
                        ->whereIn('notificationable_id', $vbxlIds)
                        ->where('notificationable_type', 'App\\Models\\VanbanXuLy')
                        ->whereNull('read_at')
                        ->update(['read_at' => date('Y-m-d H:i')]);
        }

        $vanbanden = VanbanXuLy::select('vanbans.*', 'vanban_xulys.status as trangthai', 'vanban_xulys.id as idVBUser', 'donvis.name as donviChuTriName', 'vanban_xulys.minhchung', 'vanban_xulys.file_minhchung')
            ->where('vanban_xulys.vanbanUser_id', $id)
            ->where('vanban_xulys.id_nhan', $user['id'])
            ->leftJoin('vanbans', 'vanban_xulys.vanbanUser_id', '=', 'vanbans.id')
            ->leftJoin('donvis', 'donvis.id', '=', 'vanbans.donvi_id')
            ->first();
        // get danh sách user chủ trì

        if(sizeof($vanbanden) <= 0 ){
            return redirect('/');
        }
        $userChuTriIds = explode(';', trim($vanbanden->usernhan, ';'));
        $userChuTris = User::getList()->whereIn('id', $userChuTriIds)->get();

        // get danh sách user phối hợp
        $userPhoihopIds = explode(';', trim($vanbanden->userphoihop_ids, ';'));
        $userPhoihops = User::getList()->whereIn('id', $userPhoihopIds)->get();

        // get danh sách đơn vị phối hợp
        $donviPhoihopIds = explode(';', trim($vanbanden->donviphoihop_ids, ';'));
        $donviPhoihops = Donvi::getList()->whereIn('id', $donviPhoihopIds)->get();

        $vanbanxulys = VanbanXuLy::select('tbUserGui.fullname', 'tbUserNhan.fullname as userNhan', 'vanban_xulys.*', 'vanbans.ngaygui', 'vanbans.id as IdVanBan', 'vanbans.user_id as IdUser', 'donvis.name as tenDonVi')
            ->where('vanban_xulys.vanbanUser_id', $id)
            ->where('vanban_xulys.parent_id', '<>', 0)
            ->leftJoin('vanbans', 'vanban_xulys.vanbanUser_id', '=', 'vanbans.id')
            ->leftJoin('users as tbUserGui', 'tbUserGui.id', '=', 'vanbans.user_id')
            ->leftJoin('users as tbUserNhan', 'tbUserNhan.id', '=', 'vanban_xulys.id_nhan')
            ->leftJoin('donvis', 'donvis.id', '=', 'tbUserNhan.donvi_id')
            ->get();

        $parentId = VanbanXuLy::select('id_nhan','user_tao','id')->where('vanban_xulys.vanbanUser_id',$id)->orderBy('id', 'ASC')->first();

        $parent = VanbanXuLy::select('vanban_xulys.id')
            ->where('vanban_xulys.vanbanUser_id', $id)
            ->where('vanban_xulys.parent_id', 0)->first();
        $vanBanXuLy = VanbanXuLy::select('vanban_xulys.*', 'users.fullname')
            ->where('vanbanUser_id', $id)
            ->where('id_nhan', $user['id'])
            ->leftJoin('users', 'users.id', '=', 'vanban_xulys.user_tao')
            ->first();
        $vanBanXuLy->title = $vanbanden->title;

        $vb_child = [];
        $parent_id = $vanBanXuLy->parent_id == 0 ? $vanBanXuLy->id : $vanBanXuLy->parent_id;
        if ($vanBanXuLy) {
            childVanBan($parent->id, $vb_child);
        }

        $vbxuly = VanbanXuLy::getVanBanXuLy($vanBanXuLy->id)->first();

        // get butphes
        {
            // get danh sách bút phê đã gửi
            $vbxuly->butphes = Butphe::getList($id)->get();

            // get danh sách users trong mỗi butphe
            $userIdsButphe = explode(';', trim(implode('', $vbxuly->butphes->pluck('receiver_ids')->toArray()), ';'));
            $usersButphe = User::getList()->whereIn('users.id', $userIdsButphe)->get()->keyBy('id');

            foreach($vbxuly->butphes as $key => $butphe) {
                $userNhans = [];

                foreach($butphe->receiver_ids_arr as $receiverId) {
                    if (isset($usersButphe[$receiverId])) {
                        $userNhans[$receiverId] = $usersButphe[$receiverId]->fullname;
                    }
                }

                $vbxuly->butphes[$key]->userNhans = $userNhans;
            }
        }

        // tab trao đổi văn bản
        {
            $now = date('Y-m-d H:i:s');

            // get danh sách user nhận là những user đã có trong luồng luân chuyển (để chọn người nhận khi gửi ý kiến)
            $userIdsTrongLuong = VanbanXuLy::select('id_nhan')->where('vanbanUser_id', $id)->pluck('id_nhan')->toArray();
            $userReceivers = User::whereIn('id', $userIdsTrongLuong)->where('id', '<>', session('user')['id'])->orderBy('fullname', 'ASC')->get();

            // cập nhật đã xem các trao đổi nhận được
            $user = User::where('id', session('user')['id'])->whereHas('ykiens', function($q) {
                $q->whereNull('user_ykien.read_at');
            })->first();
            if ($user) {
                foreach($user->ykiens as $ykien) {
                    $ykien->pivot->read_at = $now;
                    $ykien->pivot->save();
                }
            }

            // get danh sách ý kiến
            $ykiens = Ykien::getList($id, session('user')['id'])->get();
        }

        return view('vanbannoibo.chi_tiet', compact(
            'tab', 'vbxuly', 'userIdsTrongLuong',
            'vanbanden', 'id_vanbanuser', 'vanbanxulys', 'user','parentId','vb_child','id', 'vanBanXuLy', 'userChuTris', 'donviPhoihops', 'userPhoihops',
            'ykiens', 'userReceivers' // data for tab trao đổi văn bản
        ));
    }

    public function nhap_vanban_noibo() {
        $donvis = Donvi::all();
        $linhvucs = Linhvucs::all();
        $loaivanbans = Loaivanban::all();

        // get bookDetails
        $bookDetails = BookDetail::getList(4)->orderBy('book_detail.ordering', 'ASC')->get();

        // get danh sách sổ văn bản đến
        $sovanbandens = SoVanBan::all();

        $vanban = null;

        return view('vanbannoibo.nhap_vanban_noibo', compact('donvis', 'linhvucs', 'loaivanbans', 'sovanbandens', 'bookDetails', 'vanban'));
    }

    public function luu_nhap_vanban_noibo(Request $request) {
        // get params
        $now = date('Y-m-d H:i:s');
        $user = session('user');

        $vanban = new Vanban();
        $vanban->title = $request->title;
        $vanban->loaivanban_id = $request->loaivanban_id;
        $vanban->user_id = $user['id'];
        $vanban->book_id = $request->book_id;
        $vanban->ngayden = formatYMD($request->ngayden);
        $vanban->cq_banhanh = $request->cq_banhanh;
        $vanban->kyhieu = $request->kyhieu;
        $vanban->ngayky = formatYMD($request->ngayky);
        $vanban->linhvuc_id = $request->linhvuc_id;
        $vanban->nguoiky = $request->nguoiky;
        $vanban->hanxuly = formatYMD($request->hanxuly);
        $vanban->ngaygui = date('Y-m-d');
        $vanban->status = 0;
        $vanban->note = $request->note;
        $vanban->urgency = $request->urgency;
        $vanban->donvi_id = $request->donvi_id;
        $vanban->usernhan = $request->user_chutri_ids? ';'.implode(';', $request->user_chutri_ids).';' : '';
        $vanban->donviphoihop_ids = $request->donvi_phoihop_ids? ';'.implode(';', $request->donvi_phoihop_ids).';' : '';
        $vanban->userphoihop_ids = $request->user_phoihop_ids? ';'.implode(';', $request->user_phoihop_ids).';' : '';

        // checkbox not_have_chutri
        if ($request->not_have_chutri) {
            $vanban->not_have_chutri = 1;
        }

        // có file đính kèm
        if ($request->hasFile('files')) {
            $path = 'files/vanban/';
            $files = $request->file('files');

            // check file type
            foreach ($files as $file) {
				if (!in_array(strtolower($file->getClientOriginalExtension()), ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf'])) {
                    flash('File đính kèm không đúng định dạng');
                    return redirect()->back();
                }
            }

            // thực hiện lưu file
            $fileNames = [];
            foreach ($files as $file) {
                $fileNameArr = explode('.', $file->getClientOriginalName());
                $duoifile='';
                foreach ($fileNameArr as $key => $value):
                    if (in_array(strtolower($value), ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf'])) {
                        $duoifile = strtolower($value);
                    }
                endforeach;
                $fileName = str_slug($fileNameArr[0], '-') . '_' . time() . '.' . $duoifile;

                if (!$file->move($path, $fileName)) {
                    flash('Lưu văn bản thất bại');
                    return redirect()->back();
                }
                else {
                    $fileNames[] = $fileName;
                }
            }

            $vanban->file_dinhkem = implode(';', $fileNames);
        }

        if ($vanban->save()) {
            // lưu vào vanban_xuly
            $vb = new VanbanXuLy();
            $vb->vanbanUser_id = $vanban->id;
            $vb->parent_id = '';
            $vb->id_nhan = $user['id'];
            $vb->ngaychuyentiep = $now;
            $vb->user_tao = $user['id'];
            $vb->noidung_butphe = $request->title;
            $vb->status = VanbanXuLy::$status['daxuly'];
            $vb->type = VanbanXuLy::$type['phoihop'];
            $vb->ngayxem = date('Y-m-d H:i:s');
            $vb->save();

            $arrInsertNotifications = []; // array store notification data
            
            // lưu danh sách user chủ trì
            if ($request->user_chutri_ids) {
                foreach ($request->user_chutri_ids as $userId) {
                    $cuser = User::find($userId);

                    $vbxlyId = VanbanXuLy::insertGetId([
                        'vanbanUser_id' => $vanban->id,
                        'parent_id' => $vb->id,
                        'id_nhan' => $userId,
                        'ngaychuyentiep' => $now,
                        'user_tao' => $user['id'],
                        'noidung_butphe' => $request->title,
                        'status' => 1,
                        'donvi_nhan_id' => $cuser->donvi_id,
                        'loaivanban' => $vanban->book_id
                    ]);

                    // save notification data
                    $arrInsertNotifications[] = [
                        'creator_id' => $user['id'],
                        'receivor_id' => $userId,
                        'type' => Notification::$types['nhanvanbannoibo'],
                        'content' => 'Bạn nhận được văn bản nội bộ mới',
                        'notificationable_id' => $vbxlyId,
                        'notificationable_type' => VanbanXuLy::class,
                        'created_at' => $now
                    ];
                }
            }

            // lưu danh sách user phối hợp
            if ($request->user_phoihop_ids) {
                foreach ($request->user_phoihop_ids as $userId) {
                    $cuser = User::find($userId);

                    $vbxlyId = VanbanXuLy::insertGetId([
                        'vanbanUser_id' => $vanban->id,
                        'parent_id' => $vb->id,
                        'id_nhan' => $userId,
                        'ngaychuyentiep' => $now,
                        'user_tao' => $user['id'],
                        'noidung_butphe' => $request->title,
                        'status' => 1,
                        'type' => 2,
                        'donvi_nhan_id' => $cuser->donvi_id,
                        'loaivanban' => $vanban->book_id
                    ]);

                    // save notification data
                    $arrInsertNotifications[] = [
                        'creator_id' => $user['id'],
                        'receivor_id' => $userId,
                        'type' => Notification::$types['nhanvanbannoibo'],
                        'content' => 'Bạn nhận được văn bản nội bộ mới',
                        'notificationable_id' => $vbxlyId,
                        'notificationable_type' => VanbanXuLy::class,
                        'created_at' => $now
                    ];
                }
            }
        }

        // Insert notifications
        if ($arrInsertNotifications) {
            Notification::insert($arrInsertNotifications);
        }

        // Gửi mail hàng đợi (Queue send Mail)
        if ($request->user_chutri_ids || $request->user_phoihop_ids) {
            // get nội dung gửi mail
            $vanban->donvisoan_id = $vanban->cq_banhanh;
            $vanban->loaivanban_id = Loaivanban::where('id', $vanban->loaivanban_id)->first()->name;
            $vanban->ngaydi = $vanban->ngayky;
            $vanban->link = url('vanbannoibo/chi-tiet', $vanban->id);
            $vanban->path = url('/vanban/dowload_file');
            $vanban->file = [$vanban->file_dinhkem];
            $vanban->loai = 'Nội bộ';
            
            // get danh sách emails gửi đến
            $emails = [];
            if ($request->user_chutri_ids) {
                $emails = array_merge($emails, User::select('email')->whereIn('id', $request->user_chutri_ids)->pluck('email')->toArray());
            }
            if ($request->user_phoihop_ids) {
                $emails = array_merge($emails, User::select('email')->whereIn('id', $request->user_phoihop_ids)->pluck('email')->toArray());
            }
            $vanban->noinhan = $emails;

            // send mail
            $this->dispatch(new SendMailNoiBo($vanban->toArray()));
        }

        return redirect(url('vanbannoibo/danh-sach-gui'));
    }
    
    public function sua_vanban_noibo($vanbanId) {
        // get logged user
        $loggedUser = (object) session('user');

        // get vanban
        $vanban = Vanban::getVanBan($vanbanId)->first();
        
        if (!$vanban) {
            flash('Văn bản không tồn tại');
            return redirect(url('vanbannoibo/chi-tiet', $vanbanId));
        }

        if ($vanban->user_id != $loggedUser->id) {
            flash('Bạn không có quyền sửa văn bản này');
            return redirect(url('vanbannoibo/chi-tiet', $vanbanId));
        }

        $donvis = Donvi::all();
        $linhvucs = Linhvucs::all();
        $loaivanbans = Loaivanban::all();
     
        // get bookDetails
        $bookDetails = BookDetail::getList(1)->orderBy('id' ,'ASC')->orderBy('book_detail.ordering', 'ASC')->get();

        // get danh sách sổ văn bản đến
        $sovanbandens = SoVanBan::all();

        // get danh sách user chủ trì đã chọn
        $userChuTris = [];
        foreach(User::getList()->whereIn('id', $vanban->userChuTriIds)->get() as $user) {
            if (!isset($userChuTris[$user->donvi->name])) {
                $userChuTris[$user->donvi->name] = [];
            }

            $userChuTris[$user->donvi->name][] = $user;
        }

        // get danh sách user phối hợp đã chọn
        $userPhoiHops = [];
        foreach(User::getList()->whereIn('id', $vanban->userPhoiHopIdsVal)->get() as $user) {
            if (!isset($userPhoiHops[$user->donvi->name])) {
                $userPhoiHops[$user->donvi->name] = [];
            }

            $userPhoiHops[$user->donvi->name][] = $user;
        }

        $userChuTriDaXemVanBanIds = $vanban->vanbanxulys->where('type', VanbanXuLy::$type['chutri'])->where('parent_id', '<>', 0)->pluck('id_nhan')->toArray();
        $userPhoiHopDaXemVanBanIds = $vanban->vanbanxulys->where('type', VanbanXuLy::$type['phoihop'])->where('parent_id', '<>', 0)->pluck('id_nhan')->toArray();

        // get danh sách đơn vị phối hợp id có user đã xem văn bản
        if ($userPhoiHopDaXemVanBanIds) {
            $donviPhoiHopDaXemVanBanIds = BookDetail::select('donvi_id')
                                                    ->where('book_detail.book_id', 1)
                                                    ->where(function ($q) use ($userPhoiHopDaXemVanBanIds) {
                                                        foreach($userPhoiHopDaXemVanBanIds as $userId) {
                                                            $q->orWhere('user_id', 'like', '%'.$userId.'%');
                                                        }
                                                    })
                                                    ->pluck('donvi_id')
                                                    ->toArray();
        }
        else {
            $donviPhoiHopDaXemVanBanIds = [];
        }

        // get danh sách user lãnh đạo trong đơn vị đã chọn
        {
            // get bookdetail được chọn
            $selectedBookDetails = BookDetail::getDanhSachCoQuanCVanDen()->whereIn('book_detail.donvi_id', $vanban->donViPhoiHopIdsVal)->get();

            // get danh sách user của mỗi bookdetail
            $userTrongDonViPhoiHops = [];
            foreach($selectedBookDetails as $bookDetail) {
                $usersTmp = User::getListLanhDao()->whereIn('users.id', $bookDetail->user_ids)->get();

                $userTrongDonViPhoiHops[$bookDetail->donvi_id] = (object) [
                    'name' => $bookDetail->donvi->name,
                    'users' => $usersTmp
                ];
            }
        }
        
        return view('vanbannoibo.sua_vanban_noibo', compact('donvis', 'linhvucs', 'loaivanbans', 'sovanbandens', 'bookDetails', 'vanban', 'userChuTris', 'userPhoiHops', 'userChuTriDaXemVanBanIds', 'userPhoiHopDaXemVanBanIds', 'donviPhoiHopDaXemVanBanIds', 'userTrongDonViPhoiHops'));
    }

    public function luu_sua_vanban_noibo(Request $request) {
        // get params
        $now = date('Y-m-d H:i:s');
        $loggedUser = (object) session('user');
        $submitType = $request->get('type_submit', 'notsendmail');

        // get vanban
        $vanban = Vanban::getVanBan($request->vanban_id)->first();
        
        if (!$vanban) {
            flash('Văn bản không tồn tại');
            return redirect(url('vanbannoibo/chi-tiet', $request->vanban_id));
        }

        if ($vanban->user_id != $loggedUser->id) {
            flash('Bạn không có quyền sửa văn bản này');
            return redirect(url('vanbannoibo/chi-tiet', $request->vanban_id));
        }

        // update vanban
        $vanban->title = $request->title;
        $vanban->loaivanban_id = $request->loaivanban_id;
        $vanban->book_id = $request->book_id;
        $vanban->ngayden = formatYMD($request->ngayden);
        $vanban->cq_banhanh = $request->cq_banhanh;
        $vanban->kyhieu = $request->kyhieu;
        $vanban->ngayky = formatYMD($request->ngayky);
        $vanban->linhvuc_id = $request->linhvuc_id;
        $vanban->nguoiky = $request->nguoiky;
        $vanban->hanxuly = formatYMD($request->hanxuly);
        $vanban->note = $request->note;
        $vanban->urgency = $request->urgency;

        // user đơn vị chủ trì
        $userChuTriDaXemVanBanIds = $vanban->vanbanxulys->where('type', VanbanXuLy::$type['chutri'])->where('parent_id', '<>', 0)->pluck('id_nhan')->toArray();
        $userChuTriIds = array_merge($userChuTriDaXemVanBanIds, $request->user_chutri_ids? $request->user_chutri_ids : []);
        $vanban->usernhan = $userChuTriIds? ';'.implode(';', $userChuTriIds).';' : '';

        // user đơn vị phối hợp
        $userPhoiHopDaXemVanBanIds = $vanban->vanbanxulys->where('type', VanbanXuLy::$type['phoihop'])->where('parent_id', '<>', 0)->pluck('id_nhan')->toArray();
        $userPhoiHopIds = array_merge($userPhoiHopDaXemVanBanIds, $request->user_phoihop_ids? $request->user_phoihop_ids : []);
        $vanban->userphoihop_ids = $userPhoiHopIds? ';'.implode(';', $userPhoiHopIds).';' : '';

        // đơn vị chủ trì
        if (isset($request->donvi_id)) {
            $vanban->donvi_id = $request->donvi_id;
        }
        
        // đơn vị phối hợp
        if ($userPhoiHopDaXemVanBanIds) {
            $donviPhoiHopDaXemVanBanIds = BookDetail::select('donvi_id')
                                         ->where('book_detail.book_id', 1)
                                         ->where(function ($q) use ($userPhoiHopDaXemVanBanIds) {
                                            foreach($userPhoiHopDaXemVanBanIds as $userId) {
                                                $q->orWhere('user_id', 'like', '%'.$userId.'%');
                                            }
                                         })
                                         ->pluck('donvi_id')
                                         ->toArray();
        }
        else {
            $donviPhoiHopDaXemVanBanIds = [];
        }

        $donviPhoiHopIds = array_merge($donviPhoiHopDaXemVanBanIds, $request->donvi_phoihop_ids? $request->donvi_phoihop_ids : []);
        $vanban->donviphoihop_ids = $donviPhoiHopIds? ';'.implode(';', $donviPhoiHopIds).';' : '';

        // ngày đi (văn bản đi)
        if ($request->ngaydi) {
            $vanban->ngaydi = $request->ngaydi;
        }

        // checkbox không có người chủ trì
        if ($request->not_have_chutri) {
            $vanban->not_have_chutri = 1;
        }

        // file đính kèm
        if ($request->hasFile('files')) {
            $path = 'files/vanban/';
            $files = $request->file('files');

            // check file type
            foreach ($files as $file) {
				if (!in_array($file->getClientOriginalExtension(), ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf'])) {
                    flash('File đính kèm không đúng định dạng');
                    return redirect()->back();
                }
            }

            // thực hiện lưu file
            $fileNames = [];
            foreach ($files as $file) {
                $fileNameArr = explode('.', $file->getClientOriginalName());
                $fileName = str_slug($fileNameArr[0], '-') . '_' . time() . '.' . $fileNameArr[1];

                if (!$file->move($path, $fileName)) {
                    flash('Lưu văn bản thất bại');
                    return redirect()->back();
                }
                else {
                    $fileNames[] = $fileName;
                }
            }

            $vanban->file_dinhkem = implode(';', $fileNames);
        }

        if ($vanban->save()) {
            // find vanbanxuly root
            $vanBanXuLyRoot = VanbanXuLy::getVanBanXuLyRoot($request->vanban_id)->first();

            // xóa những vanbanxuly chưa xem
            VanbanXuLy::getVanBanXuLyChuaXem($vanBanXuLyRoot->id)->delete();

            $arrInsertNotifications = []; // array store notification data
            
            // lưu danh sách user chủ trì
            if ($request->user_chutri_ids) {
                foreach ($request->user_chutri_ids as $userId) {
                    $cuser = User::find($userId);

                    $vbxlyId = VanbanXuLy::insertGetId([
                        'vanbanUser_id' => $vanban->id,
                        'parent_id' => $vanBanXuLyRoot->id,
                        'id_nhan' => $userId,
                        'ngaychuyentiep' => $now,
                        'user_tao' => $loggedUser->id,
                        'noidung_butphe' => $request->title,
                        'status' => 1,
                        'donvi_nhan_id' => $cuser->donvi_id,
                        'loaivanban' => $vanban->book_id
                    ]);

                    // save notification data
                    $arrInsertNotifications[] = [
                        'creator_id' => $loggedUser->id,
                        'receivor_id' => $userId,
                        'type' => Notification::$types['nhanvanbannoibo'],
                        'content' => 'Bạn nhận được văn bản nội bộ mới',
                        'notificationable_id' => $vbxlyId,
                        'notificationable_type' => VanbanXuLy::class,
                        'created_at' => $now
                    ];
                }
            }

            // lưu danh sách user phối hợp
            if ($request->user_phoihop_ids) {
                foreach ($request->user_phoihop_ids as $userId) {
                    $cuser = User::find($userId);

                    $vbxlyId = VanbanXuLy::insertGetId([
                        'vanbanUser_id' => $vanban->id,
                        'parent_id' => $vanBanXuLyRoot->id,
                        'id_nhan' => $userId,
                        'ngaychuyentiep' => $now,
                        'user_tao' => $loggedUser->id,
                        'noidung_butphe' => $request->title,
                        'status' => 1,
                        'type' => 2,
                        'donvi_nhan_id' => $cuser->donvi_id,
                        'loaivanban' => $vanban->book_id
                    ]);

                    // save notification data
                    $arrInsertNotifications[] = [
                        'creator_id' => $loggedUser->id,
                        'receivor_id' => $userId,
                        'type' => Notification::$types['nhanvanbannoibo'],
                        'content' => 'Bạn nhận được văn bản nội bộ mới',
                        'notificationable_id' => $vbxlyId,
                        'notificationable_type' => VanbanXuLy::class,
                        'created_at' => $now
                    ];
                }
            }
        }

        // Insert notifications
        if ($arrInsertNotifications) {
            Notification::insert($arrInsertNotifications);
        }

        // Gửi mail hàng đợi (Queue send Mail)
        if ($submitType != 'notsendmail') {
            $data = $request->all();
            $data['id'] = $vanban->id;
            $data['link'] = url('vanbannoibo/chi-tiet', $vanban->id);
            $data['file'] = [$vanban->file_dinhkem];
            $data['file_dinhkem'] = $vanban->file_dinhkem;
            $data['path'] = url('/vanban/dowload_file');

            $loai = Loaivanban::where('id', $request->loaivanban_id)->first();
            $data['loaivanban_id'] = $loai->name;
    
            $linhvuc = Linhvucs::where('id', $request->linhvuc_id)->first();
            $data['linhvuc_id'] = $linhvuc? $linhvuc->name : '';
            $data['ngaydi'] = $request->ngayky;
            $data['loai'] = 'Nội bộ';

            // get danh sách emails gửi đến
            $emails = [];
            $userChuTriIds = explode(';', trim($vanban->usernhan, ';'));
            if ($userChuTriIds) {
                $emails = array_merge($emails, User::select('email')->whereIn('id', $userChuTriIds)->pluck('email')->toArray());
            }
            $userPhoihopIds = explode(';', trim($vanban->userphoihop_ids, ';'));
            if ($userPhoihopIds) {
                $emails = array_merge($emails, User::select('email')->whereIn('id', $userPhoihopIds)->pluck('email')->toArray());
            }
            
            $data['noinhan'] = $emails;

            $this->dispatch(new SendMailNoiBo($data));
        }

        return redirect(url('vanbannoibo/danh-sach-gui'));
    }

    public function chuyen_xu_ly($id) {
        $userSesion = session('user');
        $vanbanden = Vanban::select('vanbans.*', 'book.name as bookName','vanban_xulys.status as trangthai', 'publish.name as publishName', 'linhvucs.name as linhvucName', 'donvis.name as donviName', 'donvis.viettat as tenvtdonvi', 'loaivanbans.name as tenLoaiVanBan')
            ->where('vanbans.id', $id)
            ->where('vanban_xulys.id_nhan', $userSesion['id'])
            ->leftJoin('book', 'vanbans.book_id', '=', 'book.id')
            ->leftJoin('publish', 'vanbans.publish_id', '=', 'publish.id')
            ->leftJoin('linhvucs', 'vanbans.linhvuc_id', '=', 'linhvucs.id')
            ->leftJoin('donvis', 'vanbans.cq_banhanh', '=', 'donvis.id')
            ->leftJoin('loaivanbans', 'vanbans.loaivanban_id', '=', 'loaivanbans.id')
            ->leftJoin('vanban_xulys', 'vanbans.id', '=', 'vanban_xulys.vanbanUser_id')
            ->first();

        // get danh sách user chủ trì
        $userChuTriIds = explode(';', trim($vanbanden->usernhan, ';'));
        $userChuTris = User::getList()->whereIn('id', $userChuTriIds)->get();

        // get danh sách user phối hợp
        $userPhoihopIds = explode(';', trim($vanbanden->userphoihop_ids, ';'));
        $userPhoihops = User::getList()->whereIn('id', $userPhoihopIds)->get();

        // get danh sách đơn vị phối hợp
        $donviPhoihopIds = explode(';', trim($vanbanden->donviphoihop_ids, ';'));
        $donviPhoihops = Donvi::getList()->whereIn('id', $donviPhoihopIds)->get();

        $vanbanxulys = VanbanXuLy::select('id_nhan')->where('vanban_xulys.vanbanUser_id', $id)->get();
        $arrIdUser= [];
        foreach ($vanbanxulys as $vanbanxuly) {
            $arrIdUser[] =$vanbanxuly->id_nhan;
        }

        $book_detail = Bookdetail::select('book_detail.*', 'donvis.name as tendonvi', 'donvis.id as donvi_id','donvis.viettat as tenvtdonvi')->where('book_id', 1)
            ->leftJoin('donvis', 'book_detail.donvi_id', '=', 'donvis.id')
            ->get();

        // get userIds đã có trong luồng luân chuyển
        $userIds = VanbanXuLy::select('id_nhan')->where('vanbanUser_id', $id)->pluck('id_nhan')->toArray();

        // get bookDetails
        $bookDetails = BookDetail::getList(1)->orderBy('book_detail.ordering', 'ASC')->get();

        // get danh sách users trong mỗi bookDetail
        $users = User::getList()->where('users.id', '<>', session('user')['id'])->get()->keyBy('id');
        foreach($bookDetails as $bookDetail) {
            $arrUsers = [];
            foreach($bookDetail->userIds as $userId) {
                if (isset($users[$userId])) {
                    $arrUsers[] = $users[$userId];
                }
            }

            usort($arrUsers, function ($a, $b) {
                return $a->id > $b->id;
            });

            $bookDetail->users = $arrUsers;
        }

        $dataTreeview = [];
        foreach($bookDetails as $bookDetail) {
            $items = [];

            $hasSelected = false;
            foreach($bookDetail->users as $user) {
                $items[] = [
                    'id' => $bookDetail->id.'_'.$user->id,
                    'text' => $user->fullname.' - '.$user->chucdanh.' - '.$user->email,
                    'expanded' => ($bookDetail->donvi_id == $userSesion['donvi_id'])? 1 : 0,
                    'has_selected' => in_array($user->id, $userIds)? true : false
                ];

                if (in_array($user->id, $userIds)) {
                    $hasSelected = true;
                }
            }

            $dataTreeview[] = [
                'id' => $bookDetail->id,
                'text' => $bookDetail->donviName,
                'items' => $items,
                'expanded' => $hasSelected
            ];
        }

        $vanbanxuly = VanbanXuLy::where('vanbanUser_id', $id)->where('vanban_xulys.id_nhan', $userSesion['id'])->first();
        if ($vanbanxuly && !$vanbanxuly->ngayxem) {
            $vanbanxuly->ngayxem = date('Y-m-d H:i:s');
            $vanbanxuly->save();
        }

        return view('vanbannoibo.chuyen_xu_ly_van_ban', compact('vanbanden', 'book_detail', 'IdVanBanUser','arrIdUser','dataTreeview', 'userChuTris', 'donviPhoihops', 'userPhoihops'));
    }

    public function luu_chuyen_xu_ly(Request $request) {
        // get params
        $userIds = isset($request->users) ? $request->users : null;
        $now = date('Y-m-d H:i:s');
        $inputs = Input::all();
        $idVanBan = $inputs['id'];
        $userSesion = session('user');
        
        $conten_butphe = isset($inputs['conten_butphe']) ? $inputs['conten_butphe'] : '';
        $checkparentVanBan = VanbanXuLy::where('vanbanUser_id', $idVanBan)->where('vanban_xulys.id_nhan', $userSesion['id'])->first();

        // lưu nội dung bút phê
        $butphe = Butphe::create([
            'vanban_id' => $idVanBan,
            'noidung' => $conten_butphe,
            'receiver_ids' => ';'.trim(implode(';',$userIds)).';',
            'created_by' => $userSesion['id']
        ]);

        // get sentUserIds đã có trong luồng luân chuyển
        $sentUserIds = VanbanXuLy::select('id_nhan')->where('vanbanUser_id', $idVanBan)->pluck('id_nhan')->toArray();

        $arrInsertNotifications = []; // array store notification data

        // get nội dung văn bản
        $vanban = Vanban::find($idVanBan);

        if ($checkparentVanBan) {
            if ($userIds) {
                foreach ($userIds as $userId) {
                    if (!in_array($userId, $sentUserIds)) {
                        $user = User::find($userId);

                        $vbxlyId = VanbanXuLy::insertGetId([
                            'vanbanUser_id' => $idVanBan,
                            'parent_id' => $checkparentVanBan->id,
                            'id_nhan' => $userId,
                            'ngaychuyentiep' => date('Y-m-d H:i:s'),
                            'user_tao' => $userSesion['id'],
                            'noidung_butphe' => $conten_butphe,
                            'status' => 1,
                            'is_chuyentiep' => 1,
                            'butphe_id' => $butphe->id,
                            'donvi_nhan_id' => $user->donvi_id,
                            'loaivanban' => $vanban->book_id,
                            'type' => $checkparentVanBan->type
                        ]);
    
                        // save notification data
                        $arrInsertNotifications[] = [
                            'creator_id' => $userSesion['id'],
                            'receivor_id' => $userId,
                            'type' => Notification::$types['nhanvanbannoibochuyenxuly'],
                            'content' => 'Bạn nhận được một VB nội bộ chuyển xử lý',
                            'notificationable_id' => $vbxlyId,
                            'notificationable_type' => VanbanXuLy::class,
                            'created_at' => $now
                        ];
                    }
                }
            }
        } else {
            $vb = new VanbanXuLy();
            $vb->vanbanUser_id = $idVanBan;
            $vb->parent_id = '';
            $vb->id_nhan = $userSesion['id'];
            $vb->ngaychuyentiep = date('Y-m-d H:i:s');
            $vb->user_tao = $userSesion['id'];
            $vb->noidung_butphe = $conten_butphe;
            $vb->status = 1;
            $vb->donvi_nhan_id = $userSesion['donvi_id'];
            $vb->loaivanban = $vanban->book_id;

            if ($vb->save()) {
                if ($userIds) {
                    foreach ($userIds as $userId) {
                        if (!in_array($userId, $sentUserIds)) {
                            $user = User::find($userId);

                            $vbxlyId = VanbanXuLy::insertGetId([
                                'vanbanUser_id' => $idVanBan,
                                'parent_id' => $vb->id,
                                'id_nhan' => $userId,
                                'ngaychuyentiep' => date('Y-m-d H:i:s'),
                                'user_tao' => $userSesion['id'],
                                'noidung_butphe' => $conten_butphe,
                                'status' => 1,
                                'is_chuyentiep' => 1,
                                'butphe_id' => $butphe->id,
                                'donvi_nhan_id' => $user->donvi_id,
                                'loaivanban' => $vanban->book_id
                            ]);
    
                            // save notification data
                            $arrInsertNotifications[] = [
                                'creator_id' => $userSesion['id'],
                                'receivor_id' => $userId,
                                'type' => Notification::$types['nhanvanbannoibochuyenxuly'],
                                'content' => 'Bạn nhận được một VB nội bộ chuyển xử lý',
                                'notificationable_id' => $vbxlyId,
                                'notificationable_type' => VanbanXuLy::class,
                                'created_at' => $now
                            ];
                        }
                    }
                }
            }
        }

        // Insert notifications
        if ($arrInsertNotifications) {
            Notification::insert($arrInsertNotifications);
        }

        // send mail
        if ($userIds) {
            // get nội dung gửi mail
            $vanban->title = 'Văn bản chuyển xử lý: '.$vanban->title;
            $vanban->donvisoan_id = $vanban->cq_banhanh;
            $vanban->loaivanban_id = Loaivanban::where('id', $vanban->loaivanban_id)->first()->name;
            $vanban->ngaydi = $vanban->ngayky;
            $vanban->link = url('vanbannoibo/chi-tiet', $idVanBan);
            $vanban->path = url('/vanban/dowload_file');
            $vanban->file = [$vanban->file_dinhkem];
            $vanban->loai = 'Nội bộ';
            $vanban->noidung_butphe = $conten_butphe;

            // get danh sách emails gửi đến
            $userIdsSendMail = [];
            foreach($userIds as $userId) {
                if (!in_array($userId, $sentUserIds)) {
                    $userIdsSendMail[] = $userId;
                }
            }
            $vanban->noinhan = User::select('email')->whereIn('id', $userIdsSendMail)->pluck('email')->toArray();

            // send mail
            $this->dispatch(new SendMailNoiBo($vanban->toArray()));
        }

        flash('Chuyển xử lý văn bản nội bộ thành công!');
        return redirect(url('vanbannoibo/chi-tiet', [$idVanBan]));
    }
}