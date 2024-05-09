<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    //
    public function index(){

    	return view('upload.index');
    }


    public function store(Request $request)
    {
        $file_name = $request->file('file')->getClientOriginalName();
        $request->file('file')->storeAs('public', $file_name);
        return redirect()->route('upload.complete', ['filename' => $file_name]);
    }

    public function complete($filename)
    {
        return view('upload.complete', ['filename' => $filename]);
    }
}
