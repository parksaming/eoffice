<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\Report;
use App\Models\Plan;
use Illuminate\Support\Facades\DB;
use App\Models\CheckUser;
use App\Models\CongViec;
use App\CongviecChiTiet;
use App\Congviec_Baocao;
use App\Models\Donvi;
use App\Models\VanbanXuLy;
use App\Models\BookDetail;
use App\Models\Notification;

class BaocaoController extends Controller
{

    function guibaocao(){
        $user=\Illuminate\Support\Facades\Session::get('user');

        $date=strtotime(date('d-m-Y'));
        $day=(date('Y-m-d'));

        $checkreport = Report::select('daily_report.*')->where('daily_report.user_id','=',$user['id'])->where('daily_report.created_date','=',$date)->get();

         $kehoachs = Plan::select('plans.*')
                ->where('plans.donvi_id','=',$user['donvi_id'])
                ->where('plans.end_day','>=',$day)
                ->first();



        return view('baocaos.guibaocao',compact('checkreport','day','kehoachs'));
    }
    public function gui_bao_cao(){
        $content= Input::get('content', null);
        $user=\Illuminate\Support\Facades\Session::get('user');
        //  date_default_timezone_set("Asia/Ho_Chi_Minh");
        $date=strtotime(date('d-m-Y'));

            $report = new Report();
            $report->user_id = $user['id'];
            $report->fullname = $user['fullname'];
            $report->username = $user['username'];
            $report->donvi_id = $user['donvi_id'];
            $report->ma_donvi = $user['madonvi'];
            $report->content = $content;
            $report->reportday = date('Y-m-d H:i:s');
            $report->created_date = $date;


        if($report->save()){
            flash('Gủi báo cáo thành công.');
            return response()->json(array('error' => 0));
        }
        else {
            return json_encode(array('error' => 1));
        }
    }
    public function xem_bao_cao(\Illuminate\Http\Request $request){
//        $data = $request->all();
        $content= Input::get('content', null);

        return view('baocaos.xem_truoc_noi_dung', compact('content'));
    }
    public function xem_noi_dung_bao_cao(){
        $id_report = Input::get('id_report');
        $content = Report::select('daily_report.*')->where('daily_report.id','=',$id_report)->get();
       // dd($content);die();
        return view('baocaos.xem_noi_dung', compact('content','date'));
    }
    public function bao_cao_da_gui(){
        //date_default_timezone_set("Asia/Ho_Chi_Minh");
        $user=\Illuminate\Support\Facades\Session::get('user');
        $users=\Illuminate\Support\Facades\Session::get('users');
        $start_date = Input::get('day', date('Y-m-d'));
        $date = strtotime($start_date);
        if ($user){
            $reports = Report::select('daily_report.*')->where('daily_report.user_id','=',$user['id'])->where('daily_report.created_date','=',$date)->first();
        }elseif ($users){
            $reports = Report::select('daily_report.*')->where('daily_report.user_id','=',$users['id'])->where('daily_report.created_date','=',$date)->first();

        }

        return view('baocaos.bao_cao_da_gui',compact('reports','start_date'));
    }

    public function kq_bao_cao_da_gui(){
        $user=\Illuminate\Support\Facades\Session::get('user');
        $start_date = Input::get('day', date('Y-m-d'));
        //dd($start_date);
        $start_date = date('Y-m-d', strtotime(str_replace('/', '-', $start_date))) ;

        $reports = Report::select('daily_report.*')->where('daily_report.user_id','=',$user['id'])->where('daily_report.created_date','=',strtotime($start_date))->first();
        return view('baocaos.bao_cao_da_gui',compact('reports','start_date'));
    }
    //Sua bao cao
    public function sua_bao_cao($id){
        $user=\Illuminate\Support\Facades\Session::get('user');

        $day=(date('Y-m-d'));
        $report = Report::find($id);
        $kehoachs = Plan::select('plans.*')
            ->where('plans.donvi_id','=',$user['donvi_id'])
            ->where('plans.end_day','>=',$day)
            ->first();
        return view('baocaos.sua_bao_cao',compact('report','kehoachs'));
    }
    // Cập nhật báo cáo
    public function cap_nhat_bao_cao(){
        $inputs = Input::all();

        $report = Report::find($inputs['id']);
        $report->update($inputs);
        flash('Cập nhật báo cáo thành công.');
        return response()->json(array('error' => 0));
    }

