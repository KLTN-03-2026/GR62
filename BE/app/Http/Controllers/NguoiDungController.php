<?php

namespace App\Http\Controllers;

use App\Models\ChiTietGoi;
use App\Models\DoiTac;
use App\Models\Goi;
use App\Models\NguoiDung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PhanQuyen;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuenMatKhauMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\NguoiDung\StoreNguoiDungRequest;
use App\Http\Requests\NguoiDung\UpdateNguoiDungRequest;
use App\Http\Requests\NguoiDung\LoginNguoiDungRequest;
use App\Http\Requests\NguoiDung\RegisterNguoiDungRequest;
use App\Http\Requests\NguoiDung\QuenMatKhauRequest;
use App\Http\Requests\NguoiDung\ResetPasswordRequest;
use App\Http\Requests\NguoiDung\ChangePasswordRequest;
use App\Http\Requests\NguoiDung\UpdateProfileRequest;

class NguoiDungController extends Controller
{
    public function index()
    {
        // Lấy người dùng chính, loại bỏ nhân viên có chức vụ.
        $today = now()->toDateString();
        $data = NguoiDung::with([
            'doiTac',
            'goi',
            'chiTietGois' => function ($query) use ($today) {
                $query->with('goi')
                    ->where('is_nguoi_dung', true)
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
            },
        ])
            ->whereNull('id_chuc_vu')
            ->get();

        $this->ganGoiDangSoHuu($data);
            
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function store(StoreNguoiDungRequest $request)
    {
        $data = $request->all();
        $data['id_doi_tac'] = $request->id_doi_tac ?? 0;
        $data['id_chuc_vu'] = null;
        $res = NguoiDung::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Thêm mới thành công',
            'data' => $res
        ]);
    }

    public function update(UpdateNguoiDungRequest $request)
    {
        $data = NguoiDung::where('id', $request->id)
            ->whereNull('id_chuc_vu')
            ->first();
        if ($data) {
            $params = $request->only([
                'ho_va_ten',
                'email',
                'so_dien_thoai',
                'trang_thai',
            ]);
            $params['id_chuc_vu'] = null;

            if ($request->filled('password')) {
                $params['password'] = Hash::make($request->password);
            }

            $co_cap_nhat_goi = $request->has('id_goi');
            $goi = null;
            if ($co_cap_nhat_goi && $request->id_goi) {
                $goi = Goi::find($request->id_goi);
                $params['id_goi'] = $goi?->id;
            } elseif ($co_cap_nhat_goi) {
                $params['id_goi'] = null;
            }

            $data->update($params);

            if ($co_cap_nhat_goi) {
                $this->capNhatGoiNguoiDung($data, $goi);
            }

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
        $data = NguoiDung::where('id', $request->id)
            ->whereNull('id_chuc_vu')
            ->first();
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

    public function search(Request $request)
    {
        $today = now()->toDateString();
        $query = NguoiDung::with([
            'doiTac',
            'goi',
            'chiTietGois' => function ($query) use ($today) {
                $query->with('goi')
                    ->where('is_nguoi_dung', true)
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
            },
        ])
            ->whereNull('id_chuc_vu');
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('ho_va_ten', 'like', '%' . $keyword . '%');
                $q->orWhere('email', 'like', '%' . $keyword . '%');
                $q->orWhere('so_dien_thoai', 'like', '%' . $keyword . '%');
            });
        }
        $data = $query->get();
        $this->ganGoiDangSoHuu($data);
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function changeStatus(Request $request)
    {
        $data = NguoiDung::where('id', $request->id)
            ->whereNull('id_chuc_vu')
            ->first();
        if ($data) {
            $data->trang_thai = !$data->trang_thai;
            $data->save();
            return response()->json([
                'status' => true,
                'message' => 'Đã thay đổi trạng thái thành công'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Không tìm thấy dữ liệu'
        ]);
    }

    public function login(LoginNguoiDungRequest $request)
    {
        $user = NguoiDung::where('email', $request->email)->first();

        if (!$user || !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Email hoặc mật khẩu không đúng'
            ], 401);
        }

        if (!$user->trang_thai) {
            return response()->json([
                'status' => false,
                'message' => 'Tài khoản đã bị khóa'
            ], 403);
        }

        // Tạo token sử dụng Sanctum
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Đăng nhập thành công',
            'data' => [
                'user' => $user,
                'token' => $token,
            ]
        ]);
    }
    public function logout(Request $request)
    {
        // Xóa tất cả token của người dùng hiện tại
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Đăng xuất thành công'
        ]);
    }

    public function register(RegisterNguoiDungRequest $request)
    {
        $user = NguoiDung::create([
            'ho_va_ten'     => $request->ho_va_ten,
            'so_dien_thoai' => $request->so_dien_thoai,
            'email'         => $request->email,
            'password'      => \Illuminate\Support\Facades\Hash::make($request->password),
            'id_chuc_vu'    => null,
            'id_doi_tac'    => $request->id_doi_tac ?? 0, // Non-nullable boolean, default to 0
            'trang_thai'    => true, 
        ]);

        // Tạo token ngay sau khi đăng ký
        $token = $user->createToken('token_nguoi_dung')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Đăng ký thành công',
            'data' => [
                'user' => $user,
                'token' => $token,
            ]
        ], 201);
    }

    public function xacThucKhuonMat(Request $request)
    {
        // 1. Kiểm tra dữ liệu đầu vào
        $request->validate([
            'id' => 'required',
            'du_lieu_khuon_mat' => 'required'
        ]);

        // 2. GIẢI MÃ BẢO MẬT: Thêm tham số 'true' để ép kiểu chắc chắn ra Array (mảng chuẩn) thay vì Object.
        // Hỗ trợ luôn trường hợp Frontend/Axios tự động ép thành mảng trước khi gửi.
        $vector_moi = is_string($request->du_lieu_khuon_mat)
            ? json_decode($request->du_lieu_khuon_mat, true)
            : $request->du_lieu_khuon_mat;

        if (!is_array($vector_moi)) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi định dạng dữ liệu sinh trắc học.'
            ], 400);
        }

        // 3. KIỂM TRA TRÙNG LẶP (1:N Matching)
        $danh_sach_khac = NguoiDung::whereNotNull('du_lieu_khuon_mat')
            ->where('id', '!=', $request->id)
            ->get();

        foreach ($danh_sach_khac as $user_khac) {
            $vector_cu = is_string($user_khac->du_lieu_khuon_mat)
                ? json_decode($user_khac->du_lieu_khuon_mat, true)
                : $user_khac->du_lieu_khuon_mat;

            $khoang_cach = $this->tinhToanDistance($vector_moi, $vector_cu);

            // 4. TINH CHỈNH THRESHOLD:
            // Hạ ngưỡng từ 0.6 xuống 0.5 để siết chặt bảo mật. (Nhỏ hơn 0.5 chắc chắn là 1 người).
            // Tránh việc 2 người khác nhau bị nhận diện nhầm (False Positive).
            if ($khoang_cach < 0.50) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lỗi bảo mật! Sinh trắc học này đã được liên kết với một tài khoản khác trong hệ thống.'
                ], 400);
            }
        }

        // 5. LƯU DỮ LIỆU
        $nguoi_dung = NguoiDung::find($request->id);

        if ($nguoi_dung) {
            // Đảm bảo lưu vào DB dưới dạng chuỗi JSON nguyên bản
            $nguoi_dung->du_lieu_khuon_mat = is_array($request->du_lieu_khuon_mat)
                ? json_encode($request->du_lieu_khuon_mat)
                : $request->du_lieu_khuon_mat;

            $nguoi_dung->save();

            return response()->json([
                'success' => true,
                'message' => 'Đăng ký Face ID thành công!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Người dùng không tồn tại'
        ], 404);
    }


    public function quenMatKhau(QuenMatKhauRequest $request)
    {
        $user = NguoiDung::where('email', $request->email)->first();
        $otp = Str::upper(Str::random(6));
        $user->ma_quen_mat_khau = $otp;
        $user->save();

        Mail::to($user->email)->send(new QuenMatKhauMail($otp, $user->ho_va_ten));

        return response()->json([
            'status' => true,
            'message' => 'Mã xác nhận đã được gửi đến email của bạn'
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = NguoiDung::where('email', $request->email)
                         ->where('ma_quen_mat_khau', $request->ma_quen_mat_khau)
                         ->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Mã xác nhận không chính xác!'
            ], 400);
        }

        $user->password = Hash::make($request->password);
        $user->ma_quen_mat_khau = null;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Mật khẩu đã được cập nhật thành công'
        ]);
    }


    public function getProfile()
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Chưa đăng nhập'
            ], 401);
        }

        $today = now()->toDateString();
        $user->load([
            'goi',
            'chiTietGois' => function ($query) use ($today) {
                $query->with('goi')
                    ->where('is_nguoi_dung', true)
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
            },
        ]);
        $this->ganGoiDangSoHuu(collect([$user]));

        return response()->json([
            'status' => true,
            'data'   => [
                'id'        => $user->id,
                'ho_va_ten' => $user->ho_va_ten,
                'email'     => $user->email,
                'so_dien_thoai' => $user->so_dien_thoai,
                'id_goi'    => $user->id_goi,
                'id_doi_tac' => $user->id_doi_tac,
                'goi'       => $user->goi,
                'goi_dang_so_huu' => $user->goiDangSoHuu,
                'avatar'    => $user->avatar ? url($user->avatar) : null
            ]
        ]);
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Chưa đăng nhập'
            ], 401);
        }

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/avatars'), $filename);
            
            // Xóa ảnh cũ nếu có
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }

            $user->avatar = 'uploads/avatars/' . $filename;
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Cập nhật ảnh đại diện thành công',
                'avatar' => url($user->avatar)
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Lỗi khi tải ảnh'
        ], 400);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        /** @var \App\Models\NguoiDung $user */
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Chưa đăng nhập'
            ], 401);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Mật khẩu hiện tại không chính xác'
            ], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Đổi mật khẩu thành công'
        ]);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        /** @var \App\Models\NguoiDung $user */
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Chưa đăng nhập'
            ], 401);
        }

        $user->ho_va_ten = $request->ho_va_ten;
        $user->email = $request->email;
        $user->save();

        return response()->json([
            'status'  => true,
            'message' => 'Cập nhật thông tin hồ sơ thành công',
            'data'    => [
                'ho_va_ten' => $user->ho_va_ten,
                'email'     => $user->email
            ]
        ]);
    }

    /**
     * Hàm tính khoảng cách Euclid giữa 2 vector 128 chiều
     */
    private function tinhToanDistance($vectorA, $vectorB)
    {
        // Ràng buộc chặt chẽ đầu vào
        if (!is_array($vectorA) || !is_array($vectorB) || count($vectorA) === 0 || count($vectorA) !== count($vectorB)) {
            return 1.0;
        }

        $sum = 0;
        for ($i = 0; $i < count($vectorA); $i++) {
            // Ép kiểu float để toán học chính xác 100% khi trừ và bình phương
            $sum += pow((float)$vectorA[$i] - (float)$vectorB[$i], 2);
        }

        return sqrt($sum);
    }

    private function ganGoiDangSoHuu($danh_sach_nguoi_dung): void
    {
        $danh_sach_nguoi_dung->each(function ($nguoi_dung) {
            $goi_dang_so_huu = $nguoi_dung->chiTietGois
                ->pluck('goi')
                ->filter()
                ->unique('id')
                ->values();

            if ($goi_dang_so_huu->isEmpty() && $nguoi_dung->goi) {
                $goi_dang_so_huu->push($nguoi_dung->goi);
            }

            $nguoi_dung->setRelation('goiDangSoHuu', $goi_dang_so_huu);
        });
    }

    private function capNhatGoiNguoiDung(NguoiDung $nguoi_dung, ?Goi $goi): void
    {
        ChiTietGoi::where('id_nguoi_dung', $nguoi_dung->id)
            ->where('is_nguoi_dung', true)
            ->update([
                'trang_thai' => false,
                'is_active' => false,
            ]);

        if (!$goi) {
            $this->thuHoiDoiTacNeuLaChu($nguoi_dung);
            $nguoi_dung->id_goi = null;
            $nguoi_dung->save();
            return;
        }

        $ngay_bat_dau = now()->toDateString();
        $ngay_ket_thuc = $goi->thoi_han > 0
            ? now()->addDays($goi->thoi_han)->toDateString()
            : null;

        ChiTietGoi::updateOrCreate(
            [
                'id_goi' => $goi->id,
                'id_nguoi_dung' => $nguoi_dung->id,
                'is_nguoi_dung' => true,
            ],
            [
                'id_doi_tac' => null,
                'ngay_bat_dau' => $ngay_bat_dau,
                'ngay_ket_thuc' => $ngay_ket_thuc,
                'trang_thai' => true,
                'is_active' => true,
            ]
        );

        $nguoi_dung->id_goi = $goi->id;

        if ($this->laGoiDoiTac($goi)) {
            $doi_tac = DoiTac::firstOrNew(['email' => $nguoi_dung->email]);
            $doi_tac->fill([
                'id_admin' => $nguoi_dung->id,
                'ho_va_ten' => $nguoi_dung->ho_va_ten,
                'so_dien_thoai' => $nguoi_dung->so_dien_thoai,
                'password' => $nguoi_dung->password,
                'hinh_anh' => $nguoi_dung->avatar,
                'du_lieu_khuon_mat' => $nguoi_dung->du_lieu_khuon_mat,
                'trang_thai' => $nguoi_dung->trang_thai,
            ]);
            $doi_tac->save();

            $nguoi_dung->id_doi_tac = $doi_tac->id;
        } else {
            $this->thuHoiDoiTacNeuLaChu($nguoi_dung);
        }

        $nguoi_dung->save();
    }

    private function thuHoiDoiTacNeuLaChu(NguoiDung $nguoi_dung): void
    {
        $doi_tac = DoiTac::where('id_admin', $nguoi_dung->id)
            ->orWhere('email', $nguoi_dung->email)
            ->first();

        if ($doi_tac && (int) $nguoi_dung->id_doi_tac === (int) $doi_tac->id) {
            $nguoi_dung->id_doi_tac = 0;
            $doi_tac->tokens()->delete();
        }
    }

    private function laGoiDoiTac(Goi $goi): bool
    {
        $ten_goi = Str::lower(Str::ascii(trim($goi->ten_goi)));

        return in_array($ten_goi, ['business', 'doi tac', 'partner'], true);
    }
}
