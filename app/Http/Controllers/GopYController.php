<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GopY;

class GopYController extends Controller
{
    public function save_gop_y(Request $request) {
        $gopy = new GopY();

        // get params
        $gopy->name = $request->name;
        $gopy->email = $request->email;
        $gopy->noidung = $request->noidung;
        $gopy->created_by = session('user')['id'];

        // có file đính kèm file
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = 'files/vanban/';

            $fileNameArr = explode('.', $file->getClientOriginalName());
            $fileName = str_slug($fileNameArr[0], '-') . '_' . time() . '.' . $fileNameArr[1];

            if (!$file->move($path, $fileName)) {
                flash('Lưu góp ý thất bại');
                return redirect()->back();
            }
            else {
                $gopy->file = $fileName;
            }
        }

        if ($gopy->save()) {
            flash('Lưu góp ý thành công');
            return redirect()->back();
        }
        else {
            flash('Lưu góp ý thất bại');
            return redirect()->back();
        }
    }
}