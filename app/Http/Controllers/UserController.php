<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{
    //

    public function registration(Request $request)
    {
        $validation=Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        //'c_password' => 'required|same: password',

        if($validation->fails())
        {
            return response()->json($validation->errors(),202);
        }

        $all_data=$request->all();
        $all_data['password']=bcrypt($all_data['password']);

        $user=User::create($all_data);

        $token_array=[];

        $token_array['token']=$user->createToken('lv-Api-oAuth')->accessToken;
        $token_array['name']=$user->name;
        $token_array['expired']=$user->createToken('lv-Api-oAuth')->token->expires_at->toDateTimeString();//diffInSeconds(Carbon::now());

        return response()->json($token_array,200);
    }

    public function login(Request $request)
    {
        if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password]))
        {
            $user=Auth::user();

            $token_array=[];
            $tokens=$user->createToken('lv-Api-oAuth');
            //$token_array['token']=$user->createToken('lv-Api-oAuth')->accessToken;
            $token_array['token']=$tokens->accessToken;
            $token_array['name']=$user->name;
            $token_array['right_now']=now()->toDateTimeString();
            $token_array['expired']=$tokens->token->expires_at->toDateTimeString();//->diffInSeconds(now());
            
            return response()->json($token_array,200);
        }   
        else
        {
            return response()->json(['msg'=>'Unauthorized Access Attempt...'],203);   
        }
    }

    public function logout(Request $request)
    {
        $token=$request->user()->token();
        $token->revoke();
        $response=["msg"=>"Successfully logged out | :) "];

        return response($response,200);
    }
}
