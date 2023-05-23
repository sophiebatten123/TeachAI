<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::get();

        return view('plans', compact('plans'));
    }
    public function show(Plan $plan, Request $request)
    {
        $intent = auth()->user()->createSetupIntent();
   
        return view("subscription", compact("plan", "intent"));
    }
    public function subscription(Request $request)
    {
        $plan = Plan::find($request->plan);
   
        $subscription = $request->user()->newSubscription($request->plan, $plan->stripe_plan)
                        ->create($request->token);
   
        return view("success");
    }
}
