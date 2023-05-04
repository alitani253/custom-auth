<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use LengthException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgetPasswordManager extends Controller
{
     function forgetPassword(){

        return view("forget-password");
    }

    function forgetPasswordPost(Request $request){

        $request->validate([
            'email'=>'required|email|exists:users',
        ]);
        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email'=>$request->email,
            'token'=>$token,
            'created_at'=>Carbon::now()
        ]);
        $query = Mail::send("email.forget-password", ['token'=>$token],
                function($message) use($request){
                    $message -> to ($request->email);
                    $message -> subject("Reset password");
                });
                dd($query);
        return redirect()->to(route("forget.password"))->with("success", "we have send an email to reset password");

    }

    function resetPassword($token){
        return view("new-password", compact('token') );

    }
    function resetPasswordPost(Request $request){
        $request->validate([
            'email'=>'required|email|existes:users',
            'password'=>'required|string|min:6|confirmed',
            'password_confirmation'=>'required'
        ]);

        $updatePassword = DB::table('password_resets')
            ->where([
                "email"=>$request->email,
                "token"=>$request->token
            ])->first();

        if(!$updatePassword){

           return redirect()->to(route("reset.password"))->with("error", "Invalid");
        }

        User::where("email", $request->email)
            ->update(["password"=>Hash::make($request->password)]);

        DB::table('password_resets')->where(["email"=>$request->email])->delete();

        return redirect()->to(route("login"))->with("success", "Password reset sucsess");

    }
}
