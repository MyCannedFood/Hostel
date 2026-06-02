<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bed_pins', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel rooms (Satu kamar punya banyak titik pin)
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            
            // Relasi ke tabel beds (Bisa kosong jika titik pin belum di-assign ke kasur)
            $table->foreignId('bed_id')->nullable()->constrained('beds')->onDelete('set null');
            
            // Label point, misalnya "Point 1", "Point 2", dll.
            $table->string('point_label')->nullable();
            
            // Koordinat posisi (Disimpan dalam bentuk persentase seperti '45%' agar responsif)
            $table->string('position_top'); 
            $table->string('position_left'); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bed_pins');
    }
};