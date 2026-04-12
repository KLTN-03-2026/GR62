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
        Schema::table('doi_tacs', function (Blueprint $table) {
            $table->string('hinh_anh')->nullable()->after('dia_chi');
            $table->text('du_lieu_khuon_mat')->nullable()->after('hinh_anh');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doi_tacs', function (Blueprint $table) {
            $table->dropColumn(['hinh_anh', 'du_lieu_khuon_mat']);
        });
    }
};
