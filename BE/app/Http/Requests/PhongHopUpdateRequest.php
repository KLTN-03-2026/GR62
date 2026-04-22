<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhongHopUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id'                  => 'required|integer|exists:phong_hops,id',
            'ten_phong'           => 'required|string|max:255',
            'id_chu_phong'        => 'required|integer|exists:nguoi_dungs,id',
            'so_nguoi_toi_da'     => 'nullable|integer|min:2',
            'thoi_gian_bat_dau'   => 'nullable|date',
            'thoi_gian_ket_thuc'  => 'nullable|date|after_or_equal:thoi_gian_bat_dau',
            'trang_thai'          => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required'                 => 'ID phòng họp không được để trống',
            'id.integer'                  => 'ID phòng họp phải là số nguyên',
            'id.exists'                   => 'Phòng họp không tồn tại',

            'ten_phong.required'          => 'Tên phòng không được để trống',
            'ten_phong.string'            => 'Tên phòng phải là chuỗi',
            'ten_phong.max'               => 'Tên phòng không được vượt quá 255 ký tự',

            'id_chu_phong.required'       => 'ID chủ phòng không được để trống',
            'id_chu_phong.integer'        => 'ID chủ phòng phải là số nguyên',
            'id_chu_phong.exists'         => 'Chủ phòng không tồn tại',

            'so_nguoi_toi_da.integer'     => 'Số người tối đa phải là số nguyên',
            'so_nguoi_toi_da.min'         => 'Số người tối đa phải lớn hơn hoặc bằng 2',

            'thoi_gian_bat_dau.date'      => 'Thời gian bắt đầu không đúng định dạng ngày giờ',
            'thoi_gian_ket_thuc.date'     => 'Thời gian kết thúc không đúng định dạng ngày giờ',
            'thoi_gian_ket_thuc.after_or_equal' => 'Thời gian kết thúc phải lớn hơn hoặc bằng thời gian bắt đầu',

            'trang_thai.boolean'          => 'Trạng thái phải là true hoặc false',
        ];
    }
}
