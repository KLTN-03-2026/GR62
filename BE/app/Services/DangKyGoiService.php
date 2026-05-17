<?php

namespace App\Services;

use App\Models\DangKyGoi;
use App\Models\DoiTac;
use App\Models\Goi;
use App\Models\NguoiDung;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class DangKyGoiService
{
    public function layGoiCaNhanHieuLuc(NguoiDung $nguoiDung): Collection
    {
        return DangKyGoi::with('goi')
            ->cuaNguoiDung((int) $nguoiDung->id)
            ->conHieuLuc()
            ->latest('ngay_bat_dau')
            ->latest('id')
            ->get()
            ->pluck('goi')
            ->filter()
            ->unique('id')
            ->values();
    }

    public function layGoiDoiTacHieuLuc(DoiTac $doiTac): ?Goi
    {
        $dangKy = DangKyGoi::with('goi')
            ->cuaDoiTac((int) $doiTac->id)
            ->conHieuLuc()
            ->latest('ngay_bat_dau')
            ->latest('id')
            ->first();

        return $dangKy?->goi;
    }

    public function layGoiToChucHieuLuc(NguoiDung $nguoiDung): ?Goi
    {
        $doiTac = app(DoiTacThanhVienService::class)->layDoiTacCuaNguoiDung($nguoiDung);

        return $doiTac ? $this->layGoiDoiTacHieuLuc($doiTac) : null;
    }

    public function layGoiHieuLucChoNguoiDung(NguoiDung $nguoiDung): ?Goi
    {
        $goiToChuc = $this->layGoiToChucHieuLuc($nguoiDung);
        if ($goiToChuc) {
            return $goiToChuc;
        }

        return $this->layGoiCaNhanHieuLuc($nguoiDung)->first();
    }

    public function capNhatGoiChoNguoiDung(NguoiDung $nguoiDung, ?Goi $goi): void
    {
        DangKyGoi::cuaNguoiDung((int) $nguoiDung->id)
            ->update([
                'trang_thai' => false,
                'is_active' => false,
            ]);

        if (!$goi) {
            $this->thuHoiDoiTacNeuLaChu($nguoiDung);
            $nguoiDung->id_goi = null;
            $nguoiDung->save();
            return;
        }

        $nguoiDung->id_goi = $goi->id;

        if ($this->laGoiDoiTac($goi)) {
            $doiTac = $this->taoHoacCapNhatDoiTac($nguoiDung);

            DangKyGoi::cuaDoiTac((int) $doiTac->id)
                ->update([
                    'trang_thai' => false,
                    'is_active' => false,
                ]);

            $this->taoDangKyHieuLuc(
                $goi,
                DangKyGoi::LOAI_DOI_TAC,
                (int) $doiTac->id,
                $nguoiDung
            );

            $nguoiDung->id_doi_tac = $doiTac->id;
            $nguoiDung->save();
            return;
        }

        $this->thuHoiDoiTacNeuLaChu($nguoiDung);

        $this->taoDangKyHieuLuc(
            $goi,
            DangKyGoi::LOAI_NGUOI_DUNG,
            (int) $nguoiDung->id,
            $nguoiDung
        );

        $nguoiDung->save();
    }

    public function thuHoiDoiTacNeuLaChu(NguoiDung $nguoiDung): void
    {
        $doiTac = DoiTac::where('id_admin', $nguoiDung->id)
            ->orWhere('email', $nguoiDung->email)
            ->first();

        if (!$doiTac) {
            return;
        }

        if (!$this->doiTacDuocQuanLyBangGoi($doiTac, $nguoiDung)) {
            return;
        }

        DangKyGoi::cuaDoiTac((int) $doiTac->id)
            ->update([
                'trang_thai' => false,
                'is_active' => false,
            ]);

        if ((int) $nguoiDung->id_doi_tac === (int) $doiTac->id) {
            $nguoiDung->id_doi_tac = 0;
            $doiTac->tokens()->delete();
        }
    }

    private function doiTacDuocQuanLyBangGoi(DoiTac $doiTac, NguoiDung $nguoiDung): bool
    {
        return DangKyGoi::cuaDoiTac((int) $doiTac->id)
            ->where('purchased_by_user_id', $nguoiDung->id)
            ->exists();
    }

    public function laGoiDoiTac(Goi $goi): bool
    {
        $tenGoi = Str::lower(Str::ascii(trim($goi->ten_goi)));

        return in_array($tenGoi, ['business', 'doi tac', 'partner'], true);
    }

    private function taoHoacCapNhatDoiTac(NguoiDung $nguoiDung): DoiTac
    {
        $doiTac = DoiTac::firstOrNew(['email' => $nguoiDung->email]);
        $doiTac->fill([
            'id_admin' => $nguoiDung->id,
            'ho_va_ten' => $nguoiDung->ho_va_ten,
            'so_dien_thoai' => $nguoiDung->so_dien_thoai,
            'password' => $nguoiDung->password,
            'hinh_anh' => $nguoiDung->avatar,
            'du_lieu_khuon_mat' => $nguoiDung->du_lieu_khuon_mat,
            'trang_thai' => $nguoiDung->trang_thai,
        ]);
        $doiTac->save();
        app(DoiTacThanhVienService::class)->ganChuSoHuu($doiTac, $nguoiDung);

        return $doiTac;
    }

    private function taoDangKyHieuLuc(Goi $goi, string $subscriberType, int $subscriberId, NguoiDung $nguoiMua): DangKyGoi
    {
        $ngayBatDau = now()->toDateString();
        $ngayKetThuc = $goi->thoi_han > 0
            ? now()->addDays((int) $goi->thoi_han)->toDateString()
            : null;

        return DangKyGoi::updateOrCreate(
            [
                'subscriber_type' => $subscriberType,
                'subscriber_id' => $subscriberId,
                'id_goi' => $goi->id,
            ],
            [
                'purchased_by_user_id' => $nguoiMua->id,
                'ngay_bat_dau' => $ngayBatDau,
                'ngay_ket_thuc' => $ngayKetThuc,
                'trang_thai' => true,
                'is_active' => true,
            ]
        );
    }
}