    public function congviecOld(Request $request){
        $user = Session('user');
        // $start_date = Input::get('day', date('Y-m-d'));
        // $date=strtotime($start_date);
        // $day=(date('Y-m-d'));
        // $user=\Illuminate\Support\Facades\Session::get('user');
        // $donvi=$user['donvi_id'];
        // $kehoachs = Plan::select('plans.*')
        //     ->where('plans.donvi_id','=',$user['donvi_id'])
        //     ->where('plans.end_day','>=',$day)
        //     ->first();

        // $reports = Report::select('daily_report.*')->where('daily_report.donvi_id','LIKE',$donvi.'%')->where('daily_report.created_date','=',$date)->get();

        $congviec_chitiet_ids = CongviecChiTiet::where('user_username',$user['username'])->pluck('congviec_id')->toArray();

        $limit = $request->get('limit',10);
        $txt_search = trim($request->get('txt_search',''));
        $time_search = trim($request->get('time_search',''));
        $time_search = formatYMD($time_search);
        $trangthai_search = trim($request->get('trangthai_search',''));

        if ( $request->type == 'viec_da_giao' ) {
            // Việc đã giao
            $congviecs = CongViec::where('user_username',$user['username']);
            if ($trangthai_search && $time_search) {
                $congviecs = $congviecs->where([
                    [
                        function ($query) use ($time_search){
                            $query->orWhere('ngaybatdau',$time_search)
                                ->orWhere('ngayketthuc',$time_search);
                        }
                    ],
                    ['trangthai', $trangthai_search]
                ]);
            }if ($trangthai_search && empty($time_search)) {
                $congviecs = $congviecs->where('trangthai', $trangthai_search);
            }if ($time_search && empty($trangthai_search)) {
                $congviecs = $congviecs->where(
                    function ($query) use ($time_search){
                        $query->orWhere('ngaybatdau',$time_search)
                            ->orWhere('ngayketthuc',$time_search);
                    });
            }

        }else {
            // Việc được giao
            $congviecs = CongViec::whereIn('id',$congviec_chitiet_ids);
            if ($trangthai_search && $time_search) {
                $congviecs = $congviecs->where([
                    [
                        function ($query) use ($time_search){
                            $query->orWhere('ngaybatdau',$time_search)
                                ->orWhere('ngayketthuc',$time_search);
                        }
                    ],
                    ['trangthai', $trangthai_search]
                ]);
            }if ($trangthai_search && empty($time_search)) {
                $congviecs = $congviecs->where('trangthai', $trangthai_search);
            }if ($time_search && empty($trangthai_search)) {
                $congviecs = $congviecs->where(
                    function ($query) use ($time_search){
                        $query->orWhere('ngaybatdau',$time_search)
                            ->orWhere('ngayketthuc',$time_search);
                    });
            }
        }

        $congviecs = $congviecs->where(
            function ($query) use ($txt_search){
                $query->orWhere('tencongviec','LIKE','%'.$txt_search.'%')
                    ->orWhere('noidung','LIKE','%'.$txt_search.'%');
            }
        )
        ->orderBy('id','DESC')->paginate($limit);

        if ($request->ajax == 1) {
            return view('congviecs._table_congviec',compact('congviecs'));
        }

        // lấy API các đơn vị theo donvi_id của user đăng nhập
        $result_ws = $this->getApi(config('common.url_api').'getDonviSessionUserCapduoi/'.$user['donvi_id']); // 100100100
        if($result_ws['error'] == false){
            $donvis = $result_ws['data'];
        }

        // lấy thông tin đơn vị của user đăng nhập
        $result_dv = $this->getApi(config('common.url_api').'GetDonvi_madonvi/'.$user['donvi_id']);

        if($result_dv['error'] == false){
            $dv_sess =  $result_dv['data'];
        }

        $donvis = Donvi::getList()->whereIn('id', BookDetail::select('donvi_id')->where('book_id', 3)->pluck('donvi_id')->toArray())->active()->get();

        return view('baocaos.xem_bao_cao_don_vi',compact('reports','user','start_date','kehoachs','congviecs','limit','trangthai_search','donvis','dv_sess'));
    }

    public function congviec(Request $request) {
        // get danh sách công việc
        $congviecController = new CongviecController();
        $congviecs = $congviecController->get_danh_sach_cong_viec();

        // get danh sách đơn vị
        $donvis = Donvi::getList()->whereIn('id', BookDetail::select('donvi_id')->where('book_id', 3)->pluck('donvi_id')->toArray())->active()->get();

        return view('baocaos.xem_bao_cao_don_vi', compact('congviecs', 'donvis'));
    }

