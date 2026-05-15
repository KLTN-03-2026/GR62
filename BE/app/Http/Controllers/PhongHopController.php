<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhongHopCreateRequest;
use App\Http\Requests\PhongHopSearchRequest;
use App\Http\Requests\PhongHopUpdateRequest;
use App\Models\ChiTietPhongHop;
use App\Models\DoiTac;
use App\Models\Goi;
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

    public function getPhongHopLienQuan(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Token không hợp lệ'], 401);
        }

        $query = PhongHop::with('chuPhong')->where('trang_thai', 1);

        if ((int) $user->id_doi_tac > 0) {
            // Xác định ID của Chủ Đối Tác
            // Nếu id_doi_tac == 1, nghĩa là user này chính là Chủ Đối Tác, do đó ID của chủ là $user->id
            // Nếu id_doi_tac > 1, nghĩa là user này là Thành viên, ID của chủ là $user->id_doi_tac
            $doiTac = DoiTac::find((int) $user->id_doi_tac);
            $ownerId = $doiTac?->id_admin;
            
            // Lấy ID của tất cả thành viên thuộc Đối Tác này
            $memberIds = NguoiDung::where('id_doi_tac', (int) $user->id_doi_tac)->pluck('id')->toArray();
            
            // Bao gồm cả ID của Chủ Đối Tác và các thành viên
            $companyUserIds = collect([$ownerId])->merge($memberIds)->filter()->unique()->values()->all();

            // Lọc ra các phòng họp do những người trong công ty/đối tác này tạo
            $query->whereIn('id_chu_phong', $companyUserIds);
        } else {
            // Người dùng cơ bản (chỉ thấy phòng do chính mình tạo)
            $query->where('id_chu_phong', $user->id);
        }

        $data = $query->orderBy('created_at', 'desc')->get();

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

        $chuPhong = NguoiDung::find($request->id_chu_phong);
        $isBasic = $this->isBasicHost($chuPhong);

        // 3. Lưu vào Database
        $phongHop = PhongHop::create([
            'id_chu_phong'       => $request->id_chu_phong,
            'ma_phong'           => $ma_phong,
            'ten_phong'          => $request->ten_phong,
            'so_nguoi_toi_da'    => $isBasic ? min(5, (int)($request->so_nguoi_toi_da ?? 5)) : ($request->so_nguoi_toi_da ?? 100),
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
        $isBasic = $this->isBasicHost($chu_phong);

        // Kiểm tra số lượng người tham gia nếu là gói Basic
        $soNguoiHienTai = ChiTietPhongHop::where('id_phong_hop', $phong->id)
                                         ->where('is_active', true)
                                         ->count();
        if ($isBasic && $soNguoiHienTai >= 5) {
             return response()->json([
                'status' => false,
                'message' => 'Phòng họp đã đạt giới hạn 5 người của gói Basic!'
             ], 403);
        }

        // 2. Lấy thông tin bảo mật từ file .env
        $apiKey = env('LIVEKIT_API_KEY');
        $apiSecret = env('LIVEKIT_API_SECRET');

        if (!$apiKey || !$apiSecret) {
            return response()->json([
                'status' => false,
                'message' => 'Chưa cấu hình thẻ LIVEKIT_API_KEY trong file .env'
            ], 500);
        }

        // Gói Basic giới hạn 1 giờ, Pro 2 tiếng (hoặc hơn)
        $thoi_gian_hop = $isBasic ? (60 * 60) : (60 * 60 * 24);

        // 3. Chuẩn bị "Hành trang" (Payload) cho cái vé vào cửa theo chuẩn LiveKit
        $payload = [
            'iss' => $apiKey,                   // Ai phát hành vé? (Là bạn)
            'sub' => $request->user_name,       // Vé này cấp cho ai? (ID hoặc Tên)
            'nbf' => time(),                    // Có hiệu lực từ lúc nào? (Ngay bây giờ)
            'exp' => time() + $thoi_gian_hop,   // Hết hạn theo gói dịch vụ
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

    public function getPhongHopTheoDoiTac(Request $request)
    {
        $doiTac = Auth::guard('sanctum')->user();
        if (!$doiTac) {
            return response()->json([
                'status' => false,
                'message' => 'Token khong hop le'
            ], 401);
        }

        if (!$doiTac instanceof DoiTac) {
            return response()->json([
                'status' => false,
                'message' => 'Chi chu doi tac moi duoc xem danh sach phong hop to chuc.'
            ], 403);
        }

        $companyUserIds = $this->getCompanyUserIdsForPartner($doiTac);

        $data = empty($companyUserIds)
            ? collect()
            : PhongHop::with('chuPhong')
                ->whereIn('id_chu_phong', $companyUserIds)
                ->orderBy('id', 'desc')
                ->get();

        return response()->json([
            'status' => true,
            'data'   => $data
        ]);
    }

    public function getLichSuThamGia(Request $request)
    {
        $request->validate(['id_nguoi_dung' => 'required|integer']);
        $id_nguoi_dung = $request->id_nguoi_dung;

        $logs = ChiTietPhongHop::with(['phongHop.chuPhong'])
            ->where('id_nguoi_dung', $id_nguoi_dung)
            ->whereHas('phongHop')
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($chiTiet) {
                $phong = $chiTiet->phongHop;
                
                $thoi_luong_str = 'Đang diễn ra';
                if ($phong->thoi_gian_bat_dau && $phong->thoi_gian_ket_thuc) {
                    $bat_dau = \Carbon\Carbon::parse($phong->thoi_gian_bat_dau);
                    $ket_thuc = \Carbon\Carbon::parse($phong->thoi_gian_ket_thuc);
                    $thoi_luong_phut = $bat_dau->diffInMinutes($ket_thuc);
                    $gio = intdiv($thoi_luong_phut, 60);
                    $phut = $thoi_luong_phut % 60;
                    $thoi_luong_str = $gio > 0 ? "{$gio}g {$phut}p" : "{$phut} phút";
                }

                return [
                    'id' => $phong->id,
                    'ten_phong' => $phong->ten_phong,
                    'ma_phong' => $phong->ma_phong,
                    'chu_phong' => $phong->chuPhong ? $phong->chuPhong->ho_va_ten : 'N/A',
                    'thoi_gian_bat_dau' => $phong->thoi_gian_bat_dau,
                    'thoi_gian_ket_thuc' => $phong->thoi_gian_ket_thuc,
                    'thoi_luong' => $thoi_luong_str,
                    'trang_thai' => $phong->trang_thai,
                    'vai_tro' => ($phong->id_chu_phong == $chiTiet->id_nguoi_dung) ? 'Chủ phòng' : 'Thành viên'
                ];
            });

        // Loại bỏ trùng lặp nếu tham gia nhiều lần
        $uniqueLogs = collect($logs)->unique('id')->values();

        return response()->json([
            'status' => true,
            'data' => $uniqueLogs
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
        $doiTac = Auth::guard('sanctum')->user();
        if (!$doiTac) {
            return response()->json([
                'status' => false,
                'message' => 'Token khong hop le'
            ], 401);
        }

        if (!$doiTac instanceof DoiTac) {
            return response()->json([
                'status' => false,
                'message' => 'Chi chu doi tac moi duoc xem bao cao to chuc.'
            ], 403);
        }

        $companyUserIds = $this->getCompanyUserIdsForPartner($doiTac);

        $phong_list = empty($companyUserIds)
            ? collect()
            : PhongHop::with('chuPhong')
                ->whereIn('id_chu_phong', $companyUserIds)
                ->orderBy('thoi_gian_bat_dau', 'desc')
                ->get();

        $logs = $phong_list->map(function ($phong) {
            // Số người tham gia thực tế từ ChiTietPhongHop
            $so_nguoi = ChiTietPhongHop::where('id_phong_hop', $phong->id)->count();

            // Tính thời lượng thực tế
            $bat_dau = null;
            $ket_thuc = null;
            $thoi_luong_phut = 0;
            $thoi_luong_str = $phong->trang_thai ? 'Đang diễn ra' : '0 phút';
            if ($phong->thoi_gian_bat_dau) {
                $bat_dau = Carbon::parse($phong->thoi_gian_bat_dau);
                $ket_thuc = $phong->thoi_gian_ket_thuc
                    ? Carbon::parse($phong->thoi_gian_ket_thuc)
                    : ($phong->trang_thai && $bat_dau->lessThanOrEqualTo(Carbon::now()) ? Carbon::now() : null);
            }

            if ($bat_dau && $ket_thuc && $ket_thuc->greaterThan($bat_dau)) {
                $thoi_luong_phut = (int) $bat_dau->diffInMinutes($ket_thuc);
                $gio  = intdiv($thoi_luong_phut, 60);
                $phut = $thoi_luong_phut % 60;
                $thoi_luong_str = $gio > 0 ? "{$gio}g {$phut}p" : "{$phut} phút";
            } elseif ($bat_dau && $phong->trang_thai && $bat_dau->greaterThan(Carbon::now())) {
                $thoi_luong_str = 'Chưa bắt đầu';
            }

            return [
                'id'             => $phong->id,
                'ten_phong'      => $phong->ten_phong,
                'ma_phong'       => $phong->ma_phong,
                'chu_phong'      => $phong->chuPhong?->ho_va_ten ?? 'N/A',
                'trang_thai'     => $phong->trang_thai,
                'bat_dau'        => $phong->thoi_gian_bat_dau,
                'ket_thuc'       => $phong->thoi_gian_ket_thuc,
                'thoi_luong'     => $thoi_luong_str,
                'thoi_luong_phut'=> $thoi_luong_phut,
                'so_nguoi'       => $so_nguoi,
            ];
        })->values();

        // Tổng hợp metrics
        $tong_cuoc_hop   = $phong_list->count();
        $tong_phut       = $logs->sum('thoi_luong_phut');
        $tong_gio        = round($tong_phut / 60, 1);
        $tong_nguoi      = $logs->sum('so_nguoi');
        $tb_phut         = $tong_cuoc_hop > 0 ? round($tong_phut / $tong_cuoc_hop) : 0;
        $phongIds        = $phong_list->pluck('id');

        $topParticipantRow = $phongIds->isEmpty()
            ? null
            : ChiTietPhongHop::with('nguoiDung')
                ->select('id_nguoi_dung')
                ->selectRaw('COUNT(DISTINCT id_phong_hop) as so_cuoc_hop')
                ->whereIn('id_phong_hop', $phongIds)
                ->groupBy('id_nguoi_dung')
                ->orderByDesc('so_cuoc_hop')
                ->orderBy('id_nguoi_dung')
                ->first();

        $top_participant = $topParticipantRow ? [
            'id'          => $topParticipantRow->id_nguoi_dung,
            'ho_va_ten'   => $topParticipantRow->nguoiDung?->ho_va_ten ?? 'N/A',
            'email'       => $topParticipantRow->nguoiDung?->email,
            'so_cuoc_hop' => (int) $topParticipantRow->so_cuoc_hop,
        ] : null;

        // Dữ liệu biểu đồ 7 ngày gần nhất
        $chart_data = [];
        $chart_labels = [];
        for ($i = 6; $i >= 0; $i--) {
            $ngay = Carbon::now()->subDays($i);
            $chart_labels[] = $ngay->format('d/m');
            $chart_data[] = $phong_list
                ->filter(fn ($phong) => $phong->thoi_gian_bat_dau && Carbon::parse($phong->thoi_gian_bat_dau)->isSameDay($ngay))
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
                'top_participant'=> $top_participant,
                'chart_labels'   => $chart_labels,
                'chart_data'     => $chart_data,
            ]
        ]);
    }

    private function getCompanyUserIdsForPartner(DoiTac $doiTac): array
    {
        $ownerId = $doiTac->id_admin;
        if (!$ownerId && $doiTac->email) {
            $ownerId = NguoiDung::where('email', $doiTac->email)->value('id');
        }

        $memberIds = NguoiDung::whereRaw('CAST(id_doi_tac AS UNSIGNED) = ?', [(int) $doiTac->id])
            ->pluck('id');

        return collect([$ownerId])
            ->merge($memberIds)
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->all();
    }

    private function isBasicHost(?NguoiDung $host): bool
    {
        if (!$host) {
            return true;
        }

        $goi = $host->goi ?? ($host->id_goi ? Goi::find($host->id_goi) : null);

        if (!$goi && (int) $host->id_doi_tac > 0) {
            $doiTac = DoiTac::find((int) $host->id_doi_tac);
            $owner = $doiTac?->id_admin ? NguoiDung::find($doiTac->id_admin) : null;
            $goi = $owner?->goi ?? ($owner?->id_goi ? Goi::find($owner->id_goi) : null);
        }

        if (!$goi) {
            return true;
        }

        $tenGoi = strtolower(trim($goi->ten_goi));

        return $tenGoi === 'basic' || $tenGoi === 'starter' || (int) $goi->id === 1;
    }
}
