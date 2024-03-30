<?php

namespace App\Http\Controllers;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use Illuminate\Support\Composer;

class ItemController extends Controller
{
    //
    public function store(Request $request)
{
    // リクエストからすべてのアイテムと数量を取得
    $orders = $request->input('orders');
    $user_id = auth()->id(); // 現在の認証されたユーザーのIDを取得する
    $order = Order::where('user_id', $user_id)->firstOrFail(); // 指定されたユーザーIDに一致するOrderレコードを取得する
    $order_id = $order->id;
    
    // 注文ごとにループしてデータベースに保存
    foreach ($orders as $orderData) {
        Item::create([
            'name' => $orderData['selectedItem'],
            'quantity' => $orderData['quantity'],
            'order_id' => $order_id,
            'status' => 'pending',
            'table_number' => $order->table_number,
            'price' => $orderData['amount']
            ]);
    }


    // $items = $request->input('items');
    // // $selectedItemsがnullでないことを確認
    // if (!is_null($items)) {
    //     // 各アイテムをデータベースに保存
    //     foreach ($items as $selectedItem) {
    //         Item::create([
    //             'name' => $selectedItem,
    //             'status' => 'pending',
    //              'table_number' => 1

    //         ]);
    //     }
    //     // 成功レスポンスを返す
    //     return response()->json(['message' => 'Selected items saved successfully'], 200);
    // } else {
    //     // $selectedItemsがnullの場合はエラーメッセージを返す
    //     return response()->json(['error' => 'No selected items provided'], 400);
    // }
    

    return response()->json(['message' => '送信しました'], 200);
}

    public function index(){

        $items = Item::with('order')->get();
        $total = 0;
        foreach ($items as $item)
        {
            $total += $item->price * $item->quantity;
        }
        Log::info($total);

        return view('item.index',compact('items'));

    }
    public function show(Item $item){
        return view('item.show',compact('item'));
    }
    public function update(Request $request, Item $item){
        $item->status = $request->status;
        $item->save();
    
        return redirect()->back()->with('success', 'Order status updated successfully');

    }
    public function edit(Item $item)
    {
        return view('item.edit', compact('item'));
        //
    }
}
