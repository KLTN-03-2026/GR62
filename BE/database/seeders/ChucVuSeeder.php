<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChucVu;

class ChucVuSeeder extends Seeder
{
    public function run(): void
    {
        ChucVu::updateOrCreate(['id' => 1], ['ten_chuc_vu' => 'Quản trị tối cao (Super Admin)', 'trang_thai' => 1]);
        ChucVu::updateOrCreate(['id' => 2], ['ten_chuc_vu' => 'Quản lý Nhân sự', 'trang_thai' => 1]);
        ChucVu::updateOrCreate(['id' => 3], ['ten_chuc_vu' => 'Quản lý Kỹ thuật', 'trang_thai' => 1]);
        ChucVu::updateOrCreate(['id' => 4], ['ten_chuc_vu' => 'Chuyên viên Chăm sóc khách hàng', 'trang_thai' => 1]);
        ChucVu::updateOrCreate(['id' => 5], ['ten_chuc_vu' => 'Quản lý Kinh doanh', 'trang_thai' => 1]);
        ChucVu::updateOrCreate(['id' => 6], ['ten_chuc_vu' => 'Kế toán hệ thống', 'trang_thai' => 1]);
    }
}
