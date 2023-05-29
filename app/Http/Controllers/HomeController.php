<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VerifyToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       $user = User::where('email', Auth::user()->email)->first();
       if($user->is_activated == 1){
             return view('home');
       }else{
            return redirect()->route('verify.account');
       }

    }
    public function verifyAccount(){
        return view('verification');
    }
    public function verifyOtp(Request $request){
        $token = $request->token;
        $verified_token = VerifyToken::where('token', $token)->first();
        if($verified_token){
            $verified_token->is_activated = 1;
            $verified_token->save();
            $user = User::where('email', $verified_token->email)->first();
            $user->is_activated = 1;
            $user->save();
            $get_token = VerifyToken::where('token', $verified_token->token)->first();
            $get_token->delete();
            return redirect()->route('home');
        }else{
            return redirect()->back()->with('error', 'Your OTP does not match');
        }
    }

}
