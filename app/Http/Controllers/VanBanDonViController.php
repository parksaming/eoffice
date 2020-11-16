<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Jobs\SendMail;
use App\Jobs\SendMailVBDi;
use App\Jobs\SendMailBanHanh;
use Illuminate\Support\Facades\Storage;
use App\Models\VanbanDonvi;
use App\Models\Linhvucs;
use App\Loaivanban;
use App\Publish;
use App\Book;
use App\Models\Bookdetail;
use App\Lockvanban;
use App\Models\ButpheDonvi;
use App\Models\VanbanUser;
use App\Models\Log;
use App\Models\VanbanXuLyDonvi;
use App\Models\User;
use App\Models\SoVanBan;
use App\Models\Donvi;
use App\Models\Notification;
use App\Models\VanbanBanHanh;
use App\Models\YKienDonvi;

class VanBanDonViController extends Controller
{
    public function addVanBanDen()
    {
        $donvis = Donvi::all();
        $linhvucs = Linhvucs::all();
        $loaivanbans = Loaivanban::all();
        $publishs = Publish::all();

        // donvi
        $donvichons = Donvi::where('parent_id', session('user')['donvi_id'])->orderBy('donvis.ordering', 'ASC')->get();

        // get danh sách sổ văn bản đến
        $sovanbandens = SoVanBan::all();

        return view('vanbandonvi.nhap_van_ban_den', compact('donvis', 'linhvucs', 'loaivanbans', 'publishs', 'sovanbandens', 'donvichons', 'dataTreeview'));
    }

    public function edit_vanban($vanbanId) {
        // get logged user
        $loggedUser = (object) session('user');

        // get vanban
        $vanban = VanbanDonvi::getVanBan($vanbanId)->first();
        
        if (!$vanban) {
            flash('Văn bản không tồn tại');
            return redirect(route('chitiet_vanban_donvi', $vanbanId));
        }

        if ($vanban->user_id != $loggedUser->id) {
            flash('Bạn không có quyền sửa văn bản này');
            return redirect(route('chitiet_vanban_donvi', $vanbanId));
        }

        $donvis = Donvi::all();
        $linhvucs = Linhvucs::all();
        $loaivanbans = Loaivanban::all();
        $publishs = Publish::all();

        // donvi
        $donvichons = Donvi::where('parent_id', session('user')['donvi_id'])->orderBy('donvis.ordering', 'ASC')->get();

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

        $userChuTriDaXemVanBanIds = $vanban->vanbanxulys->where('type', VanbanXuLyDonvi::$type['chutri'])->where('parent_id', '<>', 0)->pluck('id_nhan')->toArray();
        $userPhoiHopDaXemVanBanIds = $vanban->vanbanxulys->where('type', VanbanXuLyDonvi::$type['phoihop'])->where('parent_id', '<>', 0)->pluck('id_nhan')->toArray();

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
            $selectedBookDetails = $vanban->donViPhoiHopIdsVal;

            // get danh sách user của mỗi bookdetail
            $userTrongDonViPhoiHops = [];
            foreach($selectedBookDetails as $bookDetail) {
                $donviTmp = Donvi::find($bookDetail);
                $usersTmp = User::getListLanhDao()->where('users.donvi_id', $bookDetail)->get();

                $userTrongDonViPhoiHops[$bookDetail] = (object) [
                    'name' => $donviTmp->name,
                    'users' => $usersTmp
                ];
            }
        }
        
