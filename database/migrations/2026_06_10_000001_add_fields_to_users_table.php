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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'student'])->default('student')->after('password');
            $table->boolean('is_verified')->default(false)->after('role');
            $table->string('no_kampus', 50)->nullable()->after('is_verified'); // NIM atau ID Kampus
            $table->string('verification_token')->nullable()->after('no_kampus');
            $table->timestamp('token_expired_at')->nullable()->after('verification_token');
            $table->timestamp('last_login_at')->nullable()->after('token_expired_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'is_verified',
                'no_kampus',
                'verification_token',
                'token_expired_at',
                'last_login_at',
            ]);
        });
    }
};
