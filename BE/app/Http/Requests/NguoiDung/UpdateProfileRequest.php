<?php

namespace App\Http\Requests\NguoiDung;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'ho_va_ten' => 'required|string|max:255',
            'email'     => 'required|email|unique:nguoi_dungs,email,' . auth('sanctum')->id(),
        ];
    }

    public function messages()
    {
        return [
            'ho_va_ten.required' => 'Họ và tên không được để trống',
            'email.required'     => 'Email không được để trống',
            'email.email'        => 'Email không đúng định dạng',
            'email.unique'       => 'Email đã tồn tại trong hệ thống',
        ];
    }
}
