<template>
    <div class="homepage">
        <!-- Hero Section -->
        <section class="hero-section py-5 position-relative" style="min-height: 90vh; display: flex; align-items: center;">
            <div class="container pt-5 mt-4">
                <div class="row align-items-center">
                    <!-- Left Content -->
                    <div class="col-lg-6 mb-5 mb-lg-0 z-1 pe-lg-5">
                        <div class="d-inline-flex align-items-center rounded-pill px-3 py-2 mb-4 bg-orange-subtle">
                            <span class="text-orange fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 1px;">TRẢI NGHIỆM AI THẾ HỆ MỚI</span>
                        </div>
                        <h1 class="display-4 fw-bold mb-4 pe-lg-4" style="line-height: 1.15; font-weight: 800 !important; color: #1a1e29; letter-spacing: -1px;">
                            Kiến tạo không gian<br>
                            <span class="text-gradient">hội thoại tương lai</span>
                        </h1>
                        <p class="mb-5 text-muted lh-lg" style="font-size: 1.05rem; max-width: 500px;">
                            Nền tảng họp trực tuyến tích hợp AI nhận diện khuôn mặt và tự động hóa biên bản cuộc họp, giúp tối ưu hóa 200% hiệu suất làm việc của doanh nghiệp bạn.
                        </p>
                        <div class="d-flex align-items-center gap-3 flex-wrap">
                            <a href="#" v-if="!isLoggedIn" @click.prevent="handleThuNghiemClick" class="btn btn-orange px-4 py-3 fw-bold rounded-pill shadow-sm d-flex align-items-center gap-2">
                                Bắt đầu ngay <i class='bx bx-right-arrow-alt fs-5'></i>
                            </a>
                            <template v-else>
                                <router-link v-if="isDoiTac == 0" to="/nguoi-dung/trang-chinh" class="btn btn-orange px-4 py-3 fw-bold rounded-pill shadow-sm d-flex align-items-center gap-2">Trang của tôi <i class='bx bx-right-arrow-alt fs-5'></i></router-link>
                                <router-link v-else-if="isDoiTac == 1" to="/doi-tac/trang-chinh" class="btn btn-orange px-4 py-3 fw-bold rounded-pill shadow-sm d-flex align-items-center gap-2">Trang đối tác <i class='bx bx-right-arrow-alt fs-5'></i></router-link>
                            </template> 
                        </div>
                        
                        <div class="mt-5 pt-3 d-flex align-items-center gap-3">
                            <div class="d-flex">
                                <div class="rounded-circle border border-2 border-white bg-secondary overflow-hidden" style="width: 35px; height: 35px; margin-left: -10px; z-index: 4;"><img src="https://ui-avatars.com/api/?name=User+1&background=random" class="w-100 h-100"></div>
                                <div class="rounded-circle border border-2 border-white bg-secondary overflow-hidden" style="width: 35px; height: 35px; margin-left: -10px; z-index: 3;"><img src="https://ui-avatars.com/api/?name=User+2&background=random" class="w-100 h-100"></div>
                                <div class="rounded-circle border border-2 border-white bg-secondary overflow-hidden" style="width: 35px; height: 35px; margin-left: -10px; z-index: 2;"><img src="https://ui-avatars.com/api/?name=User+3&background=random" class="w-100 h-100"></div>
                            </div>
                            <span class="text-muted small fw-medium">+10,000 doanh nghiệp đang tin dùng</span>
                        </div>
                    </div>
                    
                    <!-- Right Content (Mockup) -->
                    <div class="col-lg-6 position-relative mt-5 mt-lg-0">
                        <div class="hero-mockup-wrapper position-relative mx-auto" style="max-width: 550px;">
                            <!-- Soft Background blob/shape behind mockup -->
                            <div class="position-absolute" style="top: -10%; right: -10%; width: 120%; height: 120%; background: radial-gradient(circle, #FFE4D6 0%, rgba(255,237,213,0) 60%); z-index: 0;"></div>
                            
                            <!-- Face ID Scanning Animation Box -->
                            <div class="card border-0 shadow-lg position-relative" style="border-radius: 30px; z-index: 1; overflow: hidden; background: #000; border: 8px solid rgba(255, 255, 255, 0.8) !important; box-shadow: 0 30px 60px rgba(234, 88, 12, 0.1) !important; aspect-ratio: 1/1;">
                                <img src="../../assets/images/hero-face.png" class="w-100 h-100 object-fit-cover" alt="AI Face Recognition" style="filter: brightness(0.85) contrast(1.1); opacity: 0.8;">
                                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center">
                                    <!-- Scanning Box -->
                                    <div class="position-relative" style="width: 80%; height: 85%;">
                                        <!-- Corner brackets -->
                                        <div class="position-absolute top-0 start-0 border-top border-start" style="width: 40px; height: 40px; border-color: #EA580C !important; border-width: 3px !important; border-top-left-radius: 12px;"></div>
                                        <div class="position-absolute top-0 end-0 border-top border-end" style="width: 40px; height: 40px; border-color: #EA580C !important; border-width: 3px !important; border-top-right-radius: 12px;"></div>
                                        <div class="position-absolute bottom-0 start-0 border-bottom border-start" style="width: 40px; height: 40px; border-color: #EA580C !important; border-width: 3px !important; border-bottom-left-radius: 12px;"></div>
                                        <div class="position-absolute bottom-0 end-0 border-bottom border-end" style="width: 40px; height: 40px; border-color: #EA580C !important; border-width: 3px !important; border-bottom-right-radius: 12px;"></div>

                                        <!-- Face Box matching cyan lines -->
                                        <div class="position-absolute border-top border-start border-end" style="top: 20%; left: 10%; right: 10%; height: 35%; border-color: #F97316 !important; border-width: 2px !important;"></div>
                                        <div class="position-absolute border-bottom border-start border-end" style="bottom: 20%; left: 10%; right: 10%; height: 15%; border-color: #F97316 !important; border-width: 2px !important;"></div>

                                        <!-- Horizontal scanning line -->
                                        <div class="position-absolute w-100 scan-line" style="height: 2px; background-color: #FFEDD5; box-shadow: 0 0 15px 4px #EA580C;"></div>

                                        <!-- Badge -->
                                        <div class="position-absolute w-100 text-center" style="bottom: 10%; z-index: 10;">
                                            <div class="d-inline-flex flex-column align-items-center px-3 py-2 fw-bold text-white rounded-pill" style="background-color: #EA580C; font-size: 11px;">
                                                <span style="letter-spacing: 0.5px;"><i class='bx bx-scan'></i> ĐANG QUÉT KHUÔN MẶT...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Partners -->
        <section class="py-4 bg-transparent mt-3">
            <div class="container text-center">
                <p class="text-muted fw-bold mb-4 text-uppercase" style="letter-spacing: 2px; font-size: 0.75rem;">ĐỐI TÁC CHIẾN LƯỢC</p>
                <div class="d-flex justify-content-center align-items-center gap-4 gap-md-5 flex-wrap text-muted fw-bold fs-5 grayscale opacity-50">
                    <span style="font-family: Arial, Helvetica, sans-serif; letter-spacing: 1px;">VINTECH</span>
                    <span style="font-family: Arial, Helvetica, sans-serif; letter-spacing: 1px;">FPT AI</span>
                    <span style="font-family: Arial, Helvetica, sans-serif; letter-spacing: 1px;">MOCHA</span>
                    <span style="font-family: Arial, Helvetica, sans-serif; letter-spacing: 1px;">VNPT</span>
                    <span style="font-family: Arial, Helvetica, sans-serif; letter-spacing: 1px;">TECHCOM</span>
                </div>
            </div>
        </section>

        <!-- Features -->
        <section id="features" class="py-5 my-5">
            <div class="container py-4">
                <div class="text-center mb-5">
                    <h2 class="display-6 fw-bold mb-3 text-dark" style="letter-spacing: -1px;">Đẳng cấp công nghệ AI</h2>
                    <p class="text-muted mx-auto" style="max-width: 600px; font-size: 1.05rem;">
                        Tích hợp những công nghệ đột phá nhất để biến mỗi cuộc họp trở thành một trải nghiệm thông minh và hiệu quả.
                    </p>
                </div>

                <div class="row g-4 mt-2">
                    <!-- Feature 1 (Large) -->
                    <div class="col-lg-7">
                        <div class="feature-card fc-1 h-100 p-4 p-md-5 d-flex flex-column position-relative overflow-hidden">
                            <div class="mb-4 position-relative z-1">
                                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm mb-4 text-orange" style="width: 54px; height: 54px;">
                                    <i class='bx bx-scan fs-3'></i>
                                </div>
                                <h4 class="fw-bold mb-3 text-dark fs-3">Face ID & Sinh trắc học</h4>
                                <p class="text-muted lh-lg" style="font-size: 1rem; max-width: 380px;">
                                    Tự động nhận diện và điểm danh thành viên tham gia cuộc họp bằng công nghệ AI Face Scanning độ chính xác 99.9%.
                                </p>
                            </div>
                            <div class="position-absolute end-0 bottom-0 p-4 w-50 text-end d-none d-md-block">
                                <div class="bg-white p-2 rounded-4 shadow-sm d-inline-block text-start w-100" style="transform: rotate(-3deg);">
                                    <img src="../../assets/images/face_id_biometric.png" class="w-100 rounded-3 object-fit-cover" alt="Face ID Sinh trắc học" style="height: 120px; object-position: center 20%;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 2 (Medium) -->
                    <div class="col-lg-5">
                        <div class="feature-card fc-2 h-100 p-4 p-md-5 d-flex flex-column">
                            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm mb-4 text-orange" style="width: 54px; height: 54px;">
                                <i class='bx bx-volume-mute fs-3'></i>
                            </div>
                            <h4 class="fw-bold mb-3 text-dark fs-3">Chống ồn AI</h4>
                            <p class="text-muted lh-lg" style="font-size: 1rem;">
                                Loại bỏ hoàn toàn tiếng ồn môi trường, tập trung tối đa vào giọng nói con người bằng thuật toán Neural Link.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 3 (Medium) -->
                    <div class="col-lg-4">
                        <div class="feature-card fc-3 h-100 p-4 p-md-5 d-flex flex-column">
                            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm mb-4 text-orange" style="width: 54px; height: 54px;">
                                <i class='bx bx-file-blank fs-3'></i>
                            </div>
                            <h4 class="fw-bold mb-3 text-dark fs-3">Tóm tắt tự động</h4>
                            <p class="text-muted lh-lg" style="font-size: 1rem;">
                                Tự động tạo biên bản cuộc họp và danh sách công việc cần làm ngay sau khi kết thúc thảo luận.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 4 (Large) -->
                    <div class="col-lg-8">
                        <div class="feature-card fc-4 h-100 p-4 p-md-5 d-flex flex-column position-relative overflow-hidden">
                            <div class="mb-4 position-relative z-1">
                                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm mb-4 text-orange" style="width: 54px; height: 54px;">
                                    <i class='bx bx-transfer-alt fs-3'></i>
                                </div>
                                <h4 class="fw-bold mb-3 text-dark fs-3">Dịch thuật thời gian thực</h4>
                                <p class="text-muted lh-lg" style="font-size: 1rem; max-width: 400px;">
                                    Kết nối không biên giới với tính năng dịch phụ đề trực tiếp hơn 50 ngôn ngữ trong lúc họp.
                                </p>
                            </div>
                            <div class="position-absolute end-0 top-50 translate-middle-y pe-4 w-50 d-none d-md-block opacity-75">
                                <div class="bg-white p-4 rounded-4 shadow-sm w-100">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <span class="badge bg-light text-dark px-3 py-2">English</span>
                                        <i class='bx bx-transfer text-muted'></i>
                                        <span class="badge bg-orange-subtle text-orange px-3 py-2">Tiếng Việt</span>
                                    </div>
                                    <div class="bg-light rounded p-3 mb-2"><span class="text-muted small fw-medium">Hello everyone, let's start.</span></div>
                                    <div class="bg-orange-subtle rounded p-3"><span class="text-orange small fw-bold">Chào mọi người, chúng ta bắt đầu nhé.</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing -->
        <section id="pricing" class="py-5 my-5" style="background-color: #FDF3ED;">
            <div class="container py-5">
                <div class="text-center mb-5 pb-3">
                    <h2 class="display-6 fw-bold mb-3 text-dark" style="letter-spacing: -1px;">Lựa chọn gói dịch vụ</h2>
                    <p class="text-muted mx-auto" style="max-width: 600px; font-size: 1.05rem;">
                        Phù hợp cho mọi quy mô từ cá nhân đến tập đoàn đa quốc gia.
                    </p>
                </div>

                <div class="row g-4 justify-content-center mt-2">
                    <template v-for="(value, index) in list_goi" :key="index">
                        <div v-if="value.is_hien_thi" :class="['col-lg-4', index == 1 ? 'position-relative z-2' : 'mt-lg-4 z-1']">
                            
                            <!-- Popular Badge -->
                            <div v-if="index == 1" class="position-absolute start-50 translate-middle-x" style="top: -16px; z-index: 10;">
                                <div class="bg-orange text-white fw-bold px-4 py-2 rounded-pill shadow" style="font-size: 0.8rem; letter-spacing: 1px;">
                                    PHỔ BIẾN NHẤT
                                </div>
                            </div>

                            <div class="pricing-card card h-100 p-4 p-xl-5 bg-white" :style="index == 1 ? 'box-shadow: 0 20px 60px rgba(234,88,12,0.1) !important; transform: scale(1.04);' : 'box-shadow: 0 10px 30px rgba(0,0,0,0.02);'">
                                <div class="mb-4">
                                    <h6 class="fw-bold text-dark mb-2" style="font-size: 1.1rem;">{{ value.ten_goi }}</h6>
                                    <h2 class="fw-bold mb-0 text-dark d-flex align-items-baseline gap-1" style="font-size: 2.2rem; letter-spacing: -1px;">
                                        {{ value.gia_goi > 0 ? formatVND(value.gia_goi) : (value.gia_goi == 0 ? 'Miễn phí' : 'Liên hệ') }}
                                        <span v-if="value.gia_goi > 0" class="text-muted fw-normal" style="font-size: 0.9rem; letter-spacing: 0;">/tháng</span>
                                    </h2>
                                    <p class="text-muted mt-2 mb-0 small" style="min-height: 40px;">{{ index == 0 ? 'Dành cho 1 người dùng' : (index == 1 ? 'Dành cho các nhóm startup' : 'Dành cho tập đoàn lớn') }}</p>
                                </div>

                                <hr class="text-muted opacity-10 mb-4">

                                <ul class="list-unstyled mb-5 flex-grow-1">
                                    <li class="mb-3 d-flex align-items-start gap-2">
                                        <i class='bx bx-check-circle text-orange fs-5 mt-1'></i>
                                        <span class="text-dark" style="font-size: 0.95rem;">Tối đa {{ value.so_nguoi_toi_da }} người tham gia</span>
                                    </li>
                                    <li class="mb-3 d-flex align-items-start gap-2">
                                        <i class='bx bx-check-circle text-orange fs-5 mt-1'></i>
                                        <span class="text-dark" style="font-size: 0.95rem;">Tối đa {{ value.so_phong_toi_da }} phòng họp</span>
                                    </li>
                                    <li class="mb-3 d-flex align-items-start gap-2">
                                        <i class='bx bx-check-circle text-orange fs-5 mt-1'></i>
                                        <span class="text-dark" style="font-size: 0.95rem;">Thời hạn: {{ value.thoi_han }} ngày</span>
                                    </li>
                                    <li class="mb-3 d-flex align-items-start gap-2">
                                        <i class='bx bx-check-circle text-orange fs-5 mt-1'></i>
                                        <span class="text-dark" style="font-size: 0.95rem;">{{ value.mo_ta }}</span>
                                    </li>
                                    
                                    <li v-if="index >= 1" class="mb-3 d-flex align-items-start gap-2">
                                        <i class='bx bx-check-circle text-orange fs-5 mt-1'></i>
                                        <span class="text-dark" style="font-size: 0.95rem;">{{ index == 1 ? 'Tích hợp AI tóm tắt nội dung' : 'Tùy biến AI theo dữ liệu riêng' }}</span>
                                    </li>
                                    <li v-if="index >= 1" class="mb-3 d-flex align-items-start gap-2">
                                        <i class='bx bx-check-circle text-orange fs-5 mt-1'></i>
                                        <span class="text-dark" style="font-size: 0.95rem;">{{ index == 1 ? 'Hỗ trợ 24/7 chuyên nghiệp' : 'Quản lý tập trung SSO/SAML' }}</span>
                                    </li>
                                </ul>

                                <button :class="['btn w-100 py-3 rounded-3 fw-bold mt-auto transition', index == 1 ? 'btn-orange shadow-sm' : 'btn-outline-dark']" style="font-size: 0.95rem;">
                                    {{ value.gia_goi == 0 ? 'Sử dụng ngay' : (value.gia_goi > 0 ? 'Dùng thử 14 ngày' : 'Liên hệ chúng tôi') }}
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section id="contact" class="container mb-5 pb-5 mt-5 pt-3">
            <div class="cta-section p-5 text-center text-white shadow-lg d-flex align-items-center justify-content-center flex-column" style="border-radius: 32px; min-height: 400px;">
                <div class="cta-bg-shape" style="width: 400px; height: 400px; top: -150px; left: -100px;"></div>
                <div class="cta-bg-shape" style="width: 500px; height: 500px; bottom: -250px; right: -150px;"></div>
                
                <div class="position-relative z-1 py-4">
                    <h2 class="display-5 fw-bold mb-4" style="letter-spacing: -1px;">Sẵn sàng nâng cấp<br>văn hóa họp của bạn?</h2>
                    <p class="mb-5 mx-auto opacity-75" style="max-width: 600px; font-size: 1.1rem;">
                        Gia nhập cùng hàng ngàn doanh nghiệp đang sử dụng AI-Meet để tối ưu hóa quy trình làm việc và ra quyết định nhanh hơn.
                    </p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <button @click.prevent="handleThuNghiemClick" class="btn btn-light px-5 py-3 fw-bold rounded-pill text-orange transition shadow-sm hover-lift">Trải nghiệm miễn phí</button>
                        <button class="btn btn-outline-light px-5 py-3 fw-bold rounded-pill transition hover-lift">Tư vấn giải pháp</button>
                    </div>
                </div>
            </div>
        </section>

      
    </div>
