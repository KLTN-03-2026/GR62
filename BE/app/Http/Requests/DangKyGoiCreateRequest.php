<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class DangKyGoiCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_goi' => 'required|integer|exists:gois,id',
            'subscriber_type' => 'nullable|in:nguoi_dung,doi_tac',
            'subscriber_id' => 'nullable|integer',
            'id_nguoi_dung' => 'nullable|integer|exists:nguoi_dungs,id',
            'id_doi_tac' => 'nullable|integer|exists:doi_tacs,id',
            'purchased_by_user_id' => 'nullable|integer|exists:nguoi_dungs,id',
            'ngay_bat_dau' => 'nullable|date',
            'ngay_ket_thuc' => 'nullable|date|after_or_equal:ngay_bat_dau',
            'trang_thai' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'is_nguoi_dung' => 'nullable|boolean',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $coSubscriberMoi = $this->filled('subscriber_type') && $this->filled('subscriber_id');
            $coNguoiDungCu = $this->filled('id_nguoi_dung');
            $coDoiTacCu = $this->filled('id_doi_tac');

            if (!$coSubscriberMoi && !$coNguoiDungCu && !$coDoiTacCu) {
                $validator->errors()->add('subscriber_id', 'Vui long chon nguoi dung hoac doi tac dang ky goi.');
            }
        });
    }
}
