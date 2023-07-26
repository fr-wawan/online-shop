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
    Schema::create('customers', function (Blueprint $table) {
      $table->id();
      $table->string('first_name');
      $table->string('last_name');
      $table->string('phone')->nullable();
      $table->integer('post_code')->nullable();
      $table->text('address')->nullable();
      $table->string('country')->nullable();
      $table->string('states')->nullable();
      $table->string('city')->nullable();
      $table->string('email')->unique();
      $table->string('password');
      $table->string('avatar')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('customers');
  }
};
