<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Cashier\Cashier;


class SubscriptionController extends Controller
{
    //
    public function subscription(Request $request, )
    {   
        $user = $request->user();
        $stripeId = $user->stripe_id;

        $user1 = Cashier::findBillable($stripeId);
        $balance = $user1->balance();



        if ($user->onTrial()) {
            $trialEndsAt = $user->trialEndsAt('');

            // トライアル中の処理
            return view('/trial_page',compact('trialEndsAt','user1','balance'));
        } else {
            return view('/dashboard');
            // トライアル期間が終了している場合の処理
        }
      
    }
}
