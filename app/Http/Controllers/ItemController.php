<?php

namespace App\Http\Controllers;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use Illuminate\Support\Composer;
use Illuminate\Support\Facades\Auth;

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
    return response()->json(['message' => '送信しました'], 200);


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
}

    public function index(){
        $user = Auth::user();
        $items = Item::sortable()->with('order')->orderBy('created_at', 'desc')->get();
        $group_items = Item::orderBy('order_id')->get()->groupBy('order_id');

        $total = 0;
        foreach ($items as $item)
        {
            $total += $item->price * $item->quantity;
        }
        Log::info($total);
        
        return view('item.index',compact('items','group_items') );

    }
    // public function show( Order $order){
    //     return view('item.show',compact('item'));
    // }
    public function update(Request $request, Item $item){
        $item->status = $request->status;
        $item->save();
    
        return redirect()->back()->with('success', 'Order status updated successfully');

    }

    public function show(Request $request, Item $item, $id)
    {
        // 注文 ID を使用して、注文データを取得
        $order = Order::find($id);
    
        if (!$order) {
            abort(404, '注文が見つかりませんでした');
        }
    
        // アイテムを注文と共に取得
        $items = Item::where('order_id', $id)->get();
    
        // 合計金額を初期化
        $total = 0;
    
        // 各アイテムの価格と数量を使用して合計金額を計算
        foreach ($items as $item) {
            $total += $item->price * $item->quantity;
        }
    
        // 注文データに合計金額を追加
        $order->total_amount = $total;
    
        // 注文データを保存
        $order->save();
        Log::debug('User ID: ' . auth()->id());
        Log::debug('Order ID: ' . $order->id);
        Log::debug('Item ID: ' . $item->id);
    
        // ポリシーを使用してユーザーの権限をチェック
        $this->authorize('view', [$order, $item]);
        return view('item.order.show', compact('item', 'order'));
    }
    

    public function edit(Item $item)
    {
        return view('item.edit', compact('item'));
        //
    }
}