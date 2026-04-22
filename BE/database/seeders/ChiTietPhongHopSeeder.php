<?php

namespace Database\Seeders;

use App\Models\ChiTietPhongHop;
use Illuminate\Database\Seeder;

class ChiTietPhongHopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chiTietRows = [
            [
                'id_nguoi_dung' => 1,
                'id_phong_hop' => 1,
                'xac_thuc_khuon_mat' => null,
                'is_vi_pham' => false,
                'is_nguoi_dung' => true,
                'is_active' => true,
                'trang_thai' => true,
            ],
            [
                'id_nguoi_dung' => 2,
                'id_phong_hop' => 1,
                'xac_thuc_khuon_mat' => null,
                'is_vi_pham' => false,
                'is_nguoi_dung' => true,
                'is_active' => true,
                'trang_thai' => true,
            ],
            [
                'id_nguoi_dung' => 3,
                'id_phong_hop' => 2,
                'xac_thuc_khuon_mat' => null,
                'is_vi_pham' => false,
                'is_nguoi_dung' => true,
                'is_active' => true,
                'trang_thai' => true,
            ],
            [
                'id_nguoi_dung' => 4,
                'id_phong_hop' => 3,
                'xac_thuc_khuon_mat' => null,
                'is_vi_pham' => false,
                'is_nguoi_dung' => true,
                'is_active' => true,
                'trang_thai' => true,
            ],
        ];

        foreach ($chiTietRows as $row) {
            ChiTietPhongHop::updateOrCreate(
                [
                    'id_nguoi_dung' => $row['id_nguoi_dung'],
                    'id_phong_hop' => $row['id_phong_hop'],
                ],
                $row
            );
        }
    }
}
