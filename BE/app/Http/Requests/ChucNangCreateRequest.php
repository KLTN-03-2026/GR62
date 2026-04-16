<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChucNangCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ten_chuc_nang' => 'required|string|max:255',
            'ma_chuc_nang'  => 'required|string|max:255|unique:chuc_nangs,ma_chuc_nang',
            'url'           => 'nullable|string|max:255',
            'mo_ta'         => 'nullable|string|max:255',
            'ten_slug'      => 'required|string|max:255|unique:chuc_nangs,ten_slug',
            'trang_thai'    => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'ten_chuc_nang.required' => 'Tên chức năng không được để trống',
            'ma_chuc_nang.required'  => 'Mã chức năng không được để trống',
            'ma_chuc_nang.unique'    => 'Mã chức năng đã tồn tại',
            'ten_slug.required'      => 'Tên slug không được để trống',
            'ten_slug.unique'        => 'Tên slug đã tồn tại',
            'trang_thai.required'    => 'Trạng thái không được để trống',
        ];
    }
}
