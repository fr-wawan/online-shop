@extends('layouts.app',['title' => 'Transaction - Show'])

@section('content')

<div class="overflow-x-hidden overflow-y-auto bg-gray-300">
  <div class="mt-5 ">
    <div class="shadow-md rounded-lg xl:w-[1000px] mx-auto w-full mb-10 bg-white p-10 lg:w-10/12">
      <h1 class="text-xl border-b pb-3  font-semibold">User Details</h1>

      <div class="overflow-auto lg:overflow-hidden">
        <table class="border mt-5 w-full">
          <tr>
            <td class="w-52 border p-3">NO INVOICE</td>
            <td class="w-5 border text-center">:</td>
            <td class="border px-6">{{ $transaction->invoice }}</td>
          </tr>
          <tr>
            <td class="w-52 border p-3">FULL NAME</td>
            <td class="md:w-10 w-52 p-3 border text-center">:</td>
            <td class="border px-6">
              {{ $transaction->first_name }} {{ $transaction->last_name }}
            </td>
          </tr>
          <tr>
            <td class="w-52 border p-3">PHONE NUMBER</td>
            <td class="md:w-10 w-52 p-3 border text-center">:</td>
            <td class="border px-6">
              {{ $transaction->phone}}
            </td>
          </tr>
          <tr>
            <td class="w-52 border p-3">REGION</td>
            <td class="md:w-10 w-52 p-3 border text-center">:</td>
            <td class="border px-6">
              {{ $transaction->country }},
              {{ $transaction->states }},
              {{ $transaction->city }}
            </td>
          </tr>

          <tr>
            <td class="w-52 border p-3">ADDRESS</td>
            <td class="md:w-10 w-52 p-3 border text-center">:</td>
            <td class="border px-6">
              {{ $transaction->address }}
            </td>
          </tr>
          <tr>
            <td class="w-52 border p-3">DELIVERY STATUS</td>
            <td class="md:w-10 w-52 p-3 border text-center">:</td>
            <td class="border px-6">
              {{ $transaction->status }}
            </td>
          </tr>
          <tr>
            <td class="w-52 border p-3">PAYMENT STATUS</td>
            <td class="md:w-10 w-52 p-3 border text-center">:</td>
            <td class="border px-6">
              <div class="flex items-center gap-5">
                <p>{{ $transaction->payment_method }}</p>
                <span>/</span>

                <p>{{ $transaction->payment_status }}</p>
              </div>
            </td>
          </tr>

        </table>
        <h1 class="text-xl border-b pb-3 my-5  font-semibold">Update Order</h1>

        <form action="" method="post" class="">
          <select name="" id="" class="rounded">
            <option value="pending">Pending</option>
            <option value="success">Success</option>
            <option value="failed">Failed</option>
            <option value="cancelled">Cancelled</option>
          </select>


          <button class="bg-indigo-600 px-4 py-2 rounded shadow-sm text-white focus:outline-none">Update</button>
        </form>
      </div>
    </div>

  </div>

  <div>
    <div class=" shadow-md rounded-lg xl:w-[1000px] mx-auto w-full bg-white p-10 lg:w-10/12">
      <h1 class="text-xl border-b pb-3 font-semibold">Ordered Items</h1>

      @foreach ($transaction->product as $product)
      <div class="border-b pb-5">
        <div class="flex flex-col md:flex-row justify-between items-center mt-5">
          <img src="https://source.unsplash.com/1200x1000" class="rounded-lg w-20" alt="" />
          <h3 class="md:text-lg my-3 font-semibold">{{ $product->title }}</h3>

          <p class="">Quantity : {{ $product->pivot->quantity }}</p>
          <p class="flex gap-2 items-center">
            {{ moneyFormat($product->price) }}
            <span>x</span>
            {{ $product->pivot->quantity }}
          </p>

          <p class="text font-semibold text-gray-500 text-lg">
            {{ moneyFormat($product->pivot->quantity * $product->price) }}
          </p>
        </div>
      </div>
      @endforeach


      <div class="mt-7 flex flex-col md:flex-row justify-between items-center">
        <p class="font-semibold mb-5">Order Notes : {{ $transaction->user_notes }}</p>
        <h3 class="font-semibold text-xl">
          Total :{{ moneyFormat($transaction->total) }}
        </h3>
      </div>
    </div>
  </div>


</div>
@endsection
