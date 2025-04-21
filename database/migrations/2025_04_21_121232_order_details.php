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
            $table->id('Purchase_ID')-> primary();
            $table->integer('Order_ID')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->string('Product_ID')->nullable();
            $table->integer('Quantity')->default(0);
            $table->string('Payment_Type')->nullable();
            $table->timestamps();

            $table->index('Order_ID');
            $table->index('Product_ID');

            $table->foreign('Order_ID')->references('Order_ID')->on('orders')->onDelete('cascade');
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
