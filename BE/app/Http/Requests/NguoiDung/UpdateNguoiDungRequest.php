<?php

namespace App\Http\Requests\NguoiDung;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateNguoiDungRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
{
    return [
        'id'            => 'required|exists:nguoi_dungs,id',
        'ho_va_ten'     => 'required|string|max:255',

        'so_dien_thoai' => [
            'required',
            'string',
            'max:15',
            Rule::unique('nguoi_dungs', 'so_dien_thoai')->ignore($this->id),
        ],

        'email'         => [
            'required',
            'email',
            'regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
            Rule::unique('nguoi_dungs', 'email')->ignore($this->id),
        ],

        'password'      => 'nullable|string|min:8',
        're_password'   => 'nullable|same:password',
        'id_goi'        => 'nullable|exists:gois,id',
        'trang_thai'    => 'required|boolean',
    ];
}

    public function messages()
    {
        return [
            'id.required'            => 'ID không được để trống',
            'id.exists'              => 'Người dùng không tồn tại',

            'ho_va_ten.required'     => 'Họ và tên không được để trống',
            'ho_va_ten.string'       => 'Họ và tên phải là chuỗi ký tự',
            'ho_va_ten.max'          => 'Họ và tên không được vượt quá 255 ký tự',

            'so_dien_thoai.required' => 'Số điện thoại không được để trống',
            'so_dien_thoai.string'   => 'Số điện thoại phải là chuỗi ký tự',
            'so_dien_thoai.max'      => 'Số điện thoại không được vượt quá 15 ký tự',
            'so_dien_thoai.unique'   => 'Số điện thoại này đã được sử dụng',

            'email.required'         => 'Email không được để trống',
            'email.email'            => 'Email không đúng định dạng',
            'email.regex'            => 'Email phải có tên miền đầy đủ',
            'email.unique'           => 'Email đã tồn tại trong hệ thống',

            'password.min'           => 'Mật khẩu phải có ít nhất 8 ký tự',
            're_password.same'       => 'Mật khẩu xác nhận không khớp',
            'id_goi.exists'          => 'Gói dịch vụ không tồn tại',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'  => false,
            'message' => $validator->errors()->first(),
        ], 422));
    }
}