    public function kq_congviec(){
        $start_date = Input::get('day', date('Y-m-d'));
        $start_date = date('Y-m-d', strtotime(str_replace('/', '-', $start_date))) ;
        $date=strtotime($start_date);
         $day=(date('Y-m-d'));
        $user=\Illuminate\Support\Facades\Session::get('user');
        $donvi=$user['donvi_id'];
         $kehoachs = Plan::select('plans.*')
             ->where('plans.donvi_id','=',$user['donvi_id'])
             ->where('plans.end_day','>=',$day)
             ->first();
        $reports = Report::select('daily_report.*')->where('daily_report.donvi_id','=',$donvi)->where('daily_report.created_date','=',$date)->get();
        return view('baocaos.xem_bao_cao_don_vi',compact('reports','user','start_date','kehoachs'));
    }
    public function len_ke_hoach(){
        $user=\Illuminate\Support\Facades\Session::get('user');
        $start_date = Input::get('day', date('Y-m-d'));
        $end_date = Input::get('day', date('Y-m-d'));

        $kehoachs = Plan::select('plans.*')
            ->where('plans.donvi_id','LIKE',$user['donvi_id'].'%')

            ->orderBy('plans.start_day', 'desc')->limit(10)->get();

        return view('baocaos.len_ke_hoach',compact('start_date','end_date','kehoachs'));
    }
    public function store_len_ke_hoach(){
        $content= Input::get('content', null);
        $start_date = Input::get('day', date('Y-m-d'));
        $end_date = Input::get('day_to', date('Y-m-d'));
        $start = date('Y-m-d', strtotime(str_replace('/', '-', $start_date))) ;
        $end = date('Y-m-d', strtotime(str_replace('/', '-', $end_date))) ;
        $date= date('Y-m-d');
        $user=\Illuminate\Support\Facades\Session::get('user');
        $donvi_id =$user['donvi_id'];
    
       if($start < $date){
           flash('Ngày tạo kế hoạch không được nhơ hơn ngày hiện tại')->error();
           return json_encode(array('error' => 1));
       }else{
           $check_kehoach = Plan::select(DB::raw('count(plans.id) as count'))
            ->where('plans.donvi_id','=',$donvi_id)
               ->whereRaw('? between plans.start_day and plans.end_day', [$start])
               ->first();
           if ($check_kehoach->count >0){
               flash('Kế hoạch đã được tạo')->error();
               return json_encode(array('error' => 1));
           }else{
               $plan = new Plan();
               $plan->user_id = $user['id'];
               $plan->username = $user['username'];
               $plan->fullname = $user['fullname'];
               $plan->donvi_id = $donvi_id;
               $plan->content = $content;
               $plan->start_day = $start;
               $plan->end_day = $end;

               if($plan->save()){
                   flash('Gủi kế hoạch thành công.');
                   return response()->json(array('error' => 0));
               }
               else {
                   return json_encode(array('error' => 1));
               }
           }
       }


    }

    public function xem_ke_hoach(){
        $content= Input::get('content', null);
        $start_date = Input::get('day', date('Y-m-d'));
        $end_date = Input::get('day_to', date('Y-m-d'));
        $start = date('d-m-Y', strtotime(str_replace('/', '-', $start_date))) ;
        $end = date('d-m-Y', strtotime(str_replace('/', '-', $end_date))) ;
        return view('baocaos.xem_ke_hoach', compact('content','start','end'));
    }

    public function sua_ke_hoach($id){
        $plans = Plan::find($id);

       return view('baocaos.sua_ke_hoach',compact('plans'));
    }

    public function cap_nhat_ke_hoach(){
        $inputs = Input::all();
        $content = Input::get('content', '');
        $day = Input::get('day', '');
        $day_to = Input::get('day_to', '');
        $id = Input::get('id', '');

        if ($id) {
            Plan::where('id', $id)->update(array('content' => $content, 'start_day' => formatYMD($day), 'end_day' => formatYMD($day_to)));
            flash('Cập nhật kế hoạch thành công.');
            return response()->json(array('error' => 0));
        }

    }


    public function xem_chi_tiet_ke_hoach(){
        $id = Input::get('id');

        $plans = Plan::select('plans.*')->where('plans.id','=',$id)->first();

        return view('baocaos.xem_chi_tiet_ke_hoach', compact('plans'));
    }
    //trỏ tới trang công việc đã giao
    public function cong_viec_da_giao(){
        $user=\Illuminate\Support\Facades\Session::get('user');
        $check_user = CheckUser::select('check_user.*')->where('check_user.username', '=', $user['username'])->first();

        $data['User']['username'] =$user['username'];
        if ($check_user){
            $data['User']['url'] = '/cong-viec-da-giao';
        }else{
            $data['User']['url'] = '/cong-viec-duoc-giao';

        }
        $data = $this->en_cription($data);

        return redirect('http://dieuhanh.udn.vn/users/login_auto/'.$data);
    }

