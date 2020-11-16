<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CongviecChiTiet;
use Storage;
use App\CongviecFile;
use App\User;
use App\Models\CheckUser;
use App\CongViec;
use App\Models\Butphe;
use App\Models\Notification;
use App\Models\CongViec as AppCongViec;
use App\Models\Vanban;
use App\Models\VanbanXuLy;

class CongviecChiTietController extends Controller
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
    public function store(Request $request)
    {
        $congviec_chitiet = new CongviecChiTiet;

        $congviec_chitiet->user_id = $request->user_id;
        $congviec_chitiet->user_username = $request->user_username;
        $congviec_chitiet->congviec_id = $request->congviec_id;
        $congviec_chitiet->noidung = $request->noidung;
        $congviec_chitiet->ngaybatdau = $request->ngaybatdau;
        $congviec_chitiet->ngayketthuc = $request->ngayketthuc;

        $congviec_chitiet->save();

        return view('congviecs.them-cv', compact($congviec_chitiet));
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
        $congviec_chitiet = CongviecChiTiet::find($id);
        
        $congviec_chitiet->user_id = $request->user_id;
        $congviec_chitiet->user_username = $request->user_username;
        $congviec_chitiet->congviec_id = $request->congviec_id;
        $congviec_chitiet->noidung = nl2br($request->noidung);
        $congviec_chitiet->ngaybatdau = $request->ngaybatdau;
        $congviec_chitiet->ngayketthuc = $request->ngayketthuc;

        $congviec_chitiet->save();

        return back();
    }

    public function ajaxAdd_workDetail(Request $request){
        // get công việc
        $congviec = AppCongViec::find($request->congviec_id_hidden);
        $vanbanxuly = VanbanXuLy::find($congviec->vanbanxuly_id);

        if ( $request->nguoiphutrach == NULL ) {
              return json_encode(
                array(
                    'error' => 1,
                )
            );
        }

        $arrInsertNotifications = []; // array store notification data
        $now = date('Y-m-d H:i:s');

        $list_name = '';

        $loggedUserId = session('user')['id'];

        // lưu nội dung bút phê
        $userIdsPhutrach = [];
        foreach ($request->nguoiphutrach as $item) {
            $usernameIdFullname = explode("+",$item);
            $userIdsPhutrach[] = $usernameIdFullname[1];
        }

        if ($vanbanxuly) {
            $butphe = Butphe::create([
                'vanban_id' => $vanbanxuly->vanbanUser_id,
                'noidung' => nl2br($request->noidung),
                'receiver_ids' => ';'.trim(implode(';',$userIdsPhutrach)).';',
                'created_by' => $loggedUserId
            ]);
        }

        $vanban = Vanban::find($vanbanxuly->vanbanUser_id);

        foreach ($request->nguoiphutrach as $item) {
            $usernameIdFullname = explode("+",$item);
            $congviec_CT = new CongviecChiTiet;
            $congviec_CT->noidung = nl2br($request->noidung);
            $congviec_CT->ngaybatdau = formatYMD($request->ngaybatdau);
            $congviec_CT->ngayketthuc = formatYMD($request->ngayketthuc);
            $list_name .= $usernameIdFullname[2].', ';
            $congviec_CT->user_username = $usernameIdFullname[0];
            $congviec_CT->user_id = $usernameIdFullname[1];
            $congviec_CT->nguoiphutrach = $usernameIdFullname[2];
            $congviec_CT->congviec_id = $request->congviec_id_hidden;
            $congviec_CT->save();

            // check user được phân công có vanban_xuly chưa (fix bug giao việc nhưng ko xem đc vanban)
            if ($vanbanxuly && !VanbanXuLy::where('id_nhan', $usernameIdFullname[1])->where('vanbanUser_id', $vanbanxuly->vanbanUser_id)->first()) {
                $user = User::find($usernameIdFullname[1]);

                VanbanXuLy::insert([
                    'vanbanUser_id' => $vanban->id,
                    'parent_id' => $vanbanxuly->id,
                    'id_nhan' => $user->id,
                    'ngaychuyentiep' => $now,
                    'user_tao' => $loggedUserId,
                    'status' => 1,
                    'type' => $vanbanxuly->type,
                    'is_chuyentiep' =>  1,
                    'noidung_butphe' => nl2br($request->noidung),
                    'butphe_id' => $butphe->id,
                    'donvi_nhan_id' => $user->donvi_id,
                    'loaivanban' => $vanban->book_id
                ]);
            }

            // save notification data
            $receivor = User::where('username', $usernameIdFullname[0])->first();
            $arrInsertNotifications[] = [
                'creator_id' => $loggedUserId,
                'receivor_id' => $receivor->id,
                'type' => Notification::$types['nhancongviecmoi'],
                'content' => sprintf('Bạn nhận được một công việc từ %s', session('user')['fullname']),
                'notificationable_id' => $request->congviec_id_hidden,
                'notificationable_type' => Congviec::class,
                'created_at' => $now
            ];
        }

        // Insert notifications
        if ($arrInsertNotifications) {
            Notification::insert($arrInsertNotifications);
        }

        $congviec_CT->list_name = rtrim($list_name,', ');

        return json_encode(
            array(
                'error' => 0,
                'congviec_CT' => $congviec_CT,
            )
        );
    }

    public function delete_work_detail(Request $request){
        $list_work_detail_id = rtrim($request->list_work_detail_id,',');
        $arr_work_detail_ids = explode(",",$list_work_detail_id);

        foreach ($arr_work_detail_ids as $work_detail_id) {
            $congviec_CT = CongviecChiTiet::find($work_detail_id);

            $congviec_CTs = $congviec_CT::where('noidung',$congviec_CT->noidung)->get();
            foreach ($congviec_CTs as $congviec_CT_item) {
                $congviec_CT_item->delete();
            }
        }

        return 'ok';
    }

    public function get_update_work_detail(Request $request){
        $congviec_detail_ids = $request->congviec_detail_id;
        $congviec_CT = CongviecChiTiet::find($congviec_detail_ids[0]);
        
        $congviec_CTs =  CongviecChiTiet::where([
            ['noidung',$congviec_CT->noidung],
            ['congviec_id',$congviec_CT->congviec_id]
        ])->get();

        foreach ($congviec_CTs as $congviec_CTs_item) {
            $arr_user_id[] = $congviec_CTs_item->user_username;
        }

        $user = session('user');

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

        return view('congviecs.congviec_chitiet.modal_UpdateCongViecCt',compact('congviec_CT','congviec_CTs','arr_user_id','donvis','dv_sess','user'));
    }

    public function post_update_work_detail(Request $request){
        $congviec_detail_id = $request->congviec_detail_id;
        $congviec_id = $request->congviec_id_hidden;
        $noidung = nl2br($request->noidung);

        $congviec_CT_root = CongviecChiTiet::find($congviec_detail_id);

        if (empty($request->nguoiphutrach)) {
            return json_encode(
                array(
                    'error' => 1,
                    'congviec_id' => $congviec_id,
                )
            );
        }

        foreach ($request->nguoiphutrach as $item) {
            $usernameIdFullname = explode("+",$item);
            $arr_user_username[] = $usernameIdFullname[0]; 
            $congviec_CT = CongviecChiTiet::where([
                ['congviec_id', $congviec_id],
                ['user_username', $usernameIdFullname[0]],
                ['noidung',$congviec_CT_root->noidung],
            ])->first();
            if ( count($congviec_CT) > 0 ) {
                $congviec_CT->noidung = $noidung;
                $congviec_CT->ngaybatdau = formatYMD($request->ngaybatdau);
                $congviec_CT->ngayketthuc = formatYMD($request->ngayketthuc);
                $congviec_CT->save();
            }else{
                $congviec_CT = new CongviecChiTiet;
                $congviec_CT->noidung = $noidung;
                $congviec_CT->congviec_id = $congviec_id;
                $congviec_CT->user_id = $usernameIdFullname[1];
                $congviec_CT->user_username = $usernameIdFullname[0];
                $congviec_CT->nguoiphutrach = $usernameIdFullname[2];
                $congviec_CT->ngaybatdau = formatYMD($request->ngaybatdau);
                $congviec_CT->ngayketthuc = formatYMD($request->ngayketthuc);
                $congviec_CT->save();
            }
        }
        $congviec_CT_dels = CongviecChiTiet::where([
                ['congviec_id', $congviec_id],
                ['noidung',$congviec_CT_root->noidung],
            ])->whereNotIn('user_username',$arr_user_username)->get();
        foreach ($congviec_CT_dels as $congviec_CT_del) {
            $congviec_CT_del->delete();
        }

        return json_encode(
            array(
                'error' => 0,
                'congviec_id' => $congviec_id,
            )
        );
    }

    public function ajaxUploadDocs_workDetail(Request $request){
        $this->validate($request,
            [
                'file_work_detail' => 'max:20480',
            ],
            [
                'file_work_detail.max' => 'Kích thước tệp gới hạn < 20m',
            ]);
        $congviec_id = $request->congviec_id_hidden;

        if ($request->hasFile('file_work_detail')) {
            foreach ($request->file('file_work_detail') as $file) {
                $fileName = time().'.'.$file->getClientOriginalExtension();
                $fileName_rd = str_random(4).'_'.$fileName;
                while ( file_exists(base_path().'/files/'.$fileName_rd) ) {
                    $fileName_rd = str_random(4).'_'.$fileName_rd;
                }
                $file->move(base_path() . "/files" , $fileName_rd);

                $congviecFile = new CongviecFile; 
                $congviecFile->file = 'files/'.$fileName_rd;
                $congviecFile->congviec_id = $congviec_id;
                $congviecFile->save();
                echo '
                    <li class="list-group-item">
                        <a href="'.url('').'/'.$congviecFile->file.'" download="">'.$congviecFile->file.'</a>
                        <span title="Xóa file" class="badge" data-id="'.$congviecFile->id.'">x</span>
                    </li>';
            }
        }
    }

    public function axjaxLoadDetail_WorkJoin(Request $request)
    {
        $user_username = CongViec::where('id',$request->congviec_id)->pluck('user_username');
        $congviecCT_usernameOrFullnames = CongviecChiTiet::
            where('congviec_id',$request->congviec_id)
            ->select('user_username','nguoiphutrach')->get(); 

        $creators_User = User::where('username',$user_username[0])->first();
        if ( sizeof($creators_User) > 0 ) {
            $creators = $creators_User->fullname;
        }else{
            $creators = $user_username[0];
        }
        
        $html = '<p>'.$creators.' <em>( Người giao việc )</em></p>';
        foreach ($congviecCT_usernameOrFullnames as $congviecCT_usernameOrFullname) {
            $check_User = User::where('username',$congviecCT_usernameOrFullname->user_username)->first();
            if ( sizeof($check_User) > 0 ) {
                $html .= '<p>'.$check_User->fullname.'</p>';
            }else {
                $html .= '<p>'.($congviecCT_usernameOrFullname->nguoiphutrach != null ? $congviecCT_usernameOrFullname->nguoiphutrach : $congviecCT_usernameOrFullname->user_username).'</p>';
            }
        }

        return $html;
    }

    public function ajaxLoad_document(Request $request){
        $congviec_id = $request->congviec_id;
        $files = CongviecFile::where('congviec_id', $congviec_id)->get();
        foreach ($files as $file) {
            echo '
                <li class="list-group-item">
                    <a href="'.url('').'/'.$file->file.'" download title="">'.$file->file.'</a>
                    <span title="Xóa file" class="badge" data-id="'.$file->id.'">x</span>
                </li>
            ';
        }
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
}