</template>

<script>
import axios from 'axios';
const API = import.meta.env.VITE_API_URL;

export default {
    name: "TrangChu",
    data() {
        return {
            list_goi: [],
            isLoggedIn: false,
            isDoiTac: 0,
        }
    },
    mounted() {
        this.loadDataGoi();
        this.checkLoginStatus();
    },
    methods: {
        checkLoginStatus() {
            const userStr = localStorage.getItem('thong_tin_user');
            const doiTacStr = localStorage.getItem('thong_tin_doi_tac');
            
            if (userStr) {
                this.isLoggedIn = true;
                try {
                    JSON.parse(userStr);
                    // Nếu id_doi_tac có giá trị (không phải null), coi là đối tác
                    this.isDoiTac = 0;
                } catch (e) {
                    this.isDoiTac = 0;
                }
            } else if (doiTacStr) {
                this.isLoggedIn = true;
                this.isDoiTac = 1;
            } else {
                this.isLoggedIn = false;
            }
        },
        handleThuNghiemClick() {
            const userStr = localStorage.getItem('thong_tin_user');
            const doiTacStr = localStorage.getItem('thong_tin_doi_tac');
            if (userStr || doiTacStr) {
                try {
                    let isDoiTac = false;
                    if (userStr) {
                        JSON.parse(userStr);
                    }
                    if (doiTacStr) isDoiTac = true;

                    if (isDoiTac) {
                        if (this.$toast) this.$toast.info('Bạn đã đăng nhập với tài khoản đối tác!');
                    } else {
                        if (this.$toast) this.$toast.info('Bạn đã đăng nhập!');
                    }
                } catch (e) {
                    if (this.$toast) this.$toast.info('Bạn đã đăng nhập!');
                }
            } else {
                this.$router.push('/nguoi-dung/dang-ky');
            }
        },
        loadDataGoi() {
            axios
                .get(API + '/goi/data')
                .then((res) => {
                    this.list_goi = res.data.data;
                });
        },

        formatVND(number) {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND',
            }).format(number);
        },
    }
}
</script>

