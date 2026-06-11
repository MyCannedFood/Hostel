<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('experiences', function (Blueprint $table) {
            $table->string('name_en')->nullable()->after('name');
            $table->string('name_id')->nullable()->after('name_en');
            $table->text('short_description_en')->nullable()->after('short_description');
            $table->text('short_description_id')->nullable()->after('short_description_en');
        });
    }

    public function down(): void
    {
        Schema::table('experiences', function (Blueprint $table) {
            $table->dropColumn(['name_en', 'name_id', 'short_description_en', 'short_description_id']);
        });
    }
};
