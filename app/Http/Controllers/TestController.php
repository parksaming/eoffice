<?php

namespace App\Http\Controllers;

use App\Models\Butphe;
use App\Models\User;
use App\Models\Vanban;
use App\Models\VanbanXuLy;
use App\Models\Ykien;

class TestController extends Controller
{
    public function test() {
        $vanbandis = Vanban::where('book_id', 2)->get();

        foreach($vanbandis as $vanbandi) {
            $vanbandi->sovb = explode('/', $vanbandi->kyhieu)[0];
            
            $vanbandi->save();
        }
        session(['user' => 'test']);

        die(route('dowload.file', ['test.doc', 'vanban_id' => 1]));
    }
}
