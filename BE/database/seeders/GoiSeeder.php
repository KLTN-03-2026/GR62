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
                'id' => 1,
                'ten_goi' => 'Basic',
                'gia_goi' => 0,
                'so_nguoi_toi_da' => 5,
                'so_phong_toi_da' => 1,
                'thoi_han' => 30,
                'mo_ta' => 'Goi Basic gioi han 5 nguoi va 1 gio moi phien hop.',
                'tinh_nang_nang_cao' => ['gioi_han_5_nguoi', 'gioi_han_1_gio'],
                'is_nguoi_dung' => true,
                'is_open' => true,
                'is_hien_thi' => true,
                'trang_thai' => true,
            ],
            [
                'id' => 2,
                'ten_goi' => 'Pro',
                'gia_goi' => 599000,
                'so_nguoi_toi_da' => 9999,
                'so_phong_toi_da' => 9999,
                'thoi_han' => 30,
                'mo_ta' => 'Goi Pro khong gioi han nguoi tham gia va thoi gian hop.',
                'tinh_nang_nang_cao' => ['khong_gioi_han', 'uu_tien_chat_luong'],
                'is_nguoi_dung' => true,
                'is_open' => true,
                'is_hien_thi' => true,
                'trang_thai' => true,
            ],
            [
                'id' => 3,
                'ten_goi' => 'Business',
                'gia_goi' => 1499000,
                'so_nguoi_toi_da' => 9999,
                'so_phong_toi_da' => 9999,
                'thoi_han' => 30,
                'mo_ta' => 'Goi Business cho doi tac/to chuc, khong gioi han nguoi tham gia va thoi gian hop.',
                'tinh_nang_nang_cao' => ['quan_ly_thanh_vien', 'khong_gioi_han', 'bao_cao_to_chuc'],
                'is_nguoi_dung' => true,
                'is_open' => true,
                'is_hien_thi' => true,
                'trang_thai' => true,
            ],
        ];

        foreach ($gois as $goi) {
            Goi::updateOrCreate(
                ['id' => $goi['id']],
                $goi
            );
        }
    }
}
