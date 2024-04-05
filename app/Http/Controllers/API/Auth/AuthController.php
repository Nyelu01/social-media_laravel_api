<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        //User::where('name', '=', 'nyelu') => Return queryset (Collection of user instances)
        //User::find(primary_key_attribute-value)  => REturns a single user for the specified pk
        //User::findorFail(primary_key_attribute-value)  => REturns a single user for the specified pk (return as error if user does not exist)

        $user = User::where('email', $request->input('email'))->first(); //For fetching all users instead of ->first() use ->get()

        if ($user && Hash::check($request->input('password'), $user->password)) {
            //Delete all user old tokens
            $user->tokens()->delete();
            //Creating new user token
            $token = $user->createToken('user_token')->accessToken;

            return response()->json(['user' => $user, 'token' => $token], 200);
        } else {
            return response()->json(['error' => 'Invalid Credentials'], 401);
        }
    }


    public function logout(string $userId)
    {
        $user = User::findOrFail($userId);
        $user->tokens()->delete();
        return response()->json(['message' => "Logged out successfully"], 200);
    }
}
