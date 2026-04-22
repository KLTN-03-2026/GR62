<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\ChiTietPhanQuyen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\AdminLoginRequest;

class AdminController extends Controller
{
    public function index()
    {
        $id_chuc_nang = 1; 
        $login = Auth::guard('sanctum')->user();
        
        if (!$login->is_master) {
            $check_quyen = ChiTietPhanQuyen::where('id_chuc_vu', $login->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if (!$check_quyen) {
                return response()->json([
                    'status' => false,
                    'message' => "bạn không có quyền thực hiện chức năng này!"
                ]);
            }
        }
        
        $data = Admin::all();
        return response()->json([
            'status' => true,
            'data'   => $data
        ]);
    }

    public function store(Request $request)
    {
        $id_chuc_nang = 2; 
        $login = Auth::guard('sanctum')->user();
        
        if (!$login->is_master) {
            $check_quyen = ChiTietPhanQuyen::where('id_chuc_vu', $login->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if (!$check_quyen) {
                return response()->json([
                    'status' => false,
                    'message' => "bạn không có quyền thực hiện chức năng này!"
                ]);
            }
        }
        $data = Admin::create([
            'id_chuc_vu' => $request->id_chuc_vu,
            'ho_va_ten' => $request->ho_va_ten,
            'so_dien_thoai' => $request->so_dien_thoai,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_open' => $request->is_open ?? 1,
            'is_master' => $request->is_master ?? 0,
            'trang_thai' => $request->trang_thai ?? 1,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Thêm tài khoản admin ' . $data->ho_va_ten . ' thành công',
        ]);
    }

    public function update(Request $request)
    {
        $id_chuc_nang = 3; 
        $login = Auth::guard('sanctum')->user();
        
        if (!$login->is_master) {
            $check_quyen = ChiTietPhanQuyen::where('id_chuc_vu', $login->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if (!$check_quyen) {
                return response()->json([
                    'status' => false,
                    'message' => "bạn không có quyền thực hiện chức năng này!"
                ]);
            }
        }

        $updateData = [
            'id_chuc_vu' => $request->id_chuc_vu,
            'ho_va_ten' => $request->ho_va_ten,
            'so_dien_thoai' => $request->so_dien_thoai,
            'email' => $request->email,
            'is_open' => $request->is_open ?? 1,
            'is_master' => $request->is_master ?? 0,
            'trang_thai' => $request->trang_thai ?? 1,
        ];

        if ($request->has('password') && $request->password != '') {
            $updateData['password'] = Hash::make($request->password);
        }

        $data = Admin::where('id', $request->id)->update($updateData);

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật tài khoản admin ' . $request->ho_va_ten . ' thành công',
        ]);
    }

    public function destroy(Request $request)
    {
        $id_chuc_nang = 4; 
        $login = Auth::guard('sanctum')->user();
        
        if (!$login->is_master) {
            $check_quyen = ChiTietPhanQuyen::where('id_chuc_vu', $login->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if (!$check_quyen) {
                return response()->json([
                    'status' => false,
                    'message' => "bạn không có quyền thực hiện chức năng này!"
                ]);
            }
        }
        $data = Admin::where('id', $request->id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Xóa tài khoản admin thành công',
        ]);
    }

    public function changeStatus(Request $request)
    {
        $id_chuc_nang = 3; 
        $login = Auth::guard('sanctum')->user();
        
        if (!$login->is_master) {
            $check_quyen = ChiTietPhanQuyen::where('id_chuc_vu', $login->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if (!$check_quyen) {
                return response()->json([
                    'status' => false,
                    'message' => "bạn không có quyền thực hiện chức năng này!"
                ]);
            }
        }
        $data = Admin::where('id', $request->id)->first();
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
            'message' => 'Tài khoản không tồn tại'
        ]);
    }

    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $admin = Admin::where('email', $credentials['email'])->first();

        if (!$admin || !Hash::check($credentials['password'], $admin->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Thông tin đăng nhập không chính xác.',
            ], 401);
        }

        if ($admin->trang_thai != 1) {
            return response()->json([
                'status' => false,
                'message' => 'Tài khoản đã bị khóa.',
            ], 403);
        }

        $token = $admin->createToken('admin-token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Đăng nhập thành công.',
            'data' => [
                'admin' => $admin,
                'token' => $token,
            ],
        ]);
    }

    public function getProfile()
    {
        $admin = Auth::guard('sanctum')->user();
        return response()->json([
            'status' => true,
            'data'   => $admin,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $admin = Auth::guard('sanctum')->user();
        $admin->update([
            'ho_va_ten'     => $request->ho_va_ten,
            'so_dien_thoai' => $request->so_dien_thoai,
            'email'         => $request->email,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Cập nhật hồ sơ thành công',
        ]);
    }

    public function changePassword(Request $request)
    {
        $admin = Auth::guard('sanctum')->user();
        if (Hash::check($request->password, $admin->password)) {
            $admin->update([
                'password' => Hash::make($request->new_password),
            ]);
            return response()->json([
                'status'  => true,
                'message' => 'Đổi mật khẩu thành công',
            ]);
        }
        return response()->json([
            'status'  => false,
            'message' => 'Mật khẩu cũ không chính xác',
        ]);
    }
}
