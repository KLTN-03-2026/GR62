<template>
    <div class="billing-container animate__animated animate__fadeIn">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bolder mb-1" style="color: #0f172a; letter-spacing: -0.5px; font-size: 2rem;">Lịch sử thanh toán</h2>
                <p class="text-muted mb-0">Quản lý hóa đơn và các lần nâng cấp gói dịch vụ của bạn.</p>
            </div>
            <div class="d-flex gap-3">
                <div class="stat-card p-3 rounded-4 bg-white border shadow-sm d-flex align-items-center gap-3" style="min-width: 200px;">
                    <div class="rounded-circle d-flex justify-content-center align-items-center" style="width: 45px; height: 45px; background-color: #f0fdf4;">
                        <i class='bx bx-check-circle fs-4 text-success'></i>
                    </div>
                    <div>
                        <p class="small text-muted mb-0 fw-bold">Tổng chi tiêu</p>
                        <h5 class="mb-0 fw-bolder">{{ formatCurrency(totalSpent) }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice Table -->
        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 16px;">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 border-0 text-muted small fw-bolder uppercase">MÃ GIAO DỊCH</th>
                            <th class="py-3 border-0 text-muted small fw-bolder uppercase">GÓI DỊCH VỤ</th>
                            <th class="py-3 border-0 text-muted small fw-bolder uppercase">NGÀY THANH TOÁN</th>
                            <th class="py-3 border-0 text-muted small fw-bolder uppercase text-end">SỐ TIỀN</th>
                            <th class="py-3 border-0 text-muted small fw-bolder uppercase text-center">TRẠNG THÁI</th>
                            <th class="pe-4 py-3 border-0 text-muted small fw-bolder uppercase text-end">HÀNH ĐỘNG</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(invoice, index) in listHoaDon" :key="index" class="border-bottom">
                            <td class="ps-4 py-3 fw-bold text-dark" style="font-size: 0.9rem;">
                                #{{ invoice.ma_giao_dich }}
                            </td>
                            <td class="py-3 fw-semibold" style="color: #475569;">
                                {{ invoice.goi?.ten_goi || 'N/A' }}
                            </td>
                            <td class="py-3 text-muted" style="font-size: 0.85rem;">
                                {{ formatDate(invoice.created_at) }}
                            </td>
                            <td class="py-3 text-end fw-bolder text-dark">
                                {{ formatCurrency(invoice.so_tien) }}
                            </td>
                            <td class="py-3 text-center">
                                <span :class="['badge px-3 py-2 rounded-pill fw-bold', getStatusClass(invoice.trang_thai_thanh_toan)]">
                                    {{ invoice.trang_thai_thanh_toan === 1 ? 'Thành công' : 'Chờ xử lý' }}
                                </span>
                            </td>
                            <td class="pe-4 py-3 text-end">
                                <button @click="showInvoiceDetail(invoice)" class="btn btn-sm btn-light rounded-pill px-3 fw-bold border-0" style="color: #ea580c; background-color: #fff7ed;">
                                    <i class='bx bx-show me-1'></i> Chi tiết
                                </button>
                            </td>
                        </tr>
                        <tr v-if="listHoaDon.length === 0">
                            <td colspan="6" class="text-center py-5 text-muted">
                                <div class="py-4">
                                    <i class='bx bx-receipt fs-1 mb-3 opacity-20'></i>
                                    <p class="mb-0">Bạn chưa có hóa đơn nào.</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Invoice Detail Modal -->
        <div v-if="selectedInvoice" class="modal-backdrop-custom d-flex align-items-center justify-content-center p-3 animate__animated animate__fadeIn" @click="closeInvoiceDetail">
            <div class="invoice-modal-content bg-white shadow-2xl rounded-5 overflow-hidden animate__animated animate__zoomIn" style="max-width: 800px; width: 100%; border: 1px solid #e2e8f0;" @click.stop>
                <!-- Modal Header -->
                <div class="p-4 border-bottom d-flex justify-content-between align-items-center bg-light">
                    <h5 class="mb-0 fw-bolder text-dark">Chi tiết hóa đơn</h5>
                    <div class="d-flex gap-2">
                        <button @click="printInvoice" class="btn btn-sm btn-dark px-3 rounded-pill fw-bold border-0">
                            <i class='bx bx-printer me-1'></i> In hóa đơn
                        </button>
                        <button @click="closeInvoiceDetail" class="btn btn-sm btn-light px-2 rounded-circle border-0">
                            <i class='bx bx-x fs-4'></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Body (The Invoice) -->
                <div id="invoice-printable" class="p-5">
                    <div class="d-flex justify-content-between align-items-start mb-5">
                        <div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle d-flex justify-content-center align-items-center me-3" style="background-color: #ea580c; width: 44px; height: 44px;">
                                    <i class="bx bx-camera-movie text-white fs-4"></i>
                                </div>
                                <h3 class="mb-0 fw-bold" style="color: #0f172a;">AI-Meet</h3>
                            </div>
                            <p class="text-muted small mb-0 fw-medium">Video Intelligence Platform</p>
                        </div>
                        <div class="text-end">
                            <h4 class="fw-bolder text-dark mb-1">HÓA ĐƠN</h4>
                            <p class="text-muted small mb-1">Mã: <b>#{{ selectedInvoice.ma_giao_dich }}</b></p>
                            <p class="text-muted small mb-0">Ngày: {{ formatDate(selectedInvoice.created_at) }}</p>
                        </div>
                    </div>

                    <hr class="my-4 opacity-50">

                    <div class="row mb-5 g-4 text-start">
                        <div class="col-sm-6">
                            <h6 class="text-muted small mb-3 fw-bold uppercase" style="letter-spacing: 1px;">GỬI TỚI:</h6>
                            <h5 class="fw-bolder mb-1 text-dark">{{ ten_nguoi_dung }}</h5>
                            <p class="text-muted small mb-0">{{ email_nguoi_dung }}</p>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <h6 class="text-muted small mb-3 fw-bold uppercase" style="letter-spacing: 1px;">THÔNG TIN DOANH NGHIỆP:</h6>
                            <h5 class="fw-bolder mb-1 text-dark">AI-Meet Technology Corp</h5>
                            <p class="text-muted small mb-0">Q. Liên Chiểu, Đà Nẵng, Việt Nam</p>
                            <p class="text-muted small mb-0">contact@ai-meet.com</p>
                        </div>
                    </div>

                    <div class="table-responsive mb-5 rounded-4 border overflow-hidden">
                        <table class="table table-borderless align-middle mb-0">
                            <thead class="bg-gray-50 border-bottom">
                                <tr>
                                    <th class="ps-4 py-3 text-muted small fw-bold">DỊCH VỤ</th>
                                    <th class="py-3 text-center text-muted small fw-bold">SỐ LƯỢNG</th>
                                    <th class="py-3 text-end text-muted small fw-bold">ĐƠN GIÁ</th>
                                    <th class="pe-4 py-3 text-end text-muted small fw-bold">THÀNH TIỀN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-bottom">
                                    <td class="ps-4 py-4">
                                        <h6 class="fw-bold mb-1 text-dark">{{ selectedInvoice.goi?.ten_goi || 'Gói Dịch Vụ' }}</h6>
                                        <p class="text-muted small mb-0 line-clamp-1" v-if="selectedInvoice.goi?.mo_ta">
                                            {{ selectedInvoice.goi.mo_ta }}
                                        </p>
                                    </td>
                                    <td class="py-4 text-center fw-medium">1</td>
                                    <td class="py-4 text-end fw-medium">{{ formatCurrency(selectedInvoice.so_tien) }}</td>
                                    <td class="pe-4 py-4 text-end fw-bold text-dark">{{ formatCurrency(selectedInvoice.so_tien) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-5 mt-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted fw-medium">Tạm tính:</span>
                                <span class="text-dark fw-bold">{{ formatCurrency(selectedInvoice.so_tien) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted fw-medium">Thuế (0%):</span>
                                <span class="text-dark fw-bold">0đ</span>
                            </div>
                            <hr class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bolder text-dark">Tổng cộng:</h5>
                                <h4 class="mb-0 fw-900 text-orange">{{ formatCurrency(selectedInvoice.so_tien) }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-top">
                        <div class="p-3 rounded-4 bg-gray-50 d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex justify-content-center align-items-center bg-white" style="width: 40px; height: 40px; border: 1px dashed #cbd5e1;">
                                <i class='bx bx-credit-card-front fs-5 text-muted'></i>
                            </div>
                            <div>
                                <p class="small text-muted mb-0 fw-bold">Phương thức thanh toán</p>
                                <p class="small text-dark mb-0 fw-bolder">{{ selectedInvoice.phuong_thuc_thanh_toan || 'SePay Transfer' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Modal Footer -->
                <div class="p-4 bg-light border-top text-center">
                    <p class="small text-muted mb-0">Cảm ơn bạn đã sử dụng dịch vụ của <b>AI-Meet</b>. Nếu có bất kỳ thắc mắc nào, vui lòng liên hệ hỗ trợ.</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
const apiUrl = import.meta.env.VITE_API_URL;

export default {
    name: 'HoaDon',
    data() {
        return {
            listHoaDon: [],
            selectedInvoice: null,
            totalSpent: 0
        }
    },
    computed: {
        ten_nguoi_dung() {
            const user = JSON.parse(localStorage.getItem('thong_tin_user'));
            return user ? user.ho_va_ten : 'Người dùng AI-Meet';
        },
        email_nguoi_dung() {
            const user = JSON.parse(localStorage.getItem('thong_tin_user'));
            return user ? user.email : '';
        }
    },
    mounted() {
        this.loadHistory();
    },
    methods: {
        async loadHistory() {
            try {
                const token = localStorage.getItem('token_nguoi_dung');
                const res = await axios.get(`${apiUrl}/hoa-don/history`, {
                    headers: { Authorization: `Bearer ${token}` }
                });
                if (res.data.status) {
                    this.listHoaDon = res.data.data;
                    this.totalSpent = this.listHoaDon.reduce((total, inv) => total + parseFloat(inv.so_tien), 0);
                }
            } catch (error) {
                console.error("Lỗi khi tải lịch sử hóa đơn:", error);
            }
        },
        formatCurrency(value) {
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
        },
        formatDate(dateStr) {
            const date = new Date(dateStr);
            return date.toLocaleDateString('vi-VN', { 
                day: '2-digit', month: 'long', year: 'numeric', 
                hour: '2-digit', minute: '2-digit' 
            });
        },
        getStatusClass(status) {
            if (status === 1) return 'bg-success bg-opacity-10 text-success';
            return 'bg-warning bg-opacity-10 text-warning';
        },
        showInvoiceDetail(invoice) {
            this.selectedInvoice = invoice;
            document.body.style.overflow = 'hidden';
        },
        closeInvoiceDetail() {
            this.selectedInvoice = null;
            document.body.style.overflow = 'auto';
        },
        printInvoice() {
            const printContent = document.getElementById('invoice-printable');
            const WinPrint = window.open('', '', 'width=900,height=650');
            WinPrint.document.write('<html><head><title>Print Invoice</title>');
            WinPrint.document.write('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">');
            WinPrint.document.write('<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">');
            WinPrint.document.write('<style>body{padding:20px} .text-orange{color:#ea580c!important} .bg-gray-50{background-color:#f8fafc}</style></head><body>');
            WinPrint.document.write(printContent.innerHTML);
            WinPrint.document.write('</body></html>');
            WinPrint.document.close();
            WinPrint.focus();
            setTimeout(() => {
                WinPrint.print();
                WinPrint.close();
            }, 1000);
        }
    }
}
</script>

<style scoped>
.modal-backdrop-custom {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(8px);
    z-index: 2000;
}

.invoice-modal-content {
    max-height: 90vh;
    overflow-y: auto;
}

.stat-card {
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
}

.bg-gray-50 {
    background-color: #f8fafc;
}

.fw-900 {
    font-weight: 900;
}

.shadow-2xl {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

.text-orange {
    color: #ea580c !important;
}

.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

@media print {
    .btn, .modal-backdrop-custom header {
        display: none !important;
    }
}
</style>
