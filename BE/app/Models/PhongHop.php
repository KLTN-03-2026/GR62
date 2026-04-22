<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhongHop extends Model
{
    protected $fillable = [
        'id_chu_phong',
        'ma_phong',
        'ten_phong',
        'so_nguoi_toi_da',
        'thoi_gian_bat_dau',
        'thoi_gian_ket_thuc',
        'trang_thai',
    ];

    protected function casts(): array
    {
        return [
            'thoi_gian_bat_dau' => 'datetime',
            'thoi_gian_ket_thuc' => 'datetime',
            'trang_thai' => 'boolean',
        ];
    }

    public function chuPhong()
    {
        return $this->belongsTo(NguoiDung::class, 'id_chu_phong');
    }
}
