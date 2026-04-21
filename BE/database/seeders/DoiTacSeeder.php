<?php

namespace Database\Seeders;

use App\Models\DoiTac;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DoiTacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ nếu có để tránh trùng lặp khi chạy lại
        DB::table('doi_tacs')->truncate();

        DoiTac::create([
            'id_admin'          => 1,
            'ho_va_ten'         => 'Nguyễn Văn Đối Tác',
            'so_dien_thoai'     => '0912345678',
            'email'             => 'doitac1@gmail.com',
            'password'          => Hash::make('123456'),
            'dia_chi'           => '123 Đường ABC, Quận 1, TP. Hồ Chí Minh',
            'trang_thai'        => true,
        ]);

        DoiTac::create([
            'id_admin'          => 1,
            'ho_va_ten'         => 'Trần Thị Hợp Tác',
            'so_dien_thoai'     => '0987654321',
            'email'             => 'doitac2@gmail.com',
            'password'          => Hash::make('123456'),
            'dia_chi'           => '456 Đường XYZ, Quận 3, TP. Hồ Chí Minh',
            'trang_thai'        => true,
        ]);

        DoiTac::create([
            'id_admin'          => 2,
            'ho_va_ten'         => 'Lê Văn Cung Cấp',
            'so_dien_thoai'     => '0901234567',
            'email'             => 'doitac3@gmail.com',
            'password'          => Hash::make('123456'),
            'dia_chi'           => '789 Đường LMN, Quận Bình Thạnh, TP. Hồ Chí Minh',
            'trang_thai'        => true,
        ]);

        DoiTac::create([
            'id_admin'          => 3,
            'ho_va_ten'         => 'Phạm Minh Quân',
            'so_dien_thoai'     => '0933445566',
            'email'             => 'doitac4@gmail.com',
            'password'          => Hash::make('123456'),
            'dia_chi'           => '101 Đường PQR, Quận Tân Bình, TP. Hồ Chí Minh',
            'trang_thai'        => false,
        ]);

        DoiTac::create([
            'id_admin'          => 4,
            'ho_va_ten'         => 'Hoàng Anh Tuấn',
            'so_dien_thoai'     => '0977889900',
            'email'             => 'doitac5@gmail.com',
            'password'          => Hash::make('123456'),
            'dia_chi'           => '202 Đường STU, Quận 7, TP. Hồ Chí Minh',
            'trang_thai'        => true,
        ]);
    }
}
