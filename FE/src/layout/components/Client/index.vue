<template>
    <div class="ai-meet-landing">
        <!-- Header -->


        <!-- Hero Section -->
        <section class="hero-section py-5 d-flex align-items-center position-relative overflow-hidden">
            <div class="bg-decoration"></div>
            <div class="container position-relative z-1">
                <div class="row align-items-center">
                    <div class="col-lg-6 pes-lg-5">
                        <div class="badge-tag mb-3">
                            <i class='bx bxs-check-circle me-1'></i> AI FACIAL RECOGNITION TECHNOLOGY
                        </div>
                        <h1 class="display-3 fw-black mb-4 lh-1">
                            Kiến tạo không gian <br>
                            <span class="text-italic-orange">hội thoại</span> tương lai.
                        </h1>
                        <p class="lead text-muted mb-5 max-w-500">
                            Hệ thống hợp trực tuyến thế hệ mới tích hợp trí tuệ nhân tạo,
                            nhận diện khuôn mặt và bảo mật tuyệt đối cho doanh nghiệp hiện đại.
                        </p>
                        <div class="d-flex flex-wrap gap-3">
                            <router-link to="/nguoi-dung/dang-nhap"
                                class="btn-orange shadow-lg px-5 py-3 rounded-pill fw-bold">
                                Bắt đầu <i class='bx bx-right-arrow-alt ms-2'></i>
                            </router-link>

                        </div>

                        <div
                            class="mt-4 verification-pill d-inline-flex align-items-center gap-2 p-2 rounded-4 glass-card-light">
                            <div class="icon-check-orange"><i class='bx bx-check'></i></div>
                            <div>
                                <div class="small fw-bold">Face ID Verified</div>
                                <div class="x-small opacity-75">99.8% Độ chính xác</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-5 mt-lg-0">
                        <div class="dashboard-visual-wrapper p-3 rounded-5 position-relative">
                            <div class="visual-header d-flex align-items-center gap-2 mb-3">
                                <div class="h5 mb-0 fw-bold">AI-AI-MEET</div>
                            </div>
                            <div class="position-relative overflow-hidden rounded-4">
                                <img src="/ai_dashboard_visual.png" class="img-fluid w-100 shadow-2xl"
                                    alt="AI Dashboard">
                                <div class="hero-scan-line"></div>
                            </div>
                            <div class="visual-floating-card top-0 start-0 translate-middle-y">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="status-dot"></span>
                                    <span class="fw-bold small">AI Active</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Empower Section -->
        <section class="empower-section py-6" id="features">
            <div class="container">
                <div class="text-center mb-60">
                    <h2 class="display-4 fw-bold mb-3">Trải nghiệm quyền năng của AI</h2>
                    <p class="text-muted fw-medium">Đột phá ranh giới của hội thoại truyền thống với những tính năng độc
                        bản chỉ có tại AI-Meet.</p>
                </div>

                <div class="features-grid-complex">
                    <!-- Feature 1: Wide -->
                    <div class="feature-card wide p-5 rounded-5 shadow-sm">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <div class="icon-circle mb-3"><i class='bx bxs-face'></i></div>
                                <h3 class="fw-bold mb-3">Bảo mật sinh trắc học</h3>
                                <p class="text-muted small">Mã hóa đa lớp kết hợp nhận dạng sinh học, đảm bảo cuộc họp
                                    của bạn chỉ có người được cấp phép mới có thể truy cập.</p>
                            </div>
                            <div class="col-md-7 mt-4 mt-md-0">
                                <div class="visual-placeholder rounded-4 overflow-hidden border shadow-sm">
                                    <img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&q=80&w=800"
                                        class="w-100 object-fit-cover" height="180" alt="Security Visual">
                                    <div class="scan-effect"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 2: High (AI Face ID) -->
                    <div class="feature-card high p-5 rounded-5 shadow-lg d-flex flex-column justify-content-center">
                        <div class="icon-circle-light mb-4"><i class='bx bxs-user-account'></i></div>
                        <h3 class="fw-bold mb-3 h2">AI Face ID</h3>
                        <p class="opacity-90 small mb-0">Tự động điểm danh và xác thực danh tính người tham gia trong
                            thời gian thực bằng thuật toán nhận diện khuôn mặt tiên tiến.</p>
                    </div>

                    <!-- Feature 3: Small (Tóm tắt thông minh) -->
                    <div
                        class="feature-card small-peach p-5 rounded-5 shadow-sm d-flex flex-column justify-content-between">
                        <div>
                            <div class="icon-circle-orange mb-3"><i class='bx bxs-file-blank'></i></div>
                            <h3 class="fw-bold mb-3 h5">Tóm tắt thông minh</h3>
                            <p class="text-muted small">Tự động ghi chép và tóm tắt nội dung cuộc họp bằng văn bản sau
                                mỗi phiên làm việc.</p>
                        </div>
                        <a href="#"
                            class="text-orange fw-bold small text-decoration-none d-flex align-items-center gap-1">Khám
                            phá ngay <i class='bx bx-right-arrow-alt'></i></a>
                    </div>

                    <!-- Feature 4: Wide Dark -->
                    <div class="feature-card wide-dark p-5 rounded-5 text-white shadow-lg">
                        <div class="row align-items-center">
                            <div class="col-md-6 mb-4 mb-md-0">
                                <div class="icon-circle-orange mb-3"><i class='bx bxs-video'></i></div>
                                <h3 class="fw-bold mb-3 text-white">Hình ảnh 4K Ultra HD</h3>
                                <p class="opacity-70 small">Truyền tải hình ảnh sắc nét đến từng chi tiết, giảm thiểu độ
                                    trễ tối đa nhờ hạ tầng cloud server phân tán toàn cầu.</p>
                            </div>
                            <div class="col-md-6 text-center">
                                <div
                                    class="video-preview-box rounded-4 d-flex align-items-center justify-content-center p-5 border border-white-10">
                                    <div class="play-btn-orange"><i class='bx bx-play'></i></div>
                                </div>
                                <div class="mt-2 text-white-50 x-small text-uppercase ls-1">Safe Quality</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section class="pricing-section py-6 bg-soft-orange" id="pricing">
            <div class="container">
                <div class="text-center mb-60">
                    <h2 class="display-4 fw-bold mb-3">Bảng giá linh hoạt</h2>
                    <p class="text-muted">Lựa chọn gói dịch vụ phù hợp nhất với quy mô đội ngũ của bạn.</p>
                </div>

                <div class="row g-4 justify-content-center">
                    <div v-for="(value, index) in list_goi.slice(0, 3)" :key="index" class="col-lg-4">
                        <div class="pricing-card rounded-5 p-5 shadow-sm bg-white border border-light transition-all"
                            :class="{ 'featured border-orange shadow-lg': index == 1 }">

                            <div v-if="index == 1" class="featured-badge">PHỔ BIẾN NHẤT</div>

                            <h5 class="plan-label mb-2 fw-medium text-muted">{{ value.id == 1 ? 'Basic' : (value.id == 2
                                ? 'Professional' : 'Enterprise') }}</h5>
                            <div class="d-flex align-items-baseline gap-2 mb-4">
                                <h2 class="display-5 fw-bold mb-0">{{ index == 2 ? 'Liên hệ' :
                                    formatPriceCompact(value.id) }}</h2>
                                <span class="text-muted small" v-if="index < 2">/tháng</span>
                            </div>

                            <ul class="list-unstyled mb-5 p-0">
                                <li class="mb-3 d-flex align-items-center gap-2 small">
                                    <i class='bx bx-check-circle text-success'></i>
                                    <span>Tối đa {{ value.so_phong_toi_da }} phòng họp</span>
                                </li>
                                <li class="mb-3 d-flex align-items-center gap-2 small">
                                    <i class='bx bx-check-circle text-success'></i>
                                    <span>Tối đa {{ value.so_nguoi_toi_da }} người tham gia</span>
                                </li>
                                <li class="mb-3 d-flex align-items-center gap-2 small"
                                    :class="{ 'opacity-50 text-decoration-line-through': index == 0 }">
                                    <i
                                        :class="index == 0 ? 'bx bx-x-circle text-muted' : 'bx bx-check-circle text-success'"></i>
                                    <span>Quản lý AI Face ID & Điểm danh</span>
                                </li>
                                <li class="mb-3 d-flex align-items-center gap-2 small"
                                    :class="{ 'opacity-50 text-decoration-line-through': index < 2 }">
                                    <i
                                        :class="index < 2 ? 'bx bx-x-circle text-muted' : 'bx bx-check-circle text-success'"></i>
                                    <span>Hỗ trợ 24/7 ưu tiên</span>
                                </li>
                            </ul>

                            <router-link :to="'/chi-tiet-goi/' + value.id"
                                class="btn w-100 py-3 rounded-pill fw-bold transition-all shadow-sm"
                                :class="index == 1 ? 'btn-orange' : 'btn-outline-dark'">
                                {{ index == 1 ? 'Dùng thử 7 ngày' : (index == 2 ? 'Gửi yêu cầu' : 'Sử dụng ngay') }}
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section py-6">
            <div class="container">
                <div
                    class="cta-banner rounded-5 p-5 p-lg-6 bg-dark-slate text-center text-white position-relative overflow-hidden shadow-2xl">
                    <div class="cta-visual-decoration">CALL <span class="soft-vision">SOFT VISION</span></div>
                    <h2 class="display-4 fw-bold mb-4 position-relative z-1">Sẵn sàng trải nghiệm cuộc họp thông minh?
                    </h2>
                    <p class="lead mb-5 opacity-70 position-relative z-1">Tham gia cùng hơn 10.000 doanh nghiệp đang
                        nâng tầm không gian làm việc với AI-Meet.</p>
                    <div class="d-flex flex-wrap justify-content-center gap-3 position-relative z-1">
                        <router-link to="/nguoi-dung/dang-ky" class="btn-orange px-5 py-3 rounded-pill fw-bold">Đăng ký
                            ngay</router-link>
                        <a href="#" class="btn-outline-white px-5 py-3 rounded-pill fw-bold">Liên hệ tư vấn</a>
                    </div>
                </div>
            </div>
        </section>

    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: "TrangChu",
    data() {
        return {
            list_goi: [],
        }
    },
    mounted() {
        this.loadData();
    },
    methods: {
        loadData() {
            axios.get('http://127.0.0.1:8000/api/goi/data')
                .then((res) => {
                    this.list_goi = res.data.data;
                });
        },
        formatPriceCompact(id) {
            if (id == 1) return "0đ";
            if (id == 2) return "499.000đ";
            return "Liên hệ";
        }
    }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap');

