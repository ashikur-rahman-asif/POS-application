<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userRegistration(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'firstName' => 'required|string',
                'lastName' => 'required|string',
                'email' => 'required|email|unique:users',
                'mobile' => 'required|string',
                'password' => 'required|string',
            ]);

            $user = User::create($validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'User registration success',
                'data' => $user,
            ], 201);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'User registration failed',
                'message' => $exception->getMessage(),
            ], 500);
        }
    }

    function userLogin(Request $request)
    {
        $count = User::where('email', '=', $request->input('email'))
            ->where('password', '=', $request->input('password'))
            ->count();
           

        if ($count==0) {
            $token = JWTToken::CreateToken($request->input('email'));
            return response()->json([
                'status' => 'success',
                'message' => 'User Login Successful',
                'token'=>$token
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'test'
            ], 200);

        }

    }
}
