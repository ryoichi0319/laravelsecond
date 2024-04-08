<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Laravel\Cashier\Cashier;

use Exception;
class PaymentController extends Controller
{
    public function index()
    {
        // $user = Cashier::findBillable($stripeId);

        return Inertia::render('Payment/index');
    }

     /**
     * 決済フォーム表示
     */
    public function create()
    {
        return view('Payment.create');
    }


     /**
     * 決済実行
     */
    public function store(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.stripe_secret_key'));

        try {
            \Stripe\Charge::create([
                'source' => $request->stripeToken,
                'amount' => 1000,
                'currency' => 'jpy',
            ]);
        } catch (Exception $e) {
            return back()->with('flash_alert', '決済に失敗しました！('. $e->getMessage() . ')');
        }
        return back()->with('status', '決済が完了しました！');
    }
}
