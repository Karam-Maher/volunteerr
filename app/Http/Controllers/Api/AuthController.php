<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatore = Validator($request->all(), [
            'name' => 'required|string|min:3|max:30',
            'email' => 'required|email|max:100|unique:users,email,',
            'password' => 'required|string|min:3|max:30|confirmed',
        ]);
        if ($validatore->fails()) {
            return response()->json([
                'message' => $validatore->errors()->first()
            ], 401);
        }

        $user = User::create(array_merge(
            $validatore->validate(),
            ['password' => bcrypt($request->password),]
        ));
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->plainTextToken;
        return response()->json([
            'message' => 'User successfully register',
            'token' => $token,
            'user' => $user
        ]);
    }
    public function login(Request $request)
    {
        $this->validate($request,[
            'email' =>'required|email',
            'password' => 'required'
        ]);
        if(!auth()->attempt($request->only('email','password'))){
            throw new AuthenticationException();
        }
        $user =  $request->user();
        $token = auth()->user()->createToken('Per')->plainTextToken;
        return [
            'token' =>  $token,
            'user' => $user
        ];
    }

    public function profile()
    {
        return response()->json(auth()->user());
    }
}
