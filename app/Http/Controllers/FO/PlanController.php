<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Plan;
use App\User;
use App\Subscription;
use \Braintree_Gateway;

class PlanController extends Controller
{
    public function __construct()
    {
        $this->gateway = new Braintree_Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchant_id'),
            'publicKey' => config('services.braintree.public_key'),
            'privateKey' => config('services.braintree.private_key')
        ]);
    }

    public function index(Request $request)
    {
        if (Config::get('parameters')['payment']) {
            $time = $request->user()->subscriptions()->orderBy('ends_at', 'desc')->first();
            if (!isset($time) || time() > strtotime($time->ends_at)) { // user not subscribed
                return view('plan.list', array('plans' => Plan::orderBy('cost', 'asc')->get()));
            }
        }
        return redirect()->route('index');
    }
    
    public function show(Plan $plan)
    {
        return view('plan.show', array('plan' => $plan));
    }

    public function token(Request $request)
    {
        $user = $request->user();
        if (isset($user->braintree_id)) {
            $token = $this->gateway->clientToken()->generate([
                "customerId" => $user->braintree_id
            ]);
        } else {
            $token = $this->gateway->clientToken()->generate();
        }
        return response()->json([
            'token' => $token
        ]);
    }

    public function payment(Request $request)
    {
        $user = $request->user();
        $plan = Plan::find($request->input('plan'));
        if (!isset($user->braintree_id)) {
            $cust = $this->gateway->customer()->create([
                'firstName' => $user->first_name,
                'lastName' => $user->last_name,
                'email' => $user->email,
            ]);
            if ($cust->success) {
                $cust = $cust->customer->id;
                $user->braintree_id = $cust;
                $user->save();
            } else {
                // error
            }
        } else {
            $cust = $user->braintree_id;
        }
        $arr = [
            'amount' => $plan->cost,
            'paymentMethodNonce' => $request->input('payment_method_nonce'),
            'customerId' => $cust,
            'options' => [
              'submitForSettlement' => true,
              'storeInVaultOnSuccess' => true
            ]
        ];
        $sale = $this->gateway->transaction()->sale($arr);
        if ($sale->success) {
            $sub = new Subscription();
            $sub->user_id = $user->id;
            $sub->plan_id = $plan->id;
            $sub->braintree_id = $sale->transaction->id;
            $str = "+$plan->duration ";
            $str .= $plan->duration > 1 ? "months" : "month";
            $sub->ends_at = date('Y-m-d H:i:s', strtotime($str)); 
            $sub->save();
        }
        return redirect()->route('index');
    }
}
