<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChucNangCreateRequest extends FormRequest
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
            'ten_chuc_nang' => 'required|string|min:2|max:255',
            'ma_chuc_nang' => 'required|string|min:2|max:255',
            'url' => 'required|url',
            'mo_ta' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'ten_chuc_nang.required' => 'Tên chức năng không được để trống',
            'ten_chuc_nang.string' => 'Tên chức năng phải là chuỗi',
            'ten_chuc_nang.min' => 'Tên chức năng phải có ít nhất 2 ký tự',
            'ten_chuc_nang.max' => 'Tên chức năng không được vượt quá 255 ký tự',

            'ma_chuc_nang.required' => 'Mã chức năng không được để trống',
            'ma_chuc_nang.string' => 'Mã chức năng phải là chuỗi',
            'ma_chuc_nang.min' => 'Mã chức năng phải có ít nhất 2 ký tự',
            'ma_chuc_nang.max' => 'Mã chức năng không được vượt quá 255 ký tự',

            'url.required' => 'URL không được để trống',
            'url.url' => 'URL không hợp lệ',

            'mo_ta.string' => 'Mô tả phải là chuỗi',
            'mo_ta.max' => 'Mô tả không được vượt quá 255 ký tự',
        ];
    }
}
