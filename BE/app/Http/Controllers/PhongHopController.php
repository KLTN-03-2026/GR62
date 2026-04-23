<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhongHopCreateRequest;
use App\Http\Requests\PhongHopSearchRequest;
use App\Http\Requests\PhongHopUpdateRequest;
use App\Models\ChiTietPhongHop;
use App\Models\NguoiDung;
use App\Models\PhongHop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PhanQuyen;
use Firebase\JWT\JWT;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\MoiThamGiaMail;
use Illuminate\Support\Str;
use LiveKit\RoomServiceClient;

class PhongHopController extends Controller
{
    public function index()
    {
        $data = PhongHop::with('chuPhong')->get();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function store(PhongHopCreateRequest $request)
    {

        // 2. Tự động sinh ma_phong duy nhất (VD: xya-qwer-zxc)
        do {
            $ma_phong = strtolower(Str::random(3) . '-' . Str::random(4) . '-' . Str::random(3));
        } while (PhongHop::where('ma_phong', $ma_phong)->exists());

        // 3. Lưu vào Database
        $phongHop = PhongHop::create([
            'id_chu_phong'       => $request->id_chu_phong,
            'ma_phong'           => $ma_phong,
            'ten_phong'          => $request->ten_phong,
            'so_nguoi_toi_da'    => $request->so_nguoi_toi_da ?? 100, // Mặc định 100 người nếu không nhập
            'thoi_gian_bat_dau'  => $request->thoi_gian_bat_dau ?? now(),
            'thoi_gian_ket_thuc' => $request->thoi_gian_ket_thuc,
            'trang_thai'         => 1, // 1: Đang hoạt động
        ]);
        // 4. Xử lý mời người (nếu có email_khach_moi) + Gửi email thông báo
        $emailsNotFound = [];
        if ($request->has('email_khach_moi') && !empty($request->email_khach_moi)) {
            $emailString = $request->email_khach_moi;
            $emailArray = array_filter(array_map('trim', explode(',', $emailString)));

            // Lấy tên người tổ chức để ghi vào email
            $chuPhong = NguoiDung::find($request->id_chu_phong);
            $tenNguoiMoi = $chuPhong ? $chuPhong->ho_va_ten : 'Đối tác';

            foreach ($emailArray as $email) {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) continue;

                $user = NguoiDung::where('email', $email)->first();

                if ($user) {
                    // Email có trong hệ thống → thêm vào ChiTietPhongHop
                    ChiTietPhongHop::firstOrCreate(
                        ['id_nguoi_dung' => $user->id, 'id_phong_hop' => $phongHop->id],
                        [
                            'xac_thuc_khuon_mat' => false,
                            'is_vi_pham'         => false,
                            'is_nguoi_dung'      => true,
                            'is_active'          => false,
                            'trang_thai'         => true,
                        ]
                    );
                }
                // Dù có hay không có trong hệ thống → đều gửi email mời
                try {
                    Mail::to($email)->send(new MoiThamGiaMail(
                        $phongHop->ten_phong,
                        $phongHop->ma_phong,
                        $tenNguoiMoi,
                        $user ? $user->ho_va_ten : $email
                    ));
                } catch (\Exception $mailEx) {
                    Log::warning('Không gửi được email mời cho ' . $email . ': ' . $mailEx->getMessage());
                    $emailsNotFound[] = $email . ' (lỗi gửi mail)';
                }
            }
        }

        return response()->json([
            'status'  => true,
            'message' => empty($emailsNotFound)
                            ? 'Tạo phòng họp thành công!'
                            : 'Tạo phòng thành công, lỗi gửi email: ' . implode(', ', $emailsNotFound),
            'data'    => $phongHop
        ]);
    }

    public function update(PhongHopUpdateRequest $request)
    {
        $data = PhongHop::where('id', $request->id)->first();
        if ($data) {
            $data->update($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật thành công',
                'data' => $data
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Không tìm thấy dữ liệu'
        ]);
    }

