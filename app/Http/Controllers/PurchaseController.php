<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PurchaseController extends Controller
{
    public function store(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.stripe_secret_key'));
     



        try {
            $intent = \Stripe\PaymentIntent::create([
                'amount' => 100,
                'currency' => 'usd',
                'payment_method_types' => ['card'],
                'payment_method' => $request->paymentMethodId, // クライアントサイドから提供された支払い方法IDを使用
                'confirmation_method' => 'manual',
                'confirm' => true,
                'return_url' => route('dashboard'), // リダイレクト先のURLを指定する
            ]);
            
            $redirectUrl = route('dashboard');

            // リダイレクト
            return Redirect::to($redirectUrl);            
        } catch (\Exception $e) {
            // エラーの処理
            return back()->withError($e->getMessage())->withErrors($e->getMessage());
        }
    }
}
