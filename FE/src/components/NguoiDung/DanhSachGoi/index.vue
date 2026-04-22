<template>
    <div class="pricing-page min-vh-100 pb-5">
        <!-- Main Navbar -->
        <nav class="navbar bg-white border-bottom py-3 mb-5 shadow-sm sticky-top">
            <div class="container d-flex justify-content-between align-items-center">
                <div class="navbar-brand text-primary fw-900 fs-3 tracking-tight d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex justify-content-center align-items-center bg-primary text-white" style="width: 35px; height: 35px;">
                        <i class="bx bx-camera-movie fs-5"></i>
                    </div>
                    AI-Meet
                </div>
                <div class="nav-icons d-flex gap-4 align-items-center">
                    <router-link to="/nguoi-dung/trang-chinh" class="btn btn-light rounded-pill px-4 fw-bold small text-dark border">
                        <i class="bx bx-arrow-back me-2"></i> Dashboard
                    </router-link>
                </div>
            </div>
        </nav>

        <div class="container py-4 animate__animated animate__fadeIn">
            <div class="text-center mb-5">
                <span class="badge px-3 py-2 rounded-pill mb-3 fw-bold uppercase tracking-wider" style="background-color: #fff7ed; color: #ea580c; border: 1px solid #ffedd5;">GIÁ CẢ CẠNH TRANH</span>
                <h1 class="display-4 fw-900 text-dark mb-3" style="letter-spacing: -2px;">Chọn Gói Dịch Vụ Của Bạn</h1>
                <p class="text-secondary fs-5 mx-auto" style="max-width: 600px;">Nâng tầm trải nghiệm họp trực tuyến với sức mạnh của trí tuệ nhân tạo AI-Meet.</p>
            </div>

            <!-- Loading State -->
            <div v-if="isLoading" class="text-center py-5">
                <div class="spinner-border text-primary mb-3" role="status"></div>
                <p class="text-muted fw-bold">Đang tải danh sách gói...</p>
            </div>

            <div v-else class="row g-4 justify-content-center pt-4">
                <div v-for="(goi, index) in listGoi" :key="index" class="col-lg-4 col-md-6">
                    <div :class="['pricing-card h-100 card border-0 rounded-5 shadow-sm overflow-hidden transition-all p-2', goi.id === 2 ? 'featured-card' : 'bg-white']">
                        <div class="card-body p-4 p-xl-5 flex-grow-1 d-flex flex-column">
                            <!-- Badge for most popular -->
                            <div v-if="goi.id === 2" class="popular-badge mb-4">
                                <span class="badge bg-primary text-white px-3 py-2 rounded-pill fw-bold">PHỔ BIẾN NHẤT</span>
                            </div>

                            <div class="mb-4">
                                <h3 class="fw-800 text-dark mb-1">{{ goi.ten_goi }}</h3>
                                <p class="text-muted small fw-medium mb-0">{{ goi.mo_ta || 'Tối ưu cho nhu cầu cá nhân và doanh nghiệp nhỏ.' }}</p>
                            </div>

                            <div class="price-section mb-5">
                                <div class="d-flex align-items-baseline">
                                    <span class="h1 fw-900 text-dark m-0">{{ formatCurrency(goi.gia_goi) }}</span>
                                    <span class="text-muted ms-2 fw-medium">/ {{ goi.thoi_han || 1 }} tháng</span>
                                </div>
                            </div>

                            <hr class="mb-5 opacity-10">

                            <!-- Outstanding Features Section -->
                            <div class="mb-5">
                                <h6 class="fw-800 text-uppercase small tracking-wider mb-4" style="color: #64748b; font-size: 0.7rem;">Tính năng nổi trội</h6>
                                <ul class="list-unstyled m-0">
                                    <li v-for="(highlight, hIndex) in getHighlights(goi)" :key="hIndex" class="d-flex align-items-center mb-3">
                                        <div class="rounded-circle bg-success bg-opacity-10 d-flex p-1 me-3">
                                            <i class="bx bx-check text-success" style="font-size: 0.9rem;"></i>
                                        </div>
                                        <span class="fw-600 text-dark" style="font-size: 0.85rem;">{{ highlight }}</span>
                                    </li>
                                </ul>
                            </div>

                            <!-- Basic Specs -->
                            <div class="mb-5 p-3 rounded-4 bg-light border border-light-subtle">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bx bx-group text-muted me-2"></i>
                                    <span class="small text-muted fw-medium">Tối đa {{ goi.so_nguoi_toi_da }} khách tham dự</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-id-card text-muted me-2"></i>
                                    <span class="small text-muted fw-medium">Hỗ trợ {{ goi.so_phong_toi_da }} phòng họp</span>
                                </div>
                            </div>

                            <button @click="chonGoi(goi.id)" :class="['btn w-100 py-3 rounded-4 fw-900 fs-5 transition-all mt-auto', goi.id === 2 ? 'btn-primary shadow-lg' : 'btn-light-orange']">
                                Chọn Gói {{ goi.ten_goi }}
                                <i class="bx bx-right-arrow-alt ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Info -->
            <div class="text-center mt-5 pt-5 border-top">
                <p class="text-muted fw-medium small mb-0 d-flex align-items-center justify-content-center gap-2">
                    <i class="bx bxs-lock-alt"></i> Thanh toán an toàn qua cổng SePay & Ngân hàng MBBank
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
const apiUrl = import.meta.env.VITE_API_URL;

