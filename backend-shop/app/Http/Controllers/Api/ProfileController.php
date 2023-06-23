<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Data Profile',
            'data' => auth()->guard('api')->user(),
        ], 200);
    }

    public function update(Request $request)
    {
        $customer = Customer::whereId(auth()->guard('api')->user()->id)->first();


        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:customers,username,' . $customer->id,
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'required|numeric',
            'address' => 'required',
            'country' => 'required',
            'states' => 'required',
            'city' => 'required',
            'post_code' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $updateData = [
            'username' => $request->username,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'country' => $request->country,
            'states' => $request->states,
            'city' => $request->city,
            'post_code' => $request->post_code,
        ];

        if ($request->file('avatar')) {
            Storage::disk('local')->delete('public/customers/' . basename($customer->avatar));

            $image = $request->file('avatar');
            $image->storeAs('public/customers', $image->hashName());

            $updateData['avatar'] = $image->hashName();
        }

        $customer->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Data Profile Berhasil Diupdate',
            'data' => $customer
        ], 201);
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $customer = Customer::whereId(auth()->guard('api')->user()->id)->first();

        $customer->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password Berhasil Diupdate',
            'data' => $customer
        ], 201);
    }
}
