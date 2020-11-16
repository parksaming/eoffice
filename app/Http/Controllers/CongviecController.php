<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Them_cvRequest;
use App\Models\CongViec;
use App\CongviecFile;
use App\CongviecChiTiet;
use App\Models\CheckUser;
use App\User;
use App\Congviec_Baocao;
use App\DailyReport;
use Storage;
use DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use App\Models\Notification;
use App\Models\Vanban;
use App\Models\VanbanXuLy;
use App\Models\VanbanXuLyDonvi;

class CongviecController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Them_cvRequest $request)
    {
        // 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $congviec = Congviec::find($id);

        $congviec->user_id      = $request->user_id;
        $congviec->user_username= $request->user_username;
        $congviec->tencongviec  = $request->tencongviec;
        $congviec->macongviec   = $request->macongviec;
        $congviec->nguoigiamsat = $request->nguoigiamsat;
        $congviec->tinhchat     = $request->tinhchat;
        $congviec->ngaybatdau   = $request->ngaybd;
        $congviec->ngayketthuc  = $request->ngaykt;
        $congviec->trangthai    = $request->trangthai;
        $congviec->noidung      = $request->noidung;

        $congviec->mucdohoanthanh = $request->mucdohoanthanh;

        //$congviec->tinhchat_id  = $request->tinhchat_id;
        $congviec->save();
        \Session::flash('message', 'Successfully updated room!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function axjaxLoadDetail(Request $request){

        $congviec_id = $request->congviec_id;

        $congviec = Congviec::find($congviec_id);
        $congviec->congviecMessage->count();
        $congviec->congviecBaocao->count();
        $classCT = CongviecChiTiet::with('congviec_baocao')->where('congviec_id',$congviec_id);
        $countCongviec = $classCT->get()->count();
        $congviecCT = $classCT->groupBy('noidung')->get();
        $congviecfile = CongviecFile::where('congviec_id',$congviec_id)->get();

        if (count($congviec) > 0) {
            $congviec->ngaybatdau = formatDMY($congviec->ngaybatdau);
            $congviec->ngayketthuc = formatDMY($congviec->ngayketthuc);
        }
        
        $name_CongviecCT = '';
        foreach ($congviecCT as $congviecCT_item) {
            $listName_CongviecCT = CongviecChiTiet::select('user_username','nguoiphutrach')
                ->where([
                    [ 'noidung',$congviecCT_item->noidung ],
                    [ 'congviec_id', $congviecCT_item->congviec_id ]
                ])->get();
            if (count($listName_CongviecCT) > 0) {
                foreach ($listName_CongviecCT as $value) {
                    $user = User::where('username',$value->user_username)->first();
                    if ( count($user) > 0 ) {
                        $name_CongviecCT .= $user->fullname.'<br>';
                    }else{
                        $name_CongviecCT .= ($value->nguoiphutrach != null ? $value->nguoiphutrach : $value->user_username).'<br>';
                    }
                }
                $congviecCT_item->listName_CongviecCT = rtrim( $name_CongviecCT,' ,');
                $name_CongviecCT = '';
            }
        }

        return json_encode(
            array(
                'congviec' => $congviec,
                'congviecCT' => $congviecCT,
                'congviecfile' => $congviecfile,
                'countCongviec' => $countCongviec,
            )
        );
    }

    public function congviec_chung(Request $request) {
        if ( Session('congviec_id') != null ){
            $congviec = CongViec::find(Session('congviec_id'));
        }else{
            $congviec = new Congviec;
        }

        $congviec->user_id      = $request->user_id;
        $congviec->user_username= $request->user_username;
        $congviec->tencongviec  = $request->tencongviec;
        $congviec->nguoigiamsat = $request->nguoigiamsat;
        $congviec->tinhchat     = $request->tinhchat;
        $congviec->ngaybatdau   = formatYMD($request->ngaybd);
        $congviec->ngayketthuc  = formatYMD($request->ngaykt);
        $congviec->trangthai    = $request->trangthai;
        $congviec->noidung      = nl2br($request->noidung);
        $congviec->vanbanxuly_id= $request->vanbanxuly_id? $request->vanbanxuly_id : null;
        $congviec->vanbanxuly_donvi_id= $request->vanbanxuly_donvi_id? $request->vanbanxuly_donvi_id : null;
        $congviec->nguoiphoihop = $request->nguoiphoihop;

        if ($request->vanbanxuly_id) {
            $vanbanXuly = VanbanXuLy::find($request->vanbanxuly_id);
            $congviec->vanban_id = $vanbanXuly->vanbanUser_id;
        }

        if ($request->vanbanxuly_donvi_id) {
            $vanbanXulyDonvi = VanbanXuLyDonvi::find($request->vanbanxuly_donvi_id);
            $congviec->vanban_donvi_id = $vanbanXulyDonvi->vanbanUser_id;
        }

        if ($congviec->save()) {
            Session()->put('congviec_id', $congviec->id);
            return json_encode(
                array(
                    'step2' => '#step2',
                    'congviec_id' => $congviec->id,
                )
            );
        }
        
    }

    public function congviec_phancong (Request $request){
        if (empty($request->nguoiphutrach)) {
            return "no_pt";
        }

        $congviec_id =  Session('congviec_id');

        if ( empty($congviec_id) ) {
            return json_encode(
                array(
                    'error' => 1,
                    'session_congviec_id' => 0,
                )
            );
        }

        // get công việc
        $congviec = CongViec::find($congviec_id);
        $vanbanxuly = VanbanXuLy::find($congviec->vanbanxuly_id);

        if ($vanbanxuly) {
            $vanban = Vanban::find($vanbanxuly->vanbanUser_id);
        }
        else {
            $vanban = null;
        }
        
        $noidung = nl2br($request->nd_chitiet);
        $ngaybatdau = formatYMD($request->ngaybatdau);
        $ngayketthuc = formatYMD($request->ngayketthuc);

        $arrInsertNotifications = []; // array store notification data
        $now = date('Y-m-d H:i:s');

        foreach ($request->nguoiphutrach as $item) {
            if ( isset( $item ) ) {
                $usernameIdFullname = explode("+",$item);
                $congviec_chitiet = new CongviecChiTiet;
                $congviec_chitiet->user_id = $usernameIdFullname[1];
                $congviec_chitiet->user_username = $usernameIdFullname[0];
                $congviec_chitiet->nguoiphutrach = $usernameIdFullname[2];
                $congviec_chitiet->congviec_id = $congviec_id;
                $congviec_chitiet->noidung = $noidung;
                $congviec_chitiet->ngaybatdau = $ngaybatdau;
                $congviec_chitiet->ngayketthuc = $ngayketthuc;
                $congviec_chitiet->creator_id = session('user')['id'];
                $congviec_chitiet->save();

                if ($vanbanxuly) {
                    // check user được phân công có vanban_xuly chưa (fix bug giao việc nhưng ko xem đc vanban)
                    if (!VanbanXuLy::where('id_nhan', $usernameIdFullname[1])->where('vanbanUser_id', $vanbanxuly->vanbanUser_id)->first()) {
                        $user = User::find($usernameIdFullname[1]);

                        VanbanXuLy::insert([
                            'vanbanUser_id' => $vanbanxuly->vanbanUser_id,
                            'parent_id' => $vanbanxuly->id,
                            'id_nhan' => $user->id,
                            'ngaychuyentiep' => $now,
                            'user_tao' => session('user')['id'],
                            'status' => 1,
                            'type' => $vanbanxuly->type,
                            'is_chuyentiep' =>  1,
                            'donvi_nhan_id' => $user->donvi_id,
                            'loaivanban' => $vanban->book_id
                        ]);
                    }
                }

                // save notification data
                $receivor = User::where('username', $usernameIdFullname[0])->first();
                $arrInsertNotifications[] = [
                    'creator_id' => session('user')['id'],
                    'receivor_id' => $receivor->id,
                    'type' => Notification::$types['nhancongviecmoi'],
                    'content' => sprintf('Bạn nhận được một công việc từ %s', session('user')['fullname']),
                    'notificationable_id' => $congviec_id,
                    'notificationable_type' => Congviec::class,
                    'created_at' => $now
                ];
            }
        }

        // Insert notifications
        if ($arrInsertNotifications) {
            Notification::insert($arrInsertNotifications);
        }

        if ( $congviec_chitiet->id ) {
            $listName = '';

            $congviecCTs = CongviecChiTiet::where('congviec_id',$congviec_id)
                ->groupBy('noidung')->get();

            foreach ($congviecCTs as $congviecCT) {
                $listName_CongviecCT = CongviecChiTiet::where([
                    ['congviec_id',$congviecCT->congviec_id],
                    ['noidung',$congviecCT->noidung]
                ])->select('user_username','nguoiphutrach')->get();

                foreach ($listName_CongviecCT as $item_listName_CongviecCT) {
                    $user2 = User::where('username',$item_listName_CongviecCT->user_username)->first();
                    if ( count($user2) > 0 ) {
                        $listName .= $user2->fullname . '<br/>';
                    }else{
                        $listName .= $item_listName_CongviecCT->nguoiphutrach . '<br/>';
                    }
                }
                $congviecCT->listName_CongviecCT = $listName;
                $listName = '';
            }

            return json_encode(
                array(
                    'add_continue' => $request->add_continue,
                    'congviec_id' => $congviec_id,
                    'congviecCTs' => $congviecCTs,
                )
            );
        }
    }

    public function congviec_file(Request $request){
        $this->validate($request,
            [
                'file' => 'max:20971520',
            ],
            [
                'file.max' => 'Kích thước tệp gới hạn < 20m',
            ]);
        $congviec_id = Session('congviec_id');
        if ( empty($congviec_id) ) {
            return json_encode(
                array(
                    'error' => 1,
                    'session_congviec_id' => 0,
                )
            );
        }
        $html = '';
        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {
                if ( isset($file) ) {
                    $fileName = time().'.'.$file->getClientOriginalExtension();
                    $fileName_rd = str_random(4)."_".$fileName;
                    while(file_exists(base_path().'/files/'.$fileName_rd)){
                        $fileName_rd = str_random(4)."_".$fileName;
                    }
                    $congviecFile = new CongviecFile; 
                    $congviecFile->file = 'files/'.$fileName_rd;
                    $congviecFile->congviec_id = $congviec_id;
                    $congviecFile->save();
                    $file->move(base_path() . '/files/', $congviecFile->file);
                    $html .= '
                        <li class="list-group-item">
                            <a data-id="'.$congviecFile->id.'" href="'.url('files').'/'.$fileName_rd.'" download="">files/'.$fileName_rd.'</a>
                            <span title="Xóa file" class="badge" data-id="'.$congviecFile->id.'">x</span>
                        </li>
                    ';
                }
            }
        }

        return json_encode(
            array(
                'congviec_id' => Session('congviec_id'),
                'html' => $html,
            )
        );

    }

    public function remove_session_work(Request $request){
        Session()->forget('congviec_id');  
    }

    public function fullcalendar(){
        $user = Session('user');
        $congviecs = CongViec::where('user_username',$user['username'])->take(135)->get();
        $congviec_users = CongviecChiTiet::where('user_username',$user['username'])->take(135)->get();
        return view('congviecs.fullcalendar',compact('congviec_users','congviecs'));
    }

    public function getUser_Unit(Request $request){
        $check = null;
        $madonvi = $request->madonvi;
        if ($madonvi == 0) {
            return 0;
        }

        // Lấy  sách user theo mã đơn vị
        $result_ws = $this->getApi(config('common.url_api').'getUser_Unit/'.$madonvi);

        $resultUsers = array();

        if( $result_ws['error'] == false ){
            $resultUsers = $result_ws['data'];
        }

        $users = User::where('donvi_id',$madonvi)->get();

        $check_user = CheckUser::where('madonvi',$madonvi)->get();

        $user_logged_username = session('user_logged_username');

        $select_donvi_of_supervisor = $request->select_donvi_of_supervisor;
        return view('congviecs._getUser_Unit',compact('resultUsers','check_user','users','user_logged_username','select_donvi_of_supervisor'));
    }

    public function sua_congviec(Request $request){
        $congviec_id = $request->congviec_id;
        $congviec = CongViec::find($congviec_id);
        return view('congviecs.sua_congviec',compact('congviec'));
    }

    public function get_view_change_status(Request $request) {
        $congviec_id = $request->congviec_id;
        $congviec = CongViec::find($congviec_id);

        return view('congviecs._change_status', compact('congviec'));
    }

    public function change_status(Request $request) {
        $congviec_id = $request->congviec_id;
        $status = $request->status;

        $congviec = CongViec::find($congviec_id);
        $congviec->trangthai = $status;
        $congviec->save();

        die(json_encode(['error' => 0]));
    }

    public function sua_congviecPost(Request $request){
        $congviec_id = $request->congviec_id;
        $congviec = CongViec::find($congviec_id);
        $congviec->tencongviec = $request->tencongviec;
        $congviec->ngaybatdau = formatYMD($request->ngaybatdau);
        $congviec->ngayketthuc = formatYMD($request->ngayketthuc);
        $congviec->tinhchat = $request->tinhchat;
        $congviec->noidung = nl2br($request->noidung);
        $congviec->nguoigiamsat = $request->nguoigiamsat;
        $congviec->trangthai = $request->trangthai;
        if ($congviec->save()) {
            return 'done';
        }else{
            return 'error';
        }
    }

    public function view_Work(Request $request){
        $user = session('user');
        $date_star = formatYMD($request->date_star,'');
        $date_end = formatYMD($request->date_end,'');

        $check_CheckUser = CheckUser::where('username',$user['username'])->first();

        $congviecs = CongViec::where('user_username',$user['username'])->take(35)->get();
        $congviec_users = CongviecChiTiet::where('user_username',$user['username'])->take(35)->get();

        return view('congviecs.view_work',compact('check_CheckUser','user','date_star','date_end','congviec_users','congviecs'));
    }

    public function view_dailyReport(Request $request){
        $report_id = $request->report_id;
        $dailyReport = DailyReport::find($report_id);
        return view('baocaos._modal_view_dailyReport',compact('dailyReport'));
    }

    public function view_report_detail(Request $request){
        $baocao_id = $request->baocao_id;
        $congviec_baocao = Congviec_Baocao::find($baocao_id);
        $view_report_detail = 1;
        return view('baocaos._modal_agreement_report',compact('congviec_baocao','view_report_detail'));
    }

    public function work_search_keyup(Request $request){
        $keyword = $request->keyword;
        $congviec_baocao = CongviecChiTiet::where([
            ['user_username',$request->username],
            ['noidung','LIKE','%'.$keyword.'%']
        ])->orderBy('id','DESC')->take(15)->get();
        if ( sizeof($congviec_baocao) > 0 ) {
            foreach ($congviec_baocao as $item) {
                echo "<li data-id='".$item->id."'>".$item->noidung." <i style='color:blue' class='fa fa-check'></i></li>";
            }
        }else{
            echo "<li>Không có công việc với: ".$keyword." <i style='color:#f03' class='fa fa-times'></i></li>";
        }
    }

    public function work_search_all(Request $request){
        $congviec_baocao = CongviecChiTiet::where([
            ['user_username',$request->username],
        ])->orderBy('id','DESC')->take(35)->get();
        if ( sizeof($congviec_baocao) > 0 ) {
            foreach ($congviec_baocao as $item) {
                echo "<li data-id='".$item->id."'>".$item->noidung."</li>";
            }
            if( sizeof($congviec_baocao) == 35 )
            echo "<li><em style='color:#8a6d3b'>Hệ thống giới hạn hiển thị tối đa 35 kết quả tìm kiếm!</em></li>";
        }else{
            echo "<li><em style='color:#8a6d3b'>Không có công việc!</em></li>";
        }
    }

    public function draft_report(Request $request){
        if ($request->content == null) {
            return redirect()->back()->with('err','Vui lòng nhập nội dung báo cáo');
        }

        $user = session('user');
        $dailyReport = new DailyReport;

        $data['content'] = $request->content;
        $data['fullname'] = $user['type'] == 'local' ? $user['fullname'] : $user['tennv'];
        $data['donvi_id'] = $user['donvi_id'];
        $data['username'] = $user['username'];
        $data['user_id'] = $user['id'];
        $data['reportday'] = date('Y-m-d H:i:s');
        $data['congviec_user_id'] = $request->congviec_user_id != null ? $request->congviec_user_id : null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $data['file'] = 'files/'.$fileName;
            $file->move(base_path() . '/files/', $fileName);
        }

        if ($dailyReport->create($data)) {
            return redirect()->back()->with('msg','Gửi báo cáo thành công');
        }else{
            return redirect()->back()->with('err','Gửi báo cáo thất bại');
        }
    }

    public function get_danh_sach_cong_viec($params = []) {
        // get params
        $userId = isset($params['user_id'])? $params['user_id'] : session('user')['id'];
        $vanbanId = isset($params['vanban_id'])? $params['vanban_id'] : Input::get('vanban_id');
        $vanbanDonviId = isset($params['vanban_donvi_id'])? $params['vanban_donvi_id'] : Input::get('vanban_donvi_id');
        $search = isset($params['search'])? $params['search'] : Input::get('search', '');
        $date = isset($params['date'])? $params['date'] : Input::get('date', '');
        $type =  isset($params['type'])? $params['type'] : Input::get('type', 'all'); // get all - da_giao - duoc_giao
        $status =  isset($params['status'])? $params['status'] : Input::get('status');
        $getView = isset($params['get_view'])? $params['get_view'] : Input::get('get_view'); // get data hay view
        $congviecIdActive = isset($params['congviec_id_active'])? $params['congviec_id_active'] : Input::get('congviec_id_active'); // id công việc đang được chọn trong view
  
        // get danh sách công việc của văn bản
        $congviecs = CongViec::getDanhSach($userId, [
                        'vanban_id' => $vanbanId,
                        'vanban_donvi_id' => $vanbanDonviId,
                        'type' => $type,
                        'search' => $search,
                        'date' => $date? date('Y-m-d', strtotime($date)) : '',
                        'status' => $status
                    ])
                    ->paginate(200)
                    ->appends(Input::except('page'));

        if ($getView) {
            return view('congviecs._table_congviec', compact('congviecs', 'congviecIdActive'));
        }
        else {
            return $congviecs;
        }
    }
}
