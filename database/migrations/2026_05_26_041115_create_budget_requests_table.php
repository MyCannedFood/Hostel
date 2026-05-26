<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budget_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_code')->unique();
            $table->string('title');
            $table->string('type'); // Operational | Maintenance
            $table->string('category');
            $table->unsignedBigInteger('estimated_total_amount')->default(0);
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->text('notes')->nullable();
            $table->string('requested_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budget_requests');
    }
};
