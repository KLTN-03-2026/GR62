<?php

namespace App\Http\Requests;

class DangKyGoiUpdateRequest extends DangKyGoiCreateRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'id' => 'required|integer|exists:dang_ky_gois,id',
        ]);
    }
}
