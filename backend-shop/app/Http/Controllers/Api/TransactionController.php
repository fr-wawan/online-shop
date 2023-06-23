<?php

namespace App\Http\Controllers\Api;

use Midtrans\Snap;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    public function __construct()
    {
        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');
    }

    protected function storeTransaction($paymentMethod, $request)
    {
        $transaction = Transaction::create([
            'invoice' => 'TRX-' . Str::random(8),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'post_code' => $request->post_code,
            'address' => $request->address,
            'country' => $request->country,
            'city' => $request->city,
            'payment_method' => $paymentMethod,
            'customer_id' => auth()->guard('api')->user()->id,
            'total' => $request->total,
            'user_notes' => $request->user_notes,
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);

        $customer = Customer::find(auth()->guard('api')->user()->id);
        $customer->cart()->delete();
        $quantities = $request->input('quantity');
        $productIDs = $request->input('productIDs');

        foreach ($productIDs as $index => $productId) {
            $quantity = $quantities[$index];
            $transaction->product()->attach($productId, ['quantity' => $quantity]);
        }

        return $transaction;
    }

    public function paymentCod(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'post_code' => 'required|numeric',
            'address' => 'required',
            'country' => 'required',
            'city' => 'required',
            'user_notes' => 'required'
        ]);


        $transaction = $this->storeTransaction('cod', $request);

        return response()->json([
            'success' => true,
            'message' => 'Transaksi Berhasil Dibuat!',
            'data' => $transaction
        ]);
    }

    public function paymentMidtrans(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'post_code' => 'required|numeric',
            'address' => 'required',
            'country' => 'required',
            'city' => 'required',
            'user_notes' => 'required'
        ]);


        $transaction = $this->storeTransaction('midtrans', $request);

        $payload = [
            'transaction_details' => [
                'order_id' => $transaction->invoice,
                'gross_amount' => $transaction->total,
            ],
            'customer_details' => [
                'username' => auth()->guard('api')->user()->username,
                'email' => auth()->guard('api')->user()->email
            ]
        ];

        $snapToken = Snap::getSnapToken($payload);
        $transaction->snap_token = $snapToken;
        $transaction->save();


        return response()->json([
            'success' => true,
            'message' => 'Transaksi Berhasil Dibuat!',
            'data' => $transaction,
            'snap_token' => $snapToken
        ]);
    }

    public function show($invoice)
    {
        $transaction = Transaction::with('food')->where('invoice', $invoice)->first();

        if ($transaction) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Data Transaksi : ' . $transaction->invoice,
                'data' => $transaction
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => "Data Transaksi Tidak Ditemukan"
        ], 404);
    }

    public function notificationHandler(Request $request)
    {
        $payload = $request->getContent();
        $notification = json_decode($payload);

        $validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . config('services.midtrans.serverKey'));

        if ($notification->signature_key != $validSignatureKey) {
            return response(['message' => 'Invalid Signature!'], 403);
        }

        $transaction = $notification->transaction_status;
        $type = $notification->payment_type;
        $orderId = $notification->order_id;
        $fraud = $notification->fraud_status;

        $data_transaction = Transaction::where('invoice', $orderId)->first();

        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $data_transaction->update([
                        'status' => 'pending'
                    ]);
                } else {
                    $data_transaction->update([
                        'status' => 'success'
                    ]);
                }
            }
        } elseif ($transaction == 'settlement') {
            $data_transaction->update([
                'status' => 'success'
            ]);
        } elseif ($transaction == 'pending') {
            $data_transaction->update([
                'status' => 'pending'
            ]);
        } elseif ($transaction == 'deny') {
            $data_transaction->update([
                'status' => 'failed'
            ]);
        } elseif ($transaction == 'expire') {
            $data_transaction->update([
                'status' => 'expired'
            ]);
        } elseif ($transaction == 'cancel') {
            $data_transaction->update([
                'status' => 'failed'
            ]);
        }
    }
}
