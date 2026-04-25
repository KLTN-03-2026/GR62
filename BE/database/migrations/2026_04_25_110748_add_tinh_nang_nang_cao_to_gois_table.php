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
        Schema::table('gois', function (Blueprint $table) {
            $table->json('tinh_nang_nang_cao')->nullable()->after('mo_ta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gois', function (Blueprint $table) {
            $table->dropColumn('tinh_nang_nang_cao');
        });
    }
};
