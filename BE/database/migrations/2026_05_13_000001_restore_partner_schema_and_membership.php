<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doi_tacs', function (Blueprint $table) {
            if (!Schema::hasColumn('doi_tacs', 'ho_va_ten')) {
                $table->string('ho_va_ten')->nullable();
            }
            if (!Schema::hasColumn('doi_tacs', 'so_dien_thoai')) {
                $table->string('so_dien_thoai')->nullable();
            }
            if (!Schema::hasColumn('doi_tacs', 'email')) {
                $table->string('email')->nullable()->unique();
            }
            if (!Schema::hasColumn('doi_tacs', 'password')) {
                $table->string('password')->nullable();
            }
            if (!Schema::hasColumn('doi_tacs', 'dia_chi')) {
                $table->text('dia_chi')->nullable();
            }
            if (!Schema::hasColumn('doi_tacs', 'trang_thai')) {
                $table->boolean('trang_thai')->default(true);
            }
            if (!Schema::hasColumn('doi_tacs', 'hinh_anh')) {
                $table->string('hinh_anh')->nullable();
            }
            if (!Schema::hasColumn('doi_tacs', 'du_lieu_khuon_mat')) {
                $table->longText('du_lieu_khuon_mat')->nullable();
            }
        });

        $doiTacs = DB::table('doi_tacs')->whereNotNull('id_admin')->get();
        foreach ($doiTacs as $doiTac) {
            $owner = DB::table('nguoi_dungs')->where('id', $doiTac->id_admin)->first();

            if ($owner) {
                DB::table('doi_tacs')->where('id', $doiTac->id)->update([
                    'ho_va_ten' => $doiTac->ho_va_ten ?? $owner->ho_va_ten,
                    'so_dien_thoai' => $doiTac->so_dien_thoai ?? $owner->so_dien_thoai,
                    'email' => $doiTac->email ?? $owner->email,
                    'password' => $doiTac->password ?? $owner->password,
                    'hinh_anh' => $doiTac->hinh_anh ?? $owner->avatar,
                    'du_lieu_khuon_mat' => $doiTac->du_lieu_khuon_mat ?? $owner->du_lieu_khuon_mat,
                    'trang_thai' => $doiTac->trang_thai ?? $owner->trang_thai,
                    'updated_at' => now(),
                ]);

                DB::table('nguoi_dungs')
                    ->where('id_doi_tac', $doiTac->id_admin)
                    ->update(['id_doi_tac' => $doiTac->id]);
            }
        }

        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE nguoi_dungs MODIFY id_doi_tac BIGINT UNSIGNED NULL DEFAULT 0');
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE nguoi_dungs MODIFY id_doi_tac TINYINT(1) NOT NULL DEFAULT 0');
        }

        Schema::table('doi_tacs', function (Blueprint $table) {
            foreach ([
                'ho_va_ten',
                'so_dien_thoai',
                'email',
                'password',
                'dia_chi',
                'trang_thai',
                'hinh_anh',
                'du_lieu_khuon_mat',
            ] as $column) {
                if (Schema::hasColumn('doi_tacs', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
