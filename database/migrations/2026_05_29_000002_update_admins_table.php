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
        Schema::table('admins', function (Blueprint $table) {
            // role_id nullable: admin tanpa role = kompatibilitas backward
            $table->foreignId('role_id')
                ->nullable()
                ->after('id')
                ->constrained('roles')
                ->onDelete('set null');

            $table->enum('status', ['active', 'inactive'])
                ->default('active')
                ->after('role_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn(['role_id', 'status']);
        });
    }
};

