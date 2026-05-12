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
            $table->decimal('base_price', 15, 2);
            $table->string('type');
            $table->enum('gender_type', ['Male', 'Female', 'Mixed']);
            $table->integer('floor')->default(1);
            $table->integer('capacity');
            $table->text('description')->nullable();
            $table->string('status')->default('Available');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
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
