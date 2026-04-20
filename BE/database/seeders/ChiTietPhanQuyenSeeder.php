<?php

namespace Database\Seeders;

use App\Models\ChiTietPhanQuyen;
use App\Models\ChucNang;
use Illuminate\Database\Seeder;

class ChiTietPhanQuyenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phanQuyens = [
            1 => ['DASHBOARD_VIEW', 'PHAN_QUYEN_MANAGE', 'CHUC_VU_MANAGE', 'CHUC_NANG_MANAGE', 'GOI_DICH_VU_MANAGE', 'PHONG_HOP_MANAGE'],
            2 => ['DASHBOARD_VIEW', 'NHAN_VIEN_MANAGE', 'NHAN_VIEN_CREATE', 'NHAN_VIEN_UPDATE'],
            3 => ['DASHBOARD_VIEW', 'PHONG_HOP_MANAGE', 'PHONG_HOP_CREATE', 'PHONG_HOP_UPDATE'],
            4 => ['DASHBOARD_VIEW', 'DOI_TAC_UPDATE', 'NGUOI_DUNG_UPDATE'],
            5 => ['DASHBOARD_VIEW', 'GOI_DICH_VU_MANAGE', 'GOI_CREATE', 'GOI_UPDATE'],
            6 => ['DASHBOARD_VIEW', 'GOI_DICH_VU_MANAGE', 'PHAN_QUYEN_MANAGE'],
        ];

        foreach ($phanQuyens as $idChucVu => $maChucNangs) {
            foreach ($maChucNangs as $maChucNang) {
                $chucNang = ChucNang::where('ma_chuc_nang', $maChucNang)->first();

                if (!$chucNang) {
                    continue;
                }

                ChiTietPhanQuyen::updateOrCreate(
                    [
                        'id_chuc_vu' => $idChucVu,
                        'id_chuc_nang' => $chucNang->id,
                    ],
                    []
                );
            }
        }
    }
}
