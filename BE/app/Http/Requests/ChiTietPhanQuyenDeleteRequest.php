<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChiTietPhanQuyenDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|exists:chi_tiet_phan_quyens,id',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'ID không được để trống',
            'id.exists'   => 'Chi tiết phân quyền không tồn tại',
        ];
    }
}
