<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HoaDon;
use App\Models\NguoiDung;
use App\Models\Goi;

class HoaDonSampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nguoiDungs = NguoiDung::all();
        $gois = Goi::all();

        if ($nguoiDungs->isEmpty() || $gois->isEmpty()) {
            return;
        }

        for ($i = 0; $i < 7; $i++) {
            $goi = $gois->random();
            HoaDon::create([
                'id_nguoi_dung' => $nguoiDungs->random()->id,
                'id_goi' => $goi->id,
                'so_tien' => $goi->gia ?? 100000,
                'ma_giao_dich' => 'HD' . strtoupper(uniqid()),
                'phuong_thuc_thanh_toan' => collect(['VNPAY', 'MoMo', 'Chuyển khoản'])->random(),
                'trang_thai_thanh_toan' => 1,
            ]);
        }
    }
}
