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
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('price');  // dalam Rupiah, hindari float
            $table->enum('condition', ['New', 'Like New', 'Good', 'Well Used']);
            $table->string('category');
            $table->enum('status', ['Available', 'Reserved', 'Sold'])->default('Available');
            $table->json('image_urls')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
