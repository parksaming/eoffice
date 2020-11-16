<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CongviecMessage;
use App\Models\CheckUser;
use App\User;

class CongviecMessageController extends Controller
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
    	$user = Session('user');
    	$congviec_mes = new CongviecMessage;

    	$congviec_mes->congviec_id = $request->congviec_id_hidden;
    	$congviec_mes->user_gui = $user['username'];
    	$congviec_mes->noidung = nl2br($request->noidung);
    	$congviec_mes->ngaygui = date('Y-m-d H:i:s');
    	$congviec_mes->save();

        $time = convertCarbonToVN($congviec_mes->ngaygui);

    	$html = '
			<div class="message_content">
				<div class="thumb_mes clearfix fl-right">
					<div class="message_txt my_mes">
						'.$congviec_mes->noidung.'
					</div>
					<div class="message_time fl-right">'.$time.'</div>
				</div>
			</div>
    	';

    	return $html;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
    	// $user = Session('user'); 

        $congviec_id = $request->congviec_id;
        $congviec_messages = CongviecMessage::where('congviec_id',$congviec_id)
        ->orderBy('id','ASC')->get();
        $list_username = array();

        if ( $congviec_messages->count() > 0 ) {
	        foreach ($congviec_messages as $congviec_message) {
	        	$check_user = CheckUser::where('username',$congviec_message->user_gui)->first();
	        	if ( count($check_user) > 0 ) {
	        		$list_username[] = $check_user->username;
	        	}else{
	        		$user = User::where('username',$congviec_message->user_gui)->first();
	        		if ( count($user) > 0 ) {
	        			$list_username[] = $user->fullname;
	        		}
	        	}
	        }
	    }

        return json_encode(
        	array(
        		'congviec_mes' => $congviec_messages,
        		'list_username' => $list_username,
        	)
        );
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
