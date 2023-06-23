<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer || !Hash::check($request->password, $customer->password)) {
            return response()->json([
                'success' => true,
                'message' => 'Login Failed'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login Berhasil',
            'data' => $customer,
            'token' => $customer->createToken('authToken')->accessToken
        ], 200);
    }

    public function logout(Request $request)
    {
        $removeToken = $request->user()->tokens()->delete();

        if ($removeToken) {
            return response()->json([
                'success' => true,
                'message' => 'Logout Berhasil'
            ]);
        }
    }
}
