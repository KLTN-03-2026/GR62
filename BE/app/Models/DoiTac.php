<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class DoiTac extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'id_admin',
        'ho_va_ten',
        'so_dien_thoai',
        'email',
        'password',
        'dia_chi',
        'hinh_anh',
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
        ];
    }

    public function ownerUser()
    {
        return $this->belongsTo(NguoiDung::class, 'id_admin');
    }

    public function members()
    {
        return $this->hasMany(NguoiDung::class, 'id_doi_tac');
    }

    public function thanhViens()
    {
        return $this->hasMany(DoiTacThanhVien::class, 'doi_tac_id');
    }

    public function dangKyGois()
    {
        return $this->hasMany(DangKyGoi::class, 'subscriber_id')
            ->where('subscriber_type', DangKyGoi::LOAI_DOI_TAC);
    }
}
