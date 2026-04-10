<?php

namespace App\Http\Requests\NguoiDung;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'current_password'  => 'required|string',
            'new_password'      => 'required|string|min:8|different:current_password',
            'confirm_password'  => 'required|same:new_password',
        ];
    }

    public function messages()
    {
        return [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'new_password.required'     => 'Vui lòng nhập mật khẩu mới',
            'new_password.min'          => 'Mật khẩu mới phải từ 8 ký tự',
            'new_password.different'    => 'Mật khẩu mới phải khác mật khẩu cũ',
            'confirm_password.required' => 'Vui lòng xác nhận mật khẩu mới',
            'confirm_password.same'     => 'Mật khẩu xác nhận không khớp',
        ];
    }
}
