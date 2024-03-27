<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class TestController extends Controller
{
    public function test(){
       $fruits = [
           "apple",
           "pine",
           "orange"
       ];
       $users = User::all();
       return view('test',compact('users'),['fruits' => $fruits]);

    }
    //
}