.ai-meet-landing {
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: #1a1e29;
    background: #fff;
    overflow-x: hidden;
}

/* Base Styles */
.text-orange {
    color: #FF6600;
}

.bg-dark-slate {
    background: #1a1c1e;
}

.bg-light-offwhite {
    background: #fafafa;
}

.bg-soft-orange {
    background: #fffcf9;
}

.fw-black {
    font-weight: 800;
}

.ls-1 {
    letter-spacing: 1px;
}

.x-small {
    font-size: 11px;
}

.max-w-500 {
    max-width: 500px;
}

.py-6 {
    padding-top: 5rem;
    padding-bottom: 5rem;
}

.mb-60 {
    margin-bottom: 4rem;
}

/* Header styles removed, now in TopClient.vue */

/* Buttons */
.btn-orange {
    background: #FF6600;
    color: #fff;
    border: none;
    padding: 10px 24px;
    transition: all 0.3s ease;
}

.btn-orange:hover {
    background: #e65c00;
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(255, 102, 0, 0.2);
    color: #fff;
}

.btn-outline-soft {
    background: #fff;
    color: #1a1e29;
    border: 1px solid #eee;
    padding: 10px 24px;
    text-decoration: none;
}

.btn-outline-soft:hover {
    background: #fafafa;
    border-color: #ddd;
}

