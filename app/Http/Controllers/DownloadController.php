<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class DownloadController extends Controller
{  public function index()
    {
        $fileName = '3.jpg';
        $filePath = 'public/' . $fileName; // .演算子を使用して文字列を連結する
        $mimeType = Storage::mimeType($filePath);
        $headers = [['Content-Type' => $mimeType]];
        $disposition = 'attachment';
        
        return Storage::response($filePath, $fileName, $headers, $disposition);
}
}