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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('photo')->nullable();
            $table->string('layout_photo')->nullable(); // Tambahan untuk foto denah
            $table->enum('gender_type', ['Male', 'Female', 'Mixed']);
            $table->integer('capacity');
            $table->text('description')->nullable();
            $table->text('attributes')->nullable(); // comma-separated
            $table->text('main_facilities')->nullable(); // comma-separated
            $table->string('status')->default('Available');
            $table->boolean('is_active')->default(true);
            $table->timestamps(); // otomatis membuat created_at dan updated_at
            $table->softDeletes(); // otomatis membuat deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};