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
        Schema::table('bookings', function (Blueprint $table) {
            $table->integer('checkout_status')->default(0)->after('actual_check_in');
            $table->timestamp('actual_check_out')->nullable()->after('checkout_status');
            $table->json('extra_charges')->nullable()->after('actual_check_out');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['checkout_status', 'actual_check_out', 'extra_charges']);
        });
    }
};
