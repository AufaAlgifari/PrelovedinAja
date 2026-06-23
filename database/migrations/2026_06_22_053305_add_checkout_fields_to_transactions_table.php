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
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('buyer_id')->nullable()->after('user_id');
            $table->unsignedBigInteger('seller_id')->nullable()->after('buyer_id');
            $table->string('metode_pengiriman')->nullable()->after('snap_token');
            $table->text('alamat_pengiriman')->nullable()->after('metode_pengiriman');
            $table->string('metode_pembayaran')->nullable()->after('alamat_pengiriman');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'buyer_id',
                'seller_id',
                'metode_pengiriman',
                'alamat_pengiriman',
                'metode_pembayaran'
            ]);
        });
    }
};
