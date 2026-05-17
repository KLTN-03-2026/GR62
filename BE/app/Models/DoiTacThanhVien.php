<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DoiTacThanhVien extends Model
{
    public const VAI_TRO_OWNER = 'owner';
    public const VAI_TRO_MEMBER = 'member';
    public const TRANG_THAI_ACTIVE = 'active';
    public const TRANG_THAI_REMOVED = 'removed';

    protected $table = 'doi_tac_thanh_viens';

    protected $fillable = [
        'doi_tac_id',
        'nguoi_dung_id',
        'vai_tro',
        'trang_thai',
        'joined_at',
        'left_at',
    ];

    protected function casts(): array
    {
        return [
            'joined_at' => 'datetime',
            'left_at' => 'datetime',
        ];
    }

    public function doiTac()
    {
        return $this->belongsTo(DoiTac::class, 'doi_tac_id');
    }

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('trang_thai', self::TRANG_THAI_ACTIVE);
    }
}
