<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('general_ledger', function (Blueprint $table) {
            $table->id();
            $table->string('trans_code')->unique(); // TR-XXXX
            $table->foreignId('lpj_report_id')->nullable()->constrained('lpj_reports')->nullOnDelete();
            $table->string('description');
            $table->string('category');
            $table->enum('type', ['In', 'Out']);
            $table->unsignedBigInteger('amount');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('general_ledger');
    }
};
