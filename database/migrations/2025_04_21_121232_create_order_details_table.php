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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id('purchase_id')-> primary();

            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id');
            
            $table->string('product_id')->reference('product_id')->on('products')->onDelete('cascade');
            $table->integer('quantity')->default(0);
            $table->string('payment_type')->nullable();
            $table->timestamps();

            $table->index('order_id');
            $table->index('product_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
