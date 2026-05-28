<?php
// FILE: database/migrations/xxxx_xx_xx_create_galleries_table.php
// AKSI : Ganti isi migration lama dengan yang ini (atau hapus lama, buat baru)
//        Pastikan jalankan: php artisan migrate:fresh  (dev) atau rollback dulu

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');

            // File yang di-upload → disimpan di storage/app/public/gallery/
            $table->string('image_path');

            $table->string('title');

            // Kategori: spaces | nature | dining | wellness | people
            $table->string('category');

            // Kolom tampil di user gallery
            $table->enum('column_placement', ['left', 'right'])->default('left');

            // Urutan dalam kolom (ascending = tampil duluan)
            $table->unsignedSmallInteger('order_number')->default(1);

            $table->enum('status', ['active', 'inactive'])->default('active');

            // Alt text untuk SEO / screen reader
            $table->text('alt_text')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};