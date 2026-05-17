<?php

namespace App\Console\Commands;

use App\Models\DangKyGoi;
use App\Models\DoiTac;
use App\Models\NguoiDung;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class KiemTraGoiHetHan extends Command
{
    protected $signature = 'goi:kiem-tra-het-han';

    protected $description = 'Kiem tra va vo hieu hoa cac dang ky goi da het han';

    public function handle(): int
    {
        $this->info('[' . now() . '] Bat dau kiem tra goi het han...');

        $today = Carbon::now()->toDateString();
        $dangKyHetHan = DangKyGoi::where('is_active', true)
            ->where('trang_thai', true)
            ->whereNotNull('ngay_ket_thuc')
            ->whereDate('ngay_ket_thuc', '<', $today)
            ->get();

        $soLuongThuHoi = 0;

        foreach ($dangKyHetHan as $dangKy) {
            $dangKy->update([
                'trang_thai' => false,
                'is_active' => false,
            ]);

            if ($dangKy->subscriber_type === DangKyGoi::LOAI_DOI_TAC && $dangKy->subscriber_id) {
                $this->thuHoiQuyenDoiTac($dangKy);
                $soLuongThuHoi++;
            }

            if ($dangKy->subscriber_type === DangKyGoi::LOAI_NGUOI_DUNG && $dangKy->subscriber_id) {
                $this->dongBoCacheGoiNguoiDung((int) $dangKy->subscriber_id);
            }
        }

        $this->info("Hoan thanh. Da vo hieu hoa {$dangKyHetHan->count()} dang ky, thu hoi {$soLuongThuHoi} doi tac.");
        Log::info("KiemTraGoiHetHan: Vo hieu hoa {$dangKyHetHan->count()} dang ky, thu hoi {$soLuongThuHoi} doi tac.");

        return Command::SUCCESS;
    }

    private function thuHoiQuyenDoiTac(DangKyGoi $dangKy): void
    {
        $doiTacId = (int) $dangKy->subscriber_id;
        $doiTac = DoiTac::find($doiTacId);

        if (!$this->dangKyQuanLyQuyenDoiTac($dangKy, $doiTac)) {
            return;
        }

        if ($doiTac) {
            $doiTac->tokens()->delete();
        }

        $nguoiDungQuery = NguoiDung::where('id_doi_tac', $doiTacId);

        if ($doiTac) {
            $nguoiDungQuery->where(function ($query) use ($doiTac) {
                if ($doiTac?->id_admin) {
                    $query->where('id', $doiTac->id_admin);
                }

                if ($doiTac?->email) {
                    $query->orWhere('email', $doiTac->email);
                }
            });
        }

        $nguoiDungIds = $nguoiDungQuery->pluck('id');

        if ($nguoiDungIds->isEmpty()) {
            return;
        }

        NguoiDung::whereIn('id', $nguoiDungIds)->update(['id_doi_tac' => 0, 'id_goi' => null]);

        $nguoiDungIds->each(fn ($id) => $this->dongBoCacheGoiNguoiDung((int) $id));
    }

    private function dangKyQuanLyQuyenDoiTac(DangKyGoi $dangKy, ?DoiTac $doiTac): bool
    {
        if (!$doiTac || !$doiTac->id_admin) {
            return true;
        }

        return (int) $dangKy->purchased_by_user_id === (int) $doiTac->id_admin;
    }

    private function dongBoCacheGoiNguoiDung(int $nguoiDungId): void
    {
        if ($nguoiDungId <= 0) {
            return;
        }

        $goiId = DangKyGoi::cuaNguoiDung($nguoiDungId)
            ->conHieuLuc()
            ->latest('ngay_bat_dau')
            ->latest('id')
            ->value('id_goi');

        NguoiDung::where('id', $nguoiDungId)->update(['id_goi' => $goiId]);
    }
}
