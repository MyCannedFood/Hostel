<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->enum('status', ['save', 'block'])->default('save');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->integer('age')->nullable();
            $table->string('occupation')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            
            // ID & Documents
            $table->string('id_number')->nullable();
            $table->string('profile_picture')->nullable(); // Path foto profil
            $table->string('id_card_photo')->nullable();   // Path foto KTP/Card
            
            $table->text('self_description')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};