<?php

namespace Database\Seeders;

use App\Models\ChatRoom;
use Illuminate\Database\Seeder;

class ChatRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $messages = [
            [
                'id_phong_hop' => 1,
                'id_chi_tiet' => 1,
                'id_nguoi_dung' => 1,
                'noi_dung' => 'Chao moi nguoi, chung ta bat dau hop nhe.',
            ],
            [
                'id_phong_hop' => 1,
                'id_chi_tiet' => 2,
                'id_nguoi_dung' => 2,
                'noi_dung' => 'Da ro, em da san sang cap nhat tien do.',
            ],
            [
                'id_phong_hop' => 2,
                'id_chi_tiet' => 3,
                'id_nguoi_dung' => 3,
                'noi_dung' => 'Team da fix xong cac loi blocker tuan nay.',
            ],
            [
                'id_phong_hop' => 3,
                'id_chi_tiet' => 4,
                'id_nguoi_dung' => 4,
                'noi_dung' => 'Ban demo da on dinh, co the trinh dien cho khach.',
            ],
        ];

        foreach ($messages as $message) {
            ChatRoom::create($message);
        }
    }
}
