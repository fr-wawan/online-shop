<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice');
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('phone');
            $table->integer('post_code');
            $table->text('address');
            $table->string('states');
            $table->string('city');
            $table->enum('payment_method', ['cod', 'midtrans']);
            $table->unsignedInteger('customer_id');
            $table->bigInteger('total');
            $table->timestamp("order_placed_at")->useCurrent();
            $table->string('snap_token')->nullable();
            $table->text('user_notes')->nullable();
            $table->enum('status', ['pending', 'success', 'expired', 'failed']);
            $table->enum('payment_status', ['pending', 'success', 'failed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
