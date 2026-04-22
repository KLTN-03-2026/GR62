<?php

namespace Database\Seeders;

use App\Models\ChiTietGoi;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ChiTietGoiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = [
            [
                'id_goi' => 1,
                'id_nguoi_dung' => 1,
                'id_doi_tac' => null,
                'is_nguoi_dung' => true,
            ],
            [
                'id_goi' => 2,
                'id_nguoi_dung' => 2,
                'id_doi_tac' => null,
                'is_nguoi_dung' => true,
            ],
            [
                'id_goi' => 4,
                'id_nguoi_dung' => null,
                'id_doi_tac' => 1,
                'is_nguoi_dung' => false,
            ],
            [
                'id_goi' => 3,
                'id_nguoi_dung' => 3,
                'id_doi_tac' => null,
                'is_nguoi_dung' => true,
            ],
        ];

        foreach ($rows as $index => $row) {
            $start = Carbon::now()->subDays(($index + 1) * 5)->startOfDay();
            $end = (clone $start)->addDays(30);

            ChiTietGoi::updateOrCreate(
                [
                    'id_goi' => $row['id_goi'],
                    'id_nguoi_dung' => $row['id_nguoi_dung'],
                    'id_doi_tac' => $row['id_doi_tac'],
                ],
                [
                    'ngay_bat_dau' => $start->toDateString(),
                    'ngay_ket_thuc' => $end->toDateString(),
                    'trang_thai' => true,
                    'is_active' => true,
                    'is_nguoi_dung' => $row['is_nguoi_dung'],
                ]
            );
        }
    }
}
