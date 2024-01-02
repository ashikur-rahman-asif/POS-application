<?php

namespace App\Http\Controllers;

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
                'status' => 'failed',
                'message' => $exception->getMessage(),
            ], 500);
        }
    }
}
