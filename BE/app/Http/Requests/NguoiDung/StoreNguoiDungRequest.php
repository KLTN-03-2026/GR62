<?php

namespace App\Http\Requests\NguoiDung;

use Illuminate\Foundation\Http\FormRequest;

class StoreNguoiDungRequest extends FormRequest
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
            'ho_va_ten'     => 'required|string|max:255',
            'so_dien_thoai' => 'required|unique:nguoi_dungs,so_dien_thoai|string|max:15',
            'email'         => [
                'required',
                'email',
                'regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
                'unique:nguoi_dungs,email',
            ],
            'password'      => 'required|string|min:8',
        ];
    }

    public function messages()
    {
        return [
            'ho_va_ten.required' => 'Họ và tên không được để trống',
            'ho_va_ten.min'      => 'Họ và tên phải có ít nhất 2 ký tự',

            'email.required' => 'Email không được để trống',
            'email.email'    => 'Email không đúng định dạng',
            'email.regex'    => 'Email phải có tên miền đầy đủ',
            'email.unique'   => 'Email này đã được sử dụng',

            'so_dien_thoai.required' => 'Số điện thoại không được để trống',
            'so_dien_thoai.numeric'  => 'Số điện thoại chỉ được nhập số',
            'so_dien_thoai.unique'   => 'Số điện thoại này đã được sử dụng',

            'password.required' => 'Mật khẩu không được để trống',
            'password.min'      => 'Mật khẩu phải có ít nhất 6 ký tự',
        ];
    }
}
