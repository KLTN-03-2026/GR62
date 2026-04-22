<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoiSearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search'        => 'nullable|string|max:255',
            'ten_goi'       => 'nullable|string|max:255',
            'gia_goi_min'   => 'nullable|numeric|min:0',
            'gia_goi_max'   => 'nullable|numeric|min:0',
            'is_open'       => 'nullable|boolean',
            'is_hien_thi'   => 'nullable|boolean',
            'trang_thai'    => 'nullable|boolean',
            'sort_by'       => 'nullable|string|in:id,ten_goi,gia_goi,created_at',
            'sort_order'    => 'nullable|string|in:asc,desc',
            'page'          => 'nullable|integer|min:1',
            'per_page'      => 'nullable|integer|min:1|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'search.string'         => 'Từ khóa tìm kiếm phải là chuỗi ký tự',
            'search.max'            => 'Từ khóa tìm kiếm không được vượt quá 255 ký tự',
            'ten_goi.string'        => 'Tên gói phải là chuỗi ký tự',
            'ten_goi.max'           => 'Tên gói không được vượt quá 255 ký tự',
            'gia_goi_min.numeric'   => 'Giá gói tối thiểu phải là số',
            'gia_goi_min.min'       => 'Giá gói tối thiểu phải lớn hơn hoặc bằng 0',
            'gia_goi_max.numeric'   => 'Giá gói tối đa phải là số',
            'gia_goi_max.min'       => 'Giá gói tối đa phải lớn hơn hoặc bằng 0',
            'sort_by.in'            => 'Sắp xếp theo phải là một trong: id, ten_goi, gia_goi, created_at',
            'sort_order.in'         => 'Thứ tự sắp xếp phải là asc hoặc desc',
            'page.integer'          => 'Trang phải là số nguyên',
            'page.min'              => 'Trang phải lớn hơn hoặc bằng 1',
            'per_page.integer'      => 'Số lượng mỗi trang phải là số nguyên',
            'per_page.min'          => 'Số lượng mỗi trang phải lớn hơn hoặc bằng 1',
            'per_page.max'          => 'Số lượng mỗi trang không được vượt quá 100',
        ];
    }
}
