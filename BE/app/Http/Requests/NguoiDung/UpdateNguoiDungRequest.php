<?php

namespace App\Http\Requests\NguoiDung;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNguoiDungRequest extends FormRequest
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
            'id'            => 'required|exists:nguoi_dungs,id',
            'ho_va_ten'     => 'required|string|max:255',
            'so_dien_thoai' => 'required|string|max:15',
            'email'         => 'required|email|unique:nguoi_dungs,email,' . $this->id,
            'id_chuc_vu'    => 'nullable|exists:chuc_vus,id',
        ];
    }

    public function messages()
    {
        return [
            'id.required'            => 'ID không được để trống',
            'id.exists'              => 'Người dùng không tồn tại',
            'ho_va_ten.required'     => 'Họ và tên không được để trống',
            'so_dien_thoai.required' => 'Số điện thoại không được để trống',
            'email.required'         => 'Email không được để trống',
            'email.email'            => 'Email không đúng định dạng',
            'email.unique'           => 'Email đã tồn tại trong hệ thống',
            'id_chuc_vu.exists'      => 'Chức vụ không tồn tại',
        ];
    }
}
