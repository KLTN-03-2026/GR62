<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChiTietGoiChangeStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:chi_tiet_gois,id',
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
            'trang_thai.boolean' => 'Trạng thái phải là true hoặc false',
            'is_active.boolean' => 'Trạng thái kích hoạt phải là true hoặc false',
            'is_nguoi_dung.boolean' => 'Trạng thái người dùng phải là true hoặc false',
        ];
    }
}
