<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transportation_infos', function (Blueprint $table) {
            $table->string('title_id')->nullable()->after('title');
            $table->string('description_id')->nullable()->after('description');
            $table->json('routes_id')->nullable()->after('routes');
        });
    }

    public function down(): void
    {
        Schema::table('transportation_infos', function (Blueprint $table) {
            $table->dropColumn(['title_id', 'description_id', 'routes_id']);
        });
    }
};