.btn-outline-white {
    background: transparent;
    color: #fff;
    border: 1px solid rgba(255, 255, 255, 0.2);
    padding: 10px 24px;
    text-decoration: none;
}

.btn-outline-white:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: #fff;
}

/* Hero Style */
.text-italic-orange {
    color: #FF6600;
    font-style: italic;
    position: relative;
    display: inline-block;
}

.text-italic-orange::after {
    content: '';
    position: absolute;
    bottom: 5px;
    left: 0;
    width: 100%;
    height: 8px;
    background: rgba(255, 102, 0, 0.1);
    z-index: -1;
}

.badge-tag {
    display: inline-flex;
    align-items: center;
    background: #fff5f0;
    color: #FF6600;
    font-size: 11px;
    font-weight: 800;
    padding: 6px 12px;
    border-radius: 6px;
    letter-spacing: 0.5px;
}

.bg-decoration {
    position: absolute;
    top: -10%;
    right: -10%;
    width: 60%;
    height: 80%;
    background: radial-gradient(circle, rgba(255, 102, 0, 0.03) 0%, transparent 70%);
    z-index: 0;
}

.dashboard-visual-wrapper {
    background: #fff;
    border: 1px solid #f0f0f0;
    box-shadow: 0 30px 60px -20px rgba(0, 0, 0, 0.05);
}

