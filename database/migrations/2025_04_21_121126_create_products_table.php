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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id')->primary();
            $table->string('product_name')->nullable();
            $table->string('product_description')->nullable();
            $table->integer('price')->default(0);
            $table->integer('stock')->default(0);
            $table->enum('gender', ['male','female', 'unisex'])->default('unisex');
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->unsignedBigInteger('category_id')->required();

            $table->foreign('category_id')->references('category_id')->on('category')->onDelete('cascade');
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};
