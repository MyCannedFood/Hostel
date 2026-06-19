<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            // Deposit dari check-in
            $table->decimal('deposit_amount', 12, 2)->nullable()->after('id_card_photo');
            $table->text('deposit_notes')->nullable()->after('deposit_amount');

            // Checkout data
            $table->json('checkout_charges')->nullable()->after('check_out_date');  // array rincian charge tambahan
            $table->text('checkout_notes')->nullable()->after('checkout_charges');  // catatan admin saat checkout
            $table->integer('duration')->nullable()->after('check_out_date');       // lama menginap (malam)

            // Field tambahan yang mungkin belum ada
            $table->text('personal_notes')->nullable()->after('self_description');
        });
    }

    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropColumn([
                'deposit_amount',
                'deposit_notes',
                'checkout_charges',
                'checkout_notes',
                'duration',
                'personal_notes',
            ]);
        });
    }
};
