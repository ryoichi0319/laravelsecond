<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Facades\Auth; // Authを追加
use Illuminate\Support\Facades\Log;
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


    // レスポンスを返す前にリダイレクトする
    $order = Order::create($validated);
    return redirect('/order')->withCookie(cookie('name', 'value'));

   }
   public function destroy(Request $request, Order $order)
   {
       $order->delete();
       return redirect('order/create')->with('message', '削除しました');
   }


   public function index(){
    // ログインユーザーの注文データを取得
    $orders = Order::where('user_id', auth()->id())->get();
    $items = Item::with('order')->get();

    return response()->json($orders);
   }

   
   public function show($id)
   {
    $order = Order::find($id);

    // ログに注文データを出力
    Log::info($order);

    // ユーザー ID を取得
    $user_id = auth()->id();

    // アイテムを注文と共に取得
    $items = Item::where('order_id', $id)->get();

    // 合計金額を初期化
    $total = 0;

    // 各アイテムの価格と数量を使用して合計金額を計算
    foreach ($items as $item) {
        $total += $item->price * $item->quantity;
    }

    // ログに合計金額を出力
    Log::info($total);

    // 注文データに合計金額を追加
    $order['total_amount'] = $total;
    // 注文データを保存
    $order->save();

    // 修正された注文データを JSON レスポンスとして返す
    return response()->json($order);
   }
}