export default {
    name: 'DanhSachGoi',
    data() {
        return {
            listGoi: [],
            isLoading: false
        }
    },
    mounted() {
        this.fetchGoiData();
    },
    methods: {
        async fetchGoiData() {
            this.isLoading = true;
            try {
                const res = await axios.get(`${apiUrl}/goi/data`);
                if (res.data.status) {
                    this.listGoi = res.data.data.filter(g => g.trang_thai === true || g.trang_thai === 1);
                }
            } catch (error) {
                console.error("Lỗi khi tải danh sách gói:", error);
            } finally {
                this.isLoading = false;
            }
        },
        getHighlights(goi) {
            // Logic to provide outstanding features based on package characteristics
            if (goi.gia_goi <= 100000) {
                return [
                    "Kết nối phòng họp siêu tốc",
                    "Đầy đủ bộ công cụ trình chiếu",
                    "Mã hóa bảo mật chuẩn SSL"
                ];
            } else if (goi.gia_goi <= 600000) {
                return [
                    "Xác thực Face ID AI nâng cao",
                    "Phòng họp chất lượng 4K",
                    "Lưu trữ đám mây không giới hạn"
                ];
            } else {
                return [
                    "Bảo mật đa tầng sinh trắc học",
                    "Băng thông ưu tiên (Low latency)",
                    "Hỗ trợ kỹ thuật chuyên biệt 24/7"
                ];
            }
        },
        formatCurrency(value) {
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
        },
        chonGoi(id_goi) {
            this.$router.push(`/nguoi-dung/thanh-toan/${id_goi}`);
        }
    }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap');

.pricing-page {
    background-color: #fcfcfc;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: #1e293b;
}

.fw-900 { font-weight: 900; }
.fw-800 { font-weight: 800; }
.fw-700 { font-weight: 700; }
.fw-600 { font-weight: 600; }
.fw-500 { font-weight: 500; }

.text-primary {
    color: #ea580c !important;
}

.bg-primary {
    background-color: #ea580c !important;
}

.btn-primary {
    background-color: #ea580c !important;
    border-color: #ea580c !important;
    color: white !important;
}

.btn-primary:hover {
    background-color: #d35400 !important;
    transform: translateY(-2px);
    box-shadow: 0 10px 25px -5px rgba(234, 88, 12, 0.4) !important;
}

.btn-light-orange {
    background-color: #fff7ed;
    color: #ea580c;
    border: 1px solid #ffedd5;
}

.btn-light-orange:hover {
    background-color: #ffedd5;
    transform: translateY(-2px);
}

.pricing-card {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid #f1f5f9 !important;
}

.pricing-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 30px 60px -12px rgba(15, 23, 42, 0.08) !important;
    border-color: #ea580c33 !important;
}

.featured-card {
    border: 2px solid #ea580c !important;
    position: relative;
    background-image: linear-gradient(to bottom right, #ffffff, #fffdfb);
}

.featured-card::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 150px;
    height: 150px;
    background: radial-gradient(circle at top right, #ea580c11, transparent 70%);
    pointer-events: none;
}

.popular-badge {
    position: absolute;
    top: 20px;
    right: 20px;
}

.uppercase { text-transform: uppercase; }
.tracking-wider { letter-spacing: 0.1em; }
.tracking-tight { letter-spacing: -0.05em; }

.rounded-5 { border-radius: 2rem !important; }
.rounded-4 { border-radius: 1.25rem !important; }

.shadow-sm {
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1) !important;
}

/* Animations */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate__fadeIn {
    animation: fadeIn 0.8s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
</style>