    public function destroy(Request $request)
    {
        $data = PhongHop::where('id', $request->id)->first();
        if ($data) {
            $data->delete();
            return response()->json([
                'status' => true,
                'message' => 'Xóa thành công'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Không tìm thấy dữ liệu'
        ]);
    }

    public function search(PhongHopSearchRequest $request)
    {
        $query = PhongHop::query();
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('ten_phong', 'like', '%' . $keyword . '%');
                $q->orWhere('ma_phong', 'like', '%' . $keyword . '%');
            });
        }
        $data = $query->get();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function getByMaPhong($maPhong)
    {
        $data = PhongHop::where('ma_phong', $maPhong)->first();
        if ($data) {
            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Không tìm thấy phòng họp với mã: ' . $maPhong
        ]);
    }

    public function changeStatus(Request $request)
    {
        $data = PhongHop::where('id', $request->id)->first();
        if ($data) {
            $data->trang_thai = !$data->trang_thai;
            if ($data->trang_thai == false) {
                $data->thoi_gian_ket_thuc = now();
            } else {
                $data->thoi_gian_ket_thuc = null;
            }
            $data->save();
            return response()->json([
                'status' => true,
                'message' => 'Đã cập nhật trạng thái phòng họp thành công'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Không tìm thấy dữ liệu'
        ]);
    }
    public function taoToken(Request $request)
    {
        // 1. Kiểm tra xem Frontend có gửi đủ mã phòng và tên người dùng không
        $request->validate([
            'ma_phong' => 'required|string',
            'user_name' => 'required|string'
        ]);
        $ma_phong = $request->ma_phong;
        $phong = PhongHop::where('ma_phong', $ma_phong)->first();
        if (!$phong) {
            return response()->json([
                'status' => false,
                'message' => 'Mã phòng họp không tồn tại!'
            ], 404);
        }

        // 1. Lấy thông tin chủ phòng để kiểm tra gói dịch vụ
        $chu_phong = NguoiDung::find($phong->id_chu_phong);
        // 2. Lấy thông tin bảo mật từ file .env
        $apiKey = env('LIVEKIT_API_KEY');
        $apiSecret = env('LIVEKIT_API_SECRET');

        if (!$apiKey || !$apiSecret) {
            return response()->json([
                'status' => false,
                'message' => 'Chưa cấu hình thẻ LIVEKIT_API_KEY trong file .env'
            ], 500);
        }

        // 3. Chuẩn bị "Hành trang" (Payload) cho cái vé vào cửa theo chuẩn LiveKit
        $payload = [
            'iss' => $apiKey,                   // Ai phát hành vé? (Là bạn)
            'sub' => $request->user_name,       // Vé này cấp cho ai? (ID hoặc Tên)
            'nbf' => time(),                    // Có hiệu lực từ lúc nào? (Ngay bây giờ)
            'exp' => time() + (60 * 60 * 2),    // Hết hạn khi nào? (Cho phép họp tối đa 2 tiếng)
            'video' => [
                'roomJoin' => true,             // Quyền: Được phép vào phòng
                'room' => $request->ma_phong,   // Cụ thể là phòng nào?
            ],
            'name' => $request->user_name,      // Tên hiển thị trong phòng họp
        ];

        try {
            // 4. "Đóng dấu" vé bằng thuật toán HS256 và Secret Key
            $token = JWT::encode($payload, $apiSecret, 'HS256');

            return response()->json([
                'status' => true,
                'message' => 'Cấp quyền vào phòng thành công!',
                'token' => $token,
                'id_phong_hop' => $phong->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Lỗi tạo Token: ' . $e->getMessage()
            ], 500);
        }
    }
    public function kiemTraPhongHop(Request $request)
    {
        $request->validate([
            'ma_phong' => 'required'
        ]);
        $check_ma_phong = PhongHop::where('ma_phong', $request->ma_phong)->first();
        if (!$check_ma_phong) {
            return response()->json([
                'status'  => false,
                'message' => 'Mã phòng họp "' . $request->ma_phong . '" không tồn tại'
            ], 404);
        } else {
            return response()->json([
                'status'  => true,
            ], 200);
        }
    }
    public function getDataByChuPhong(Request $request)
    {
        $request->validate([
            'id_chu_phong' => 'required|integer'
        ]);

        $data = PhongHop::with('chuPhong')
                        ->where('id_chu_phong', $request->id_chu_phong)
                        ->orderBy('id', 'desc')
                        ->get();

        return response()->json([
            'status' => true,
            'data'   => $data
        ]);
    }

    public function roiPhongHop(Request $request)
    {
        try {
            ChiTietPhongHop::where('id_phong_hop', $request->id_phong_hop)
                ->where('id_nguoi_dung', $request->id_nguoi_dung)
                ->update(['is_active' => false]);

            $soNguoiConLai = ChiTietPhongHop::where('id_phong_hop', $request->id_phong_hop)
                ->where('is_active', true)
                ->count();

            if ($soNguoiConLai == 0) {
                PhongHop::where('id', $request->id_phong_hop)->update([
                    'thoi_gian_ket_thuc' => \Carbon\Carbon::now(),
                    'trang_thai' => false
                ]);
            }
            return response()->json([
                'status' => true,
                'message' => 'Đã rời phòng và cập nhật lịch sử thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Lỗi khi cập nhật rời phòng: ' . $e->getMessage()
            ], 500);
        }
    }
    public function livekitWebhook(Request $request)
    {
        $payload = $request->all();

        // Ghi log
        Log::info('LiveKit Webhook Received:', $payload);

        $event = $payload['event'] ?? null;
        if (!$event) {
            return response()->json(['status' => false, 'message' => 'No event type']);
        }

        // xuất Mã phòng
        $ma_phong = $payload['room']['name'] ?? null;
        $phong = PhongHop::where('ma_phong', $ma_phong)->first();

        if (!$phong) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy phòng trong DB']);
        }

        // XỬ LÝ SỰ KIỆN: 1 NGƯỜI DÙNG THOÁT HOẶC RỚT MẠNG
        if ($event === 'participant_left' || $event === 'participant_disconnected') {
            // Lấy identity của người dùng
            $userName = $payload['participant']['identity'] ?? null;

            // Tìm ID người dùng dựa vào tên
            $user = NguoiDung::where('ho_va_ten', $userName)->first();

            if ($user) {
                ChiTietPhongHop::where('id_phong_hop', $phong->id)
                    ->where('id_nguoi_dung', $user->id)
                    ->update(['is_active' => false]);
            }
        }

        // XỬ LÝ SỰ KIỆN: PHÒNG HỌP CHÍNH THỨC KẾT THÚC (Mọi người đã thoát hết)
        if ($event === 'room_finished') {
            // Cập nhật thời gian kết thúc vào bảng phong_hops
            $phong->update([
                'thoi_gian_ket_thuc' => Carbon::now(),
                'trang_thai' => false // Đóng phòng
            ]);

            // Quét sạch: Đảm bảo mọi người trong phòng này đều được update thành is_active = 0
            ChiTietPhongHop::where('id_phong_hop', $phong->id)
                ->update(['is_active' => false]);
        }
        // Trả về 200
        return response()->json(['status' => true]);
    }

    /**
     * API Báo cáo chi tiết cho Đối tác: thời lượng thực tế + số người thực từ ChiTietPhongHop
     */
    public function getThongKeBaoCao(Request $request)
    {
        $request->validate(['id_chu_phong' => 'required|integer']);
        $id_chu_phong = $request->id_chu_phong;

        $phong_list = PhongHop::where('id_chu_phong', $id_chu_phong)
            ->orderBy('thoi_gian_bat_dau', 'desc')
            ->get();

        $logs = $phong_list->map(function ($phong) {
            // Số người tham gia thực tế từ ChiTietPhongHop
            $so_nguoi = ChiTietPhongHop::where('id_phong_hop', $phong->id)->count();

            // Tính thời lượng thực tế
            $thoi_luong_phut = 0;
            $thoi_luong_str  = 'Đang diễn ra';
            if ($phong->thoi_gian_bat_dau && $phong->thoi_gian_ket_thuc) {
                $bat_dau     = Carbon::parse($phong->thoi_gian_bat_dau);
                $ket_thuc    = Carbon::parse($phong->thoi_gian_ket_thuc);
                $thoi_luong_phut = $bat_dau->diffInMinutes($ket_thuc);
                $gio  = intdiv($thoi_luong_phut, 60);
                $phut = $thoi_luong_phut % 60;
                $thoi_luong_str = $gio > 0 ? "{$gio}g {$phut}p" : "{$phut} phút";
            }

            return [
                'id'             => $phong->id,
                'ten_phong'      => $phong->ten_phong,
                'ma_phong'       => $phong->ma_phong,
                'trang_thai'     => $phong->trang_thai,
                'bat_dau'        => $phong->thoi_gian_bat_dau,
                'ket_thuc'       => $phong->thoi_gian_ket_thuc,
                'thoi_luong'     => $thoi_luong_str,
                'thoi_luong_phut'=> $thoi_luong_phut,
                'so_nguoi'       => $so_nguoi,
            ];
        });

        // Tổng hợp metrics
        $tong_cuoc_hop   = $phong_list->count();
        $tong_phut       = $logs->sum('thoi_luong_phut');
        $tong_gio        = round($tong_phut / 60, 1);
        $tong_nguoi      = $logs->sum('so_nguoi');
        $tb_phut         = $tong_cuoc_hop > 0 ? round($tong_phut / $tong_cuoc_hop) : 0;

        // Dữ liệu biểu đồ 7 ngày gần nhất
        $chart_data = [];
        $chart_labels = [];
        for ($i = 6; $i >= 0; $i--) {
            $ngay = Carbon::now()->subDays($i);
            $chart_labels[] = $ngay->format('d/m');
            $chart_data[] = PhongHop::where('id_chu_phong', $id_chu_phong)
                ->whereDate('thoi_gian_bat_dau', $ngay->toDateString())
                ->count();
        }

        return response()->json([
            'status' => true,
            'data'   => [
                'tong_cuoc_hop'  => $tong_cuoc_hop,
                'tong_gio'       => $tong_gio,
                'tong_nguoi'     => $tong_nguoi,
                'tb_phut'        => $tb_phut,
                'logs'           => $logs,
                'chart_labels'   => $chart_labels,
                'chart_data'     => $chart_data,
            ]
        ]);
    }
}
