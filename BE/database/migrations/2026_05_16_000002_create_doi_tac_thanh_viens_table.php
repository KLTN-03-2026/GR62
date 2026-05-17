<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('doi_tac_thanh_viens')) {
            Schema::create('doi_tac_thanh_viens', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('doi_tac_id');
                $table->unsignedBigInteger('nguoi_dung_id');
                $table->string('vai_tro', 30)->default('member');
                $table->string('trang_thai', 30)->default('active');
                $table->timestamp('joined_at')->nullable();
                $table->timestamp('left_at')->nullable();
                $table->timestamps();

                $table->unique(['doi_tac_id', 'nguoi_dung_id'], 'doi_tac_thanh_vien_unique');
            });
        }

        $this->backfillOwners();
        $this->backfillMembers();
    }

    public function down(): void
    {
        Schema::dropIfExists('doi_tac_thanh_viens');
    }

    private function backfillOwners(): void
    {
        if (!Schema::hasTable('doi_tacs') || !Schema::hasTable('nguoi_dungs')) {
            return;
        }

        $doiTacs = DB::table('doi_tacs')
            ->whereNotNull('id_admin')
            ->select('id', 'id_admin')
            ->get();

        foreach ($doiTacs as $doiTac) {
            if (!$doiTac->id_admin) {
                continue;
            }

            DB::table('doi_tac_thanh_viens')->updateOrInsert(
                [
                    'doi_tac_id' => $doiTac->id,
                    'nguoi_dung_id' => $doiTac->id_admin,
                ],
                [
                    'vai_tro' => 'owner',
                    'trang_thai' => 'active',
                    'joined_at' => now(),
                    'left_at' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    private function backfillMembers(): void
    {
        if (!Schema::hasTable('nguoi_dungs') || !Schema::hasColumn('nguoi_dungs', 'id_doi_tac')) {
            return;
        }

        $members = DB::table('nguoi_dungs')
            ->whereNotNull('id_doi_tac')
            ->where('id_doi_tac', '>', 0)
            ->select('id', 'id_doi_tac')
            ->get();

        foreach ($members as $member) {
            $doiTacId = (int) $member->id_doi_tac;
            $nguoiDungId = (int) $member->id;

            if ($doiTacId <= 0 || $nguoiDungId <= 0) {
                continue;
            }

            $isOwner = DB::table('doi_tacs')
                ->where('id', $doiTacId)
                ->where('id_admin', $nguoiDungId)
                ->exists();

            DB::table('doi_tac_thanh_viens')->updateOrInsert(
                [
                    'doi_tac_id' => $doiTacId,
                    'nguoi_dung_id' => $nguoiDungId,
                ],
                [
                    'vai_tro' => $isOwner ? 'owner' : 'member',
                    'trang_thai' => 'active',
                    'joined_at' => now(),
                    'left_at' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
};
