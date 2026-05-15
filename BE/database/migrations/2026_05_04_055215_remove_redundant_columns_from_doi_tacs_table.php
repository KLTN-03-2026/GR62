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
            $table->dropColumn([
                'ho_va_ten',
                'so_dien_thoai',
                'email',
                'password',
                'dia_chi',
                'trang_thai',
                'hinh_anh',
                'du_lieu_khuon_mat'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doi_tacs', function (Blueprint $table) {
            $table->string('ho_va_ten')->nullable();
            $table->string('so_dien_thoai')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->text('dia_chi')->nullable();
            $table->boolean('trang_thai')->default(true);
            $table->string('hinh_anh')->nullable();
            $table->text('du_lieu_khuon_mat')->nullable();
        });
    }
};
