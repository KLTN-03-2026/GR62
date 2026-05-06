<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DoiTacRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ho_va_ten'     => 'required|min:2',
            'email'         => [
                'required',
                'email',
                'regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
                'unique:doi_tacs,email',
            ],
            'so_dien_thoai' => 'required|numeric',
            'password'      => 'required|min:8',
            'dia_chi'       => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'ho_va_ten.required' => 'Họ và tên không được để trống',
            'ho_va_ten.min'      => 'Họ và tên phải có ít nhất 2 ký tự',

            'email.required' => 'Email không được để trống',
            'email.email'    => 'Email không đúng định dạng',
            'email.regex'    => 'Email phải có tên miền đầy đủ, ví dụ: tuan@gmail.com',
            'email.unique'   => 'Email này đã được sử dụng',

            'so_dien_thoai.required' => 'Số điện thoại không được để trống',
            'so_dien_thoai.numeric'  => 'Số điện thoại chỉ được nhập số',

            'password.required' => 'Mật khẩu không được để trống',
            'password.min'      => 'Mật khẩu phải có ít nhất 8 ký tự',
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
