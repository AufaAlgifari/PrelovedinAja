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
        // Adjust chats table
        Schema::table('chats', function (Blueprint $table) {
            // Drop foreign key constraints first
            $table->dropForeign('chats_sender_id_foreign');
            $table->dropForeign('chats_receiver_id_foreign');
            
            // Now drop index
            $table->dropIndex('chats_sender_id_receiver_id_index');
            
            // Rename columns
            $table->renameColumn('sender_id', 'buyer_id');
            $table->renameColumn('receiver_id', 'seller_id');
            
            // Drop columns
            $table->dropColumn(['message', 'is_read']);
        });

        // Add constraints back
        Schema::table('chats', function (Blueprint $table) {
            $table->foreign('buyer_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('seller_id')->references('id')->on('users')->cascadeOnDelete();
        });

        // Create messages table
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id')->constrained('chats')->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->text('pesan'); // 'pesan' matches ERD
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');

        Schema::table('chats', function (Blueprint $table) {
            $table->dropForeign(['buyer_id']);
            $table->dropForeign(['seller_id']);
            
            $table->renameColumn('buyer_id', 'sender_id');
            $table->renameColumn('seller_id', 'receiver_id');
            
            $table->text('message')->nullable();
            $table->boolean('is_read')->default(false);
        });

        Schema::table('chats', function (Blueprint $table) {
            $table->foreign('sender_id')->references('id')->on('users');
            $table->foreign('receiver_id')->references('id')->on('users');
            $table->index(['sender_id', 'receiver_id']);
        });
    }
};
