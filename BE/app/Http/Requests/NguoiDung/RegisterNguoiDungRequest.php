<?php

namespace App\Http\Requests\NguoiDung;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'ho_va_ten' => 'required|string|max:255|regex:/^[\p{L}\s]+$/u',
            'so_dien_thoai' => 'required|string|max:15|regex:/^([0-9\s\-\+\(\)]*)$/|unique:nguoi_dungs,so_dien_thoai',
            'email' => [
                'required',
                'email',
                'regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
                'unique:nguoi_dungs,email',
            ],
            'password' => 'required|string|min:8',
            're_password' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'ho_va_ten.required' => 'Họ và tên là bắt buộc.',
            'ho_va_ten.string' => 'Họ và tên phải là chuỗi ký tự.',
            'ho_va_ten.max' => 'Họ và tên không được vượt quá 255 ký tự.',
            'ho_va_ten.regex' => 'Họ và tên chỉ được chứa chữ cái và khoảng trắng.',

            'so_dien_thoai.required' => 'Số điện thoại là bắt buộc.',
            'so_dien_thoai.string' => 'Số điện thoại phải là chuỗi ký tự.',
            'so_dien_thoai.max' => 'Số điện thoại không được vượt quá 15 ký tự.',
            'so_dien_thoai.regex' => 'Số điện thoại không đúng định dạng.',
            'so_dien_thoai.unique' => 'Số điện thoại này đã được sử dụng',

            'email.required' => 'Địa chỉ Email là bắt buộc.',
            'email.email' => 'Địa chỉ Email không đúng định dạng.',
            'email.regex' => 'Email phải có tên miền đầy đủ',
            'email.unique' => 'Địa chỉ Email này đã được đăng ký trong hệ thống.',

            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',

            're_password.required' => 'Vui lòng xác nhận lại mật khẩu.',
            're_password.same' => 'Mật khẩu xác nhận không trùng khớp.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => $validator->errors()->first(),
        ], 422));
    }
}
