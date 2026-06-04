<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->nullable();
            $table->string('note')->nullable(); // Catatan ex: "(for free)"
            $table->boolean('is_auto_include')->default(false); // Apakah otomatis dicentang?
            $table->json('include_days')->nullable(); // Disimpan dalam JSON: ["Monday", "Friday"]
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addons');
    }
};