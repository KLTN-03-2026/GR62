<?php

namespace App\Http\Requests\NguoiDung;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'email'             => 'required|email|exists:nguoi_dungs,email',
            'ma_quen_mat_khau'  => 'required|string',
            'password'          => 'required|string|min:8',
            'confirm_password'  => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'email.required'            => 'Email không được để trống',
            'email.email'               => 'Email không đúng định dạng',
            'email.exists'              => 'Email không tồn tại trong hệ thống',
            'ma_quen_mat_khau.required' => 'Mã xác nhận không được để trống',
            'password.required'         => 'Mật khẩu không được để trống',
            'password.min'              => 'Mật khẩu phải từ 8 ký tự',
            'confirm_password.required' => 'Mật khẩu xác nhận không được để trống',
            'confirm_password.same'     => 'Mật khẩu xác nhận không khớp',
        ];
    }
}
