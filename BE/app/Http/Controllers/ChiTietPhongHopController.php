<?php

namespace App\Http\Controllers;

use App\Models\ChiTietPhongHop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PhanQuyen;

class ChiTietPhongHopController extends Controller
{
    public function index(Request $request)
    {
        $query = ChiTietPhongHop::join('phong_hops', 'chi_tiet_phong_hops.id_phong_hop', '=', 'phong_hops.id')
            ->join('nguoi_dungs', 'chi_tiet_phong_hops.id_nguoi_dung', '=', 'nguoi_dungs.id')
            ->select('chi_tiet_phong_hops.*', 'phong_hops.ten_phong', 'phong_hops.ma_phong', 'phong_hops.thoi_gian_bat_dau', 'phong_hops.trang_thai as trang_thai_phong', 'nguoi_dungs.ho_va_ten')
            ->orderBy('chi_tiet_phong_hops.created_at', 'desc');
            
        if ($request->has('id_nguoi_dung') && $request->id_nguoi_dung) {
            $query->where('chi_tiet_phong_hops.id_nguoi_dung', $request->id_nguoi_dung);
        }
        
        $data = $query->get();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $data = ChiTietPhongHop::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Thêm mới thành công',
            'data' => $data
        ]);
    }

    public function update(Request $request)
    {
        $data = ChiTietPhongHop::where('id', $request->id)->first();
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
        $data = ChiTietPhongHop::where('id', $request->id)->first();
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

    public function changeStatus(Request $request)
    {
        $data = ChiTietPhongHop::where('id', $request->id)->first();
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
