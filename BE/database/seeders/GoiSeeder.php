<?php

namespace Database\Seeders;

use App\Models\Goi;
use Illuminate\Database\Seeder;

class GoiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gois = [
            [
                'ten_goi' => 'Starter',
                'gia_goi' => 199000,
                'so_nguoi_toi_da' => 25,
                'so_phong_toi_da' => 3,
                'thoi_han' => 30,
                'mo_ta' => 'Goi co ban cho nhom nho.',
                'is_nguoi_dung' => true,
                'is_open' => true,
                'is_hien_thi' => true,
                'trang_thai' => true,
            ],
            [
                'ten_goi' => 'Professional',
                'gia_goi' => 599000,
                'so_nguoi_toi_da' => 100,
                'so_phong_toi_da' => 10,
                'thoi_han' => 30,
                'mo_ta' => 'Goi pho bien cho doanh nghiep vua.',
                'is_nguoi_dung' => true,
                'is_open' => true,
                'is_hien_thi' => true,
                'trang_thai' => true,
            ],
            [
                'ten_goi' => 'Enterprise',
                'gia_goi' => 1499000,
                'so_nguoi_toi_da' => 500,
                'so_phong_toi_da' => 50,
                'thoi_han' => 30,
                'mo_ta' => 'Goi nang cao cho doanh nghiep lon.',
                'is_nguoi_dung' => true,
                'is_open' => true,
                'is_hien_thi' => true,
                'trang_thai' => true,
            ],
            [
                'ten_goi' => 'Partner Plan',
                'gia_goi' => 399000,
                'so_nguoi_toi_da' => 50,
                'so_phong_toi_da' => 8,
                'thoi_han' => 30,
                'mo_ta' => 'Goi danh rieng cho doi tac.',
                'is_nguoi_dung' => false,
                'is_open' => true,
                'is_hien_thi' => true,
                'trang_thai' => true,
            ],
        ];

        foreach ($gois as $goi) {
            Goi::updateOrCreate(
                ['ten_goi' => $goi['ten_goi']],
                $goi
            );
        }
    }
}
