<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChucVu;

class ChucVuSeeder extends Seeder
{
    public function run(): void
    {
        ChucVu::updateOrCreate(['id' => 1], [
            'ten_chuc_vu' => 'Quản trị tối cao (Super Admin)', 
            'mo_ta' => 'Quyền hạn cao nhất trong hệ thống, quản lý mọi tài nguyên và cấu hình.',
            'trang_thai' => 1
        ]);
        ChucVu::updateOrCreate(['id' => 2], [
            'ten_chuc_vu' => 'Quản lý Nhân sự', 
            'mo_ta' => 'Quản lý thông tin nhân viên, tuyển dụng và các vấn đề về nhân sự của hệ thống.',
            'trang_thai' => 1
        ]);
        ChucVu::updateOrCreate(['id' => 3], [
            'ten_chuc_vu' => 'Quản lý Kỹ thuật', 
            'mo_ta' => 'Chịu trách nhiệm về vận hành kỹ thuật, bảo trì và xử lý các sự cố hệ thống.',
            'trang_thai' => 1
        ]);
        ChucVu::updateOrCreate(['id' => 4], [
            'ten_chuc_vu' => 'Chuyên viên Chăm sóc khách hàng', 
            'mo_ta' => 'Hỗ trợ người dùng, giải đáp thắc mắc và xử lý các phản hồi từ khách hàng.',
            'trang_thai' => 1
        ]);
        ChucVu::updateOrCreate(['id' => 5], [
            'ten_chuc_vu' => 'Quản lý Kinh doanh', 
            'mo_ta' => 'Quản lý các gói dịch vụ, chiến lược kinh doanh và doanh thu của nền tảng.',
            'trang_thai' => 1
        ]);
        ChucVu::updateOrCreate(['id' => 6], [
            'ten_chuc_vu' => 'Kế toán hệ thống', 
            'mo_ta' => 'Quản lý hóa đơn, thanh toán và các báo cáo tài chính của hệ thống.',
            'trang_thai' => 1
        ]);
    }
}
