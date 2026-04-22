<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChiTieGoiUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:chi_tiet_gois,id',
            'id_goi' => 'required|integer|exists:gois,id',
            'id_nguoi_dung' => 'nullable|integer|exists:nguoi_dungs,id',
            'id_doi_tac' => 'nullable|integer|exists:doi_tacs,id',
            'ngay_bat_dau' => 'nullable|date',
            'ngay_ket_thuc' => 'nullable|date|after_or_equal:ngay_bat_dau',
            'trang_thai' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'is_nguoi_dung' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'ID chi tiết gói không được để trống',
            'id.integer' => 'ID chi tiết gói phải là số nguyên',
            'id.exists' => 'Chi tiết gói không tồn tại',
            'id_goi.required' => 'Gói dịch vụ không được để trống',
            'id_goi.integer' => 'ID gói phải là số nguyên',
            'id_goi.exists' => 'Gói dịch vụ không tồn tại',
            'id_nguoi_dung.integer' => 'ID người dùng phải là số nguyên',
            'id_nguoi_dung.exists' => 'Người dùng không tồn tại',
            'id_doi_tac.integer' => 'ID đối tác phải là số nguyên',
            'id_doi_tac.exists' => 'Đối tác không tồn tại',
            'ngay_bat_dau.date' => 'Ngày bắt đầu không hợp lệ',
            'ngay_ket_thuc.date' => 'Ngày kết thúc không hợp lệ',
            'ngay_ket_thuc.after_or_equal' => 'Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu',
            'trang_thai.boolean' => 'Trạng thái phải là true/false',
            'is_active.boolean' => 'Is active phải là true/false',
            'is_nguoi_dung.boolean' => 'Is người dùng phải là true/false',
        ];
    }
}
