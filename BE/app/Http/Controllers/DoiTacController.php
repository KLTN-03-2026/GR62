<?php
namespace App\Http\Controllers;

use App\Models\DoiTac;
use App\Models\NguoiDung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DoiTacController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $doi_tac = DoiTac::where('email', $request->email)->first();

        if (!$doi_tac || !Hash::check($request->password, $doi_tac->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Email hoặc mật khẩu không đúng'
            ], 401);
        }

        if (!$doi_tac->trang_thai) {
            return response()->json([
                'status'  => false,
                'message' => 'Tài khoản của bạn đang bị khóa'
            ], 403);
        }

        $token = $doi_tac->createToken('token_doi_tac')->plainTextToken;

        return response()->json([
            'status'  => true,
            'message' => 'Đăng nhập thành công',
            'data'    => [
                'token'   => $token,
                'doi_tac' => $doi_tac
            ]
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ho_va_ten'     => 'required|min:2',
            'email'         => 'required|email|unique:doi_tacs,email',
            'so_dien_thoai' => 'required|numeric',
            'password'      => 'required|min:6',
            'dia_chi'       => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $doi_tac = DoiTac::create([
            'ho_va_ten'     => $request->ho_va_ten,
            'email'         => $request->email,
            'so_dien_thoai' => $request->so_dien_thoai,
            'dia_chi'       => $request->dia_chi,
            'password'      => Hash::make($request->password),
            'trang_thai'    => 1,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Đăng ký tài khoản đối tác thành công!',
            'data'    => $doi_tac
        ]);
    }

    public function getProfile(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'Token không hợp lệ hoặc đã hết hạn'
            ], 401);
        }

        // Nếu là NguoiDung, phải có quyền Đối tác (id_doi_tac = 1) mới được vào
        if ($user instanceof NguoiDung) {
            if ($user->id_doi_tac != 1) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Tài khoản của bạn chưa được nâng cấp lên Đối tác!'
                ], 403);
            }
            $user->hinh_anh = $user->avatar;
        }

        return response()->json([
            'status' => true,
            'data'   => $user
        ]);
    }

    public function updateAvatar(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'Token không hợp lệ'
            ], 401);
        }

        if ($request->hasFile('hinh_anh')) {
            $file = $request->file('hinh_anh');
            $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            
            $path = public_path('uploads/avatars');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            
            $file->move($path, $filename);

            // Xác định trường cần cập nhật dựa trên loại model
            if ($user instanceof NguoiDung) {
                // Xóa ảnh cũ của NguoiDung
                if ($user->avatar && file_exists(public_path($user->avatar))) {
                    unlink(public_path($user->avatar));
                }
                $user->avatar = 'uploads/avatars/' . $filename;
                $user->save();
                // Trả về hinh_anh để đồng bộ với phía FE đang dùng hinh_anh
                $return_filename = $user->avatar;
            } else {
                // Xóa ảnh cũ của DoiTac
                if ($user->hinh_anh && file_exists(public_path('uploads/avatars/' . $user->hinh_anh))) {
                    unlink(public_path('uploads/avatars/' . $user->hinh_anh));
                }
                $user->hinh_anh = $filename;
                $user->save();
                $return_filename = $filename;
            }

            return response()->json([
                'status'    => true,
                'message'   => 'Cập nhật ảnh đại diện thành công',
                'hinh_anh'  => $return_filename
            ]);
        }

        return response()->json([
            'status'  => false,
            'message' => 'Vui lòng chọn ảnh đại diện'
        ], 400);
    }

    public function updateProfile(Request $request)
    {
        $doi_tac = Auth::guard('sanctum')->user();
        if (!$doi_tac) {
            return response()->json([
                'status'  => false,
                'message' => 'Token không hợp lệ'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'ho_va_ten'     => 'required|min:2',
            'so_dien_thoai' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $doi_tac->ho_va_ten = $request->ho_va_ten;
        $doi_tac->so_dien_thoai = $request->so_dien_thoai;
        $doi_tac->save();

        return response()->json([
            'status'  => true,
            'message' => 'Cập nhật thông tin cá nhân thành công'
        ]);
    }

    public function updateFaceData(Request $request)
    {
        $doi_tac_hien_tai = Auth::guard('sanctum')->user();
        if (!$doi_tac_hien_tai) {
            return response()->json([
                'status'  => false,
                'message' => 'Token không hợp lệ'
            ], 401);
        }

        // 1. Kiểm tra đầu vào
        $request->validate([
            'face_data' => 'required'
        ]);

        $vector_moi = is_string($request->face_data)
            ? json_decode($request->face_data, true)
            : $request->face_data;

        if (!is_array($vector_moi)) {
            return response()->json([
                'status'  => false,
                'message' => 'Lỗi định dạng dữ liệu sinh trắc học.'
            ], 400);
        }

        // 2. Kiểm tra trùng lặp với các đối tác khác (Bảo mật 1:N)
        $danh_sach_doi_tac = DoiTac::whereNotNull('du_lieu_khuon_mat')
            ->where('id', '!=', $doi_tac_hien_tai->id)
            ->get();

        foreach ($danh_sach_doi_tac as $dt_khac) {
            $vector_cu = is_string($dt_khac->du_lieu_khuon_mat)
                ? json_decode($dt_khac->du_lieu_khuon_mat, true)
                : $dt_khac->du_lieu_khuon_mat;

            $khoang_cach = $this->tinhToanDistance($vector_moi, $vector_cu);

            // Ngưỡng 0.50 (càng nhỏ càng giống)
            if ($khoang_cach < 0.50) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Lỗi bảo mật! Khuôn mặt này đã được liên kết với một tài khoản đối tác khác.'
                ], 400);
            }
        }

        // 3. Lưu dữ liệu
        $doi_tac_hien_tai->du_lieu_khuon_mat = is_array($request->face_data)
            ? json_encode($request->face_data)
            : $request->face_data;

        $doi_tac_hien_tai->save();

        return response()->json([
            'status'  => true,
            'message' => 'Đăng ký Face ID doanh nghiệp thành công!'
        ]);
    }

    /**
     * Hàm tính khoảng cách Euclid giữa 2 vector 128 chiều (Biometrics)
     */
    private function tinhToanDistance($vectorA, $vectorB)
    {
        if (!is_array($vectorA) || !is_array($vectorB) || count($vectorA) === 0 || count($vectorA) !== count($vectorB)) {
            return 1.0;
        }

        $sum = 0;
        for ($i = 0; $i < count($vectorA); $i++) {
            $sum += pow((float)$vectorA[$i] - (float)$vectorB[$i], 2);
        }

        return sqrt($sum);
    }

    public function changePassword(Request $request)
    {
        $doi_tac = Auth::guard('sanctum')->user();
        if (!$doi_tac) {
            return response()->json([
                'status'  => false,
                'message' => 'Token không hợp lệ'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'old_password'     => 'required',
            'new_password'     => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        if (!Hash::check($request->old_password, $doi_tac->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Mật khẩu cũ không chính xác'
            ], 400);
        }

        $doi_tac->password = Hash::make($request->new_password);
        $doi_tac->save();

        return response()->json([
            'status'  => true,
            'message' => 'Đổi mật khẩu thành công'
        ]);
    }

    public function index()
    {
        $data = DoiTac::all();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $data = DoiTac::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Thêm mới thành công',
            'data' => $data
        ]);
    }

    public function update(Request $request)
    {
        $data = DoiTac::where('id', $request->id)->first();
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
        $data = DoiTac::where('id', $request->id)->first();
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
        $query = DoiTac::query();
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('ho_va_ten', 'like', '%' . $keyword . '%');
                $q->orWhere('email', 'like', '%' . $keyword . '%');
                $q->orWhere('so_dien_thoai', 'like', '%' . $keyword . '%');
            });
        }
        $data = $query->get();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function changeStatus(Request $request)
    {
        $data = DoiTac::where('id', $request->id)->first();
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
    
}
