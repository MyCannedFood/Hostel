<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->decimal('discount_value', 15, 2);
            $table->enum('discount_type', ['percentage', 'flat']);
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('quota')->default(0);
            $table->integer('used_count')->default(0);
            $table->enum('status', ['active', 'non-active'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promo_codes');
    }
};