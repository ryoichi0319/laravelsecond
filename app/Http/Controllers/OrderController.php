<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Facades\Auth; // Authを追加

class OrderController extends Controller
{
    //
   public function create(){
    $user = Auth::user();

    return view('order.create');

   }
   public function store(Request $request){
          $validated = $request->validate([
            'table_number' => 'required|unique:orders|integer|min:1|max:3',

        ]);
        $validated['user_id'] = auth()->id();

          $order = Order::create($validated);
          return redirect('/order');

   }
   public function destroy(Request $request, Order $order)
   {
       $order->delete();
       $request->session();
       return redirect()->route('order.index')->with('message','削除しました');

       //
   }


   public function index(){
   $orders = Order::all();
    return view('order.index',compact('orders'));
   }

   
   public function show($id)
   {
    $order_id = Order::find($id);
    $user_id = auth()->id();

    return view('order.show',compact('order_id','user_id'));
    


    
    // $order_table = Order::find($id);

       }
}
