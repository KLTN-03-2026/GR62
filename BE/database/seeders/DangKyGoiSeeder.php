<?php

namespace Database\Seeders;

use App\Models\DangKyGoi;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DangKyGoiSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'id_goi' => 1,
                'subscriber_type' => DangKyGoi::LOAI_NGUOI_DUNG,
                'subscriber_id' => 1,
                'purchased_by_user_id' => 1,
            ],
            [
                'id_goi' => 2,
                'subscriber_type' => DangKyGoi::LOAI_NGUOI_DUNG,
                'subscriber_id' => 2,
                'purchased_by_user_id' => 2,
            ],
            [
                'id_goi' => 3,
                'subscriber_type' => DangKyGoi::LOAI_DOI_TAC,
                'subscriber_id' => 1,
                'purchased_by_user_id' => 2,
            ],
        ];

        foreach ($rows as $index => $row) {
            $start = Carbon::now()->subDays(($index + 1) * 5)->startOfDay();
            $end = (clone $start)->addDays(30);

            DangKyGoi::updateOrCreate(
                [
                    'id_goi' => $row['id_goi'],
                    'subscriber_type' => $row['subscriber_type'],
                    'subscriber_id' => $row['subscriber_id'],
                ],
                [
                    'purchased_by_user_id' => $row['purchased_by_user_id'],
                    'ngay_bat_dau' => $start->toDateString(),
                    'ngay_ket_thuc' => $end->toDateString(),
                    'trang_thai' => true,
                    'is_active' => true,
                ]
            );
        }
    }
}
