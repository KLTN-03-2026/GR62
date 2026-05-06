<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DoiTacStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ho_va_ten'     => 'required|string|min:2|max:255',
            'email'         => [
                'required',
                'email',
                'regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
                'unique:nguoi_dungs,email',
            ],
            'so_dien_thoai' => 'required|numeric',
            'password'      => 'required|string|min:8',
            'dia_chi'       => 'nullable|string|max:255',
            'trang_thai'    => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'ho_va_ten.required' => 'Họ và tên không được để trống',
            'ho_va_ten.string'   => 'Họ và tên phải là chuỗi ký tự',
            'ho_va_ten.min'      => 'Họ và tên phải có ít nhất 2 ký tự',
            'ho_va_ten.max'      => 'Họ và tên không được vượt quá 255 ký tự',

            'email.required' => 'Email không được để trống',
            'email.email'    => 'Email không đúng định dạng',
            'email.regex'    => 'Email phải có tên miền đầy đủ',
            'email.unique'   => 'Email này đã được sử dụng',

            'so_dien_thoai.required' => 'Số điện thoại không được để trống',
            'so_dien_thoai.numeric'  => 'Số điện thoại chỉ được nhập số',

            'password.required' => 'Mật khẩu không được để trống',
            'password.string'   => 'Mật khẩu phải là chuỗi ký tự',
            'password.min'      => 'Mật khẩu phải có ít nhất 8 ký tự',

            'dia_chi.string' => 'Địa chỉ phải là chuỗi ký tự',
            'dia_chi.max'    => 'Địa chỉ không được vượt quá 255 ký tự',

            'trang_thai.boolean' => 'Trạng thái không hợp lệ',
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
