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
        ], [
            'email.required' => 'Email không được để trống',
            'email.email'    => 'Email không đúng định dạng',
            'password.required' => 'Mật khẩu không được để trống',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $doiTac = DoiTac::where('email', $request->email)->first();
        $ownerUser = $doiTac ? $this->timNguoiDungSoHuuDoiTac($doiTac) : null;

        if ($doiTac && $this->doiTacConHieuLuc($doiTac, $ownerUser)) {
            if (!Hash::check($request->password, $doiTac->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email hoặc mật khẩu không đúng'
                ], 401);
            }

            if (!$doiTac->trang_thai) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tài khoản của bạn đang bị khóa'
                ], 403);
            }

            if ($ownerUser) {
                if ((int) $doiTac->id_admin !== (int) $ownerUser->id) {
                    $doiTac->id_admin = $ownerUser->id;
                    $doiTac->save();
                }
            }

            $doiTac->setAttribute('owner_user_id', $ownerUser?->id);
            $doiTac->setAttribute('account_type', 'doi_tac');
            $doiTac->setAttribute('is_doi_tac', true);

            return response()->json([
                'status'  => true,
                'message' => 'Đăng nhập thành công',
                'data'    => [
                    'user'        => $doiTac,
                    'token'       => $doiTac->createToken('token_doi_tac')->plainTextToken,
                    'role'        => 'doi_tac',
                    'type'        => 'doi_tac',
                    'redirect_to' => '/doi-tac/trang-chinh',
                ]
            ]);
        }

        $user = NguoiDung::with(['chucVu', 'goi', 'doiTac'])->where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
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

        $role = ((int) $user->id_doi_tac > 0) ? 'thanh_vien_doi_tac' : 'nguoi_dung';
        $user->setAttribute('account_type', $role);
        $user->setAttribute('is_doi_tac', false);

        return response()->json([
            'status'  => true,
            'message' => 'Đăng nhập thành công',
            'data'    => [
                'user'        => $user,
                'token'       => $user->createToken('API Token')->plainTextToken,
                'role'        => $role,
                'type'        => 'nguoi_dung',
                'redirect_to' => '/nguoi-dung/trang-chinh',
            ]
        ]);
    }

    private function timNguoiDungSoHuuDoiTac(DoiTac $doiTac): ?NguoiDung
    {
        if ($doiTac->id_admin) {
            $ownerUser = NguoiDung::find($doiTac->id_admin);
            if ($ownerUser) {
                return $ownerUser;
            }
        }

        if ($doiTac->email) {
            return NguoiDung::where('email', $doiTac->email)->first();
        }

        return null;
    }

    private function doiTacConHieuLuc(DoiTac $doiTac, ?NguoiDung $ownerUser): bool
    {
        if (!$ownerUser) {
            return true;
        }

        return (int) $ownerUser->id_doi_tac === (int) $doiTac->id;
    }
}
