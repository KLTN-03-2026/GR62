<?php

namespace App\Http\Controllers;

use App\Models\ChucVu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PhanQuyen;

use App\Http\Requests\ChucVuStoreRequest;
use App\Http\Requests\ChucVuUpdateRequest;
use App\Http\Requests\ChucVuDestroyRequest;
use App\Http\Requests\ChucVuSearchRequest;

class ChucVuController extends Controller
{
    public function index()
    {
        $data = ChucVu::all();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function store(ChucVuStoreRequest $request)
    {
        $login = Auth::guard('sanctum')->user();
        if (!$login || !$login->is_master) {
            return response()->json(['status' => false, 'message' => 'Bạn không có quyền thực hiện thao tác này!']);
        }
        $data = ChucVu::create($request->validated());
        return response()->json([
            'status' => true,
            'message' => 'Thêm mới thành công',
            'data' => $data
        ]);
    }

    public function update(ChucVuUpdateRequest $request)
    {
        $login = Auth::guard('sanctum')->user();
        if (!$login || !$login->is_master) {
            return response()->json(['status' => false, 'message' => 'Bạn không có quyền thực hiện thao tác này!']);
        }
        $data = ChucVu::where('id', $request->id)->first();
        if ($data) {
            $data->update($request->validated());
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

    public function search(ChucVuSearchRequest $request)
    {
        $query = ChucVu::query();
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('ten_chuc_vu', 'like', '%' . $keyword . '%');
                $q->orWhere('mo_ta', 'like', '%' . $keyword . '%');
            });
        }
        $data = $query->get();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
}
