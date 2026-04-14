<template>
    <div class="checkout-container min-vh-100 pb-5">
        <!-- Main Navbar -->
        <nav class="navbar bg-white border-bottom py-3 mb-5 shadow-sm">
            <div class="container d-flex justify-content-between align-items-center">
                <div class="navbar-brand text-primary fw-900 fs-3 tracking-tight">AI-Meet</div>
                <div class="nav-icons d-flex gap-4 align-items-center">
                    <i class="bx bx-help-circle fs-4 text-muted cursor-pointer"></i>
                    <a href="/nguoi-dung/trang-chinh">
                        <i class="bx bx-user-circle fs-3 text-muted cursor-pointer"></i>
                    </a>
                </div>
            </div>
        </nav>

        <div class="container animate__animated animate__fadeIn">
            <div class="row g-5">
                <!-- Left Section: Breakdown -->
                <div class="col-lg-5">
                    <div class="header-section mb-4">
                        <h2 class="fw-800 text-dark mb-2">Hoàn tất thanh toán</h2>
                        <p class="text-muted fw-500">Vui lòng kiểm tra lại thông tin gói dịch vụ của bạn.</p>
                    </div>

                    <div class="card border-0 rounded-5 overflow-hidden shadow-sm mb-4">
                        <div class="card-body p-0">
                            <!-- Package Header -->
                            <div class="p-4 bg-white position-relative">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="text-primary fw-800 small text-uppercase mb-2 tracking-wide">GÓI
                                            ĐĂNG KÝ</div>
                                        <h4 class="fw-800 text-dark m-0" v-if="goiInfo">{{ goiInfo.ten_goi }}</h4>
                                        <div class="skeleton-text w-150" v-else></div>
                                    </div>
                                    <div class="stamp-icon">
                                        <i class="bx bxs-check-circle text-light-gray fs-1"></i>
                                    </div>
                                </div>
                                <div class="mt-4 space-y-3">
                                    <div class="d-flex justify-content-between align-items-center text-secondary">
                                        <span class="fw-500">Phí thuê bao / tháng</span>
                                        <span class="fw-700 text-dark">{{ formatMoney(basePrice) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center text-secondary">
                                        <span class="fw-500">Thuế (VAT 10%)</span>
                                        <span class="fw-700 text-dark">{{ formatMoney(vatAmount) }}</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Total Section -->
                            <div class="p-4 bg-soft-orange border-top">
                                <div class="d-flex justify-content-between align-items-end">
                                    <span class="fw-800 text-dark fs-5">Tổng cộng</span>
                                    <div class="text-end">
                                        <div class="text-primary fw-900 fs-3">{{ formatMoney(totalPrice) }}</div>
                                        <div class="text-secondary small fw-500">Thanh toán định kỳ hàng tháng</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="info-alert p-4 rounded-4 bg-soft-gray d-flex gap-3">
                        <i class="bx bxs-info-circle text-primary fs-3"></i>
                        <p class="small text-secondary fw-500 m-0 leading-relaxed">
                            Bằng cách hoàn tất giao dịch, bạn đồng ý với Điều khoản dịch vụ và Chính sách bảo mật của
                            AI-Meet.
                            Gói cước sẽ tự động gia hạn cho đến khi bạn hủy.
                        </p>
                    </div>
                </div>

                <!-- Right Section: SePay QR -->
                <div class="col-lg-7">
                    <div class="card border-0 rounded-5 shadow-lg p-2 bg-white main-payment-card">
                        <div class="card-body p-5">
                            <div class="d-flex justify-content-between align-items-center mb-5">
                                <h4 class="fw-800 text-dark m-0">Chuyển khoản qua SePay</h4>
                                <div class="sepay-badge p-2 rounded-2 border">
                                    <img src="https://sepay.vn/logo.png" height="15" alt="SePay" class="grayscale">
                                </div>
                            </div>

                            <div class="row g-4 align-items-start">
                                <!-- QR Display -->
                                <div class="col-md-6">
                                    <div class="qr-dotted-container p-4 border-dashed rounded-4 text-center">
                                        <div v-if="isCreating" class="py-5">
                                            <div class="spinner-border text-primary" role="status"></div>
                                        </div>
                                        <template v-else-if="payment">
                                            <div class="qr-frame rounded-4 overflow-hidden mb-3 shadow-sm mx-auto">
                                                <img :src="payment.qr_url" alt="QR" class="w-100">
                                            </div>
                                            <p class="small text-muted fw-500">Quét mã QR để tự động điền thông tin</p>
                                        </template>
                                    </div>
                                </div>

                                <!-- Bank Fields -->
                                <div class="col-md-6 space-y-4">
                                    <div class="form-group-custom">
                                        <label class="text-primary fw-800 small text-uppercase tracking-wider">NGÂN
                                            HÀNG</label>
                                        <div
                                            class="field-box py-3 px-4 rounded-4 bg-soft-orange fw-800 text-dark border-0">
                                            MBBank
                                        </div>
                                    </div>

                                    <div class="form-group-custom">
                                        <label class="text-primary fw-800 small text-uppercase tracking-wider">SỐ TÀI
                                            KHOẢN</label>
                                        <div
                                            class="field-box py-3 px-4 rounded-4 bg-soft-orange d-flex justify-content-between align-items-center">
                                            <span class="fw-800 text-dark font-mono" v-if="payment">{{
                                                payment.bank_account }}</span>
                                            <span class="fw-800 text-dark font-mono" v-else>0342211914</span>
                                            <button @click="copyText(payment?.bank_account || '0342211914')"
                                                class="btn-copy">
                                                <i class="bx bxs-copy text-primary"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="form-group-custom">
                                        <label class="text-primary fw-800 small text-uppercase tracking-wider">TÊN CHỦ
                                            TÀI KHOẢN</label>
                                        <div
                                            class="field-box py-3 px-4 rounded-4 bg-soft-orange fw-800 text-dark border-0">
                                            TRAN HUU HIEU
                                        </div>
                                    </div>

                                    <div class="form-group-custom">
                                        <label class="text-primary fw-800 small text-uppercase tracking-wider">NỘI DUNG
                                            CHUYỂN KHOẢN</label>
                                        <div
                                            class="field-box py-3 px-4 rounded-4 bg-soft-orange d-flex justify-content-between align-items-center">
                                            <span class="fw-800 text-dark font-mono" v-if="payment">{{
                                                payment.transfer_content }}</span>
                                            <span class="fw-800 text-dark font-mono" v-else>AIMEE 548900</span>
                                            <button @click="copyText(payment?.transfer_content || '')" class="btn-copy">
                                                <i class="bx bxs-copy text-primary"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Warning Box -->
                            <div
                                class="mt-5 p-4 rounded-4 bg-soft-red border border-red-faded d-flex gap-3 align-items-center">
                                <i class="bx bxs-error text-danger fs-3"></i>
                                <p class="small text-dark fw-500 m-0">
                                    Vui lòng nhập <span class="fw-800 text-danger">chính xác nội dung chuyển
                                        khoản</span> để hệ thống tự động kích
                                    hoạt dịch vụ sau 1-3 phút.
                                </p>
                            </div>

                            <!-- Action Button -->
                            <button @click="checkStatusManual" :disabled="status === 'paid'"
                                class="btn btn-primary-action w-100 py-4 fs-5 fw-800 rounded-4 mt-5 d-flex align-items-center justify-content-center gap-3">
                                {{ status === 'paid' ? 'Đã thanh toán thành công' : 'Xác nhận đã thanh toán' }}
                                <i :class="status === 'paid' ? 'bx bxs-check-shield' : 'bx bxs-badge-check'"></i>
                            </button>

                            <div
                                class="text-center mt-4 d-flex align-items-center justify-content-center gap-2 text-muted small fw-600">
                                <i class="bx bxs-shield-alt"></i> Giao dịch bảo mật qua cổng SePay
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    data() {
        return {
            apiUrl: import.meta.env.VITE_API_URL,
            payment: null,
            status: 'pending',
            timer: null,
            isCreating: false,
            id_goi: 2, // Default will be overridden in created
            goiInfo: null,
        }
    },
    created() {
        if (this.$route && this.$route.params && this.$route.params.id_goi) {
            this.id_goi = parseInt(this.$route.params.id_goi) || 2;
        }
    },
    computed: {
        totalPrice() {
            return this.goiInfo ? parseFloat(this.goiInfo.gia_goi) : 548900;
        },
        basePrice() {
            return this.totalPrice / 1.1;
        },
        vatAmount() {
            return this.totalPrice - this.basePrice;
        }
    },
    async mounted() {
        await this.fetchGoiInfo();
        if (this.goiInfo) {
            this.createOrder();
        }
    },
    methods: {
        async fetchGoiInfo() {
            try {
                const res = await axios.get(`${this.apiUrl}/goi/detail/${this.id_goi}`);
                if (res.data.status) {
                    this.goiInfo = res.data.data;
                }
            } catch (error) {
                console.error("Fetch gói error:", error);
            }
        },

        async createOrder() {
            if (this.isCreating) return;
            this.isCreating = true;
            try {
                const res = await axios.post(`${this.apiUrl}/sepay/create-order`, {
                    id_goi: this.id_goi,
                    amount: Math.round(this.totalPrice),
                    customer_name: 'Premium Member',
                    customer_email: 'member@example.com'
                });
                this.payment = res.data;
                this.status = res.data.status;
                this.startPolling();
            } catch (error) {
                console.error("Order error:", error);
            } finally {
                this.isCreating = false;
            }
        },

        startPolling() {
            if (!this.payment?.order_code) return;
            if (this.timer) clearInterval(this.timer);
            this.timer = setInterval(async () => {
                try {
                    const res = await axios.get(`${this.apiUrl}/sepay/status/${this.payment.order_code}`);
                    this.status = res.data.status;
                    if (res.data.status === 'paid') {
                        clearInterval(this.timer);
                        if (this.$toast) this.$toast.success("Thanh toán hoàn tất!");
                        setTimeout(() => this.$router.push('/nguoi-dung/trang-chinh'), 2500);
                    }
                } catch (e) { }
            }, 4000);
        },

        async checkStatusManual() {
            if (this.status === 'paid') return;
            if (this.$toast) this.$toast.info("Đang kiểm tra giao dịch...");
            this.startPolling();
        },

        formatMoney(value) {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(value).replace('₫', 'đ');
        },

        copyText(text) {
            navigator.clipboard.writeText(text);
            if (this.$toast) this.$toast.success("Đã sao chép");
        }
    },
    beforeUnmount() {
        if (this.timer) clearInterval(this.timer);
    }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800;900&display=swap');

.checkout-container {
    background-color: #fffcf9;
    font-family: 'Lexend', sans-serif;
    color: #2d3436;
}

.fw-900 {
    font-weight: 900;
}

.fw-800 {
    font-weight: 800;
}

.fw-700 {
    font-weight: 700;
}

.fw-500 {
    font-weight: 500;
}

.tracking-tight {
    letter-spacing: -1.5px;
}

.tracking-wide {
    letter-spacing: 0.5px;
}

.tracking-wider {
    letter-spacing: 1.5px;
}

.space-y-3>*+* {
    margin-top: 0.75rem;
}

.space-y-4>*+* {
    margin-top: 1.25rem;
}

.rounded-5 {
    border-radius: 2.5rem !important;
}

.rounded-4 {
    border-radius: 1.25rem !important;
}

.text-primary {
    color: #d35400 !important;
}

/* Main Orange */
.bg-soft-orange {
    background-color: #fdf2e9;
}

.bg-soft-gray {
    background-color: #f7f1eb;
}

.bg-soft-red {
    background-color: #feefef;
}

.border-red-faded {
    border-color: #fcdbdb !important;
}

.text-light-gray {
    color: #e0e0e0;
}

.navbar {
    height: 80px;
}

/* QR Dotted Box */
.qr-dotted-container {
    background: white;
    min-height: 280px;
}

.border-dashed {
    border: 2px dashed #e0e0e0 !important;
}

.qr-frame {
    max-width: 220px;
    background: #1e293b;
    padding: 10px;
}

/* Fields */
.field-box {
    min-height: 56px;
    display: flex;
    align-items: center;
}

.btn-copy {
    background: transparent;
    border: none;
    padding: 8px;
    transition: 0.2s;
}

.btn-copy:hover {
    transform: scale(1.1);
}

.font-mono {
    font-family: 'SF Mono', 'Courier New', monospace;
    letter-spacing: 1.5px;
}

/* Main Button */
.btn-primary-action {
    background-color: #d35400 !important;
    border: none;
    color: white;
    transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    box-shadow: 0 15px 30px rgba(211, 84, 0, 0.2);
}

.btn-primary-action:hover:not(:disabled) {
    background-color: #bf4d00 !important;
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(211, 84, 0, 0.3);
}

.btn-primary-action:disabled {
    background-color: #27ae60 !important;
    opacity: 1;
}

.grayscale {
    filter: grayscale(1);
    opacity: 0.4;
}

.cursor-pointer {
    cursor: pointer;
}

@media (max-width: 991px) {
    .navbar-brand {
        font-size: 1.5rem !important;
    }
}
</style>