<style scoped>
.homepage {
    background-color: #FCF8F5;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
    color: #1a1e29;
    overflow-x: hidden;
}

#features,
#pricing,
#contact {
    scroll-margin-top: 96px;
}

.text-gradient {
    background: linear-gradient(90deg, #EA580C, #F97316);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.bg-orange {
    background-color: #EA580C !important;
}

.bg-orange-subtle {
    background-color: #FFEDD5 !important;
}

.text-orange {
    color: #EA580C !important;
}

.btn-orange {
    background-color: #EA580C !important;
    color: white !important;
    border: none;
}

.btn-orange:hover {
    background-color: #C2410C !important;
    color: white !important;
}

.btn-orange-light {
    background-color: #FFEDD5 !important;
    color: #EA580C !important;
    border: none;
}

.btn-orange-light:hover {
    background-color: #FDBA74 !important;
    color: #9A3412 !important;
}

.hover-orange:hover {
    color: #EA580C !important;
}

.hover-orange.bg-light:hover {
    background-color: #FFEDD5 !important;
}

.transition {
    transition: all 0.3s ease;
}

.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-4px);
}

.feature-card {
    border-radius: 32px;
    border: none;
    transition: all 0.4s ease;
}

.feature-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(234, 88, 12, 0.06);
}

.fc-1 { background-color: #FFFFFF; border: 1px solid rgba(0,0,0,0.03); }
.fc-2 { background-color: #FFF5F0; }
.fc-3 { background-color: #FFF5F0; }
.fc-4 { background-color: #FFFFFF; border: 1px solid rgba(0,0,0,0.03); }

.pricing-card {
    border-radius: 32px;
    transition: all 0.4s ease;
    border: 2px solid transparent !important;
}

.pricing-card:hover {
    border-color: rgba(234, 88, 12, 0.2) !important;
    transform: translateY(-5px);
}

.cta-section {
    background: linear-gradient(135deg, #C2410C, #EA580C, #F97316);
    position: relative;
    overflow: hidden;
}

.cta-bg-shape {
    position: absolute;
    background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%);
    border-radius: 50%;
}

.cursor-pointer {
    cursor: pointer;
}

.grayscale {
    filter: grayscale(100%);
}

@keyframes scan-animation {
    0% {
        top: 20%;
        opacity: 1;
    }
    50% {
        top: 80%;
        opacity: 1;
    }
    100% {
        top: 20%;
        opacity: 1;
    }
}

.scan-line {
    animation: scan-animation 3s ease-in-out infinite;
}
</style>
