<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoiChangeStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id'            => 'required|integer|exists:gois,id',
            'is_open'       => 'nullable|boolean',
            'is_hien_thi'   => 'nullable|boolean',
            'trang_thai'    => 'nullable|boolean',
            'is_nguoi_dung' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required'       => 'ID gói không được để trống',
            'id.integer'        => 'ID gói phải là số nguyên',
            'id.exists'         => 'Gói không tồn tại',
            'is_open.boolean'   => 'Trạng thái mở phải là true hoặc false',
            'is_hien_thi.boolean' => 'Trạng thái hiển thị phải là true hoặc false',
            'trang_thai.boolean' => 'Trạng thái phải là true hoặc false',
            'is_nguoi_dung.boolean' => 'Trạng thái người dùng phải là true hoặc false',
        ];
    }
}
