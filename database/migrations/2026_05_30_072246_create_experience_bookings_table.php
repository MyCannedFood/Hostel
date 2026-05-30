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
        Schema::create('experience_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('experience_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('ticket_id')->unique();
            $table->string('guest_name');
            $table->string('guest_email')->nullable();
            $table->string('guest_whatsapp')->nullable();
            $table->date('scheduled_date');
            $table->string('time_slot');
            $table->integer('guest_count')->default(1);
            $table->text('special_notes')->nullable();
            $table->decimal('total_amount', 15, 2);
            $table->string('payment_method')->default('Cash');
            $table->enum('payment_status', ['Unpaid', 'Paid'])->default('Unpaid');
            $table->enum('status', ['Awaiting', 'Checked In', 'Cancelled'])->default('Awaiting');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experience_bookings');
    }
};