    //Trỏ tới trang điều hành tác nghiệp
    public function dieu_hanh(){
        $user=\Illuminate\Support\Facades\Session::get('user');

        $data['User']['username'] =$user['username'];
        $data['User']['url'] = '/';
        $data = $this->en_cription($data);

        return redirect('http://dieuhanh.udn.vn/users/login_auto/'.$data);
    }
    function en_cription($data){
        $data = json_encode($data);
        $iv = mcrypt_create_iv(
            mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM
        );
        $encrypted = base64_encode(
            $iv .
            mcrypt_encrypt(
                MCRYPT_RIJNDAEL_256, hash('sha256', 'tnvhung120587', true), $data, MCRYPT_MODE_CBC, $iv
            )
        );
        return rtrim(strtr($encrypted, '+/', '-_'), '=');
    }

    public function report_work_detail(Request $request){
        $user = Session('user');
        $check_congviec_user_id = "err";

        if (empty($request->congviec_user_id)) {
            return $check_congviec_user_id;
        }

        $now = date('Y-m-d H:i:s');

        // có file đính kèm file
        $file_dinhkem = '';
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = 'files/vanban/';

            $fileNameArr = explode('.', $file->getClientOriginalName());
            $fileName = str_slug($fileNameArr[0], '-') . '_' . time() . '.' . $fileNameArr[1];

            if (!$file->move($path, $fileName)) {
                return $check_congviec_user_id;
            }
            else {
                $file_dinhkem = $fileName;
            }
        }

        foreach ($request->congviec_user_id as $congviec_user_id) {
            if (isset($congviec_user_id)) {
                $congviec_user = CongviecChiTiet::find($congviec_user_id);
                if($congviec_user){
                    $congviec_user->status = $request->status;
                    $congviec_user->mucdohoanthanh = $request->mucdohoanthanh;
                    $congviec_user->save();
                }
                $check_update_baocao_cv = Congviec_Baocao::where('congviec_user_id',$congviec_user_id);

                if ( $check_update_baocao_cv->count() > 0 ) {
                    $congviec_baocao = $check_update_baocao_cv->first();
                }else{
                    $congviec_baocao = new Congviec_Baocao;
                }
                
                $congviec_baocao->noidung = nl2br($request->noidung);
                $congviec_baocao->mucdohoanthanh = $request->mucdohoanthanh; 
                $congviec_baocao->username = $user['username'];
                $congviec_baocao->congviec_user_id = (int) $congviec_user_id;
                $congviec_baocao->ngaycapnhat = $now;
                $congviec_baocao->assessment = "";
                $congviec_baocao->status = $request->status;
                $congviec_baocao->file = $file_dinhkem;
                $congviec_baocao->save();
                $check_congviec_user_id = 'ok';

                // Insert notifications
                Notification::insert([
                    'creator_id' => session('user')['id'],
                    'receivor_id' => $congviec_user->creator_id,
                    'type' => Notification::$types['nhanbaocaocongviec'],
                    'content' => sprintf('Bạn nhận được 1 báo cáo công việc từ %s', session('user')['fullname']),
                    'notificationable_id' => $congviec_user->congviec_id,
                    'notificationable_type' => Congviec::class,
                    'created_at' => $now
                ]);
            }
        }

