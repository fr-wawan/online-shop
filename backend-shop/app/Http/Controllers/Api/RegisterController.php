<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:customers',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:customers',
            'password' => 'required|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $customer = Customer::create([
            'username'  => $request->username,
            'first_name'  => $request->first_name,
            'last_name'  => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Register Berhasil',
            'data' => $customer,
            'token' => $customer->createToken('authToken')->accessToken
        ], 201);
    }
}