.hero-scan-line {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(to right, transparent, #FF6600, transparent);
    box-shadow: 0 0 15px #FF6600, 0 0 30px rgba(255, 102, 0, 0.5);
    z-index: 2;
    animation: hero-scanning 4s ease-in-out infinite;
    opacity: 0.8;
}

@keyframes hero-scanning {

    0%,
    100% {
        top: 0%;
        opacity: 0;
    }

    10%,
    90% {
        opacity: 1;
    }

    50% {
        top: 100%;
        opacity: 1;
    }
}

.visual-floating-card {
    position: absolute;
    background: #fff;
    padding: 10px 20px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid #eee;
}

.status-dot {
    display: inline-block;
    width: 8px;
    height: 8px;
    background: #10b981;
    border-radius: 50%;
}

.icon-check-orange {
    width: 32px;
    height: 32px;
    background: #FF6600;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

/* Features Grid Refined */
.features-grid-complex {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    grid-template-rows: repeat(2, minmax(280px, auto));
    gap: 20px;
}

.feature-card.wide {
    grid-column: span 8;
    background: #fffcfb;
    border: 1px solid #fdf0ea;
}

.feature-card.high {
    grid-column: span 4;
    grid-row: span 2;
    background: #FF6600;
    color: #fff;
    padding-top: 60px !important;
}

.feature-card.small-peach {
    grid-column: span 8;
    background: #fffafa;
    border: 1px solid #fef5f0;
}

.feature-card.wide-dark {
    grid-column: span 12;
    background: #1a1c1e;
    margin-top: 10px;
}

.icon-circle {
    width: 48px;
    height: 48px;
    background: #fff;
    color: #FF6600;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    box-shadow: 0 4px 12px rgba(255, 102, 0, 0.1);
}

.icon-circle-light {
    width: 48px;
    height: 48px;
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.icon-circle-orange {
    width: 48px;
    height: 48px;
    background: #FF6600;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.video-preview-box {
    background: #25282b;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.visual-placeholder {
    position: relative;
    background: #eee;
}

.scan-effect {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: #FF6600;
    box-shadow: 0 0 15px #FF6600;
    animation: scanning 3s infinite;
}

@keyframes scanning {
    0% {
        top: 0%;
    }

    100% {
        top: 100%;
    }
}

.play-btn-orange {
    width: 60px;
    height: 60px;
    background: #FF6600;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    padding-left: 5px;
}

/* Pricing */
.pricing-card {
    position: relative;
}

.pricing-card.featured {
    transform: scale(1.03);
}

.featured-badge {
    position: absolute;
    top: 0;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #FF6600;
    color: #fff;
    padding: 6px 20px;
    border-radius: 50px;
    font-size: 11px;
    font-weight: 800;
}

.border-orange {
    border-color: #FF6600 !important;
}

/* CTA */
.cta-banner {
    position: relative;
}

.cta-visual-decoration {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 120px;
    font-weight: 900;
    color: rgba(255, 255, 255, 0.03);
    white-space: nowrap;
    z-index: 0;
}

.soft-vision {
    display: block;
    font-size: 80px;
    margin-top: -40px;
}

/* Footer removed, now in BotClient.vue */
</style>
