<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
//use App\Http\Requests\Request;
use App\Models\Lichtuan;
use App\Models\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

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

    public function LoginTest(Request $request){
        $validator = \Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user = User::where('email', $request->email)->first();
        $user_email = '';
        if ($user) {
            if (\Hash::check($request->password, $user->password)) {
                $token = time();
                $response = ['token' => $token];
                $user_email = $user->email;
                $user->user_id_login = $user->id;
                $user->type = 'local';
                session(['user' => $user->toArray()]);
                //Session::put('user', $user->toArray());
//                $value = \session('user');
//                dd($value);

                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" =>'User does not exist'];
            return response($response, 422);
        }
    }
}
