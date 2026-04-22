<?php

namespace Database\Seeders;

use App\Models\PhongHop;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PhongHopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $base = Carbon::now()->startOfHour();

        $phongHops = [
            [
                'id_chu_phong' => 1,
                'ma_phong' => 'PHONG-001',
                'ten_phong' => 'Hop du an Alpha',
                'so_nguoi_toi_da' => 20,
                'thoi_gian_bat_dau' => (clone $base)->addHours(2),
                'thoi_gian_ket_thuc' => (clone $base)->addHours(3),
                'trang_thai' => true,
            ],
            [
                'id_chu_phong' => 2,
                'ma_phong' => 'PHONG-002',
                'ten_phong' => 'Hop sprint tuan',
                'so_nguoi_toi_da' => 30,
                'thoi_gian_bat_dau' => (clone $base)->addHours(4),
                'thoi_gian_ket_thuc' => (clone $base)->addHours(5),
                'trang_thai' => true,
            ],
            [
                'id_chu_phong' => 3,
                'ma_phong' => 'PHONG-003',
                'ten_phong' => 'Demo san pham',
                'so_nguoi_toi_da' => 50,
                'thoi_gian_bat_dau' => (clone $base)->addHours(6),
                'thoi_gian_ket_thuc' => (clone $base)->addHours(7),
                'trang_thai' => true,
            ],
        ];

        foreach ($phongHops as $phongHop) {
            PhongHop::updateOrCreate(
                ['ma_phong' => $phongHop['ma_phong']],
                $phongHop
            );
        }
    }
}