        return $check_congviec_user_id;
    }

    public function viewDetail_report(Request $request){
        $congviec_baocao = Congviec_Baocao::find($request->data_id);
        $congviec_user = CongviecChiTiet::find($congviec_baocao->congviec_user_id);

        return view('baocaos._modalViewDetail_Report',compact('congviec_baocao','congviec_user'));
    }

    public function agreement_report(Request $request){
        $congviec_baocao = Congviec_Baocao::find($request->congviec_baocao_id);
        if ( count($congviec_baocao) > 0 ) {
            if ($request->assessment == NULL) {
                $assessment = "Đã duyệt";
            }else{
                $assessment = $request->assessment;
            }
            $congviec_baocao->assessment = $assessment;
            $congviec_baocao->save();
        }

        return json_encode(
            array(
                'congviec_baocao_id' => $congviec_baocao->id,
                'assessment' => $congviec_baocao->assessment
            )
        );
    }

    public function commonBaocao_congviecs(Request $request) {
        $user = Session('user');
        $congviec_id = $request->congviec_id;
        $congviec_users = CongviecChiTiet::where('congviec_id',$congviec_id)->orderBy('user_username','ASC');

        // get công việc
        $congviec = CongViec::find($request->congviec_id);

        if ($congviec->user_id == session('user')['id']) {// nếu là người giao công việc: xem danh sách báo cáo
            $congviec_users = $congviec_users->get();

            return view('baocaos._showOrduyetBaocao_congviec_dagiao',compact('congviec_users','congviec_id'));
        }
        else {// nếu là người được giao công việc: hiển thị form báo cáo
            $congviec_users = $congviec_users->where('user_username',$user['username'])->get();

            return view('baocaos._showBaocao_congviec_duocgiao',compact('congviec_users','congviec_id'));
        }
    }

    public function view_baocao_notifi(Request $request){
        $congviec_user = CongviecChiTiet::find($request->congviec_ct_id);
        $congviec_user->ngayxem = date("Y-m-d H:i:s");
        $congviec_user->save();
        return view('baocaos.modal_baocao_notifi',compact('congviec_user'));
    }

    public function view_agreement_report(Request $request){
        $congviec_baocao = Congviec_Baocao::find($request->congviec_baocao_id);
        $congviec_baocao->user_view = $congviec_baocao->user_view + 1;
        $congviec_baocao->save();
        return view('baocaos._modal_agreement_report',compact('congviec_baocao'));
    }
    public function dashboard (){
        $vanbans = 0;
      return view('baocaos.dashboard',compact('vanbans'));
    }

    public function thong_ke_theo_ca_nhan() {
        
        // get dữ liệu thống kê của $donvis
        VanbanXuLy::select()
                  ->whereIn('vanban_xulys.donvi_nhan_id', $donvis->pluck('id')->toArray());
    }
    public function tinh_hinh_xu_ly_van_ban_den() {
        // get data
        $ds_vanbans = VanbanXuLy::select(
                    'users.fullname',
                    'vanbans.id',
                    'vanbans.soden',
                    'vanbans.ngayky',
                    'vanbans.kyhieu',
                    'vanbans.book_id',
                    'vanbans.title',
                    'vanbans.loaivanban_id',
                    'vanbans.ngaygui',
                    'vanbans.cq_banhanh',
                    'vanbans.file_dinhkem',
                    'vanbans.ngayden',
                    'vanbans.hanxuly',
                    'vanban_xulys.noidung_butphe',
                    'vanban_xulys.status',
                    'vanban_xulys.ngayxuly',
                    'vanban_xulys.ngaychuyentiep as ngaychuyentiepRaw',
                    'tbDonViNhan.name as tenDonViNhan',
                    'tbDviBanHanh.name as tenDonViBanHanh',
                    'linhvucs.name as nameLinhvuc',
                    'publish.name as namePublish'
                )
                ->join('vanbans', function ($join) {
                    $join->on('vanbans.id', '=', 'vanban_xulys.vanbanUser_id')
                         ->where('vanbans.book_id', 1)
                         ->where('vanban_xulys.id_nhan', session('user')['id']);
                })
                ->join('users', 'users.id', '=', 'vanban_xulys.id_nhan')
                ->join('donvis as tbDonViNhan', 'tbDonViNhan.id', '=', 'users.donvi_id')
                ->leftJoin('donvis as tbDviBanHanh', 'tbDviBanHanh.id', '=', 'vanbans.cq_banhanh')
                ->leftJoin('publish', 'vanbans.publish_id', '=', 'publish.id')
                ->leftJoin('linhvucs', 'vanbans.linhvuc_id', '=', 'linhvucs.id')
                ->orderBy('vanban_xulys.id', 'DESC')
                ->paginate(30)
                ->appends(Input::except('page'));

        // data total
        $total = VanbanXuLy::select(
                    DB::raw('COUNT(vanban_xulys.id) AS tongSoVBDen'),
                    DB::raw('SUM(IF(vanban_xulys.status = 1, 1, 0)) AS tongSoVBChuaXuLy'),
                    DB::raw('SUM(IF(vanban_xulys.ngayxem IS NULL, 1, 0)) AS tongSoVBChuaDoc'),
                    DB::raw('SUM(IF(vanban_xulys.status = 2, 1, 0)) AS tongSoVBDangXuLy'),
                    DB::raw('SUM(IF(vanban_xulys.status = 3, 1, 0)) AS tongSoVBDaXuLy')
                )
                ->join('vanbans', function ($join) {
                    $join->on('vanbans.id', '=', 'vanban_xulys.vanbanUser_id')
                         ->where('vanbans.book_id', 1);
                })
                ->first();

        return view('baocaos.tinh_hinh_xu_ly_van_ban_den', compact('ds_vanbans', 'total'));
    }

    public function tong_hop_tinh_hinh_xu_ly_van_ban() {
        // get data
        $data = VanbanXuLy::select(
                        'users.fullname',
                        'tbDonViNhan.name as tenDonViNhan',
                        DB::raw('COUNT(vanban_xulys.id) AS tongSoVBDen'),
                        DB::raw('SUM(IF(vanbans.hanxuly IS NULL, 1, 0)) AS tongVBKhongHanXuLy'),
                        DB::raw('SUM(IF(vanban_xulys.status = 3 AND vanbans.hanxuly IS NOT NULL AND DATE(vanban_xulys.ngayxuly) < DATE(vanbans.hanxuly), 1, 0)) AS tongVBHoanThanhTruocHan'),
                        DB::raw('SUM(IF(vanban_xulys.status = 3 AND vanbans.hanxuly IS NOT NULL AND DATE(vanban_xulys.ngayxuly) = DATE(vanbans.hanxuly), 1, 0)) AS tongVBHoanThanhDungHan'),
                        DB::raw('SUM(IF(vanban_xulys.status = 3 AND vanbans.hanxuly IS NOT NULL AND DATE(vanban_xulys.ngayxuly) > DATE(vanbans.hanxuly), 1, 0)) AS tongVBHoanThanhQuaHan'),
                        DB::raw('SUM(IF(vanban_xulys.status <> 3 AND vanbans.hanxuly IS NOT NULL AND DATE(vanbans.hanxuly) <= CURDATE(), 1, 0)) AS tongVBChuaHoanThanhTrongHan'),
                        DB::raw('SUM(IF(vanban_xulys.status <> 3 AND vanbans.hanxuly IS NOT NULL AND DATE(vanbans.hanxuly) > CURDATE(), 1, 0)) AS tongVBChuaHoanThanhQuaHan')
                    )
                    ->join('vanbans', function ($join) {
                        $join->on('vanbans.id', '=', 'vanban_xulys.vanbanUser_id')
                            ->where('vanbans.book_id', 1);
                    })
                    ->join('users', 'users.id', '=', 'vanban_xulys.id_nhan')
                    ->join('donvis as tbDonViNhan', 'tbDonViNhan.id', '=', 'users.donvi_id')
                    ->groupBy('users.id', 'tbDonViNhan.id')
                    ->orderBy('tenDonViNhan', 'ASC')
                    ->orderBy('users.fullname', 'ASC')
                    ->paginate(30)
                    ->appends(Input::except('page'));

        return view('baocaos.tong_hop_tinh_hinh_xu_ly_van_ban',compact('data'));
    }

    public function baoCaoThongKeDonVi(Request $request)
    {
        if(session('user')['view_thongke'] !== 1) return abort(403);

        $start_time = formatYMD($request->start_time);
        $end_time = formatYMD($request->end_time);
        $filter_sql = '';

        if($end_time && $end_time){
            $filter_sql = "AND `vanban_xulys`.`ngaychuyentiep` >= '$start_time' AND `vanban_xulys`.`ngaychuyentiep` <= '$end_time'";
        }elseif($start_time){
            $filter_sql = "AND `vanban_xulys`.`ngaychuyentiep` >= '$start_time'";
        }elseif($start_time){
            $filter_sql = "AND `vanban_xulys`.`ngaychuyentiep` <= '$end_time'";
        }

        $_sql_cm = 'SELECT count(*)
                    FROM `vanban_xulys`
                    JOIN `vanbans` ON `vanbans`.`id` = `vanban_xulys`.`vanbanUser_id` AND `vanbans`.`book_id` = 1
                    WHERE `is_chuyentiep` = 0
                    AND `donvi_nhan_id` = tbDonViNhan.id';

        $data = VanbanXuLy::select(
                'tbDonViNhan.id AS donvi_id',
                'tbDonViNhan.name as tenDonViNhan',
                DB::raw('(
                    '.$_sql_cm.'
                    AND vanban_xulys.status = 3
                    AND (
                        ( vanban_xulys.ngayxuly AND vanbans.hanxuly AND DATE(vanban_xulys.ngayxuly) <= DATE(vanbans.hanxuly) )
                        OR !vanbans.hanxuly
                    )
                    '.$filter_sql.'
                ) AS tongVBHoanThanhDungHan'),
                DB::raw('(
                    '.$_sql_cm.'
                    AND vanban_xulys.status = 3
                    AND vanbans.hanxuly
                    AND DATE(vanban_xulys.ngayxuly) > DATE(vanbans.hanxuly)
                    '.$filter_sql.'
                ) AS tongVBHoanThanhQuaHan'),
                DB::raw('(
                   '.$_sql_cm.'
                    AND vanban_xulys.status <> 3
                    AND vanbans.hanxuly
                    AND CURDATE() > DATE(vanbans.hanxuly)
                    '.$filter_sql.'
                ) AS tongVBChuaHoanThanh'),
                DB::raw('(
                    '.$_sql_cm.'
                    AND vanban_xulys.type = 1
                    '.$filter_sql.'
                ) AS tongVBChuTri'),
                DB::raw('(
                    '.$_sql_cm.'
                    AND vanban_xulys.type = 2
                    '.$filter_sql.'
                ) AS tongVBPhoiHop')
            )
            ->whereIs_chuyentiep(0)
            ->join('vanbans', function ($join) {
                $join->on('vanbans.id', '=', 'vanban_xulys.vanbanUser_id')
                    ->where('vanbans.book_id', 1);
            })
            ->join('users', 'users.id', '=', 'vanban_xulys.id_nhan')
            ->join('donvis as tbDonViNhan', 'tbDonViNhan.id', '=', 'users.donvi_id')
            ->when($start_time, function ($query) use ($start_time) {
                return $query->where('vanban_xulys.ngaychuyentiep', '>=', $start_time);
            })
            ->when($end_time, function ($query) use ($end_time) {
                return $query->where('vanban_xulys.ngaychuyentiep', '<=', $end_time);
            })
            ->groupBy('tbDonViNhan.id')
            ->orderBy('tenDonViNhan', 'ASC')
            ->paginate(30)
            ->appends(Input::except('page'));

        return view('baocaos.bao_cao_thong_ke_theo_don_vi', compact('data', 'start_time', 'end_time'));
    }

    public function baoCaoThongKeCaNhan(Request $request)
    {
        if(session('user')['view_thongke'] !== 1) return abort(403);
        
        $start_time = formatYMD($request->start_time);
        $end_time = formatYMD($request->end_time);
        $donvi_id = $request->donvi_id;
        $filter_sql = '';

        if($end_time && $end_time){
            $filter_sql = "AND `vanban_xulys`.`ngaychuyentiep` >= '$start_time' AND `vanban_xulys`.`ngaychuyentiep` <= '$end_time'";
        }elseif($start_time){
            $filter_sql = "AND `vanban_xulys`.`ngaychuyentiep` >= '$start_time'";
        }elseif($start_time){
            $filter_sql = "AND `vanban_xulys`.`ngaychuyentiep` <= '$end_time'";
        }

        $_sql_cm = 'SELECT count(*)
                    FROM `vanban_xulys`
                    JOIN `vanbans` ON `vanbans`.`id` = `vanban_xulys`.`vanbanUser_id` AND `vanbans`.`book_id` = 1
                    WHERE `id_nhan` = users.id';

        $data = VanbanXuLy::select(
                'users.fullname AS fullname',
                'users.id AS user_id',
                'tbDonViNhan.id AS donvi_id',
                'tbDonViNhan.name as tenDonViNhan',
                DB::raw('(
                    '.$_sql_cm.'
                    AND vanban_xulys.status = 3
                    AND (
                        ( vanban_xulys.ngayxuly AND vanbans.hanxuly AND DATE(vanban_xulys.ngayxuly) <= DATE(vanbans.hanxuly) )
                        OR !vanbans.hanxuly
                    )
                    '.$filter_sql.'
                ) AS tongVBHoanThanhDungHan'),
                DB::raw('(
                   '.$_sql_cm.'
                    AND vanban_xulys.status = 3
                    AND vanbans.hanxuly
                    AND DATE(vanban_xulys.ngayxuly) > DATE(vanbans.hanxuly)
                    '.$filter_sql.'
                ) AS tongVBHoanThanhQuaHan'),
                DB::raw('(
                    '.$_sql_cm.'
                    AND vanban_xulys.status <> 3
                    AND vanbans.hanxuly
                    AND CURDATE() > DATE(vanbans.hanxuly)
                    '.$filter_sql.'
                ) AS tongVBChuaHoanThanh'),
                DB::raw('(
                    '.$_sql_cm.'
                    AND vanban_xulys.type = 1
                    '.$filter_sql.'
                ) AS tongVBChuTri'),
                DB::raw('(
                    '.$_sql_cm.'
                    AND vanban_xulys.type = 2
                    '.$filter_sql.'
                ) AS tongVBPhoiHop')
            )
            ->join('vanbans', function ($join) {
                $join->on('vanbans.id', '=', 'vanban_xulys.vanbanUser_id')
                    ->where('vanbans.book_id', 1);
            })
            ->join('users', 'users.id', '=', 'vanban_xulys.id_nhan')
            ->join('donvis as tbDonViNhan', function ($join) use ($donvi_id) {
                $join->on('tbDonViNhan.id', '=', 'users.donvi_id')
                        ->when($donvi_id, function ($query) use ($donvi_id) {
                            return $query->where('tbDonViNhan.id', '=', $donvi_id);
                    });
            })
            ->when($start_time, function ($query) use ($start_time) {
                return $query->where('vanban_xulys.ngaychuyentiep', '>=', $start_time);
            })
            ->when($end_time, function ($query) use ($end_time) {
                return $query->where('vanban_xulys.ngaychuyentiep', '<=', $end_time);
            })
            ->groupBy('users.id')
            ->orderBy('users.fullname', 'ASC')
            ->paginate(30)
            ->appends(Input::except('page'));

        $donvis = Donvi::join('book_detail', function($join) {
            $join->on('donvis.id', '=', 'book_detail.donvi_id')
                    ->where('book_detail.book_id', 1);
        })->get(['donvis.id', 'donvis.name']);

        return view('baocaos.bao_cao_thong_ke_theo_ca_nhan', compact('data', 'donvis', 'donvi_id', 'start_time', 'end_time'));
    }

    public function xemBaoCaoThongKe(Request $request)
    {
        $input = $request->only('donvi_id', 'user_id', 'type', 'start_time', 'end_time');
        $start_time = formatYMD($input['start_time']);
        $end_time = formatYMD($input['end_time']);

        $query = VanbanXuLy::query();

        if($input['type'] == 1 || $input['type'] == 2) $query->whereType($input['type']); // 1 - chủ trì 2 - phối hợp

        if($input['type'] == 3){
            $query->whereRaw("
                vanban_xulys.`status` = 3
                AND (
                    (
                        vanban_xulys.ngayxuly
                        AND vanbans.hanxuly
                        AND DATE(vanban_xulys.ngayxuly) <= DATE(vanbans.hanxuly)
                    )
                    OR ! vanbans.hanxuly
                )
            ");
        }

        if($input['type'] == 4){
            $query->whereRaw("
                vanban_xulys.status = 3
                AND vanbans.hanxuly
                AND DATE(vanban_xulys.ngayxuly) > DATE(vanbans.hanxuly)
            ");
        }

        if($input['type'] == 5){
            $query->whereRaw("
                vanban_xulys.status <> 3
                AND vanbans.hanxuly
                AND CURDATE() > DATE(vanbans.hanxuly)
            ");
        }

        if($input['donvi_id']){
            $query->whereDonvi_nhan_id($input['donvi_id'])->whereIs_chuyentiep(0); // theo don vi
        }elseif($input['user_id']) $query->whereId_nhan($input['user_id']); // theo user

        $data = $query->join('vanbans', function ($join) {
                $join->on('vanbans.id', '=', 'vanban_xulys.vanbanUser_id')
                    ->where('vanbans.book_id', 1);
            })
            ->when($start_time, function ($query) use ($start_time) {
                return $query->where('vanban_xulys.ngaychuyentiep', '>=', $start_time);
            })
            ->when($end_time, function ($query) use ($end_time) {
                return $query->where('vanban_xulys.ngaychuyentiep', '<=', $end_time);
            })
            ->get(['vanbans.title', 'vanbans.file_dinhkem', DB::raw('DATE_FORMAT(vanban_xulys.ngaychuyentiep,"%d-%m-%Y %H:%i:%s") AS ngaychuyentiep'),  DB::raw('DATE_FORMAT(vanban_xulys.ngayxuly,"%d-%m-%Y %H:%i:%s") AS ngayxuly'), 'vanban_xulys.status', 'vanban_xulys.type']);
        
        return  response()->json($data);
    }

    public function thong_ke_van_ban_den_theo_ngay() {
        $curDate = date('Y-m-d');

        // get data
        $ds_vanbans = VanbanUser::select(
                        'users.fullname',
                        'vanbans.id',
                        'vanban_users.id as IdVanBanUser',
                        'vanbans.soden',
                        'vanbans.ngayky',
                        'vanbans.kyhieu',
                        'vanbans.book_id',
                        'vanbans.title',
                        'vanbans.loaivanban_id',
                        'vanbans.ngaygui',
                        'vanbans.cq_banhanh',
                        'vanbans.file_dinhkem',
                        'vanbans.ngayden',
                        'vanbans.hanxuly',
                        'vanban_users.user_id',
                        'vanban_users.content_butphe',
                        'vanban_users.status',
                        'tbDonViNhan.name as tenDonViNhan',
                        'tbDviBanHanh.name as tenDonViBanHanh',
                        'linhvucs.name as nameLinhvuc',
                        'publish.name as namePublish'
                    )
                    ->leftJoin('vanbans', 'vanban_users.vanban_id', '=', 'vanbans.id')
                    ->leftJoin('donvis as tbDonViNhan', 'vanban_users.donvi_id', '=', 'tbDonViNhan.id')
                    ->leftJoin('donvis as tbDviBanHanh', 'tbDviBanHanh.id', '=', 'vanbans.cq_banhanh')
                    ->leftJoin('publish', 'vanbans.publish_id', '=', 'publish.id')
                    ->leftJoin('linhvucs', 'vanbans.linhvuc_id', '=', 'linhvucs.id')
                    ->leftJoin('users', 'vanban_users.user_id', '=', 'users.id')
                    ->where('vanbans.ngaygui', $curDate)
                    ->orderBy('vanban_users.id', 'DESC')
                    ->paginate(30)
                    ->appends(Input::except('page'));

        return view('baocaos.thong_ke_van_ban_den_theo_ngay', compact('curDate', 'ds_vanbans'));
    }
}
