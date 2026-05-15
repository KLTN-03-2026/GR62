<?php

namespace App\Console\Commands;

use App\Models\HoaDon;
use App\Models\NguoiDung;
use App\Models\Goi;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KiemTraGoiHetHan extends Command
{
    /**
     * Tên lệnh artisan
     */
    protected $signature = 'goi:kiem-tra-het-han';

    /**
     * Mô tả lệnh
     */
    protected $description = 'Kiểm tra và thu hồi quyền Đối tác của những user đã hết hạn gói Business';

    public function handle(): int
    {
        $this->info('[' . now() . '] Bắt đầu kiểm tra gói hết hạn...');

        // Lấy tất cả user đang có quyền Đối tác (id_doi_tac khác null/0)
        $danh_sach_doi_tac = NguoiDung::whereNotNull('id_doi_tac')
            ->where('id_doi_tac', '>', 0)
            ->get();

        $so_luong_thu_hoi = 0;

        foreach ($danh_sach_doi_tac as $user) {
            // Lấy hóa đơn gói Business thanh toán thành công gần nhất của user
            $hoa_don_moi_nhat = HoaDon::where('id_nguoi_dung', $user->id)
                ->where('trang_thai_thanh_toan', 'completed')
                ->latest('created_at')
                ->first();

            // Nếu không có hóa đơn hợp lệ nào -> thu hồi quyền ngay
            if (!$hoa_don_moi_nhat) {
                $this->warn("  User #{$user->id} ({$user->email}): Không có hóa đơn hợp lệ -> Thu hồi quyền.");
                $this->thuHoiQuyenDoiTac($user);
                $so_luong_thu_hoi++;
                continue;
            }

            // Lấy thông tin gói để biết thời hạn (số ngày)
            $goi = Goi::find($hoa_don_moi_nhat->id_goi);

            // Nếu gói không có thời hạn (thoi_han = 0) -> bỏ qua (gói vĩnh viễn)
            if (!$goi || $goi->thoi_han <= 0) {
                continue;
            }

            // Tính ngày hết hạn = ngày thanh toán + số ngày gói
            $ngay_het_han = Carbon::parse($hoa_don_moi_nhat->created_at)
                ->addDays($goi->thoi_han);

            if (Carbon::now()->greaterThan($ngay_het_han)) {
                // Gói đã hết hạn -> thu hồi quyền
                $this->warn("  User #{$user->id} ({$user->email}): Gói hết hạn {$ngay_het_han->toDateString()} -> Thu hồi quyền.");
                $this->thuHoiQuyenDoiTac($user);
                $so_luong_thu_hoi++;
            } else {
                $con_lai = Carbon::now()->diffInDays($ngay_het_han);
                $this->line("  User #{$user->id} ({$user->email}): Còn hạn {$con_lai} ngày (hết {$ngay_het_han->toDateString()}).");
            }
        }

        $this->info("Hoàn thành. Đã thu hồi quyền: {$so_luong_thu_hoi} tài khoản.");
        Log::info("KiemTraGoiHetHan: Thu hồi {$so_luong_thu_hoi} tài khoản hết hạn gói Business.");

        return Command::SUCCESS;
    }

    /**
     * Thu hồi quyền Đối tác: đặt id_doi_tac về 0 (không dùng NULL vì cột NOT NULL)
     */
    private function thuHoiQuyenDoiTac(NguoiDung $user): void
    {
        DB::table('nguoi_dungs')
            ->where('id', $user->id)
            ->update(['id_doi_tac' => 0]);
    }
}
