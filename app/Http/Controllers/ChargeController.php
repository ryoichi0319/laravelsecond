<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use App\Models\Order;

class ChargeController extends Controller
{
    //
    public function charge(Request $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));
    
            $customer = Customer::create(array(
                'email' => $request->stripeEmail,
                'source' => $request->stripeToken
            ));

            // 注文情報を取得
            $order = Order::find($request->id);

            // 注文が見つからない場合はエラーメッセージを返す
            if (!$order) {
                return "Order not found";
            }
           
            $total_amount = $order->total_amount; // 注文の金額を取得
    
            $charge = Charge::create(array(
                'customer' => $customer->id,
                'amount' => $total_amount,
                'currency' => 'jpy'
            ));
    
            return back();
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
}