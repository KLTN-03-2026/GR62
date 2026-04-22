<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class HoaDonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hoaDons = [];
        for ($i = 1; $i <= 18; $i++) {
            $hoaDons[] = [
                'id_nguoi_dung' => $i,
                'id_goi' => rand(1, 4), // Giả sử id_goi có từ 1 đến 4
                'so_tien' => rand(500, 5000) * 1000, // Giá từ 500k đến 5 triệu
                'ma_giao_dich' => 'HD' . time(),
                'phuong_thuc_thanh_toan' => collect(['Sepay'])->random(),
                'trang_thai_thanh_toan' => collect(['pending', 'completed', 'failed', 'cancelled'])->random(),
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                'updated_at' => Carbon::now()->subDays(rand(1, 30)),
            ];
        }

        DB::table('hoa_dons')->insert($hoaDons);
    }
}
