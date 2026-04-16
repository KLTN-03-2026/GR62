<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoiCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ten_goi'           => 'required|string|max:255',
            'gia_goi'           => 'required|numeric|min:0',
            'so_nguoi_toi_da'   => 'required|integer|min:1',
            'so_phong_toi_da'   => 'required|integer|min:1',
            'thoi_han'          => 'required|integer|min:1',
            'mo_ta'             => 'nullable|string',
            'is_nguoi_dung'     => 'nullable|boolean',
            'is_open'           => 'nullable|boolean',
            'is_hien_thi'       => 'nullable|boolean',
            'trang_thai'        => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'ten_goi.required'          => 'Tên gói không được để trống',
            'ten_goi.string'            => 'Tên gói phải là chuỗi ký tự',
            'ten_goi.max'               => 'Tên gói không được vượt quá 255 ký tự',
            'gia_goi.required'          => 'Giá gói không được để trống',
            'gia_goi.numeric'           => 'Giá gói phải là số',
            'gia_goi.min'               => 'Giá gói phải lớn hơn hoặc bằng 0',
            'so_nguoi_toi_da.required'  => 'Số người tối đa không được để trống',
            'so_nguoi_toi_da.integer'   => 'Số người tối đa phải là số nguyên',
            'so_nguoi_toi_da.min'       => 'Số người tối đa phải lớn hơn hoặc bằng 1',
            'so_phong_toi_da.required'  => 'Số phòng tối đa không được để trống',
            'so_phong_toi_da.integer'   => 'Số phòng tối đa phải là số nguyên',
            'so_phong_toi_da.min'       => 'Số phòng tối đa phải lớn hơn hoặc bằng 1',
            'thoi_han.required'         => 'Thời hạn không được để trống',
            'thoi_han.integer'          => 'Thời hạn phải là số nguyên',
            'thoi_han.min'              => 'Thời hạn phải lớn hơn hoặc bằng 1',
        ];
    }
}
