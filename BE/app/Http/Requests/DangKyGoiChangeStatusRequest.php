<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DangKyGoiChangeStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:dang_ky_gois,id',
            'trang_thai' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'is_nguoi_dung' => 'nullable|boolean',
        ];
    }
}
