<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $plans = [
            [
                'id' => 1,
                'ten_goi' => 'Basic',
                'gia_goi' => 0,
                'so_nguoi_toi_da' => 5,
                'so_phong_toi_da' => 1,
                'thoi_han' => 30,
                'mo_ta' => 'Goi Basic gioi han 5 nguoi va 1 gio moi phien hop.',
                'tinh_nang_nang_cao' => json_encode(['gioi_han_5_nguoi', 'gioi_han_1_gio']),
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
                'tinh_nang_nang_cao' => json_encode(['khong_gioi_han', 'uu_tien_chat_luong']),
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
                'tinh_nang_nang_cao' => json_encode(['quan_ly_thanh_vien', 'khong_gioi_han', 'bao_cao_to_chuc']),
                'is_nguoi_dung' => true,
                'is_open' => true,
                'is_hien_thi' => true,
                'trang_thai' => true,
            ],
        ];

        foreach ($plans as $plan) {
            DB::table('gois')->updateOrInsert(
                ['id' => $plan['id']],
                array_merge($plan, [
                    'created_at' => $now,
                    'updated_at' => $now,
                ])
            );
        }

        DB::table('gois')
            ->whereNotIn('id', [1, 2, 3])
            ->update([
                'is_hien_thi' => false,
                'trang_thai' => false,
                'updated_at' => $now,
            ]);
    }

    public function down(): void
    {
        $now = now();
        $legacyPlans = [
            [
                'id' => 1,
                'ten_goi' => 'Starter',
                'gia_goi' => 199000,
                'so_nguoi_toi_da' => 25,
                'so_phong_toi_da' => 3,
                'thoi_han' => 30,
                'mo_ta' => 'Goi co ban cho nhom nho.',
                'tinh_nang_nang_cao' => null,
                'is_nguoi_dung' => true,
                'is_open' => true,
                'is_hien_thi' => true,
                'trang_thai' => true,
            ],
            [
                'id' => 2,
                'ten_goi' => 'Professional',
                'gia_goi' => 599000,
                'so_nguoi_toi_da' => 100,
                'so_phong_toi_da' => 10,
                'thoi_han' => 30,
                'mo_ta' => 'Goi pho bien cho doanh nghiep vua.',
                'tinh_nang_nang_cao' => null,
                'is_nguoi_dung' => true,
                'is_open' => true,
                'is_hien_thi' => true,
                'trang_thai' => true,
            ],
            [
                'id' => 3,
                'ten_goi' => 'Enterprise',
                'gia_goi' => 1499000,
                'so_nguoi_toi_da' => 500,
                'so_phong_toi_da' => 50,
                'thoi_han' => 30,
                'mo_ta' => 'Goi nang cao cho doanh nghiep lon.',
                'tinh_nang_nang_cao' => null,
                'is_nguoi_dung' => true,
                'is_open' => true,
                'is_hien_thi' => true,
                'trang_thai' => true,
            ],
        ];

        foreach ($legacyPlans as $plan) {
            DB::table('gois')->updateOrInsert(
                ['id' => $plan['id']],
                array_merge($plan, [
                    'created_at' => $now,
                    'updated_at' => $now,
                ])
            );
        }
    }
};
