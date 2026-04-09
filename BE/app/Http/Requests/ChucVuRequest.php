<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChucVuRequest extends FormRequest
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
            'ten_chuc_vu' => 'required|string|max:255',
            'mo_ta' => 'nullable|string',
            'id' => 'required|exists:chuc_vu,id',
            'keyword' => 'nullable|string|max:255',
        ];
    }
    public function messages(): array
    {
        return [
            'ten_chuc_vu.required' => 'Tên chức vụ không được để trống',
            'ten_chuc_vu.string'   => 'Tên chức vụ phải là một chuỗi',
            'ten_chuc_vu.max'      => 'Tên chức vụ không được vượt quá 255 ký tự',

            'mo_ta.string'         => 'Mô tả phải là một chuỗi',

            'id.required'          => 'ID không được để trống',
            'id.exists'            => 'ID không tồn tại trong cơ sở dữ liệu',

            'keyword.string'       => 'Từ khóa tìm kiếm phải là chuỗi',
            'keyword.max'          => 'Từ khóa tìm kiếm không được vượt quá 255 ký tự',
        ];
    }
}
