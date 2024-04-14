<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // QrCodeファサードのインポート

class HomeController extends Controller
{
    public function index(){
        QrCode::size(500)->generate('https://www.example.com');

        return view('dashboard');
    }
}
