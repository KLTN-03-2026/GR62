<?php

namespace App\Http\Controllers;

use App\Models\HoaDon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PhanQuyen;

class HoaDonController extends Controller
{
    public function index()
    {
        $data = HoaDon::with(['goi', 'nguoiDung'])->orderBy('id', 'desc')->get();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function getHistory()
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        }

        $data = HoaDon::where('id_nguoi_dung', $user->id)
                      ->with('goi')
                      ->orderBy('created_at', 'desc')
                      ->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $data = HoaDon::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Thêm mới thành công',
            'data' => $data
        ]);
    }

    public function update(Request $request)
    {
        $data = HoaDon::where('id', $request->id)->first();
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
        $data = HoaDon::where('id', $request->id)->first();
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
        $query = HoaDon::with(['goi', 'nguoiDung']);
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('ma_giao_dich', 'like', '%' . $keyword . '%')
                    ->orWhereHas('nguoiDung', function ($q2) use ($keyword) {
                        $q2->where('ho_va_ten', 'like', '%' . $keyword . '%')
                            ->orWhere('email', 'like', '%' . $keyword . '%');
                    });
            });
        }
        $data = $query->orderBy('id', 'desc')->get();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
}
