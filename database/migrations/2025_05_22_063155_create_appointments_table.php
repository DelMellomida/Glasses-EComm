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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // who booked
            $table->unsignedBigInteger('product_id')->nullable(); // optional, if related to a product
            $table->string('type'); // e.g., eye exam, fitting
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->unsignedBigInteger('branch_id');
            $table->timestamps();

            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
