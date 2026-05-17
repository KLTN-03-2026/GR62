<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DangKyGoi extends Model
{
    public const LOAI_NGUOI_DUNG = 'nguoi_dung';
    public const LOAI_DOI_TAC = 'doi_tac';

    protected $table = 'dang_ky_gois';

    protected $fillable = [
        'id_goi',
        'subscriber_type',
        'subscriber_id',
        'id_nguoi_dung',
        'id_doi_tac',
        'purchased_by_user_id',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'trang_thai',
        'is_active',
        'is_nguoi_dung',
    ];

    protected function casts(): array
    {
        return [
            'ngay_bat_dau' => 'date',
            'ngay_ket_thuc' => 'date',
            'trang_thai' => 'boolean',
            'is_active' => 'boolean',
            'is_nguoi_dung' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (DangKyGoi $dangKyGoi) {
            $dangKyGoi->dongBoCotSoHuu();
        });
    }

    public function goi()
    {
        return $this->belongsTo(Goi::class, 'id_goi');
    }

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'id_nguoi_dung');
    }

    public function doiTac()
    {
        return $this->belongsTo(DoiTac::class, 'id_doi_tac');
    }

    public function nguoiMua()
    {
        return $this->belongsTo(NguoiDung::class, 'purchased_by_user_id');
    }

    public function scopeConHieuLuc(Builder $query, ?string $today = null): Builder
    {
        $today = $today ?: now()->toDateString();

        return $query
            ->where('is_active', true)
            ->where('trang_thai', true)
            ->where(function ($q) use ($today) {
                $q->whereNull('ngay_bat_dau')
                    ->orWhereDate('ngay_bat_dau', '<=', $today);
            })
            ->where(function ($q) use ($today) {
                $q->whereNull('ngay_ket_thuc')
                    ->orWhereDate('ngay_ket_thuc', '>=', $today);
            });
    }

    public function scopeCuaNguoiDung(Builder $query, int $nguoiDungId): Builder
    {
        return $query->where(function ($q) use ($nguoiDungId) {
            $q->where(function ($subQuery) use ($nguoiDungId) {
                $subQuery->where('subscriber_type', self::LOAI_NGUOI_DUNG)
                    ->where('subscriber_id', $nguoiDungId);
            })->orWhere('id_nguoi_dung', $nguoiDungId);
        });
    }

    public function scopeCuaDoiTac(Builder $query, int $doiTacId): Builder
    {
        return $query->where(function ($q) use ($doiTacId) {
            $q->where(function ($subQuery) use ($doiTacId) {
                $subQuery->where('subscriber_type', self::LOAI_DOI_TAC)
                    ->where('subscriber_id', $doiTacId);
            })->orWhere('id_doi_tac', $doiTacId);
        });
    }

    public function dongBoCotSoHuu(): void
    {
        if (!$this->subscriber_type || !$this->subscriber_id) {
            if ($this->id_doi_tac) {
                $this->subscriber_type = self::LOAI_DOI_TAC;
                $this->subscriber_id = $this->id_doi_tac;
            } elseif ($this->id_nguoi_dung) {
                $this->subscriber_type = self::LOAI_NGUOI_DUNG;
                $this->subscriber_id = $this->id_nguoi_dung;
            }
        }

        if ($this->subscriber_type === self::LOAI_NGUOI_DUNG) {
            $this->id_nguoi_dung = $this->subscriber_id;
            $this->id_doi_tac = null;
            $this->is_nguoi_dung = true;
        }

        if ($this->subscriber_type === self::LOAI_DOI_TAC) {
            $this->id_nguoi_dung = null;
            $this->id_doi_tac = $this->subscriber_id;
            $this->is_nguoi_dung = false;
        }
    }
}
