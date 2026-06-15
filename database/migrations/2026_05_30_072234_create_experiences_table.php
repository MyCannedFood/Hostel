<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_en')->nullable();
            $table->string('name_id')->nullable();
            $table->text('short_description_en')->nullable();
            $table->text('short_description_id')->nullable();
            $table->string('category');
            $table->decimal('price', 15, 2);
            $table->json('inclusions')->nullable();
            $table->json('time_slots')->nullable();
            $table->string('cover_image')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};