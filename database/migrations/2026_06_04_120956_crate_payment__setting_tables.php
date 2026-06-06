<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── Payment Settings (Cash, QRIS, Midtrans toggles & config) ──
        Schema::create('payment_settings', function (Blueprint $table) {
            $table->id();

            // Cash
            $table->boolean('cash_enabled')->default(true);
            $table->text('cash_instruction')->nullable();

            // QRIS
            $table->boolean('qris_enabled')->default(false);
            $table->string('qris_merchant_id')->nullable();
            $table->string('qris_image_path')->nullable();   // uploaded QR image

            // Midtrans
            $table->boolean('midtrans_enabled')->default(false);
            $table->string('midtrans_client_key')->nullable();
            $table->text('midtrans_server_key')->nullable();  // encrypted at rest
            $table->boolean('midtrans_production')->default(false);

            $table->timestamps();
        });

        // ── Bank Accounts (manual transfer) ──
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name');
            $table->string('account_holder');
            $table->string('account_number');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
        Schema::dropIfExists('payment_settings');
    }
};