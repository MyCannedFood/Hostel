<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budget_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_request_id')->constrained('budget_requests')->cascadeOnDelete();
            $table->string('title');
            $table->unsignedBigInteger('estimated_amount')->default(0);
            $table->text('notes')->nullable();
            $table->string('invoice_path')->nullable();
            $table->string('payment_method')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budget_request_items');
    }
};
