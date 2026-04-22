<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Dọn dẹp dữ liệu cũ để tránh lỗi truncation
        // Biến tất cả các ID đối tác hiện có thành 1 (True), Null thành 0 (False)
        DB::table('nguoi_dungs')->whereNotNull('id_doi_tac')->update(['id_doi_tac' => 1]);
        DB::table('nguoi_dungs')->whereNull('id_doi_tac')->update(['id_doi_tac' => 0]);

        Schema::table('nguoi_dungs', function (Blueprint $table) {
            // 2. Chuyển id_doi_tac sang Boolean
            $table->boolean('id_doi_tac')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nguoi_dungs', function (Blueprint $table) {
            $table->unsignedBigInteger('id_doi_tac')->nullable()->change();
        });
    }
};
