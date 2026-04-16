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
        Schema::table('chuc_nangs', function (Blueprint $table) {
            $table->string('ten_slug')->nullable();
            $table->integer('trang_thai')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chuc_nangs', function (Blueprint $table) {
            $table->dropColumn('ten_slug');
            $table->dropColumn('trang_thai');
        });
    }
};
