<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->has('role') ? $request->role : 0
        ]);

//        $user[] = ['access_token' => $token, 'token_type' => 'Bearer'];

        return $this->sendResponse($user , 'Registered successfully');
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password', 'password')))
        {
            return $this->sendError('Unauthorized', [], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        if((int)$user->role === 1){
            $abilities = ['admin'];
        }else{
            $abilities = ['customer'];
        }

        $token = $user->createToken('auth_token', $abilities)->plainTextToken;

        return $this->sendResponse(['access_token' => $token, 'token_type' => 'Bearer'], "Hi {$user->name}, Welcome to DCT support center!");
    }

    // method for user logout and delete token
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return $this->sendResponse([], 'You have successfully logged out and the token was successfully deleted');
    }
}
