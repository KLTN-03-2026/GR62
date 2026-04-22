<?php

namespace App\Http\Requests\NguoiDung;

use Illuminate\Foundation\Http\FormRequest;

class RegisterNguoiDungRequest extends FormRequest
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
            'so_dien_thoai' => 'required|string|max:15|regex:/^([0-9\s\-\+\(\)]*)$/',
            'email'         => 'required|email|unique:nguoi_dungs,email',
            'password'      => 'required|string|min:8',
            're_password'   => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'ho_va_ten.required'     => 'Họ và tên là bắt buộc.',
            'so_dien_thoai.required' => 'Số điện thoại là bắt buộc.',
            'so_dien_thoai.regex'    => 'Số điện thoại không đúng định dạng.',
            'email.required'         => 'Địa chỉ Email là bắt buộc.',
            'email.email'            => 'Địa chỉ Email không đúng định dạng.',
            'email.unique'           => 'Địa chỉ Email này đã được đăng ký trong hệ thống.',
            'password.required'      => 'Mật khẩu là bắt buộc.',
            'password.min'           => 'Mật khẩu phải có ít nhất 8 ký tự.',
            're_password.required'   => 'Vui lòng xác nhận lại mật khẩu.',
            're_password.same'       => 'Mật khẩu xác nhận không trùng khớp.',
        ];
    }
}
