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
            $table->foreignId('buyer_id')->constrained('users');
            $table->foreignId('product_id')->constrained('products');
            $table->unsignedBigInteger('total_amount');
            $table->string('payment_method');  // e.g. Transfer, QRIS, COD
            $table->enum('payment_status', ['Pending', 'Paid', 'Failed'])->default('Pending');
            $table->enum('transaction_status', ['Processing', 'Completed', 'Cancelled'])->default('Processing');
            $table->enum('shipping_method', ['COD', 'Courier']);
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
