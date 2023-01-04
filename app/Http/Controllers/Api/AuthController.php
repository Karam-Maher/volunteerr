<?php

namespace App\Http\Controllers\Api;


use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;
            $success['email'] =  $user->email;
            $success['active'] =  $user->active = 'active';
            return  response()->json([
                 'message' => 'User login successfully.',
                 'user' => $success
            ]);
        }
        else{
            return  response()->json([
                'message' => 'Unauthorised',
            ]);

        }
        // $user = User::where('email', $request->email )->first();
        // if(!$user||!Hash::check($request->password, $user->password)) {
        //     return  response()->json([
        //         'message' => ['These credentials do not match our records']
        //     ], 404);
        // }

        // $token = $user->createToken('my-app-token')->plainTextToken;
        // $response =[
        //     'user' => $user,
        //     'token' => $token
        // ];
        // return response($response,201);
    }

    public function profile()
    {
        return response()->json(auth()->user());
    }
}
