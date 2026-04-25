<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NguoiDung;
use App\Models\DoiTac;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
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

        // 1. Kiểm tra bảng NguoiDung trước
        $user = NguoiDung::with('chucVu')->where('email', $request->email)->first();
        $role = null;
        $token = null;
        $type = null; // 'nguoi_dung' hoặc 'doi_tac' (table)

        if ($user) {
            if (!Hash::check($request->password, $user->password)) {
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

            // Nếu NguoiDung có id_doi_tac = 1 thì là Chủ Đối Tác -> role = 'doi_tac'
            // Nếu id_doi_tac > 1 (là id của Đối tác chủ) thì là Thành viên -> role = 'nguoi_dung'
            if ($user->id_doi_tac == 1) {
                $role = 'doi_tac';
            } else {
                $role = 'nguoi_dung';
            }
            $type = 'nguoi_dung';
            
            // Cấp token chung
            $token = $user->createToken('API Token')->plainTextToken;
            
        } else {
            // 2. Nếu không tìm thấy, kiểm tra bảng DoiTac
            $user = DoiTac::where('email', $request->email)->first();
            
            if ($user) {
                if (!Hash::check($request->password, $user->password)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Email hoặc mật khẩu không đúng'
                    ], 401);
                }

                if (!$user->trang_thai) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Tài khoản của bạn đang bị khóa'
                    ], 403);
                }

                $role = 'doi_tac';
                $type = 'doi_tac';
                $token = $user->createToken('token_doi_tac')->plainTextToken;
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Email hoặc mật khẩu không đúng'
                ], 401);
            }
        }

        return response()->json([
            'status'  => true,
            'message' => 'Đăng nhập thành công',
            'data'    => [
                'user'  => $user,
                'token' => $token,
                'role'  => $role,
                'type'  => $type
            ]
        ]);
    }
}