        return view('vanbandonvi.edit_van_ban_den', compact('donvis', 'linhvucs', 'loaivanbans', 'publishs', 'sovanbandens', 'donvichons', 'vanban', 'userChuTris', 'userPhoiHops', 'userChuTriDaXemVanBanIds', 'userPhoiHopDaXemVanBanIds', 'donviPhoiHopDaXemVanBanIds', 'userTrongDonViPhoiHops'));
    }

    public function edit_vanban_di($vanbanId) {
        // get logged user
        $loggedUser = (object) session('user');

        // get vanban
        $vanban = VanbanDonvi::getVanBan($vanbanId)->first();
        
        $bookDetails = BookDetail::getList(2)->orderBy('book_detail.ordering', 'ASC')->get();

        // get đơn vị id trong bookdetails
        $donviIds = $bookDetails->pluck('donvi_id')->toArray();
        $donvischa = Donvi::where('parent_id', 1)->whereIn('id', $donviIds)->get();

        $linhvucs = Linhvucs::all();
        $loaivanbans = Loaivanban::all();
        
        return view('vanbandonvi.edit_van_ban_di', compact('loaivanbans', 'donvischa', 'donviIds', 'linhvucs', 'bookDetails', 'vanban'));
        return view('vanbandonvi.edit_van_ban_den', compact('donvis', 'linhvucs', 'loaivanbans', 'publishs', 'sovanbandens', 'bookDetails', 'vanban', 'userChuTris', 'userPhoiHops', 'userChuTriDaXemVanBanIds', 'userPhoiHopDaXemVanBanIds', 'donviPhoiHopDaXemVanBanIds', 'userTrongDonViPhoiHops'));
    }

    public function save_vanban(Request $request) {
        // get params
        $now = date('Y-m-d H:i:s');
        $loggedUser = (object) Session::get('user');
        $submitType = $request->get('type_submit', 'notsendmail');

        // get vanban
        $vanban = VanbanDonvi::getVanBan($request->vanban_id)->first();
        
        if (!$vanban) {
            flash('Văn bản không tồn tại');
            return redirect(route('chitiet_vanban_donvi', $request->vanban_id));
        }

        if ($vanban->user_id != $loggedUser->id) {
            flash('Bạn không có quyền sửa văn bản này');
            return redirect(route('chitiet_vanban_donvi', $request->vanban_id));
        }

        // update vanban
        $vanban->sovanban_id = $request->sovanban_id;
        $vanban->title = $request->title;
        $vanban->loaivanban_id = $request->loaivanban_id;
        $vanban->book_id = $request->book_id;
        $vanban->soden = $request->soden;
        $vanban->ngayden = formatYMD($request->ngayden);
        $vanban->cq_banhanh = $request->cq_banhanh;
        $vanban->kyhieu = $request->kyhieu;
        $vanban->ngayky = formatYMD($request->ngayky);
        $vanban->linhvuc_id = $request->linhvuc_id;
        $vanban->nguoiky = $request->nguoiky;
        $vanban->hanxuly = formatYMD($request->hanxuly);
        $vanban->publish_id = $request->publish;
        $vanban->note = $request->note;
        $vanban->urgency = $request->urgency;

        // user đơn vị chủ trì
        $userChuTriDaXemVanBanIds = $vanban->vanbanxulys->where('type', VanbanXuLyDonvi::$type['chutri'])->where('parent_id', '<>', 0)->pluck('id_nhan')->toArray();
        $userChuTriIds = array_merge($userChuTriDaXemVanBanIds, $request->user_chutri_ids? $request->user_chutri_ids : []);
        $vanban->usernhan = $userChuTriIds? ';'.implode(';', $userChuTriIds).';' : '';

        // user đơn vị phối hợp
        $userPhoiHopDaXemVanBanIds = $vanban->vanbanxulys->where('type', VanbanXuLyDonvi::$type['phoihop'])->where('parent_id', '<>', 0)->pluck('id_nhan')->toArray();
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
            $vanBanXuLyRoot = VanbanXuLyDonvi::getVanBanXuLyRoot($request->vanban_id)->first();

            // xóa những vanbanxuly chưa xem
            VanbanXuLyDonvi::getVanBanXuLyChuaXem($vanBanXuLyRoot->id)->delete();

            $arrInsertNotifications = []; // array store notification data
            
            // lưu danh sách user chủ trì
            if ($request->user_chutri_ids) {
                foreach ($request->user_chutri_ids as $userId) {
                    $user = User::find($userId);

                    $vbxlyId = VanbanXuLyDonvi::insertGetId([
                        'vanbanUser_id' => $vanban->id,
                        'parent_id' => $vanBanXuLyRoot->id,
                        'id_nhan' => $userId,
                        'ngaychuyentiep' => $now,
                        'user_tao' => $loggedUser->id,
                        'noidung_butphe' => $request->title,
                        'status' => 1,
                        'donvi_nhan_id' => $user->donvi_id,
                        'loaivanban' => $vanban->book_id
                    ]);

                    // save notification data
                    $arrInsertNotifications[] = [
                        'creator_id' => $loggedUser->id,
                        'receivor_id' => $userId,
                        'type' => Notification::$types['nhanvanbanmoi_donvi'],
                        'content' => 'Bạn nhận được văn bản mới',
                        'notificationable_id' => $vbxlyId,
                        'notificationable_type' => VanbanXuLyDonvi::class,
                        'created_at' => $now
                    ];
                }
            }

            // lưu danh sách user phối hợp
            if ($request->user_phoihop_ids) {
                foreach ($request->user_phoihop_ids as $userId) {
                    $user = User::find($userId);

                    $vbxlyId = VanbanXuLyDonvi::insertGetId([
                        'vanbanUser_id' => $vanban->id,
                        'parent_id' => $vanBanXuLyRoot->id,
                        'id_nhan' => $userId,
                        'ngaychuyentiep' => $now,
                        'user_tao' => $loggedUser->id,
                        'noidung_butphe' => $request->title,
                        'status' => 1,
                        'type' => 2,
                        'donvi_nhan_id' => $user->donvi_id,
                        'loaivanban' => $vanban->book_id
                    ]);

                    // save notification data
                    $arrInsertNotifications[] = [
                        'creator_id' => $loggedUser->id,
                        'receivor_id' => $userId,
                        'type' => Notification::$types['nhanvanbanmoi_donvi'],
                        'content' => 'Bạn nhận được văn bản mới',
                        'notificationable_id' => $vbxlyId,
                        'notificationable_type' => VanbanXuLyDonvi::class,
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
            // get nội dung gửi mail
            $vanban->donvisoan_id = $vanban->cq_banhanh;
            $vanban->loaivanban_id = Loaivanban::where('id', $vanban->loaivanban_id)->first()->name;
            $vanban->ngaydi = $vanban->ngayky;
            $vanban->link = route('chitiet_vanban_donvi', $vanban->id);
            $vanban->path = url('/vanban/dowload_file');
            $vanban->file = [$vanban->file_dinhkem];
            $vanban->loai = 'Đến';
            
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

            $vanban->noinhan = $emails;
    
            // send mail
            $vanban->isvanbandonvi = 1;
            $this->dispatch(new SendMail($vanban->toArray()));
        }

        if ($request->loai == 'Đi') {
            return redirect()->route('danhsach.vanbandi_donvi');
        } else {
            return redirect()->route('danhsach.vanbanden_donvi');
        }
    }

    public function guimailvbdi(Request $request) {
        // get văn bản đi
        $vanban = VanbanDonvi::find($request->vanban_id);
        if (!$vanban) {
            die(json_encode(['error' => 1, 'message' => 'Văn bản không tồn tại']));
        }

        // get loại văn bản
        $vanban->loai_vanban = Loaivanban::where('id', $vanban->loaivanban_id)->first()->name;

        // get lĩnh vực
        $vanban->linhvuc_name = $vanban->linhvuc_id? Linhvucs::where('id', $vanban->linhvuc_id)->first()->name : '';

        // get public
        $vanban->public =  $vanban->is_publish == 1? 'Public' : 'Không public';

        // get độ khẩn
        $vanban->dokhan = VanbanDonvi::$dokhans[$vanban->urgency];

        // get link
        $vanban->link = route('chi_tiet_van_ban_di_donvi', $vanban->id);

        // get danh sách emails sẽ gửi
        $vanban->emails = User::whereIn('id', $request->user_ids)->pluck('email')->toArray();

        $this->dispatch(new SendMailVBDi($vanban->toArray()));

        die(json_encode(['error' => 0]));
    }

    public function gui_lai_mail($vanbanId) {
        // get vanban
        $vanban = VanbanDonvi::getVanBan($vanbanId)->first();
        
        if (!$vanban) {
            flash('Văn bản không tồn tại');
            return redirect(route('chitiet_vanban_donvi', $vanbanId));
        }

        // get nội dung gửi mail
        $vanban->donvisoan_id = $vanban->cq_banhanh;
        $vanban->loaivanban_id = Loaivanban::where('id', $vanban->loaivanban_id)->first()->name;
        $vanban->ngaydi = $vanban->ngayky;
        $vanban->link = route('chitiet_vanban_donvi', $vanbanId);
        $vanban->path = url('/vanban/dowload_file');
        $vanban->file = [$vanban->file_dinhkem];
        $vanban->loai = 'Đến';

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

        $vanban->noinhan = $emails;

        // send mail
        $vanban->isvanbandonvi = 1;
        $this->dispatch(new SendMail($vanban->toArray()));
    }

    public function getUser()
    {
        $id_donvi = Input::get('id_donvi');
        if (sizeof($id_donvi) > 1) {
            $users = User::whereIn('donvi_id', $id_donvi)->get();
        } else {
            $users = User::where('donvi_id', $id_donvi)->get();
        }

        return view('vanbandonvi.ajax_user', compact('users'));
    }

    public function dsVanbanden(Request $request)
    {
        // get params
        $status = Input::get('status', '');
        $userId = Session::get('user')['id'];
        $tukhoa = Input::get('tukhoa', '');
        $linhvuc = Input::get('linhvuc', '');       
        $loaivanban = Input::get('loaivanban', '');       
        $ngaybanhanhtu = Input::get('ngaybanhanhtu', '');       
        $ngaybanhanhden = Input::get('ngaybanhanhden', '');       
        $ngayguitu = Input::get('ngayguitu', '');       
        $ngayguiden = Input::get('ngayguiden', '');
        $trangthai = Input::get('trangthai', '');
         
        // get data
        $vanbans = VanbanXuLyDonvi::getDanhSachDen($userId, $trangthai? $trangthai : $status, [
            'tukhoa' => $tukhoa,
            'linhvuc' => $linhvuc,
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

        return view('vanbandonvi.danh_sach_van_ban_den', compact('status', 'linhvucs', 'loaivanbans', 'vanbans'));
    }

    public function get_number_vbden_new() {
        $userId = session('user')['id'];

        $number = VanbanXuLyDonvi::getVBDenNew($userId)->count();

        return die(json_encode(['error' => 0, 'number' => $number]));
    }

    public function get_number_vbnoibo_new() {
        $userId = session('user')['id'];

        $number = VanbanXuLyDonvi::getVBNoiboNew($userId)->count();

        return die(json_encode(['error' => 0, 'number' => $number]));
    }

    //văn bản đến cần xử lý
    public function van_ban_den_xu_ly()
    {
        $user = Session::get('user');
        $userId = $user['id'];
        $vanbanxulys = VanbanXuLyDonvi::select('vanban_xulys_donvi.*', 'vanbans_donvi.*', 'vanban_xulys_donvi.status as trangthai', 'publish.name as namePublish', 'tbDviBanHanh.name as tenDonViBanHanh', 'users.fullname', 'vanbans_donvi.id as IdVanBan', 'vanbans_donvi.user_id as IdUser')
            ->leftJoin('vanbans', 'vanbans_donvi.id', '=', 'vanban_xulys_donvi.vanbanUser_id')
            ->leftJoin('publish', 'vanbans_donvi.publish_id', '=', 'publish.id')
            ->leftJoin('donvis as tbDviBanHanh', 'tbDviBanHanh.id', '=', 'vanbans_donvi.cq_banhanh')
            ->leftJoin('users', 'vanban_xulys_donvi.id_nhan', '=', 'users.id')
            ->where('vanban_xulys_donvi.id_nhan', $userId)->paginate(30)->appends(Input::except('page'));

        $checkStatus = VanbanXuLyDonvi::where('vanban_xulys_donvi.status',3)->where('vanban_xulys_donvi.id_nhan', $userId)->first();
        if(!$checkStatus){
            VanbanXuLyDonvi::where('vanban_xulys_donvi.id_nhan', $userId)->update(array('vanban_xulys_donvi.status' => 2, 'vanban_xulys_donvi.ngayxem' => date('Y-m-d H:i:s')));

        }
        return view('vanbandonvi.van_ban_den_xu_ly', compact('vanbanxulys'));
    }

    public function vanbandendagui()
    {
        $linhvucs = Linhvucs::all();
        $lists = VanbanDonvi::all();
        $publishs = Publish::all();
        $donvis = Donvi::all();
        $loaivanbans = Loaivanban::all();
        $book_detail = Bookdetail::where('book_id', 1)->get();
        $ds_vanbans = VanbanDonvi::select('vanbans_donvi.*', 'donvis.name as tenDonVi', 'linhvucs.name as nameLinhvuc', 'book.type as typeBook', 'book.name as nameBook', 'publish.name as namePublish', 'loaivanbans_donvi.name as TenLoaiVanBan')
            ->leftJoin('book', 'vanbans_donvi.book_id', '=', 'book.id')
            ->leftJoin('publish', 'vanbans_donvi.publish_id', '=', 'publish.id')
            ->leftJoin('linhvucs', 'vanbans_donvi.linhvuc_id', '=', 'linhvucs.id')
            ->leftJoin('donvis', 'vanbans_donvi.cq_banhanh', '=', 'donvis.id')
            ->leftJoin('loaivanbans', 'vanbans_donvi.loaivanban_id', '=', 'loaivanbans_donvi.id')
            ->orderBy('id', 'DESC')
            ->paginate(10)->appends(Input::except('page'));
        return view('vanbandonvi.danh_sach_van_ban_den_da_gui', compact('lists', 'ds_vanbans', 'publishs', 'donvis', 'linhvucs', 'loaivanbans', 'book_detail'));
    }

    public function dsVanbandi(Request $request)
    {
        // get params
        $loggedUser = (object) session('user');
        $userId = session('user')['id'];
        $tukhoa = Input::get('tukhoa', '');
        $linhvuc = Input::get('linhvuc', '');       
        $loaivanban = Input::get('loaivanban', '');       
        $ngaybanhanhtu = Input::get('ngaybanhanhtu', '');       
        $ngaybanhanhden = Input::get('ngaybanhanhden', '');       
        $ngayguitu = Input::get('ngayguitu', '');       
        $ngayguiden = Input::get('ngayguiden', '');

        // get data
        $vanbans = VanbanDonvi::getDanhSachDi($userId, [
            'tukhoa' => $tukhoa,
            'linhvuc' => $linhvuc,
            'loaivanban' => $loaivanban,
            'ngaybanhanhtu' => $ngaybanhanhtu,
            'ngaybanhanhden' => $ngaybanhanhden,
            'ngayguitu' => $ngayguitu,
            'ngayguiden' => $ngayguiden
        ])
        ->paginate(30)
        ->appends(Input::except('page'));

        // get data for filter in view 
        $linhvucs = Linhvucs::all();
        $publishs = Publish::all();
        $donvis = Donvi::all();
        $loaivanbans = Loaivanban::all();

        // get danh sách đơn vị để gửi mail trong bookdetails
        $bookDetails = BookDetail::getList(2)->orderBy('book_detail.ordering', 'ASC')->get();
        $donviGuiMails = Donvi::whereIn('id', $bookDetails->pluck('donvi_id')->toArray())->get();

        return view('vanbandonvi.danh_sach_van_ban_di', compact('vanbans', 'publishs', 'donvis', 'linhvucs', 'loaivanbans', 'donviGuiMails'));
    }

    public function attachfile(Request $request)
    {
        if ($request->hasFile('file_dinhkem')) {
            $date = time();
            $file = $request->file('file_dinhkem');
            $path = 'files/vanban/';
            $file_tmp = $file->getClientOriginalName();
            $file_arr = explode('.', $file_tmp);
            $file_ = str_slug($file_arr[0], '-') . '_' . $date . '.' . $file_arr[1];
            $filename = $file->move($path, $file_);
            if ($filename !== false) {
                die(json_encode(array('success' => true, 'filename' => $file_)));
            } else {
                die(json_encode(array('success' => false, 'message' => 'Lỗi khi upload, thử lại')));
            }
        } else
            die(json_encode(array('success' => false, 'message' => 'Dung lượng file lớn hơn 20M, vui lòng chọn lại file khác')));
    }

    public function removeFile(Request $request)
    {
        if (!empty($request->key)) {
            $path = 'files/vanban';
            @unlink($path . $request->key);
            die(json_encode(array('success' => true, 'id' => $request->key)));
        }
        die(json_encode(array('success' => false)));
    }

    public function addVanban(Request $request) {
        // get params
        $now = date('Y-m-d H:i:s');
        $user = Session::get('user');

        $vanban = new VanbanDonvi();
        $vanban->sovanban_id = $request->sovanban_id;
        $vanban->title = $request->title;
        $vanban->loaivanban_id = $request->loaivanban_id;
        $vanban->user_id = $user['id'];
        $vanban->book_id = $request->book_id;
        $vanban->soden = $request->soden;
        $vanban->ngayden = formatYMD($request->ngayden);
        $vanban->cq_banhanh = $request->cq_banhanh;
        $vanban->kyhieu = $request->kyhieu;
        $vanban->ngayky = formatYMD($request->ngayky);
        $vanban->linhvuc_id = $request->linhvuc_id;
        $vanban->nguoiky = $request->nguoiky;
        $vanban->hanxuly = formatYMD($request->hanxuly);
        $vanban->publish_id = $request->publish;
        $vanban->ngaygui = date('Y-m-d');
        $vanban->status = 0;
        $vanban->note = $request->note;
        $vanban->urgency = $request->urgency;
        $vanban->donvi_id = $request->donvi_id;
        $vanban->usernhan = $request->user_chutri_ids? ';'.implode(';', $request->user_chutri_ids).';' : '';
        $vanban->donviphoihop_ids = $request->donvi_phoihop_ids? ';'.implode(';', $request->donvi_phoihop_ids).';' : '';
        $vanban->userphoihop_ids = $request->user_phoihop_ids? ';'.implode(';', $request->user_phoihop_ids).';' : '';

        if (isset($request->is_publish)) {
            $vanban->is_publish = $request->is_publish;
        }

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
            // lưu vào vanban_xuly
            $vb = new VanbanXuLyDonvi();
            $vb->vanbanUser_id = $vanban->id;
            $vb->parent_id = '';
            $vb->id_nhan = $user['id'];
            $vb->ngaychuyentiep = $now;
            $vb->user_tao = $user['id'];
            $vb->noidung_butphe = $request->title;
            $vb->status = VanbanXuLyDonvi::$status['daxuly'];
            $vb->type = VanbanXuLyDonvi::$type['phoihop'];
            $vb->ngayxem = date('Y-m-d H:i:s');
            $vb->save();

            $arrInsertNotifications = []; // array store notification data
            
            // lưu danh sách user chủ trì
            if ($request->user_chutri_ids) {
                foreach ($request->user_chutri_ids as $userId) {
                    $cuser = User::find($userId);

                    $vbxlyId = VanbanXuLyDonvi::insertGetId([
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
                        'type' => Notification::$types['nhanvanbanmoi_donvi'],
                        'content' => 'Bạn nhận được văn bản mới',
                        'notificationable_id' => $vbxlyId,
                        'notificationable_type' => VanbanXuLyDonvi::class,
                        'created_at' => $now
                    ];
                }
            }

            // lưu danh sách user phối hợp
            if ($request->user_phoihop_ids) {
                foreach ($request->user_phoihop_ids as $userId) {
                    $cuser = User::find($userId);

                    $vbxlyId = VanbanXuLyDonvi::insertGetId([
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
                        'type' => Notification::$types['nhanvanbanmoi_donvi'],
                        'content' => 'Bạn nhận được văn bản mới',
                        'notificationable_id' => $vbxlyId,
                        'notificationable_type' => VanbanXuLyDonvi::class,
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
            $vanban->link = route('chitiet_vanban_donvi', $vanban->id);
            $vanban->path = url('/vanban/dowload_file');
            $vanban->file = [$vanban->file_dinhkem];
            $vanban->loai = $request->loai;

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
            $vanban->isvanbandonvi = 1;
            $this->dispatch(new SendMail($vanban->toArray()));
        }

        if ($request->loai == 'Đi') {
            return redirect()->route('danhsach.vanbandi_donvi');
        } else {
            return redirect()->route('danhsach.vanbanden_donvi');
        }
    }

    public function save_vanban_di(Request $request) {
        // get params
        $user = (object) Session::get('user');

        if (isset($request->vanban_id)) {
            $vanban = VanbanDonvi::find($request->vanban_id);
        }
        else {
            $vanban = new VanbanDonvi();
        }
        
        $vanban->book_id = $request->book_id;
        $vanban->title = $request->title;
        $vanban->loaivanban_id = $request->loaivanban_id;
        $vanban->user_id = $user->id;
        $vanban->donvi_creator_id = $user->donvi_id;
        $vanban->ngayky = formatYMD($request->ngayky);
        $vanban->kyhieu = $request->kyhieu;
        $vanban->sovb = $request->sovb;
        $vanban->cq_banhanh = $request->cq_banhanh;
        $vanban->linhvuc_id = $request->linhvuc_id;
        $vanban->nguoiky = $request->nguoiky;
        $vanban->is_publish = $request->is_publish;
        $vanban->urgency = $request->urgency;
        $vanban->note = $request->note;
        $vanban->donvi_nhan_vbdi = $request->donvi_nhan_vbdi;

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

            $vanban->file_vbdis = implode(';', $fileNames);
        }

        if ($vanban->save()) {
            flash('Lưu văn bản thành công');
        }
        else {
            flash('Lưu văn bản thất bại');
        }

        return redirect()->route('danhsach.vanbandi_donvi');
    }

    public function uploadFile(Request $request)
    {
        if ($request->hasFile('vanban_file')) {
            $file = $request->file('vanban_file');
            $date = strtotime(date('d-m-Y'));
            $filename = $file->getClientOriginalName();
            $file_arr = explode('.', $filename);
            $file_ = str_slug($file_arr[0], '-') . '_' . $date . '.' . $file_arr[1];
            $path = asset('files/vanban/' . $file_);
            $file->move('files/vanban', $file_);
            $defailfile = (explode("\n", detect_text($path)->text[0]));
            $date1 = str_replace(',', '', $defailfile['5']);
            $date2 = explode(' ', $date1);
            $date3 = $date2[3] . '-' . $date2[5] . '-' . $date2[7];
            $defailfile['5'] = $date3;
            if ($defailfile) {
                die(json_encode(array('success' => true, 'data' => $defailfile, 'file' => $file_)));
            } else {
                die(json_encode(array('success' => false, 'message' => 'Hình ảnh không thể trích xuất')));
            }
        } else {
            die(json_encode(array('success' => false, 'message' => 'Dung lượng file lớn hơn 20M, vui lòng chọn lại file khác')));
        }
    }

    public function ajaxDsVanban()
    {
        $data = Input::all();
        $search = VanbanDonvi::all();
        if ($data['tukhoa']) {
            $search .= $search->where('title', 'Like', '%' . $data['tukhoa'] . '%')
                ->orwhere('soden', 'Like', '%' . $data['tukhoa'] . '%')
                ->orwhere('cq_banhanh', 'Like', '%' . $data['tukhoa'] . '%')
                ->orwhere('kyhieu', 'Like', '%' . $data['tukhoa'] . '%')
                ->orwhere('nguoiky', 'Like', '%' . $data['tukhoa'] . '%');
        }
        if ($data['timtheo']) {
            $search .= $search->where('');
        }
        dd($data);
        die();
    }

    public function VanBanDi()
    {
        $bookDetails = BookDetail::getList(2)->orderBy('book_detail.ordering', 'ASC')->get();

        // get đơn vị id trong bookdetails
        $donviIds = $bookDetails->pluck('donvi_id')->toArray();
        $donvischa = Donvi::where('parent_id', 1)->whereIn('id', $donviIds)->get();

        $linhvucs = Linhvucs::all();
        $loaivanbans = Loaivanban::all();

        return view('vanbandonvi.nhap_van_ban_di', compact('loaivanbans', 'donvischa', 'donviIds', 'linhvucs', 'bookDetails'));
    }


    public function settingUnit()
    {
        $role = Session::get('user');
        if ($role['role'] == 1) {
            $donvischa = Donvi::where('parent_id', null)->get();
            $donvis = Donvi::all();
            $linhvucs = Linhvucs::all();
            $loaivanbans = Loaivanban::all();
            $publishs = Publish::all();
            $users = User::all();
            $books = Book::all();
            return view('vanbandonvi.cau_hinh_don_vi_nhan', compact('donvischa', 'linhvucs', 'loaivanbans', 'publishs', 'donvis', 'users', 'books'));
        } else {
            return view('vanbandonvi.test');
        }

    }

    //Thêm cấu hình cho Đơn Vị
    public function addCauhinh(Request $request)
    {
        $bookdetail = new Bookdetail();
        $bookdetail->book_id = $request->loaivanban_id;
        $bookdetail->donvi_id = $request->donvi_cauhinh;
        $bookdetail->donvi_email = $request->emaildonvi;
        if (sizeof($request->signer) > 1) {
            $bookdetail->user_id = implode(';', $request->signer);
        } else {
            $bookdetail->user_id = implode(';', $request->signer);
        }
        $bookdetail->save();
        return redirect()->back()->with('success', 'Cấu hình thành công');
    }

    //Kiểm tra xem đơn vị đã được cấu hình hay chưa
    public function checkDonvi()
    {
        $donvi = Input::get('donvi');
        $cauhinh = Input::get('cauhinh');
        $check = Bookdetail::where('donvi_id', $donvi)->where('book_id', $cauhinh)->first();
        if ($check) {
            die(json_encode(array('success' => false)));
        } else {
            die(json_encode(array('success' => true)));
        }
    }

    public function email()
    {
        return view('emails.vanbandi');
    }

    //View chi tiết văn bản đi và đến
    public function detailVanbanden($id) {
        // get params
        $tab = Input::get('tab', 0);
        $user = Session::get('user');

        // get vanbanxuly
        $checkvanbanXL = VanbanXuLyDonvi::where('vanbanUser_id', $id)->where('id_nhan', $user['id'])->first();

        // cập nhật văn bản là đã xem
        if($checkvanbanXL && !$checkvanbanXL->ngayxem) {
            VanbanXuLyDonvi::where('vanbanUser_id', $id)->where('id_nhan', $user['id'])->update(array('vanban_xulys_donvi.ngayxem' => date('Y-m-d H:i:s')));
        }

        // cập nhật các notification là đã xem
        {
            $vbxlIds = VanbanXuLyDonvi::where('vanbanUser_id', $id)->pluck('id')->toArray();
            Notification::where('receivor_id', $user['id'])
                        ->whereIn('notificationable_id', $vbxlIds)
                        ->where('notificationable_type', 'App\\Models\\VanbanXuLyDonvi')
                        ->whereNull('read_at')
                        ->update(['read_at' => date('Y-m-d H:i')]);
        }

        $vanbanden = VanbanXuLyDonvi::select('vanbans_donvi.*', 'vanban_xulys_donvi.status as trangthai', 'vanban_xulys_donvi.id as idVBUser', 'donvis.name as donviChuTriName', 'vanban_xulys_donvi.minhchung', 'vanban_xulys_donvi.file_minhchung')
            ->where('vanban_xulys_donvi.vanbanUser_id', $id)
            ->where('vanban_xulys_donvi.id_nhan', $user['id'])
            ->leftJoin('vanbans_donvi', 'vanban_xulys_donvi.vanbanUser_id', '=', 'vanbans_donvi.id')
            ->leftJoin('donvis', 'donvis.id', '=', 'vanbans_donvi.donvi_id')
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

        $vanbanxulys = VanbanXuLyDonvi::select('tbUserGui.fullname', 'tbUserNhan.fullname as userNhan', 'vanban_xulys_donvi.*', 'vanbans_donvi.ngaygui', 'vanbans_donvi.id as IdVanBan', 'vanbans_donvi.user_id as IdUser', 'donvis.name as tenDonVi')
            ->where('vanban_xulys_donvi.vanbanUser_id', $id)
            ->where('vanban_xulys_donvi.parent_id', '<>', 0)
            ->leftJoin('vanbans_donvi', 'vanban_xulys_donvi.vanbanUser_id', '=', 'vanbans_donvi.id')
            ->leftJoin('users as tbUserGui', 'tbUserGui.id', '=', 'vanbans_donvi.user_id')
            ->leftJoin('users as tbUserNhan', 'tbUserNhan.id', '=', 'vanban_xulys_donvi.id_nhan')
            ->leftJoin('donvis', 'donvis.id', '=', 'tbUserNhan.donvi_id')
            ->get();

        $parentId = VanbanXuLyDonvi::select('id_nhan','user_tao','id')->where('vanban_xulys_donvi.vanbanUser_id',$id)->orderBy('id', 'ASC')->first();

        $parent = VanbanXuLyDonvi::select('vanban_xulys_donvi.id')
            ->where('vanban_xulys_donvi.vanbanUser_id', $id)
            ->where('vanban_xulys_donvi.parent_id', 0)->first();
        $vanBanXuLy = VanbanXuLyDonvi::select('vanban_xulys_donvi.*', 'users.fullname')
            ->where('vanbanUser_id', $id)
            ->where('id_nhan', $user['id'])
            ->leftJoin('users', 'users.id', '=', 'vanban_xulys_donvi.user_tao')
            ->first();
        $vanBanXuLy->title = $vanbanden->title;

        $vb_child = [];
        $parent_id = $vanBanXuLy->parent_id == 0 ? $vanBanXuLy->id : $vanBanXuLy->parent_id;
        if ($vanBanXuLy) {
            childVanBanDonvi($parent->id, $vb_child);
        }

        $vbxuly = VanbanXuLyDonvi::getVanBanXuLy($vanBanXuLy->id)->first();

        // get butphes
        {
            // get danh sách bút phê đã gửi
            $vbxuly->butphes = ButpheDonvi::getList($id)->get();

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
            $userIdsTrongLuong = VanbanXuLyDonvi::select('id_nhan')->where('vanbanUser_id', $id)->pluck('id_nhan')->toArray();
            $userReceivers = User::whereIn('id', $userIdsTrongLuong)->where('id', '<>', session('user')['id'])->orderBy('fullname', 'ASC')->get();

            // cập nhật đã xem các trao đổi nhận được
            $user = User::where('id', session('user')['id'])->whereHas('ykiendonvis', function($q) {
                $q->whereNull('user_ykien_donvi.read_at');
            })->first();
            if ($user) {
                foreach($user->ykiendonvis as $ykien) {
                    $ykien->pivot->read_at = $now;
                    $ykien->pivot->save();
                }
            }

            // get danh sách ý kiến
            $ykiens = YKienDonvi::getList($id, session('user')['id'])->get();
        }
        
        // tab công việc
        {
            // get danh sách công việc của văn bản
            $congviecController = new CongviecController();
            $congviecs = $congviecController->get_danh_sach_cong_viec(['vanban_donvi_id' => $vanBanXuLy->vanbanUser_id]);

            // get danh sách đơn vị
            $donvis = Donvi::getList()->whereIn('id', BookDetail::select('donvi_id')->where('book_id', 3)->pluck('donvi_id')->toArray())->active()->get();
        }

        return view('vanbandonvi.chi_tiet_van_ban_den', compact(
            'tab', 'vbxuly', 
            'vanbanden', 'id_vanbanuser', 'vanbanxulys', 'user','parentId','vb_child','id', 'vanBanXuLy', 'userChuTris', 'donviPhoihops', 'userPhoihops',
            'ykiens', 'userReceivers', // data for tab trao đổi văn bản
            'congviecs', 'donvis' // data for tab công việc
        ));
    }

    public function chi_tiet_van_ban_di($vanbanId) {
        // get văn bản
        $vanban = VanbanDonvi::getVanBanDi($vanbanId)->first();
        if (!$vanban) {
            flash('Văn bản không tồn tại!');
            return redirect(route('danhsach.vanbandi_donvi'));
        }

        return view('vanbandonvi.chi_tiet_van_ban_di', compact('vanban'));
    }

    //View chi tiết văn bản đến đã gửi
    public function chi_tiet_van_ban_den_da_gui($id)
    {
        $user = Session::get('user');
        $username_create = $user['username'];
        $vanbanden = VanbanDonvi::where('id', $id)->where('user_id', $user['id'])->first();

        return view('vanbandonvi.chi_tiet_van_ban_den_da_gui', compact('vanbanden', 'user'));

    }


    //Download file đính kèm
    public function dowloadFile($name)
    {
        // get params
        $vanbanId = Input::get('vanban_id', '');
        $loggedUser = session('user');
        $name = Input::get('file', $name);
        if ($vanbanId) {
            if ($loggedUser) {
                $vanbanxuly = VanbanXuLyDonvi::where('vanbanUser_id', $vanbanId)->where('id_nhan', $loggedUser['id'])->first();
                if ($vanbanxuly && !$vanbanxuly->ngayxem) {
                    $vanbanxuly->ngayxem = date('Y-m-d H:i:s');
                    $vanbanxuly->save();
                }

                // cập nhật các notification là đã xem
                {
                    $vbxlIds = VanbanXuLyDonvi::where('vanbanUser_id', $vanbanId)->pluck('id')->toArray();
                    Notification::where('receivor_id', $loggedUser['id'])
                                ->whereIn('notificationable_id', $vbxlIds)
                                ->where('notificationable_type', 'App\\Models\\VanbanXuLyDonvi')
                                ->whereNull('read_at')
                                ->update(['read_at' => date('Y-m-d H:i')]);
                }
            }
        }

        $files = 'files/vanban/' . $name;
        return response()->download($files);
    }

    public function dsVanbanluu()
    {
        $user = Session::get('user');
        $donvis = Donvi::all();
        $publishs = Publish::all();
        $lists = VanbanDonvi::where('save', 1)->where('user_id', $user['id'])->orderBy('id', 'DESC')->get();
        return view('vanbandonvi.van_ban_luu', compact('lists', 'donvis', 'publishs'));
    }

    public function detailVanbanluu($id)
    {
        $vanbanden = VanbanDonvi::find($id);
        return view('vanbandonvi.chi_tiet_van_ban_den', compact('vanbanden'));
    }

    public function editVanbanluu($id)
    {
        $donvis = Donvi::all();
        $linhvucs = Linhvucs::all();
        $loaivanbans = Loaivanban::all();
        $publishs = Publish::all();
        $book_detail = Bookdetail::where('book_id', 1)->get();
        $vanbans = VanbanDonvi::findorFail($id);
        return view('vanbandonvi.edit_van_ban_luu', compact('donvis', 'linhvucs', 'loaivanbans', 'publishs', 'book_detail', 'vanbans'));
    }

    public function edit_van_ban_da_gui($id)
    {
        $donvis = Donvi::all();
        $linhvucs = Linhvucs::all();
        $loaivanbans = Loaivanban::all();
        $publishs = Publish::all();


        $book_detail = Bookdetail::select('book_detail.*', 'donvis.id as idDonVi', 'donvis.name as TenDonVi')
            ->where('book_id', 1)
            ->leftJoin('donvis', 'book_detail.donvi_id', '=', 'donvis.id')
            ->get();

        $vanbans = VanbanDonvi::findorFail($id);
        $vanbanusers = VanbanUser::where('vanban_id', $id)->get();

        $userid = array();
        $arrDv = array();
        foreach ($vanbanusers as $vanbanuser) {
            $userid[] = $vanbanuser->user_id;
            $arrDv[] = $vanbanuser->donvi_id;
        }

        return view('vanbandonvi.edit_van_ban_da_gui', compact('donvis', 'linhvucs', 'loaivanbans', 'publishs', 'book_detail', 'vanbans', 'userid', 'arrDv'));
    }

    public function addEditvanban(Request $request)
    {
        $user = Session::get('user');
        $vanban = VanbanDonvi::findorFail($request->id);
        $vanban_file = isset($request->vanban_file) ? $request->vanban_file : '';
        $title = isset($request->title) ? $request->title : '';
        $loaivanban_id = isset($request->loaivanban_id) ? $request->loaivanban_id : '';
        $ngaydi = isset($request->ngaydi) ? formatYMD($request->ngaydi) : '';
        $user_id = $user['id'];
        $book_id = isset($request->book_id) ? $request->book_id : '';
        $soden = isset($request->soden) ? $request->soden : '';
        $ngayden = isset($request->ngayden) ? formatYMD($request->ngayden) : '';
        $cq_banhanh = isset($request->cq_banhanh) ? $request->cq_banhanh : '';
        $kyhieu = isset($request->kyhieu) ? $request->kyhieu : '';
        $ngayky = isset($request->ngayky) ?  formatYMD($request->ngayky): '';
        $linhvuc_id = isset($request->linhvuc_id) ? $request->linhvuc_id : '';
        $nguoiky = isset($request->nguoiky) ? $request->nguoiky : '';
        $hanxuly = isset($request->hanxuly) ? formatYMD($request->hanxuly) : '';
        $publish_id = isset($request->publish) ?  $request->publish : '';
        $status = 0;
        $file_dinhkem = isset($request->file_dinhkem) ? implode(';', $request->file_dinhkem) : '';
        $note = isset($request->note) ?  $request->note : '';
        $urgency = isset($request->urgency) ?  $request->urgency : '';
        $inputs = Input::all();
        $noinhan = isset($inputs['noinhan']) ? $inputs['noinhan'] : '';
        $arr_usernhan = [];
        if ($noinhan) {
            foreach ($noinhan as $value) {
                if (isset($value['user'])) {
                    foreach ($value['user'] as $userId) {
                        $arr_usernhan[] = $userId;
                    }
                }
            }

        }
        VanbanDonvi::where('id', $request->id)->update(array(
            'user_id' => $user_id,
            'book_id' => $book_id,
            'title'=> $title,
            'loaivanban_id'=> $loaivanban_id,
            'ngayden'=> $ngayden,
            'ngaydi'=> $ngaydi,
            'soden'=> $soden,
            'cq_banhanh'=> $cq_banhanh,
            'kyhieu'=> $kyhieu,
            'ngayky'=> $ngayky,
            'linhvuc_id'=> $linhvuc_id,
            'nguoiky'=> $nguoiky,
            'hanxuly'=> $hanxuly,
            'publish_id'=> $publish_id,
            'note'=> $note,
            'save'=> $book_id,
            'status'=> $status,
            'vanban_file'=> $vanban_file,
            'urgency'=> $urgency,
            'ngaygui'=> date('Y-m-d'),
            'file_dinhkem' => $file_dinhkem,
            'usernhan' => $arr_usernhan ? implode(',', $arr_usernhan) : ''
        ));

        VanbanUser::where('vanban_id', $request->id)->delete();
        Lockvanban::where('vanban_id', $request->id)->delete();
        VanbanXuLyDonvi::where('vanbanUser_id', $request->id)->delete();

        if ($noinhan) {
            foreach ($noinhan as $value) {
                if (isset($value['donvi'])) {
                    //lưu vao bảng văn bản xử lý
                    $checkparentVanBan = VanbanXuLyDonvi::where('vanbanUser_id', $vanban->id)
                        ->where('vanban_xulys_donvi.id_nhan', $user['id'])->first();
                    if (!$checkparentVanBan) {
                        $vb = new VanbanXuLy();
                        $vb->vanbanUser_id = $vanban->id;
                        $vb->parent_id = '';
                        $vb->id_nhan = $user['id'];
                        $vb->ngaychuyentiep = date('Y-m-d H:i:s');
                        $vb->user_tao = $user['id'];
                        $vb->noidung_butphe = $request->title;
                        $vb->status = 1;
                        $vb->donvi_nhan_id = $user['donvi_id'];
                        $vb->loaivanban = $book_id;

                        if ($vb->save()) {
                            if (isset($value['user'])) {
                                foreach ($value['user'] as $userId) {
                                    $fuser = User::find($userId);

                                    VanbanXuLyDonvi::insert([
                                        'vanbanUser_id' => $vanban->id,
                                        'parent_id' => $vb->id,
                                        'id_nhan' => $userId,
                                        'ngaychuyentiep' => date('Y-m-d H:i:s'),
                                        'user_tao' => $user['id'],
                                        'noidung_butphe' => $request->title,
                                        'status' => 1,
                                        'donvi_nhan_id' => $fuser->donvi_id,
                                        'loaivanban' => $book_id
                                    ]);
                                }
                            }
                        }
                    } else {
                        if (isset($value['user'])) {
                            foreach ($value['user'] as $userId) {
                                $fuser = User::find($userId);

                                VanbanXuLyDonvi::insert([
                                    'vanbanUser_id' => $vanban->id,
                                    'parent_id' => $checkparentVanBan->id,
                                    'id_nhan' => $userId,
                                    'ngaychuyentiep' => date('Y-m-d H:i:s'),
                                    'user_tao' => $user['id'],
                                    'noidung_butphe' => $request->title,
                                    'status' => 1,
                                    'donvi_nhan_id' => $fuser->donvi_id,
                                    'loaivanban' => $book_id
                                ]);
                            }
                        }
                    }
                    if(isset($value['user'])){
                        foreach ($value['user'] as $userId) {
                            $vbid = new VanbanUser();
                            $vbid->user_id = $userId;
                            $vbid->donvi_id = isset($value['donvi']) ? $value['donvi'] : '';
                            $vbid->vanban_id = $vanban->id;
                            $vbid->created = date('Y-m-d H:i:s');
                            $vbid->status =null;
                            $vbid->save();
                        }
                    }
                } elseif (isset($value['user'])) {
                    //lưu vao bảng văn bản xử lý
                    foreach ($value['user'] as $userId) {
                        $vbid = new VanbanUser();
                        $vbid->user_id = $userId;
                        $vbid->donvi_id = isset($value['donvi']) ? $value['donvi'] : '';
                        $vbid->vanban_id = $vanban->id;
                        $vbid->created = date('Y-m-d H:i:s');
                        $vbid->status =null;
                        if ($vbid->save()) {
                            $checkparentVanBan = VanbanXuLyDonvi::where('vanbanUser_id', $vanban->id)
                                ->where('vanban_xulys_donvi.id_nhan', $user['id'])->first();

                            if (!$checkparentVanBan) {
                                $vb = new VanbanXuLy();
                                $vb->vanbanUser_id = $vanban->id;
                                $vb->parent_id = '';
                                $vb->id_nhan = $user['id'];
                                $vb->ngaychuyentiep = date('Y-m-d H:i:s');
                                $vb->user_tao = $user['id'];
                                $vb->noidung_butphe = $request->title;
                                $vb->status = 1;
                                $vb->donvi_nhan_id = $user['donvi_id'];
                                $vb->loaivanban = $book_id;

                                if ($vb->save()) {
                                    $fuser = User::find($userId);

                                    VanbanXuLyDonvi::insert([
                                        'vanbanUser_id' => $vanban->id,
                                        'parent_id' => $vb->id,
                                        'id_nhan' => $userId,
                                        'ngaychuyentiep' => date('Y-m-d H:i:s'),
                                        'user_tao' => $user['id'],
                                        'noidung_butphe' => $request->title,
                                        'status' => 1,
                                        'donvi_nhan_id' => $fuser->donvi_id,
                                        'loaivanban' => $book_id
                                    ]);
                                }
                            } else {
                                VanbanXuLyDonvi::insert([
                                    'vanbanUser_id' => $vanban->id,
                                    'parent_id' => $checkparentVanBan->id,
                                    'id_nhan' => $userId,
                                    'ngaychuyentiep' => date('Y-m-d H:i:s'),
                                    'user_tao' => $user['id'],
                                    'noidung_butphe' => $request->title,
                                    'status' => 1
                                ]);
                            }

                        }
                    }

                }
            }
            $datasend = date('d/m/Y');
            if ($noinhan) {
                foreach ($noinhan as $value) {
                    if (isset($value['user'])) {
                        foreach ($value['user'] as $userId) {
                            $lock = new Lockvanban();
                            $lock->user_id = $userId;
                            $lock->vanban_id = $vanban->id;
                            $lock->ngaygui = $datasend;
                            $lock->save();
                        }
                    }
                }
            }

        }
        return redirect()->route('danhsach.vanbanden_donvi');
    }

    public function gui_lai_mail_van_ban_den($id)
    {

    }

    public function gui_but_phe_van_ban_den($id)
    {
        $vanbanden = VanbanDonvi::select('vanbans_donvi.*', 'book.name as bookName', 'publish.name as publishName', 'linhvucs.name as linhvucName', 'donvis.name as donviName', 'loaivanbans_donvi.name as tenLoaiVanBan')->where('vanbans_donvi.id', $id)
            ->leftJoin('book', 'vanbans_donvi.book_id', '=', 'book.id')
            ->leftJoin('publish', 'vanbans_donvi.publish_id', '=', 'publish.id')
            ->leftJoin('linhvucs', 'vanbans_donvi.linhvuc_id', '=', 'linhvucs.id')
            ->leftJoin('donvis', 'vanbans_donvi.cq_banhanh', '=', 'donvis.id')
            ->leftJoin('loaivanbans', 'vanbans_donvi.loaivanban_id', '=', 'loaivanbans_donvi.id')
            ->first();
        $book_detail = Bookdetail::select('book_detail.*', 'donvis.name as tendonvi', 'donvis.id as donvi_id')->where('book_id', 4)
            ->leftJoin('donvis', 'book_detail.donvi_id', '=', 'donvis.id')
            ->get();
        Log::where('vanban_id', $id)->update(array('logs.status' => 2));
        return view('vanbandonvi.gui_but_phe_van_ban_den', compact('vanbanden', 'book_detail'));
    }

    public function save_but_phe_van_ban_den(Request $request)
    {
        $inputs = Input::all();
        $idVanBan = $inputs['id'];
        $userSesion = Session::get('user');
        $username_create = $userSesion['username'];
        $usernhan = isset($inputs['usernhan']) ? $inputs['usernhan'] : '';
        $noinhan = isset($inputs['noinhan']) ? $inputs['noinhan'] : '';
        $conten_butphe = isset($inputs['conten_butphe']) ? $inputs['conten_butphe'] : '';
        $vanban = VanbanDonvi::where('id', $idVanBan)->first();
        $vb = new Vanban();
        $vb->user_id = $vanban->user_id;
        $vb->book_id = $vanban->book_id;
        $vb->loaivanban_id = $vanban->loaivanban_id;
        $vb->title = $vanban->title . ' gửi bút phê';
        $vb->ngayden = $vanban->ngayden;
        $vb->ngaydi = $vanban->ngaydi;
        $vb->soden = $vanban->soden;
        $vb->cq_banhanh = $vanban->cq_banhanh;
        $vb->kyhieu = $vanban->kyhieu;
        $vb->ngayky = $vanban->ngayky;
        $vb->linhvuc_id = $vanban->linhvuc_id;
        $vb->nguoiky = $vanban->nguoiky;
        $vb->hanxuly = $vanban->hanxuly;
        $vb->publish_id = $vanban->publish_id;
        $vb->note = $vanban->note;
        $vb->save = $vanban->save;
        $vb->status = $vanban->status;
        $vb->vanban_file = $vanban->vanban_file;
        $vb->urgency = $vanban->urgency;
        $vb->vanban_id = $idVanBan;
        $vb->content_butphe = $conten_butphe;
        if ($vb->save()) {
            if ($noinhan) {
                for ($i = 0; $i < sizeof($noinhan); $i++) {
                    $dataDonvi = Donvi::select('donvis.*')
                        ->where('donvis.id', $noinhan[$i])
                        ->first();
                    $vanbanUser = new VanbanUser();
                    $vanbanUser->donvi_id = $noinhan[$i];
                    $vanbanUser->vanban_id = $vanban->id;
                    $vanbanUser->content_butphe = $conten_butphe;
                    $vanbanUser->user_id = '';
                    $vanbanUser->created = date('Y-m-d H:i:s');
                    $vanbanUser->save();
                    $content = $userSesion['fullname'] . ' gửi bút phê đến đơn vị ' . $dataDonvi->name . ' vào lúc ' . date('H:i');
                    save_log($username_create, null, $content, 'guibutphe', $noinhan[$i], $vanban->id);
                }
            }
            if ($usernhan) {
                for ($i = 0; $i < sizeof($usernhan); $i++) {
                    $user = User::select('users.donvi_id', 'users.fullname', 'users.username')
                        ->where('users.id', $usernhan[$i])
                        ->first();
                    $vanbanUser = new VanbanUser();
                    $vanbanUser->user_id = $usernhan[$i];
                    $vanbanUser->vanban_id = $vanban->id;
                    $vanbanUser->content_butphe = $conten_butphe;
                    $vanbanUser->donvi_id = $user->donvi_id ? $user->donvi_id : '';
                    $vanbanUser->created = date('Y-m-d H:i:s');
                    $vanbanUser->save();
                    $content = $userSesion['fullname'] . ' gửi bút phê đến ' . $user->fullname . ' vào lúc ' . date('H:i');
                    save_log($username_create, $user->username, $content, 'guibutphe', $noinhan[$i], $vanban->id);
                }
            }
        }
        flash('Gủi bút phê thành công!');
        return \redirect(route('danhsach.vanbanden_donvi'));
    }

    public function view_log($IdVanBanUser)
    {
        $dataLog = Log::select('vanbans_donvi.cq_banhanh', 'vanbans_donvi.title', 'vanbans_donvi.file_dinhkem', 'vanbans_donvi.ngaygui', 'vanbans_donvi.hanxuly', 'logs.*', 'tbDonViNhan.name as tenDonViNhan', 'tbDviBanHanh.name as tenDViBanHanh')
            ->where('logs.vanban_id', $IdVanBanUser)
            ->leftJoin('vanbans', 'logs.vanban_id', '=', 'vanbans_donvi.id')
            ->leftJoin('donvis as tbDonViNhan', 'tbDonViNhan.id', '=', 'logs.donvi_id')
            ->leftJoin('donvis as tbDviBanHanh', 'tbDviBanHanh.id', '=', 'vanbans_donvi.cq_banhanh')
            ->get();
        return view('vanbandonvi.view_log', compact('dataLog'));
    }

    public function sendInfo()
    {
        $user = Session::get('user');
        $user_capnhat = $user['id'];
        $id = Input::get('id', null);
        $type = Input::get('type', null);

        VanbanUser::where('id', $id)->update(array('vanban_users.ngaycapnhat' => date('Y-m-d H:i:s'), 'vanban_users.user_capnhat' => $user_capnhat, 'vanban_users.status' => $type));
        flash('Cập nhật thành công!');

        return json_encode(array('error' => 0));
    }

    public function chuyen_xu_ly_van_ban($id)
    {

        $userSesion = Session::get('user');
        $vanbanden = VanbanDonvi::select('vanbans_donvi.*', 'book.name as bookName','vanban_xulys_donvi.status as trangthai', 'publish.name as publishName', 'linhvucs.name as linhvucName', 'donvis.name as donviName', 'donvis.viettat as tenvtdonvi', 'loaivanbans.name as tenLoaiVanBan')
            ->where('vanbans_donvi.id', $id)
            ->where('vanban_xulys_donvi.id_nhan', $userSesion['id'])
            ->leftJoin('book', 'vanbans_donvi.book_id', '=', 'book.id')
            ->leftJoin('publish', 'vanbans_donvi.publish_id', '=', 'publish.id')
            ->leftJoin('linhvucs', 'vanbans_donvi.linhvuc_id', '=', 'linhvucs.id')
            ->leftJoin('donvis', 'vanbans_donvi.cq_banhanh', '=', 'donvis.id')
            ->leftJoin('loaivanbans', 'vanbans_donvi.loaivanban_id', '=', 'loaivanbans.id')
            ->leftJoin('vanban_xulys_donvi', 'vanbans_donvi.id', '=', 'vanban_xulys_donvi.vanbanUser_id')
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

        $vanbanxulys = VanbanXuLyDonvi::select('id_nhan')->where('vanban_xulys_donvi.vanbanUser_id', $id)->get();
        $arrIdUser= [];
        foreach ($vanbanxulys as $vanbanxuly) {
            $arrIdUser[] =$vanbanxuly->id_nhan;
        }

        $book_detail = Bookdetail::select('book_detail.*', 'donvis.name as tendonvi', 'donvis.id as donvi_id','donvis.viettat as tenvtdonvi')->where('book_id', 1)
            ->leftJoin('donvis', 'book_detail.donvi_id', '=', 'donvis.id')
            ->get();

        // get userIds đã có trong luồng luân chuyển
        $userIds = VanbanXuLyDonvi::select('id_nhan')->where('vanbanUser_id', $id)->pluck('id_nhan')->toArray();

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

        $loggedDonvi = Donvi::find(session('user')['donvi_id']);
        $donvikey = substr($loggedDonvi->madonvi, 0, 4);
        $donvichons = Donvi::where('madonvi', 'like', "$donvikey%")->orderBy('donvis.ordering', 'ASC')->get();

        foreach($donvichons as $donvi) {
            $items = [];

            $users = User::where('users.donvi_id', $donvi->id)->get();

            $hasSelected = false;
            foreach($users as $user) {
                $items[] = [
                    'id' => $donvi->id.'_'.$user->id,
                    'text' => $user->fullname.' - '.$user->chucdanh.' - '.$user->email,
                    'expanded' => ($donvi->id == $userSesion['donvi_id'])? 1 : 0,
                    'has_selected' => in_array($user->id, $userIds)? true : false
                ];

                if (in_array($user->id, $userIds)) {
                    $hasSelected = true;
                }
            }

            $dataTreeview[] = [
                'id' => $donvi->id,
                'text' => $donvi->name,
                'items' => $items,
                'expanded' => $hasSelected
            ];
        }

        $vanbanxuly = VanbanXuLyDonvi::where('vanbanUser_id', $id)->where('vanban_xulys_donvi.id_nhan', $userSesion['id'])->first();
        if ($vanbanxuly && !$vanbanxuly->ngayxem) {
            $vanbanxuly->ngayxem = date('Y-m-d H:i:s');
            $vanbanxuly->save();
        }

        return view('vanbandonvi.chuyen_xu_ly_van_ban', compact('vanbanden', 'book_detail', 'IdVanBanUser','arrIdUser','dataTreeview', 'userChuTris', 'donviPhoihops', 'userPhoihops'));
    }

    public function luu_xu_ly_van_ban(Request $request)
    {
        // get params
        $userIds = isset($request->users) ? $request->users : null;
        $now = date('Y-m-d H:i:s');
        $inputs = Input::all();
        $idVanBan = $inputs['id'];
        $userSesion = Session::get('user');
        
        $conten_butphe = isset($inputs['conten_butphe']) ? $inputs['conten_butphe'] : '';
        $checkparentVanBan = VanbanXuLyDonvi::where('vanbanUser_id', $idVanBan)->where('vanban_xulys_donvi.id_nhan', $userSesion['id'])->first();

        // lưu nội dung bút phê
        $butphe = ButpheDonvi::create([
            'vanban_id' => $idVanBan,
            'noidung' => $conten_butphe,
            'receiver_ids' => ';'.trim(implode(';',$userIds)).';',
            'created_by' => $userSesion['id']
        ]);

        // get sentUserIds đã có trong luồng luân chuyển
        $sentUserIds = VanbanXuLyDonvi::select('id_nhan')->where('vanbanUser_id', $idVanBan)->pluck('id_nhan')->toArray();

        $arrInsertNotifications = []; // array store notification data

        // get nội dung văn bản
        $vanban = VanbanDonvi::find($idVanBan);

        if ($checkparentVanBan) {
            if ($userIds) {
                foreach ($userIds as $userId) {
                    if (!in_array($userId, $sentUserIds)) {
                        $user = User::find($userId);

                        $vbxlyId = VanbanXuLyDonvi::insertGetId([
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
                            'type' => Notification::$types['nhanvanbanchuyenxuly_donvi'],
                            'content' => 'Bạn nhận được một VB chuyển xử lý',
                            'notificationable_id' => $vbxlyId,
                            'notificationable_type' => VanbanXuLyDonvi::class,
                            'created_at' => $now
                        ];
                    }
                }
            }
        } else {
            $vb = new VanbanXuLyDonvi();
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

                            $vbxlyId = VanbanXuLyDonvi::insertGetId([
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
                                'type' => Notification::$types['nhanvanbanchuyenxuly_donvi'],
                                'content' => 'Bạn nhận được một VB chuyển xử lý',
                                'notificationable_id' => $vbxlyId,
                                'notificationable_type' => VanbanXuLyDonvi::class,
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
            $vanban->link = route('chitiet_vanban_donvi', $idVanBan);
            $vanban->path = url('/vanban/dowload_file');
            $vanban->file = [$vanban->file_dinhkem];
            $vanban->loai = 'Đến';
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
            $vanban->isvanbandonvi = 1;
            $this->dispatch(new SendMail($vanban->toArray()));
        }

        flash('Chuyển xử lý văn bản thành công!');
        return \redirect(route('danhsach.vanbanden_donvi'));
    }

    public function save_ykien(Request $request) {
        $now = date('Y-m-d H:i:s');
        $loggedUser = (object) session('user');

        $file_name = '';
        if($request->hasFile('file')) {
            $file = $request->file('file');

            $storage_path = Storage::putFile("local/files", $file, 'public');
            $file_name = basename($storage_path);
        }

        // lưu nội dung trao đổi
        $ykien = YKienDonvi::create([
            'file' => $file_name,
            'vanban_id' => $request->vanban_id,
            'noidung' => $request->noidung,
            'created_by' => Session::get('user')['id'],
            'created_at' => $now
        ]);

        // lưu danh sánh người nhận trao đổi
        $ykien->userNhans()->attach($request->receiver_ids);

        flash('Gửi trao đổi thành công');

        $vanban = VanbanDonvi::find($request->vanban_id);

        $arrInsertNotifications = []; // array store notification data
        foreach($request->receiver_ids as $receiverId) {
            $arrInsertNotifications[] = [
                'creator_id' => $loggedUser->id,
                'receivor_id' => $receiverId,
                'type' => Notification::$types['nhantraodoicongviec_vanbandonvi'],
                'content' => 'Bạn nhận được 1 trao đổi công việc',
                'notificationable_id' => $request->vanban_id,
                'notificationable_type' => VanbanDonvi::class,
                'created_at' => $now
            ];
        }
        if ($arrInsertNotifications) {
            Notification::insert($arrInsertNotifications);
        }

        if ($vanban->book_id == 4) {
            return redirect(url('vanbannoibo/chi-tiet/'.$request->vanban_id.'?tab=2'));
        }
        else {
            return redirect(route('chitiet_vanban_donvi', [$request->vanban_id, 'tab' => 2]));
        }
    }
    
    public function quy_trinh_chuyen_tiep()
    {
        $Id = Input::get('Id');
        $vanBanXuLy = VanbanXuLyDonvi::select('vanban_xulys_donvi.*', 'users.fullname')
            ->where('vanbanUser_id', $Id)
            ->leftJoin('users', 'users.id', '=', 'vanban_xulys_donvi.user_tao')
            ->first();

        $vb_child = [];

        $parent_id = $vanBanXuLy->parent_id == 0 ? $vanBanXuLy->id : $vanBanXuLy->parent_id;
        if ($vanBanXuLy) {
            $vb_child = getCayLuanChuyenDonvi($parent_id);
            $vanBanXuLy->children = $vb_child;
        }

        return view('vanbandonvi.quy_trinh_chuyen_tiep', compact('vanBanXuLy', 'vb_child'));
    }

    public function xu_ly_van_ban_user()
    {
        $id = Input::get('id');
        $id_vanbanuser = Input::get('id_vanbanuser');
        return view('vanbandonvi.xu_ly_van_ban_user', compact('id_vanbanuser', 'id'));
    }

    public function cap_nhat_trang_thai_xu_ly(Request $request) {
        // get params
        $loggedUser = (object) Session::get('user');
        $vanbanxulyId = $request->get('vanbanxuly_id');
        $status = $request->get('status');
        $now = date('Y-m-d H:i:s');
        $forceChange = $request->get('force_change');
        $minhchung = $request->get('minhchung');
        
        $file_minhchung = '';
        $file = $request->file('file');
        if ($file) {
            $path = 'files/vanban/';

            $fileNameArr = explode('.', $file->getClientOriginalName());
            $file_minhchung = str_slug($fileNameArr[0], '-') . '_' . time() . '.' . $fileNameArr[1];

            $file->move($path, $file_minhchung);
        }

        // get vanbanxuly
        $vanbanxuly = VanbanXuLyDonvi::find($vanbanxulyId);

        if (!$vanbanxuly) {
            flash('Có lỗi! Dữ liệu không tồn tại');
            return Redirect::back();
        }

        // cập nhật trạng thái của vanbanxuly
        if ($vanbanxuly->status != $status) {
            // kiểm tra và set dữ liệu trước khi cập nhật trạng thái vanbanxuly
            if ($status == VanbanXuLyDonvi::$status['daxuly']) {
                // nếu vanbanxuly là chủ trì và ko có yêu cầu thay đổi vanbanxuly con thì kiểm tra trạng thái các vanbanxuly con đều là đã xử lý chưa
                if ($vanbanxuly->type == VanbanXuLyDonvi::$type['chutri'] && !$forceChange && $vanbanxuly->parent_id) {
                    $vanbanxulyChildrenIds = VanbanXuLyDonvi::getChildrenIds($vanbanxuly);
                    if ($vanbanxulyChildrenIds && VanbanXuLyDonvi::whereIn('id', $vanbanxulyChildrenIds)->where('status', '<>', VanbanXuLyDonvi::$status['daxuly'])->first()) {
                        flash('Không thể cập nhật trạng thái! Có văn bản chuyển tiếp trong luồng chưa xử lý xong.');
                        return Redirect::back();
                    }
                }

                $vanbanxuly->ngayxuly = $now;
                $vanbanxuly->minhchung = $minhchung;
                $vanbanxuly->file_minhchung = $file_minhchung;
            }
            else {
                $vanbanxuly->ngayxuly = null;
                $vanbanxuly->minhchung = null;
                $vanbanxuly->file_minhchung = null;
            }

            // cập nhật status
            $vanbanxuly->status = $status;

            // cập nhật ngày xem (nếu chưa xem)
            if (!$vanbanxuly->ngayxem) {
                $vanbanxuly->ngayxem = $now;
            }
            
            $vanbanxuly->save();

            // insert notification
            if ($loggedUser->id != $vanbanxuly->user_tao) {
                Notification::insert([
                    'creator_id' => $loggedUser->id,
                    'receivor_id' => $vanbanxuly->user_tao,
                    'type' => Notification::$types['capnhattrangthaivanban_donvi'],
                    'content' => sprintf('%s đã cập nhật xử lý vb: %s', $loggedUser->fullname, $vanbanxuly->vanban->soden),
                    'notificationable_id' => $vanbanxuly->id,
                    'notificationable_type' => VanbanXuLyDonvi::class,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }

            // cập nhật vanbanxuly con và cùng cấp thành đã xử lý nếu check $forceChange, vanbanxuly hiện tại là chủ trì và trạng thái là đã xử lý
            if ($forceChange && $vanbanxuly->type == VanbanXuLyDonvi::$type['chutri'] && $vanbanxuly->status == VanbanXuLyDonvi::$status['daxuly']) {
                // cập nhật trạng thái xử lý vanbanxuly cùng cấp
                VanbanXuLyDonvi::where('parent_id', $vanbanxuly->parent_id)
                          ->where('id', '<>', $vanbanxuly->id)
                          ->where('status', '<>', VanbanXuLyDonvi::$status['daxuly'])
                          ->update([
                                'status' => VanbanXuLyDonvi::$status['daxuly'],
                                'ngayxuly' => $now
                          ]);

                // cập nhật trạng thái xử lý vanbanxuly con
                $vanbanxulyChildrenIds = VanbanXuLyDonvi::getChildrenIds($vanbanxuly);
                VanbanXuLyDonvi::whereIn('id', $vanbanxulyChildrenIds)
                          ->where('status', '<>', VanbanXuLyDonvi::$status['daxuly'])
                          ->update([
                                'status' => 3,
                                'ngayxuly' => $now
                          ]);
            }
        }

        flash('Cập nhật thành công!');
        return Redirect::back();
    }

    public function check_xu_ly_vanban() {
        $vanbanxulyId = Input::get('vanbanxuly_id');
        $vanbanxuly = VanbanXuLyDonvi::find($vanbanxulyId);

        if (!$vanbanxuly) {
            return view('vanbandonvi._form_check_status_vanban', compact('vanbanxuly'));
        }

        $check = 1; // có cần check checkbox để đổi sang đã xử lý không

        // phối hợp ko cần check
        if ($vanbanxuly->type == VanbanXuLyDonvi::$type['phoihop']) {
            $check = 0;
        }

        // lấy danh sách vanbanxulyId con
        $vanbanxulyChildrenIds = VanbanXuLyDonvi::getChildrenIds($vanbanxuly);

        // item cuối ko cần check
        if (empty($vanbanxulyChildrenIds)) {
            $check = 0; 
        }

        // tất cả vanbanxuly con đã xử lý hết thì ko cần check
        if (!VanbanXuLyDonvi::whereIn('id', $vanbanxulyChildrenIds)->where('status', '<>', VanbanXuLyDonvi::$status['daxuly'])->first()) {
            $check = 0;
        }

        return view('vanbandonvi._form_check_status_vanban', compact('vanbanxuly', 'check'));
    }

    public function nhap_vanban_banhanh() {
        // get data for select
        $donvis = Bookdetail::select('donvis.*')
                              ->join('donvis', 'donvis.id', '=', 'book_detail.donvi_id')
                              ->where('book_detail.book_id', 4)
                              ->orderBy('book_detail.ordering', 'ASC')
                              ->get();

        return view('vanbandonvi.form_van_ban_banhanh', compact('donvis'));
    }

    public function sua_vanban_banhanh($vanbanbanhanhId) {
        $loggedUser = (object) session('user');

        // get văn bản ban hành
        $vanbanBanhanh = VanbanBanHanh::find($vanbanbanhanhId);

        if (!$vanbanBanhanh) {
            flash('Văn bản ban hành không tồn tại');
            return redirect(route('danhsach_vanban_banhanh_donvi'));
        }

        if ($vanbanBanhanh->created_by != $loggedUser->id) {
            flash('Không có quyền sửa văn bản ban hành');
            return redirect(route('danhsach_vanban_banhanh_donvi'));
        }

        // get danh sách user id nhận
        $userNhanIdsArr = $vanbanBanhanh->userNhanIdsArr;

        // get danh sách user trong đơn vị nhận
        $bookDetail = Bookdetail::where('book_detail.book_id', 4)->where('book_detail.donvi_id', $vanbanBanhanh->donvi_nhan_id)->first();
        $usersInDonvi = User::getList()->whereIn('id', $bookDetail->user_ids)->get();

        // get data for select
        $donvis = Bookdetail::select('donvis.*')
                            ->join('donvis', 'donvis.id', '=', 'book_detail.donvi_id')
                            ->where('book_detail.book_id', 4)
                            ->orderBy('book_detail.ordering', 'ASC')
                            ->get();

        return view('vanbandonvi.form_van_ban_banhanh', compact('donvis', 'vanbanBanhanh', 'userNhanIdsArr', 'usersInDonvi'));
    }

    public function save_vanban_banhanh(Request $request) {
        $loggedUser = (object) session('user');

        // get văn bản ban hành
        if ($request->id) {
            $vanbanBanhanh = VanbanBanHanh::find($request->id);

            if (!$vanbanBanhanh) {
                flash('Văn bản ban hành không tồn tại');
                return redirect(route('danhsach_vanban_banhanh'));
            }

            if ($vanbanBanhanh->created_by != $loggedUser->id) {
                flash('Không có quyền sửa văn bản ban hành');
                return redirect(route('danhsach_vanban_banhanh'));
            }
        }
        else {
            $vanbanBanhanh = new VanbanBanHanh();
        }

        // get params
        $vanbanBanhanh->name = $request->name;
        $vanbanBanhanh->thoigian_banhanh = date('Y-m-d H:i:s', strtotime($request->thoigian_banhanh));
        $vanbanBanhanh->donvi_nhan_id = ';'.implode(';', $request->donvi_nhan_id).';';
        $vanbanBanhanh->coquan_banhanh_id = $loggedUser->donvi_id;
        $vanbanBanhanh->created_by = $loggedUser->id;
        $vanbanBanhanh->user_nhan_ids = ';'.implode(';', $request->user_nhan_ids).';';

        // file đính kèm file
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = 'files/vanban/';

            $fileNameArr = explode('.', $file->getClientOriginalName());
            $fileName = str_slug($fileNameArr[0], '-') . '_' . time() . '.' . $fileNameArr[1];

            if (!$file->move($path, $fileName)) {
                flash('Nhập/Sửa văn bản ban hành thất bại');
                return redirect()->back();
            }
            else {
                $vanbanBanhanh->file = $fileName;
            }
        }

        if ($vanbanBanhanh->save()) {
            // gửi mail
            $vanbanBanhanh->tenCoQuanBanHanh = $vanbanBanhanh->donviBanhanh->name;
            $vanbanBanhanh->tenDonviNhan = implode('; ',Donvi::select('name')->whereIn('id', $request->donvi_nhan_id)->pluck('name')->toArray());
            $vanbanBanhanh->tenUserNhans = User::select('fullname')->whereIn('id', $request->user_nhan_ids)->pluck('fullname')->toArray();
            $vanbanBanhanh->fileDinhKem = url('/files/vanban/' . $vanbanBanhanh->file);
            $vanbanBanhanh->toUsers = User::select('email')->whereIn('id', $request->user_nhan_ids)->get()->toArray();
            $this->dispatch(new SendMailBanHanh($vanbanBanhanh));
            //Notification
            // save notification data
            $arrInsertNotifications =[];
            foreach ($request->user_nhan_ids as $user_nhan_id)
            $arrInsertNotifications[] = [
                'creator_id' => $loggedUser->id,
                'receivor_id' => $user_nhan_id,
                'type' => Notification::$types['nhanvanbanbanhanh'],
                'content' => 'Bạn nhận được văn bản ban hàng mới',
                'notificationable_id' => $vanbanBanhanh->id,
                'notificationable_type' => VanbanXuLyDonvi::class,
                'created_at' =>date('Y-m-d H:i:s')
            ];
            Notification::insert($arrInsertNotifications);

            flash('Lưu văn bản ban hành thành công');
            return redirect(route('danhsach_vanban_banhanh_donvi'));
        }
        else {
            flash('Có lỗi. Không thể lưu văn bản ban hành');
            return redirect(route('danhsach_vanban_banhanh_donvi'));
        }
    }

    public function danhsach_vanban_banhanh() {
        // get params
        $loggedUser = (object) session('user');
        $tukhoa = Input::get('tukhoa', '');
        $ngaybanhanhtu = Input::get('ngaybanhanhtu', '');       
        $ngaybanhanhden = Input::get('ngaybanhanhden', '');       
        $type = Input::get('type', 'nhanvanban'); // nhanvanban - guivanban

        // get data
        $vanbans = VanbanBanHanh::getDanhSach([
            'user_id' => $loggedUser->id,
            'donvi_id' => $loggedUser->donvi_id,
            'type' => $type,
            'tukhoa' => $tukhoa,
            'ngaybanhanhtu' => $ngaybanhanhtu? date('Y-m-d', strtotime($ngaybanhanhtu)) : '',
            'ngaybanhanhden' => $ngaybanhanhden? date('Y-m-d', strtotime($ngaybanhanhden)) : ''
        ])
        ->paginate(30)
        ->appends(Input::except('page'));

        // get users
        $users = User::getList()->get()->keyBy('id');
        $donvis = Donvi::GetList()->get()->keyBy('id');
        return view('vanbandonvi.danh_sach_van_ban_ban_hanh', compact('vanbans', 'users','donvis', 'type'));
    }

    public function delete_vanban() {
        $ids = Input::get('ids', []);

        VanbanXuLyDonvi::whereIn('vanbanUser_id', $ids)->delete();
        VanbanDonvi::whereIn('id', $ids)->delete();

        die(json_encode(['error' => 0]));
    }
}