<?php

// php artisan make:migration create_payment_methods_tables

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── Payment Settings (singleton row) ──────────────────────────────
        // Pakai createIfNotExists agar tidak error jika sudah ada
        if (!Schema::hasTable('payment_settings')) {
            Schema::create('payment_settings', function (Blueprint $table) {
                $table->id();
                $table->boolean('cash_enabled')->default(true);
                $table->text('cash_instruction')->nullable();
                $table->boolean('qris_enabled')->default(false);
                $table->string('qris_merchant_id')->nullable();
                $table->string('qris_image_path')->nullable();
                $table->boolean('midtrans_enabled')->default(false);
                $table->string('midtrans_client_key')->nullable();
                $table->text('midtrans_server_key')->nullable();
                $table->boolean('midtrans_production')->default(false);
                $table->timestamps();
            });
        } else {
            // Tabel sudah ada — tambah kolom yang mungkin belum ada
            Schema::table('payment_settings', function (Blueprint $table) {
                if (!Schema::hasColumn('payment_settings', 'qris_merchant_id')) {
                    $table->string('qris_merchant_id')->nullable()->after('qris_enabled');
                }
                if (!Schema::hasColumn('payment_settings', 'qris_image_path')) {
                    $table->string('qris_image_path')->nullable()->after('qris_merchant_id');
                }
                if (!Schema::hasColumn('payment_settings', 'midtrans_production')) {
                    $table->boolean('midtrans_production')->default(false)->after('midtrans_server_key');
                }
            });
        }

        // ── Bank Accounts (manual transfer) ──────────────────────────────
        if (!Schema::hasTable('bank_accounts')) {
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

        // ── Custom Payment Methods ────────────────────────────────────────
        if (!Schema::hasTable('payment_methods')) {
            Schema::create('payment_methods', function (Blueprint $table) {
                $table->id();
                $table->string('type', 50);
                $table->string('provider_name');
                $table->string('account_number')->nullable();
                $table->string('email_username')->nullable();
                $table->boolean('is_default')->default(false);
                $table->boolean('is_active')->default(true);
                $table->integer('sort_order')->default(0);
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
        Schema::dropIfExists('bank_accounts');
        Schema::dropIfExists('payment_settings');
    }
};