<?php

namespace App\Http\Controllers\API\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserRegistrationRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(UserRegistrationRequest $request)
    {
        try {
            DB::beginTransaction();
            //Etracting validated user detail from custom request
            $data = $request->validated();

            //Creating user to db using instance of User
            // $user = new User();
            // $user->name = $data['name'];
            // $user->mobile = $data['mobile'];
            // $user->email = $data['email'];
            // $user->password = Hash::make($data['password']);
            // $user->save();

            //Creating user using static method
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);

            //Generate t$oken for the user created
            $token = $user->createToken('user_token')->accessToken;
            DB::commit();
            return response()->json(['message' => "Account created successfully", "user" => $user, 'token' => $token], 201);
        } catch (Exception $error) {
            DB::rollBack();
            return response()->json([
                'error' => "something went wrong in UserController.register",
                'message' => $error->getMessage()
            ], 500);
        }
    }
}
