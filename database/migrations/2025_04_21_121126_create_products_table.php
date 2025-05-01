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

            $table->unsignedBigInteger('product_image_id')->nullable();
            $table->unsignedBigInteger('category_id')->required();

            $table->foreign('product_image_id')->references('id')->on('product_images')->onDelete('cascade');
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
