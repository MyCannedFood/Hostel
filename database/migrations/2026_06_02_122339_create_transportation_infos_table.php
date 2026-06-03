<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transportation_infos', function (Blueprint $table) {
            $table->id();
            $table->string('icon');          // car, motorcycle, bus, etc.
            $table->string('title');
            $table->string('description')->nullable();
            $table->json('routes')->nullable(); // array of route strings
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transportation_infos');
    }
};