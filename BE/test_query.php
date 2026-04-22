<?php
include 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\ChiTietPhongHop;

try {
    $data = ChiTietPhongHop::join('phong_hops', 'chi_tiet_phong_hops.id_phong_hop', '=', 'phong_hops.id')
            ->join('nguoi_dungs', 'chi_tiet_phong_hops.id_nguoi_dung', '=', 'nguoi_dungs.id')
            ->select('chi_tiet_phong_hops.*', 'phong_hops.ten_phong', 'nguoi_dungs.ho_va_ten')
            ->get();
    echo "Success: " . count($data) . " rows\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
