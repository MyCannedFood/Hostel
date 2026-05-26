<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lpj_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_request_id')->constrained('budget_requests')->cascadeOnDelete();
            $table->string('request_code')->nullable();
            $table->unsignedBigInteger('total_estimated_amount')->default(0);
            $table->unsignedBigInteger('total_actual_amount')->default(0);
            $table->enum('status', ['Draft', 'Submitted', 'Approved', 'Rejected'])->default('Submitted');
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->string('invoice_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lpj_reports');
    }
};
