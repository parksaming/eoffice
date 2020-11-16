<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookDetail;
use App\Models\User;
use App\Models\Vanban;
use function GuzzleHttp\json_encode;

class CommonController extends Controller
{
    public function load_user_donviden_option(Request $request) {
        // get params
        $donviIds = $request->donvi_ids;
        $emptyOption = $request->empty_option;
        $selectedUserIds = $request->selected_values? $request->selected_values : [];

        if (!$donviIds) {
            return '';
        }

        // get data
        $bookDetails = BookDetail::where('book_detail.book_id', 1)->whereIn('book_detail.donvi_id', $donviIds)->get();

        $userIds = [];
        foreach($bookDetails as $bookDetail) {
            $userIds = array_merge($userIds, $bookDetail->user_ids);
        }
        $users = User::getList()->whereIn('users.id', $userIds)->get();

        // create option string
        $strOptions = '';
        if (!empty($emptyOption)) {
            $strOptions = '<option value="">'.$emptyOption.'</option>';
        }

        foreach($users as $user) {
            $strOptions .= '<option value="'.$user->id.'" '.(in_array($user->id, $selectedUserIds)? 'selected' : '').'>'.$user->fullname.' - '.$user->chucdanh.' - '.$user->email.'</option>';
        }

        return $strOptions;
    }

    public function load_user_donvidi_option(Request $request) {
        // get params
        $donviIds = $request->donvi_ids;
        $emptyOption = $request->empty_option;
        $selectedUserIds = $request->selected_values? $request->selected_values : [];

        if (!$donviIds) {
            return '';
        }

        // get data
        $bookDetails = BookDetail::where('book_detail.book_id', 2)->whereIn('book_detail.donvi_id', $donviIds)->get();

        $userIds = [];
        foreach($bookDetails as $bookDetail) {
            $userIds = array_merge($userIds, $bookDetail->user_ids);
        }
        $users = User::getList()->whereIn('users.id', $userIds)->get();

        // create option string
        $strOptions = '';
        if (!empty($emptyOption)) {
            $strOptions = '<option value="">'.$emptyOption.'</option>';
        }

        foreach($users as $user) {
            $strOptions .= '<option value="'.$user->id.'" '.(in_array($user->id, $selectedUserIds)? 'selected' : '').'>'.$user->fullname.' - '.$user->chucdanh.' - '.$user->email.'</option>';
        }

        return $strOptions;
    }

    public function load_user_donviden_checkbox(Request $request) {
        // get params
        $donviIds = $request->donvi_ids;
        $checkboxName = $request->checkbox_name;
        $selectedUserIds = $request->selected_values? $request->selected_values : [];
        if (!is_array($selectedUserIds)) {
            $selectedUserIds = [$selectedUserIds];
        }

        if (!$donviIds) {
            return 'Không có dữ liệu';
        }


        // get bookdetail được chọn
        $users = User::getListLanhDao()->whereIn('users.donvi_id', $donviIds)->get();
       // get bookdetail được chọn
		 // get data
        $bookDetails = BookDetail::where('book_detail.book_id', 2)->whereIn('book_detail.donvi_id', $donviIds)->get();

        $userIds = [];
        foreach($bookDetails as $bookDetail) {
            $userIds = array_merge($userIds, $bookDetail->user_ids);
        }
        $users = User::getList()->whereIn('users.id', $userIds)->where('users.role', User::$roles['lanhdao'])->get()->keyBy('id');
		$datas = [];
        foreach($userIds as $v){
			if(isset($users[$v]))
			   $datas[$v] = $users[$v];
		}

        // format lại dữ liệu: nhóm $users theo đơn vị
        $data = [];
        foreach($datas as $user) {
            if ($user->donvi_id) {
                if (!isset($data[$user->donvi->name])) {
                    $data[$user->donvi->name] = [];
                }

                $data[$user->donvi->name][] = $user;
            }
        }


        // return view
        return view('vanban._checkbox_user', compact('data', 'checkboxName', 'selectedUserIds'));
    }

    public function load_user_donvinoibo_checkbox(Request $request) {
        // get params
        $donviIds = $request->donvi_ids;
        $checkboxName = $request->checkbox_name;
        $selectedUserIds = $request->selected_values? $request->selected_values : [];
        if (!is_array($selectedUserIds)) {
            $selectedUserIds = [$selectedUserIds];
        }

        if (!$donviIds) {
            return 'Không có dữ liệu';
        }

        // get bookdetail được chọn
        $bookDetails = BookDetail::where('book_detail.book_id', 4)->whereIn('book_detail.donvi_id', $donviIds)->get();

        $userIds = [];
        foreach($bookDetails as $bookDetail) {
            $userIds = array_merge($userIds, $bookDetail->user_ids);
        }


        $users = User::getList()->whereIn('users.id', $userIds)->where('users.id', '<>', session('user')['id'])->get()->keyBy('id');

        $dataUsers = [];
        foreach($userIds as $v){
            if(isset($users[$v]))
                $dataUsers[$v] = $users[$v];
        }


        // format lại dữ liệu: nhóm $users theo đơn vị
        $data = [];
        foreach($dataUsers as $user) {
            if ($user->donvi_id) {
                if (!isset($data[$user->donvi->name])) {
                    $data[$user->donvi->name] = [];
                }

                $data[$user->donvi->name][] = $user;
            }
        }
        // return view
        return view('vanban._checkbox_user', compact('data', 'checkboxName', 'selectedUserIds'));
    }

    public function check_number_van_ban_trong_ngay(Request $request) {
        // get params
        $number = $request->get('number');
        $date = date('Y-m-d', strtotime($request->get('date')));
        $vanbanId = $request->get('vanban_id');

        // check văn bản có số văn bản $number đã có trong ngày chưa
        $vanban = Vanban::where('vanbans.soden', $number)->where('vanbans.ngayden', $date);

        if ($vanbanId) {
            $vanban->where('vanbans.id', '<>', $vanbanId);
        }

        $vanban = $vanban->first();

        if ($vanban) {
            die(json_encode('Số đến đã tồn tại'));
        }
        else {
            die(json_encode(true));
        }
    }
}