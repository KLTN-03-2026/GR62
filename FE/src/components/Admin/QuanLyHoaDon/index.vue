<template>
    <div class="row">
        <!-- Summary Cards -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 border-start border-0 border-4 border-primary shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tổng Doanh Thu</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ formatCurrency(tong_doanh_thu) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bx bx-dollar-circle fs-1 text-primary opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 border-start border-0 border-4 border-success shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Thanh Toán Thành Công</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ sl_thanh_cong }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bx bx-check-circle fs-1 text-success opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 border-start border-0 border-4 border-warning shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Chờ Xử Lý</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ sl_cho_xu_ly }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bx bx-time-five fs-1 text-warning opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 border-start border-0 border-4 border-info shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tổng Hóa Đơn</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ list_hoa_don.length }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bx bx-receipt fs-1 text-info opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card radius-10 border-top border-0 border-3 border-primary shadow-sm">
        <div class="card-header bg-white py-3 flex-wrap d-flex align-items-center justify-content-between gap-3">
            <h5 class="mb-0 fw-bold text-primary"><i class="bx bx-list-ul me-2"></i>QUẢN LÝ HÓA ĐƠN</h5>
            <div class="d-flex flex-wrap gap-2">
                <input type="date" class="form-control" style="max-width: 150px;" v-model="tu_ngay" @change="locHoaDon()" title="Từ ngày">
                <input type="date" class="form-control" style="max-width: 150px;" v-model="den_ngay" @change="locHoaDon()" title="Đến ngày">
                <select class="form-select" style="max-width: 150px;" v-model="loai_tai_khoan" @change="locHoaDon()">
                    <option value="all">Tất cả tài khoản</option>
                    <option value="basic">Gói Basic</option>
                    <option value="partner">Gói Đối Tác</option>
                </select>
                <div class="input-group" style="width: 250px;">
                    <span class="input-group-text bg-transparent border-end-0"><i class="bx bx-search"></i></span>
                    <input type="text" class="form-control border-start-0" placeholder="Mã GD, tên khách..." 
                           v-model="tu_khoa" @keyup.enter="locHoaDon()">
                </div>
                <button class="btn btn-primary px-4" @click="loadData()">
                    <i class="bx bx-refresh me-1"></i> Làm mới
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-borderless align-middle">
                    <thead class="bg-light shadow-sm">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Khách Hàng</th>
                            <th>Mã Giao Dịch</th>
                            <th>Gói Dịch Vụ</th>
                            <th class="text-end">Số Tiền</th>
                            <th class="text-center">Trạng Thái</th>
                            <th>Ngày Tạo</th>
                            <th class="text-center pe-4">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(v, k) in list_hoa_don" :key="k" class="border-bottom">
                            <td class="ps-4 text-muted">{{ k + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm rounded-circle bg-light d-flex align-items-center justify-content-center me-2 text-primary fw-bold" style="width: 35px; height: 35px;">
                                        {{ v.nguoi_dung?.ho_va_ten?.charAt(0) || 'U' }}
                                    </div>
                                    <div>
                                        <div class="fw-bold mb-0" style="font-size: 0.9rem;">{{ v.nguoi_dung?.ho_va_ten || 'N/A' }}</div>
                                        <small class="text-muted">{{ v.nguoi_dung?.email || 'N/A' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border fw-bold">#{{ v.ma_giao_dich }}</span>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ v.goi?.ten_goi || 'N/A' }}</div>
                            </td>
                            <td class="text-end fw-bold text-primary">
                                {{ formatCurrency(v.so_tien) }}
                            </td>
                            <td class="text-center">
                                <span v-if="v.trang_thai_thanh_toan == 1" class="badge rounded-pill bg-success-subtle text-success px-3">
                                    <i class="bx bxs-check-circle me-1"></i>Thành công
                                </span>
                                <span v-else class="badge rounded-pill bg-warning-subtle text-warning px-3">
                                    <i class="bx bxs-time-five me-1"></i>Chờ xử lý
                                </span>
                            </td>
                            <td class="text-muted small">
                                {{ formatDate(v.created_at) }}
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-sm btn-outline-primary" @click="showDetail(v)" 
                                            data-bs-toggle="modal" data-bs-target="#detailModal">
                                        <i class="bx bx-show"></i>
                                    </button>
                                    <button v-if="v.trang_thai_thanh_toan != 1" class="btn btn-sm btn-outline-success" @click="updateStatus(v)">
                                        <i class="bx bx-check"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" @click="hoa_don_xoa = v"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="list_hoa_don.length === 0">
                            <td colspan="8" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bx bx-receipt fs-1 opacity-25 mb-2"></i>
                                    <p class="text-muted">Không tìm thấy hóa đơn nào.</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow-lg" v-if="hoa_don_chi_tiet">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold"><i class="bx bx-receipt me-2"></i>Chi Tiết Hóa Đơn #{{ hoa_don_chi_tiet.ma_giao_dich }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase mb-3 small fw-bold">Thông tin khách hàng</h6>
                            <p class="mb-1"><strong>Họ tên:</strong> {{ hoa_don_chi_tiet.nguoi_dung?.ho_va_ten }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ hoa_don_chi_tiet.nguoi_dung?.email }}</p>
                            <p class="mb-0"><strong>SĐT:</strong> {{ hoa_don_chi_tiet.nguoi_dung?.so_dien_thoai || 'Chưa cập nhật' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase mb-3 small fw-bold">Thông tin thanh toán</h6>
                            <p class="mb-1"><strong>Phương thức:</strong> {{ hoa_don_chi_tiet.phuong_thuc_thanh_toan || 'Chuyển khoản' }}</p>
                            <p class="mb-1"><strong>Trạng thái:</strong> 
                                <span :class="hoa_don_chi_tiet.trang_thai_thanh_toan == 1 ? 'text-success' : 'text-warning'">
                                    {{ hoa_don_chi_tiet.trang_thai_thanh_toan == 1 ? 'Thành công' : 'Đang xử lý' }}
                                </span>
                            </p>
                            <p class="mb-0"><strong>Ngày tạo:</strong> {{ formatDate(hoa_don_chi_tiet.created_at) }}</p>
                        </div>
                        <div class="col-12">
                            <div class="table-responsive rounded-3 border">
                                <table class="table table-sm mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-3 py-2">Dịch vụ</th>
                                            <th class="text-end pe-3 py-2">Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="ps-3 py-3">
                                                <div class="fw-bold">{{ hoa_don_chi_tiet.goi?.ten_goi }}</div>
                                                <small class="text-muted">{{ hoa_don_chi_tiet.goi?.mo_ta }}</small>
                                            </td>
                                            <td class="text-end pe-3 py-3 fw-bold">{{ formatCurrency(hoa_don_chi_tiet.so_tien) }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="bg-light">
                                        <tr>
                                            <th class="ps-3">TỔNG CỘNG</th>
                                            <th class="text-end pe-3 text-primary fs-5">{{ formatCurrency(hoa_don_chi_tiet.so_tien) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 p-4 pt-0">
                    <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary px-4 rounded-pill" @click="printInvoice()">
                        <i class="bx bx-printer me-1"></i>In hóa đơn
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-4 border-0">
                <div class="modal-body p-4 text-center">
                    <div class="text-danger mb-3">
                        <i class="bx bx-error-circle" style="font-size: 5rem;"></i>
                    </div>
                    <h5 class="fw-bold">Xác nhận xóa?</h5>
                    <p class="text-muted">Bạn có chắc chắn muốn xóa hóa đơn <strong>#{{ hoa_don_xoa.ma_giao_dich }}</strong>? Hành động này không thể hoàn tác.</p>
                </div>
                <div class="modal-footer border-0 justify-content-center pb-4">
                    <button type="button" class="btn btn-light px-4 rounded-pill" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger px-4 rounded-pill" data-bs-dismiss="modal" @click="deleteHoaDon()">Xác nhận xóa</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
const API = import.meta.env.VITE_API_URL;

export default {
    data() {
        return {
            list_hoa_don: [],
            list_hoa_don_goc: [],
            tu_khoa: '',
            tu_ngay: '',
            den_ngay: '',
            loai_tai_khoan: 'all',
            hoa_don_chi_tiet: null,
            hoa_don_xoa: {},
            tong_doanh_thu: 0,
            sl_thanh_cong: 0,
            sl_cho_xu_ly: 0,
        }
    },
    mounted() {
        this.loadData();
    },
    methods: {
        headers() {
            return { Authorization: 'Bearer ' + localStorage.getItem('token_admin') };
        },
        async loadData() {
            try {
                let url = `${API}/hoa-don/data`;
                const res = await axios.get(url, { headers: this.headers() });
                if (res.data.status) {
                    this.list_hoa_don_goc = res.data.data;
                }
                this.locHoaDon();
            } catch (error) {
                this.$toast.error('Lỗi khi tải dữ liệu hóa đơn');
            }
        },
        locHoaDon() {
            let filtered = this.list_hoa_don_goc || [];

            if (this.tu_khoa) {
                const kw = this.tu_khoa.toLowerCase();
                filtered = filtered.filter(item => 
                    (item.ma_giao_dich && item.ma_giao_dich.toLowerCase().includes(kw)) ||
                    (item.nguoi_dung && item.nguoi_dung.ho_va_ten && item.nguoi_dung.ho_va_ten.toLowerCase().includes(kw))
                );
            }

            if (this.tu_ngay) {
                const fromDate = new Date(this.tu_ngay);
                filtered = filtered.filter(item => new Date(item.created_at) >= fromDate);
            }

            if (this.den_ngay) {
                const toDate = new Date(this.den_ngay);
                toDate.setHours(23, 59, 59, 999);
                filtered = filtered.filter(item => new Date(item.created_at) <= toDate);
            }

            if (this.loai_tai_khoan !== 'all') {
                if (this.loai_tai_khoan === 'basic') {
                    filtered = filtered.filter(item => !item.nguoi_dung || !item.nguoi_dung.id_doi_tac);
                } else if (this.loai_tai_khoan === 'partner') {
                    filtered = filtered.filter(item => item.nguoi_dung && item.nguoi_dung.id_doi_tac);
                }
            }

            this.list_hoa_don = filtered;
            this.calculateStats();
        },
        calculateStats() {
            this.tong_doanh_thu = this.list_hoa_don.reduce((sum, item) => {
                return item.trang_thai_thanh_toan == 1 ? sum + parseFloat(item.so_tien) : sum;
            }, 0);
            this.sl_thanh_cong = this.list_hoa_don.filter(i => i.trang_thai_thanh_toan == 1).length;
            this.sl_cho_xu_ly = this.list_hoa_don.filter(i => i.trang_thai_thanh_toan != 1).length;
        },
        showDetail(v) {
            this.hoa_don_chi_tiet = v;
        },
        async updateStatus(v) {
            try {
                const res = await axios.post(`${API}/hoa-don/update`, { id: v.id, trang_thai_thanh_toan: 1 }, { headers: this.headers() });
                if (res.data.status) {
                    this.$toast.success('Cập nhật trạng thái thành công');
                    this.loadData();
                } else {
                    this.$toast.error(res.data.message);
                }
            } catch (error) {
                this.$toast.error('Lỗi khi cập nhật trạng thái');
            }
        },
        async deleteHoaDon() {
            try {
                const res = await axios.post(`${API}/hoa-don/delete`, { id: this.hoa_don_xoa.id }, { headers: this.headers() });
                if (res.data.status) {
                    this.$toast.success('Xóa hóa đơn thành công');
                    this.loadData();
                } else {
                    this.$toast.error(res.data.message);
                }
            } catch (error) {
                this.$toast.error('Lỗi khi xóa hóa đơn');
            }
        },
        formatCurrency(value) {
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
        },
        formatDate(dateStr) {
            if (!dateStr) return 'N/A';
            const date = new Date(dateStr);
            return date.toLocaleString('vi-VN', { 
                day: '2-digit', month: '2-digit', year: 'numeric',
                hour: '2-digit', minute: '2-digit'
            });
        },
        printInvoice() {
            window.print();
        }
    }
}
</script>

<style scoped>
.bg-success-subtle { background-color: #d1e7dd !important; }
.bg-warning-subtle { background-color: #fff3cd !important; }
.text-success { color: #0f5132 !important; }
.text-warning { color: #664d03 !important; }
.avatar-sm { font-size: 0.8rem; }
.table-borderless > :not(caption) > * > * { border-bottom-width: 0; }
.card { border-radius: 12px; }
.shadow-sm { box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important; }
@media print {
    body * { visibility: hidden; }
    #detailModal, #detailModal * { visibility: visible; }
    #detailModal { position: absolute; left: 0; top: 0; width: 100%; }
    .btn-close, .modal-footer, .btn-primary { display: none !important; }
}
</style>
