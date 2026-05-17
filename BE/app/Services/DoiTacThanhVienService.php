<?php

namespace App\Services;

use App\Models\DoiTac;
use App\Models\DoiTacThanhVien;
use App\Models\NguoiDung;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DoiTacThanhVienService
{
    public function ganChuSoHuu(DoiTac $doiTac, NguoiDung $nguoiDung): DoiTacThanhVien
    {
        $thanhVien = DoiTacThanhVien::updateOrCreate(
            [
                'doi_tac_id' => $doiTac->id,
                'nguoi_dung_id' => $nguoiDung->id,
            ],
            [
                'vai_tro' => DoiTacThanhVien::VAI_TRO_OWNER,
                'trang_thai' => DoiTacThanhVien::TRANG_THAI_ACTIVE,
                'joined_at' => now(),
                'left_at' => null,
            ]
        );

        $this->capNhatCacheIdDoiTac($nguoiDung, (int) $doiTac->id);

        return $thanhVien;
    }

    public function capQuyenThanhVien(DoiTac $doiTac, NguoiDung $nguoiDung): DoiTacThanhVien
    {
        $thanhVien = DoiTacThanhVien::updateOrCreate(
            [
                'doi_tac_id' => $doiTac->id,
                'nguoi_dung_id' => $nguoiDung->id,
            ],
            [
                'vai_tro' => DoiTacThanhVien::VAI_TRO_MEMBER,
                'trang_thai' => DoiTacThanhVien::TRANG_THAI_ACTIVE,
                'joined_at' => now(),
                'left_at' => null,
            ]
        );

        $this->capNhatCacheIdDoiTac($nguoiDung, (int) $doiTac->id);

        return $thanhVien;
    }

    public function thuHoiThanhVien(DoiTac $doiTac, NguoiDung $nguoiDung): void
    {
        DoiTacThanhVien::where('doi_tac_id', $doiTac->id)
            ->where('nguoi_dung_id', $nguoiDung->id)
            ->where('vai_tro', DoiTacThanhVien::VAI_TRO_MEMBER)
            ->update([
                'trang_thai' => DoiTacThanhVien::TRANG_THAI_REMOVED,
                'left_at' => now(),
            ]);

        if ((int) $nguoiDung->id_doi_tac === (int) $doiTac->id) {
            $this->capNhatCacheIdDoiTac($nguoiDung, 0);
        }
    }

    public function layThanhVienHienTai(NguoiDung $nguoiDung): ?DoiTacThanhVien
    {
        $thanhVien = DoiTacThanhVien::with('doiTac')
            ->active()
            ->where('nguoi_dung_id', $nguoiDung->id)
            ->latest('id')
            ->first();

        if ($thanhVien) {
            return $thanhVien;
        }

        $doiTacId = (int) ($nguoiDung->id_doi_tac ?? 0);
        if ($doiTacId <= 0) {
            return null;
        }

        $doiTac = DoiTac::find($doiTacId);
        if (!$doiTac) {
            return null;
        }

        $vaiTro = (int) $doiTac->id_admin === (int) $nguoiDung->id
            ? DoiTacThanhVien::VAI_TRO_OWNER
            : DoiTacThanhVien::VAI_TRO_MEMBER;

        return $vaiTro === DoiTacThanhVien::VAI_TRO_OWNER
            ? $this->ganChuSoHuu($doiTac, $nguoiDung)->load('doiTac')
            : $this->capQuyenThanhVien($doiTac, $nguoiDung)->load('doiTac');
    }

    public function layDoiTacCuaNguoiDung(NguoiDung $nguoiDung): ?DoiTac
    {
        return $this->layThanhVienHienTai($nguoiDung)?->doiTac;
    }

    public function laThanhVien(DoiTac $doiTac, NguoiDung $nguoiDung, ?string $vaiTro = null): bool
    {
        $query = DoiTacThanhVien::active()
            ->where('doi_tac_id', $doiTac->id)
            ->where('nguoi_dung_id', $nguoiDung->id);

        if ($vaiTro) {
            $query->where('vai_tro', $vaiTro);
        }

        if ($query->exists()) {
            return true;
        }

        if ((int) $nguoiDung->id_doi_tac !== (int) $doiTac->id) {
            return false;
        }

        if ($vaiTro === DoiTacThanhVien::VAI_TRO_OWNER) {
            return (int) $doiTac->id_admin === (int) $nguoiDung->id;
        }

        if ($vaiTro === DoiTacThanhVien::VAI_TRO_MEMBER) {
            return (int) $doiTac->id_admin !== (int) $nguoiDung->id;
        }

        return true;
    }

    public function layIdsNguoiDungCuaDoiTac(DoiTac $doiTac, bool $baoGomChu = true): Collection
    {
        $ids = DoiTacThanhVien::active()
            ->where('doi_tac_id', $doiTac->id)
            ->when(!$baoGomChu, fn ($query) => $query->where('vai_tro', '!=', DoiTacThanhVien::VAI_TRO_OWNER))
            ->pluck('nguoi_dung_id');

        $legacyIds = NguoiDung::whereRaw('CAST(id_doi_tac AS UNSIGNED) = ?', [(int) $doiTac->id])
            ->pluck('id');

        $ownerId = $doiTac->id_admin ?: ($doiTac->email ? NguoiDung::where('email', $doiTac->email)->value('id') : null);

        return collect($baoGomChu ? [$ownerId] : [])
            ->merge($ids)
            ->merge($legacyIds)
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->when(!$baoGomChu && $ownerId, fn ($collection) => $collection->reject(fn ($id) => (int) $id === (int) $ownerId))
            ->unique()
            ->values();
    }

    public function coThanhVienActiveKhac(DoiTac $doiTac, NguoiDung $nguoiDung): bool
    {
        return DoiTacThanhVien::active()
            ->where('nguoi_dung_id', $nguoiDung->id)
            ->where('doi_tac_id', '!=', $doiTac->id)
            ->exists();
    }

    private function capNhatCacheIdDoiTac(NguoiDung $nguoiDung, int $doiTacId): void
    {
        DB::table('nguoi_dungs')
            ->where('id', $nguoiDung->id)
            ->update(['id_doi_tac' => $doiTacId]);

        $nguoiDung->id_doi_tac = $doiTacId;
    }
}
