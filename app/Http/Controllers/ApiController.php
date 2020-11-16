<?php


namespace App\Http\Controllers;
use App\Models\Lichtuan;
use Illuminate\Support\Facades\Input;

class ApiController extends Controller
{
    public function GetLichTuan(){
        $date = Input::get('date', date('Y-m-d'));
        $firstDateInWeek = date("Y-m-d", strtotime('sunday last week', strtotime($date)));
        $lastDateInWeek = date("Y-m-d", strtotime('saturday this week', strtotime($date)));
        $data = Lichtuan::getDanhSach([
            'status' => 1,
            'from_date' => $firstDateInWeek,
            'to_date' => $lastDateInWeek
        ])->get()->keyBy('id');

        $result = [];
        foreach ($data as $item){
            array_push($result, [
                'Id'=>$item->id,
                'Date'=>$item->time,
                'Content'=>$item->noidung,
                'Components'=> $item->thanhphan,
                'Address'=>$item->diadiem,
                'MainChain'=>$item->chutri,
                'ObjectType'=> $item->type
            ]);
        }

        return response(json_encode($result), 200)
            ->header('Content-Type', 'json/application');
    }
}
