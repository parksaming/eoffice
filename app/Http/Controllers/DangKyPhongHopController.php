<?php

namespace App\Http\Controllers;
use Validator;
use App\Models\DangKyPhongHop;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class DangKyPhongHopController extends Controller
{
   

    public function DangKy(Request $request){
    	$dangky = new DangKyPhongHop;
    	$dangky->nguoidangky = $request->nguoidangky;
    	$dangky->donvi = $request->donvi;
    	$dangky->sodienthoai = $request->sodienthoai;
    	$dangky->email = $request->email;
    	$dangky->start_time = $request->start_time;
    	$dangky->end_time = $request->end_time;
        $dangky->noidung = $request->noidung;
        $dangky->hinhthuchop = $request->hinhthuchop;
        $dangky->chutri = $request->chutri;
        $dangky->songuoithamgia = $request->songuoithamgia;
        $dangky->yeucau = $request->yeucau;
        $dangky->nguonkinhphi = $request->nguonkinhphi;
    	$dangky->save();
    	return view('phonghop.quan_ly_phong_hop', compact('phonghop'));

    }

}
