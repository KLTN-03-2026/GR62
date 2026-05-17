<?php

namespace App\Http\Controllers;

use App\Models\DoiTac;
use App\Models\DoiTacThanhVien;
use App\Models\NguoiDung;
use App\Services\DangKyGoiService;
use App\Services\DoiTacThanhVienService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email khong duoc de trong',
            'email.email' => 'Email khong dung dinh dang',
            'password.required' => 'Mat khau khong duoc de trong',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $doiTac = DoiTac::where('email', $request->email)->first();
        $ownerUser = $doiTac ? $this->timNguoiDungSoHuuDoiTac($doiTac) : null;

        if (
            $doiTac &&
            Hash::check($request->password, $doiTac->password) &&
            $this->doiTacCoQuyenDangNhap($doiTac, $ownerUser)
        ) {
            if (!$doiTac->trang_thai) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tai khoan cua ban dang bi khoa',
                ], 403);
            }

            if ($ownerUser && (int) $doiTac->id_admin !== (int) $ownerUser->id) {
                $doiTac->id_admin = $ownerUser->id;
                $doiTac->save();
            }

            $doiTac->setAttribute('owner_user_id', $ownerUser?->id);
            $doiTac->setAttribute('account_type', 'doi_tac');
            $doiTac->setAttribute('is_doi_tac', true);

            return response()->json([
                'status' => true,
                'message' => 'Dang nhap thanh cong',
                'data' => [
                    'user' => $doiTac,
                    'token' => $doiTac->createToken('token_doi_tac')->plainTextToken,
                    'role' => 'doi_tac',
                    'type' => 'doi_tac',
                    'redirect_to' => '/doi-tac/trang-chinh',
                ],
            ]);
        }

        $user = NguoiDung::with(['chucVu', 'goi', 'doiTac'])
            ->where('email', $request->email)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Email hoac mat khau khong dung',
            ], 401);
        }

        if (!$user->trang_thai) {
            return response()->json([
                'status' => false,
                'message' => 'Tai khoan da bi khoa',
            ], 403);
        }

        $thanhVien = app(DoiTacThanhVienService::class)->layThanhVienHienTai($user);
        $role = $thanhVien && $thanhVien->vai_tro === DoiTacThanhVien::VAI_TRO_MEMBER
            ? 'thanh_vien_doi_tac'
            : 'nguoi_dung';
        $user->setAttribute('account_type', $role);
        $user->setAttribute('is_doi_tac', false);

        return response()->json([
            'status' => true,
            'message' => 'Dang nhap thanh cong',
            'data' => [
                'user' => $user,
                'token' => $user->createToken('API Token')->plainTextToken,
                'role' => $role,
                'type' => 'nguoi_dung',
                'redirect_to' => '/nguoi-dung/trang-chinh',
            ],
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

    private function doiTacCoQuyenDangNhap(DoiTac $doiTac, ?NguoiDung $ownerUser): bool
    {
        if (!$ownerUser) {
            return true;
        }

        if (app(DangKyGoiService::class)->layGoiDoiTacHieuLuc($doiTac)) {
            return true;
        }

        return (int) $ownerUser->id_doi_tac === (int) $doiTac->id;
    }
}
