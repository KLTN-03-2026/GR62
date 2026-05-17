<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('chi_tiet_gois') && !Schema::hasTable('dang_ky_gois')) {
            Schema::rename('chi_tiet_gois', 'dang_ky_gois');
        }

        if (!Schema::hasTable('dang_ky_gois')) {
            Schema::create('dang_ky_gois', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_goi');
                $table->string('subscriber_type', 30)->nullable();
                $table->unsignedBigInteger('subscriber_id')->nullable();
                $table->unsignedBigInteger('id_nguoi_dung')->nullable();
                $table->unsignedBigInteger('id_doi_tac')->nullable();
                $table->unsignedBigInteger('purchased_by_user_id')->nullable();
                $table->date('ngay_bat_dau')->nullable();
                $table->date('ngay_ket_thuc')->nullable();
                $table->boolean('trang_thai')->default(true);
                $table->boolean('is_active')->default(true);
                $table->boolean('is_nguoi_dung')->default(true);
                $table->timestamps();
            });
        }

        $this->addColumnIfMissing('subscriber_type', function (Blueprint $table) {
            $table->string('subscriber_type', 30)->nullable();
        });

        $this->addColumnIfMissing('subscriber_id', function (Blueprint $table) {
            $table->unsignedBigInteger('subscriber_id')->nullable();
        });

        $this->addColumnIfMissing('purchased_by_user_id', function (Blueprint $table) {
            $table->unsignedBigInteger('purchased_by_user_id')->nullable();
        });

        $this->backfillSubscriberColumns();
        $this->backfillFromNguoiDungCache();
    }

    public function down(): void
    {
        if (Schema::hasTable('dang_ky_gois') && !Schema::hasTable('chi_tiet_gois')) {
            Schema::rename('dang_ky_gois', 'chi_tiet_gois');
        }
    }

    private function addColumnIfMissing(string $column, callable $callback): void
    {
        if (!Schema::hasColumn('dang_ky_gois', $column)) {
            Schema::table('dang_ky_gois', $callback);
        }
    }

    private function backfillSubscriberColumns(): void
    {
        if (
            !Schema::hasColumn('dang_ky_gois', 'subscriber_type') ||
            !Schema::hasColumn('dang_ky_gois', 'subscriber_id')
        ) {
            return;
        }

        $rows = DB::table('dang_ky_gois')->orderBy('id')->get();

        foreach ($rows as $row) {
            $subscriberType = $row->subscriber_type;
            $subscriberId = $row->subscriber_id;
            $isNguoiDung = (bool) ($row->is_nguoi_dung ?? true);

            if (!$subscriberType || !$subscriberId) {
                if ($isNguoiDung && !empty($row->id_nguoi_dung)) {
                    $subscriberType = 'nguoi_dung';
                    $subscriberId = (int) $row->id_nguoi_dung;
                } elseif (!empty($row->id_doi_tac)) {
                    $subscriberType = 'doi_tac';
                    $subscriberId = (int) $row->id_doi_tac;
                }
            }

            if (!$subscriberType || !$subscriberId) {
                continue;
            }

            $updates = [
                'subscriber_type' => $subscriberType,
                'subscriber_id' => $subscriberId,
                'is_nguoi_dung' => $subscriberType === 'nguoi_dung',
            ];

            if ($subscriberType === 'nguoi_dung') {
                $updates['id_nguoi_dung'] = $subscriberId;
                $updates['id_doi_tac'] = null;
            } else {
                $updates['id_nguoi_dung'] = null;
                $updates['id_doi_tac'] = $subscriberId;
            }

            DB::table('dang_ky_gois')->where('id', $row->id)->update($updates);
        }
    }

    private function backfillFromNguoiDungCache(): void
    {
        if (!Schema::hasTable('nguoi_dungs') || !Schema::hasColumn('nguoi_dungs', 'id_goi')) {
            return;
        }

        $users = DB::table('nguoi_dungs')
            ->leftJoin('gois', 'gois.id', '=', 'nguoi_dungs.id_goi')
            ->whereNotNull('nguoi_dungs.id_goi')
            ->select([
                'nguoi_dungs.id',
                'nguoi_dungs.id_goi',
                'nguoi_dungs.id_doi_tac',
                'gois.ten_goi',
                'gois.thoi_han',
            ])
            ->get();

        foreach ($users as $user) {
            $isPartnerPlan = $this->isPartnerPlan((string) $user->ten_goi);
            $partnerId = (int) ($user->id_doi_tac ?? 0);
            $subscriberType = $isPartnerPlan && $partnerId > 0 ? 'doi_tac' : 'nguoi_dung';
            $subscriberId = $subscriberType === 'doi_tac' ? $partnerId : (int) $user->id;

            if ($subscriberId <= 0) {
                continue;
            }

            $exists = DB::table('dang_ky_gois')
                ->where('subscriber_type', $subscriberType)
                ->where('subscriber_id', $subscriberId)
                ->where('id_goi', $user->id_goi)
                ->where('is_active', true)
                ->where('trang_thai', true)
                ->exists();

            if ($exists) {
                continue;
            }

            $ngayBatDau = now()->toDateString();
            $ngayKetThuc = ((int) $user->thoi_han > 0)
                ? now()->addDays((int) $user->thoi_han)->toDateString()
                : null;

            DB::table('dang_ky_gois')->insert([
                'id_goi' => $user->id_goi,
                'subscriber_type' => $subscriberType,
                'subscriber_id' => $subscriberId,
                'id_nguoi_dung' => $subscriberType === 'nguoi_dung' ? $subscriberId : null,
                'id_doi_tac' => $subscriberType === 'doi_tac' ? $subscriberId : null,
                'purchased_by_user_id' => (int) $user->id,
                'ngay_bat_dau' => $ngayBatDau,
                'ngay_ket_thuc' => $ngayKetThuc,
                'trang_thai' => true,
                'is_active' => true,
                'is_nguoi_dung' => $subscriberType === 'nguoi_dung',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function isPartnerPlan(string $tenGoi): bool
    {
        $normalized = Str::lower(Str::ascii(trim($tenGoi)));

        return in_array($normalized, ['business', 'doi tac', 'partner'], true);
    }
};
