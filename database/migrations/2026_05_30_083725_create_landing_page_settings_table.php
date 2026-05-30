<?php
// FILE: database/migrations/xxxx_create_landing_page_settings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('landing_page_settings', function (Blueprint $table) {
            $table->id();

            // Satu baris per section: 'hero' | 'philosophy' | 'flora' | 'map' | 'guest_stories'
            $table->string('section')->unique();

            // Semua field section disimpan sebagai JSON
            // Contoh hero: {"headline":"...","subheadline":"...","bg_image":"landing/hero/xxx.jpg"}
            $table->json('data')->nullable();

            $table->foreignId('updated_by')
                  ->nullable()
                  ->constrained('admins')
                  ->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_page_settings');
    }
};