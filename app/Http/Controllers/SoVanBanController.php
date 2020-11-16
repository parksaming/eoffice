<?php

namespace App\Http\Controllers;

use App\Models\SoVanBan;
use App\Models\Vanban;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class SoVanBanController extends Controller
{
    public function get_danh_sach() {
        //get data
        $sovanbans = SoVanBan::getDanhSach()->withCount(['vanbans'])->get();
        return view('sovanban.danh_sach_so_van_ban', compact('sovanbans'));
    }

    public function get_danh_sach_van_ban_thuoc_so($sovanbanId) {
        // get data
        $vanbans = Vanban::GetDanhSachVanBanThuocSo($sovanbanId)->get();
        // dd($vanbans->toArray());
        return view('sovanban.danh_sach_van_ban_thuoc_so', compact('vanbans'));
    }

    public function create_so_van_ban() {
        return view('sovanban.create_so_van_ban');
    }

    public function edit_so_van_ban($id) {
        // get book
        $soVanBan = SoVanBan::find($id);
        if (!$soVanBan) {
            flash('Sổ văn bản không tồn tại');
            return redirect(route('sovanban.list'));
        }

        // view
        return view('sovanban.edit_so_van_ban', compact('soVanBan'));   
    }

    public function save_so_van_ban(Request $request) {
        if ($request->id) {
            $soVanBan = SoVanBan::find($request->id);
            if (!$soVanBan) {
                flash('Sổ văn bản không tồn tại');
                return redirect(route('sovanban.list'));
            }
            
            $soVanBan->update([
                'name' => $request->name,
                'type' => $request->type,
                'description' => $request->description,
                'status' => isset($request->status)? SoVanBan::$statuses['active'] : SoVanBan::$statuses['deactive']
            ]);

            flash('Sửa sổ văn bản thành công');
        }
        else {
            $user = (object) Session::get('user');
            SoVanBan::insert([
                'name' => $request->name,
                'type' => $request->type,
                'description' => $request->description,
                'status' => isset($request->status)? 1 : 0,
                'created_by' => $user->id,
                'donvi_id' => $user->donvi_id,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            flash('Thêm sổ văn bản thành công');
        }

        return redirect(route('sovanban.list'));
    }

    public function delete_so_van_ban(Request $request) {
        // xóa data
        SoVanBan::whereIn('id', $request->ids)->delete();

        flash('Xóa sổ văn bản thành công thành công');

        return response()->json(['error' => 0]);
    }
}