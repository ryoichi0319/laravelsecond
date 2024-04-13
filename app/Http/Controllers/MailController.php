<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendTestMail; // 送信するメールのMailableクラスをインポートする
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MailController extends Controller
{
    //
    public function send_mail(){
        $user = Auth::user();
        $name = $user->name;
        Log::info($user);
        $emails = $user->email;
        Mail::to($emails)->send(new SendTestMail($name));

        return redirect()->back()->with('message', '送信しました');
    }

    public function mail(){
        $user=Auth::user();
        $name = $user->name;
        $time = Carbon::now()->format('H:i');


        return view('emails.test',compact('name','time'));

    }
}
