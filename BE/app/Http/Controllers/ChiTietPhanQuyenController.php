<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChiTietPhanQuyenCreateRequest;
use App\Http\Requests\ChiTietPhanQuyenDeleteRequest;
use App\Http\Requests\ChiTietPhanQuyenRequest;
use App\Http\Requests\ChiTietPhanQuyenUpdateRequest;
use App\Models\ChiTietPhanQuyen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChiTietPhanQuyenController extends Controller
{
    public function index()
    {
        $data = ChiTietPhanQuyen::all();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function store(ChiTietPhanQuyenCreateRequest $request)
    {
        $login = Auth::guard('sanctum')->user();
        if (!$login || !$login->is_master) {
            return response()->json(['status' => false, 'message' => 'Bạn không có quyền thực hiện thao tác này!']);
        }
        $data = ChiTietPhanQuyen::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Thêm mới thành công',
            'data' => $data
        ]);
    }

    public function update(ChiTietPhanQuyenUpdateRequest $request)
    {
        $login = Auth::guard('sanctum')->user();
        if (!$login || !$login->is_master) {
            return response()->json(['status' => false, 'message' => 'Bạn không có quyền thực hiện thao tác này!']);
        }
        $data = ChiTietPhanQuyen::where('id', $request->id)->first();
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

    public function destroy(ChiTietPhanQuyenDeleteRequest $request)
    {
        $login = Auth::guard('sanctum')->user();
        if (!$login || !$login->is_master) {
            return response()->json(['status' => false, 'message' => 'Bạn không có quyền thực hiện thao tác này!']);
        }
        $data = ChiTietPhanQuyen::where('id', $request->id)->first();
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
}
