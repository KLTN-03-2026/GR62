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
            'so_dien_thoai' => 'required|string|max:15',
            'email'         => 'required|email|unique:nguoi_dungs,email',
            'password'      => 'required|string|min:8',
            'id_chuc_vu'    => 'nullable|exists:chuc_vus,id',
            'id_doi_tac'    => 'nullable|exists:doi_tacs,id',
        ];
    }

    public function messages()
    {
        return [
            'ho_va_ten.required'     => 'Họ và tên không được để trống',
            'so_dien_thoai.required' => 'Số điện thoại không được để trống',
            'email.required'         => 'Email không được để trống',
            'email.email'            => 'Email không đúng định dạng',
            'email.unique'           => 'Email đã tồn tại trong hệ thống',
            'password.required'      => 'Mật khẩu không được để trống',
            'password.min'           => 'Mật khẩu phải từ 8 ký tự',
            'id_chuc_vu.exists'      => 'Chức vụ không tồn tại',
            'id_doi_tac.exists'      => 'Đối tác không tồn tại',
        ];
    }
}
