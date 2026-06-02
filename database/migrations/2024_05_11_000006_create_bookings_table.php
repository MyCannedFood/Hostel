<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            
            // Kode Booking (Contoh: BK-2025-1042)
            $table->string('booking_code')->unique();
            
            // Relasi
            // guests table dibuat pada migration yang lebih baru, jadi kolom ini disimpan tanpa FK agar fresh migrate tidak gagal.
            $table->foreignId('guest_id');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->foreignId('bed_id')->nullable()->constrained('beds')->onDelete('set null');
            
            // Stay Dates
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->integer('total_nights')->default(1);
            
            // Notes & Requests
            $table->text('personal_notes')->nullable();
            $table->text('special_requests')->nullable();
            
            // Transportation (Arrival & Departure)
            $table->string('arrival_time')->nullable();
            $table->string('arrival_location')->nullable();
            $table->string('departure_time')->nullable();
            $table->string('departure_location')->nullable();
            
            // Payment & Policies
            $table->decimal('total_price', 15, 2)->default(0);
            $table->string('payment_method')->nullable(); // QRIS, E-Wallet, Bank Transfer, Credit/Debit Card
            $table->boolean('policy_accepted')->default(false);
            
            // Status (Pending, Confirmed, Cancelled, Completed)
            $table->enum('status', ['PENDING', 'CONFIRMED', 'CANCELLED', 'COMPLETED'])->default('PENDING');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};