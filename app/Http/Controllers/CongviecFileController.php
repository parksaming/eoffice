<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CongviecFile;
use Storage;
use App\Congviec;



class CongviecFileController extends Controller
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
    public function create($id)
    {
        $congviec = Congviec::find($id);
        return view('congviecs.congviecFile', compact($congviec));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $congviecFile = new CongviecFile;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalName();
            $location = 'files/';
            $filename = uniqid() . '.' . $extension;
        }
        $congviecFile->file = 'files/'.$filename;
        $congviecFile->congviec_id = $request->congviec_id;

        $congviecFile->save();

        return redirect('baocao/xem_bao_cao_don_vi')->with(['congviecFile' => $congviecFile]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = session('user')? session('user') : session(['user' => '1']);
        $files = CongviecFile::get();
        return view('tabs.congviecfile', compact($files));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $congviecFile = CongviecFile;

        $congviecFile->congviec_id = $request->congviec_id;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalName();
            $location = 'files/';
            $filename = uniqid() . '.' . $extension;
             Storage::put(
            'files/'.$congviecFile->id,
            file_get_contents($request->file('file')->getRealPath())
            );
            $file->move($location, $filename);
        }
        $congviecFile->file = 'files/'.$filename;

        $congviecFile->save();

        return view('congviecs.them-cv', compact($congviecFile));
    }

    public function ajaxRemove_file(Request $request){
        $congviec_file_id = $request->congviec_file_id;
        $congviecfile = CongviecFile::find($congviec_file_id);
        if (file_exists(base_path() . "/" .$congviecfile->file) && !empty($congviecfile->file)) {
            unlink(base_path() . "/" . $congviecfile->file);
        }
        $congviecfile->delete();
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
