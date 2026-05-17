<?php

namespace App\Http\Controllers;

use App\Http\Requests\DangKyGoiChangeStatusRequest;
use App\Http\Requests\DangKyGoiCreateRequest;
use App\Http\Requests\DangKyGoiUpdateRequest;
use App\Models\DangKyGoi;
use Illuminate\Http\Request;

class DangKyGoiController extends Controller
{
    public function index()
    {
        $data = DangKyGoi::with(['goi', 'nguoiDung', 'doiTac', 'nguoiMua'])->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function store(DangKyGoiCreateRequest $request)
    {
        $data = DangKyGoi::create($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Them moi thanh cong',
            'data' => $data
        ]);
    }

    public function update(DangKyGoiUpdateRequest $request)
    {
        $data = DangKyGoi::where('id', $request->id)->first();
        if ($data) {
            $data->update($request->validated());

            return response()->json([
                'status' => true,
                'message' => 'Cap nhat thanh cong',
                'data' => $data
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Khong tim thay du lieu'
        ]);
    }

    public function destroy(Request $request)
    {
        $data = DangKyGoi::where('id', $request->id)->first();
        if ($data) {
            $data->delete();

            return response()->json([
                'status' => true,
                'message' => 'Xoa thanh cong'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Khong tim thay du lieu'
        ]);
    }

    public function changeStatus(DangKyGoiChangeStatusRequest $request)
    {
        $data = DangKyGoi::where('id', $request->id)->first();
        if ($data) {
            $data->trang_thai = !$data->trang_thai;
            $data->is_active = $data->trang_thai;
            $data->save();

            return response()->json([
                'status' => true,
                'message' => 'Da thay doi trang thai thanh cong'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Khong tim thay du lieu'
        ]);
    }
}
