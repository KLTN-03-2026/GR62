<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChiTietPhanQuyenUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id'            => 'required|exists:chi_tiet_phan_quyens,id',
            'id_phan_quyen' => 'required|exists:phan_quyens,id',
            'id_chuc_nang'  => 'required|integer',
            'hanh_dong'     => 'nullable|string|max:255',
            'mo_ta'         => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required'            => 'ID không được để trống',
            'id.exists'              => 'Chi tiết phân quyền không tồn tại',

            'id_phan_quyen.required' => 'ID phân quyền không được để trống',
            'id_phan_quyen.exists'   => 'Phân quyền không tồn tại',

            'id_chuc_nang.required'  => 'ID chức năng không được để trống',
            'id_chuc_nang.integer'   => 'ID chức năng phải là số nguyên',

            'hanh_dong.string'       => 'Hành động phải là chuỗi',
            'hanh_dong.max'          => 'Hành động không được vượt quá 255 ký tự',

            'mo_ta.string'           => 'Mô tả phải là chuỗi',
        ];
    }
}
