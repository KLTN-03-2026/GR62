<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChucNang;

class ChucNangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ChucNang::updateOrCreate(['ma_chuc_nang' => 'DASHBOARD_VIEW'], [
            'ten_chuc_nang' => 'Xem Dashboard',
            'ten_slug'      => 'dashboard-view',
            'url'           => '/admin/dashboard',
            'mo_ta'         => 'Quyền xem bảng điều khiển hệ thống',
            'trang_thai'    => 1,
        ]);

        ChucNang::updateOrCreate(['ma_chuc_nang' => 'NHAN_VIEN_MANAGE'], [
            'ten_chuc_nang' => 'Quản Lý Nhân Viên',
            'ten_slug'      => 'nhan-vien-manage',
            'url'           => '/admin/nhan-vien',
            'mo_ta'         => 'Quyền quản lý danh sách nhân viên',
            'trang_thai'    => 1,
        ]);

        ChucNang::updateOrCreate(['ma_chuc_nang' => 'CHUC_VU_MANAGE'], [
            'ten_chuc_nang' => 'Quản Lý Chức Vụ',
            'ten_slug'      => 'chuc-vu-manage',
            'url'           => '/admin/chuc-vu',
            'mo_ta'         => 'Quyền quản lý danh sách chức vụ',
            'trang_thai'    => 1,
        ]);

        ChucNang::updateOrCreate(['ma_chuc_nang' => 'CHUC_NANG_MANAGE'], [
            'ten_chuc_nang' => 'Quản Lý Chức Năng',
            'ten_slug'      => 'chuc-nang-manage',
            'url'           => '/admin/chuc-nang',
            'mo_ta'         => 'Quyền quản lý danh sách chức năng hệ thống',
            'trang_thai'    => 1,
        ]);

        ChucNang::updateOrCreate(['ma_chuc_nang' => 'PHAN_QUYEN_MANAGE'], [
            'ten_chuc_nang' => 'Phân Quyền Hệ Thống',
            'ten_slug'      => 'phan-quyen-manage',
            'url'           => '/admin/phan-quyen',
            'mo_ta'         => 'Quyền thiết lập phân quyền cho các chức vụ',
            'trang_thai'    => 1,
        ]);

        ChucNang::updateOrCreate(['ma_chuc_nang' => 'GOI_DICH_VU_MANAGE'], [
            'ten_chuc_nang' => 'Quản Lý Gói Dịch Vụ',
            'ten_slug'      => 'goi-dich-vu-manage',
            'url'           => '/admin/goi-dich-vu',
            'mo_ta'         => 'Quyền quản lý các gói dịch vụ AI-Meet',
            'trang_thai'    => 1,
        ]);
        
        ChucNang::updateOrCreate(['ma_chuc_nang' => 'PHONG_HOP_MANAGE'], [
            'ten_chuc_nang' => 'Quản Lý Phòng Họp',
            'ten_slug'      => 'phong-hop-manage',
            'url'           => '/admin/phong-hop',
            'mo_ta'         => 'Quyền giám sát và quản lý các phòng họp trực tuyến',
            'trang_thai'    => 1,
        ]);

        // Cụ thể hơn cho Nhân viên
        ChucNang::updateOrCreate(['ma_chuc_nang' => 'NHAN_VIEN_CREATE'], [
            'ten_chuc_nang' => 'Thêm Mới Nhân Viên',
            'ten_slug'      => 'nhan-vien-create',
            'url'           => '/api/admin/create',
            'mo_ta'         => 'Quyền thêm mới nhân viên vào hệ thống',
            'trang_thai'    => 1,
        ]);

        ChucNang::updateOrCreate(['ma_chuc_nang' => 'NHAN_VIEN_UPDATE'], [
            'ten_chuc_nang' => 'Cập Nhật Nhân Viên',
            'ten_slug'      => 'nhan-vien-update',
            'url'           => '/api/admin/update',
            'mo_ta'         => 'Quyền chỉnh sửa thông tin nhân viên',
            'trang_thai'    => 1,
        ]);

        ChucNang::updateOrCreate(['ma_chuc_nang' => 'NHAN_VIEN_DELETE'], [
            'ten_chuc_nang' => 'Xóa Nhân Viên',
            'ten_slug'      => 'nhan-vien-delete',
            'url'           => '/api/admin/delete',
            'mo_ta'         => 'Quyền xóa nhân viên khỏi hệ thống',
            'trang_thai'    => 1,
        ]);

        // Cụ thể hơn cho Chức vụ
        ChucNang::updateOrCreate(['ma_chuc_nang' => 'CHUC_VU_CREATE'], [
            'ten_chuc_nang' => 'Thêm Mới Chức Vụ',
            'ten_slug'      => 'chuc-vu-create',
            'url'           => '/api/chuc-vu/create',
            'mo_ta'         => 'Quyền thêm mới chức vụ',
            'trang_thai'    => 1,
        ]);

        ChucNang::updateOrCreate(['ma_chuc_nang' => 'CHUC_VU_UPDATE'], [
            'ten_chuc_nang' => 'Cập Nhật Chức Vụ',
            'ten_slug'      => 'chuc-vu-update',
            'url'           => '/api/chuc-vu/update',
            'mo_ta'         => 'Quyền cập nhật chức vụ',
            'trang_thai'    => 1,
        ]);

        ChucNang::updateOrCreate(['ma_chuc_nang' => 'CHUC_VU_DELETE'], [
            'ten_chuc_nang' => 'Xóa Chức Vụ',
            'ten_slug'      => 'chuc-vu-delete',
            'url'           => '/api/chuc-vu/delete',
            'mo_ta'         => 'Quyền xóa chức vụ',
            'trang_thai'    => 1,
        ]);

        // Cụ thể hơn cho Chức năng
        ChucNang::updateOrCreate(['ma_chuc_nang' => 'CHUC_NANG_CREATE'], [
            'ten_chuc_nang' => 'Thêm Mới Chức Năng',
            'ten_slug'      => 'chuc-nang-create',
            'url'           => '/api/chuc-nang/create',
            'mo_ta'         => 'Quyền thêm mới chức năng hệ thống',
            'trang_thai'    => 1,
        ]);

        ChucNang::updateOrCreate(['ma_chuc_nang' => 'CHUC_NANG_UPDATE'], [
            'ten_chuc_nang' => 'Cập Nhật Chức Năng',
            'ten_slug'      => 'chuc-nang-update',
            'url'           => '/api/chuc-nang/update',
            'mo_ta'         => 'Quyền cập nhật thông tin chức năng',
            'trang_thai'    => 1,
        ]);

        ChucNang::updateOrCreate(['ma_chuc_nang' => 'CHUC_NANG_DELETE'], [
            'ten_chuc_nang' => 'Xóa Chức Năng',
            'ten_slug'      => 'chuc-nang-delete',
            'url'           => '/api/chuc-nang/delete',
            'mo_ta'         => 'Quyền xóa chức năng hệ thống',
            'trang_thai'    => 1,
        ]);

        // ══════════════════════════════════════════════════════
        // PHÒNG HỌP
        // ══════════════════════════════════════════════════════
        ChucNang::updateOrCreate(['ma_chuc_nang' => 'PHONG_HOP_CREATE'], [
            'ten_chuc_nang' => 'Thêm Mới Phòng Họp',
            'ten_slug'      => 'phong-hop-create',
            'url'           => '/api/phong-hop/create',
            'mo_ta'         => 'Quyền tạo mới phòng họp trực tuyến',
            'trang_thai'    => 1,
        ]);

        ChucNang::updateOrCreate(['ma_chuc_nang' => 'PHONG_HOP_UPDATE'], [
            'ten_chuc_nang' => 'Cập Nhật Phòng Họp',
            'ten_slug'      => 'phong-hop-update',
            'url'           => '/api/phong-hop/update',
            'mo_ta'         => 'Quyền chỉnh sửa thông tin phòng họp',
            'trang_thai'    => 1,
        ]);

        ChucNang::updateOrCreate(['ma_chuc_nang' => 'PHONG_HOP_DELETE'], [
            'ten_chuc_nang' => 'Xóa Phòng Họp',
            'ten_slug'      => 'phong-hop-delete',
            'url'           => '/api/phong-hop/delete',
            'mo_ta'         => 'Quyền xóa phòng họp khỏi hệ thống',
            'trang_thai'    => 1,
        ]);

        // ══════════════════════════════════════════════════════
        // ĐỐI TÁC
        // ══════════════════════════════════════════════════════
        ChucNang::updateOrCreate(['ma_chuc_nang' => 'DOI_TAC_CREATE'], [
            'ten_chuc_nang' => 'Thêm Mới Đối Tác',
            'ten_slug'      => 'doi-tac-create',
            'url'           => '/api/doi-tac/create',
            'mo_ta'         => 'Quyền đăng ký đối tác mới',
            'trang_thai'    => 1,
        ]);

        ChucNang::updateOrCreate(['ma_chuc_nang' => 'DOI_TAC_UPDATE'], [
            'ten_chuc_nang' => 'Cập Nhật Đối Tác',
            'ten_slug'      => 'doi-tac-update',
            'url'           => '/api/doi-tac/update',
            'mo_ta'         => 'Quyền chỉnh sửa thông tin đối tác',
            'trang_thai'    => 1,
        ]);

        ChucNang::updateOrCreate(['ma_chuc_nang' => 'DOI_TAC_DELETE'], [
            'ten_chuc_nang' => 'Xóa Đối Tác',
            'ten_slug'      => 'doi-tac-delete',
            'url'           => '/api/doi-tac/delete',
            'mo_ta'         => 'Quyền xóa đối tác khỏi hệ thống',
            'trang_thai'    => 1,
        ]);

        // ══════════════════════════════════════════════════════
        // GÓI DỊCH VỤ
        // ══════════════════════════════════════════════════════
        ChucNang::updateOrCreate(['ma_chuc_nang' => 'GOI_CREATE'], [
            'ten_chuc_nang' => 'Thêm Mới Gói Dịch Vụ',
            'ten_slug'      => 'goi-create',
            'url'           => '/api/goi/create',
            'mo_ta'         => 'Quyền tạo mới các gói dịch vụ AI-Meet',
            'trang_thai'    => 1,
        ]);

        ChucNang::updateOrCreate(['ma_chuc_nang' => 'GOI_UPDATE'], [
            'ten_chuc_nang' => 'Cập Nhật Gói Dịch Vụ',
            'ten_slug'      => 'goi-update',
            'url'           => '/api/goi/update',
            'mo_ta'         => 'Quyền chỉnh sửa cấu hình gói dịch vụ',
            'trang_thai'    => 1,
        ]);

        ChucNang::updateOrCreate(['ma_chuc_nang' => 'GOI_DELETE'], [
            'ten_chuc_nang' => 'Xóa Gói Dịch Vụ',
            'ten_slug'      => 'goi-delete',
            'url'           => '/api/goi/delete',
            'mo_ta'         => 'Quyền xóa gói dịch vụ khỏi hệ thống',
            'trang_thai'    => 1,
        ]);

        // ══════════════════════════════════════════════════════
        // NGƯỜI DÙNG
        // ══════════════════════════════════════════════════════
        ChucNang::updateOrCreate(['ma_chuc_nang' => 'NGUOI_DUNG_CREATE'], [
            'ten_chuc_nang' => 'Thêm Mới Người Dùng',
            'ten_slug'      => 'nguoi-dung-create',
            'url'           => '/api/nguoi-dung/create',
            'mo_ta'         => 'Quyền tạo tài khoản người dùng mới',
            'trang_thai'    => 1,
        ]);

        ChucNang::updateOrCreate(['ma_chuc_nang' => 'NGUOI_DUNG_UPDATE'], [
            'ten_chuc_nang' => 'Cập Nhật Người Dùng',
            'ten_slug'      => 'nguoi-dung-update',
            'url'           => '/api/nguoi-dung/update',
            'mo_ta'         => 'Quyền chỉnh sửa thông tin người dùng',
            'trang_thai'    => 1,
        ]);

        ChucNang::updateOrCreate(['ma_chuc_nang' => 'NGUOI_DUNG_DELETE'], [
            'ten_chuc_nang' => 'Xóa Người Dùng',
            'ten_slug'      => 'nguoi-dung-delete',
            'url'           => '/api/nguoi-dung/delete',
            'mo_ta'         => 'Quyền xóa người dùng khỏi hệ thống',
            'trang_thai'    => 1,
        ]);
    }
}
