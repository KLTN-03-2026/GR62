<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class NguoiDung extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'id_chuc_vu',
        'id_doi_tac',
        'id_goi',
        'ho_va_ten',
        'so_dien_thoai',
        'email',
        'avatar',
        'password',
        'du_lieu_khuon_mat',
        'trang_thai',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'trang_thai' => 'boolean',
            'id_doi_tac' => 'integer',
        ];
    }

    public function doiTac()
    {
        return $this->belongsTo(DoiTac::class, 'id_doi_tac');
    }

    public function chucVu()
    {
        return $this->belongsTo(ChucVu::class, 'id_chuc_vu');
    }

    public function goi()
    {
        return $this->belongsTo(Goi::class, 'id_goi');
    }

    public function chiTietGois()
    {
        return $this->dangKyGois();
    }

    public function dangKyGois()
    {
        return $this->hasMany(DangKyGoi::class, 'subscriber_id')
            ->where('subscriber_type', DangKyGoi::LOAI_NGUOI_DUNG);
    }

    public function doiTacThanhViens()
    {
        return $this->hasMany(DoiTacThanhVien::class, 'nguoi_dung_id');
    }
}
