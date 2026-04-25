<template>
    <div class="partner-dashboard-wrapper h-100">
        <div class="main-layout d-flex h-100">
            <!-- Sidebar (AI-Meet Business Branding) -->
            <aside class="sidebar-business d-flex flex-column py-5 shadow-sm">
                <div class="logo-section px-4 mb-5">
                    <div class="d-flex align-items-center gap-3">
                        <div class="logo-icon-business">
                            <i class="bx bxs-component fs-3"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-800 text-dark tracking-tighter">AI-Meet Business</h5>
                            <small class="text-muted fw-bold text-uppercase"
                                style="font-size: 0.6rem; letter-spacing: 1.5px;">Đối tác cao cấp</small>
                        </div>
                    </div>
                </div>

                <div class="nav-links d-flex flex-column gap-3 px-3 flex-grow-1 mt-3">
                    <button class="nav-business-item active">
                        <i class="bx bxs-dashboard"></i>
                        <span>Tổng quan</span>
                    </button>

                    <button @click="$router.push('/doi-tac/phong-hop')" class="nav-business-item">
                        <i class="bx bxs-video"></i>
                        <span>Tham gia cuộc họp</span>
                    </button>
                    <button @click="$router.push('/doi-tac/quan-ly-phong-hop')" class="nav-business-item">
                        <i class="bx bxs-megaphone"></i>
                        <span>Quản lý phòng họp</span>
                    </button>
                    <button @click="$router.push('/doi-tac/quan-ly-thanh-vien')" class="nav-business-item">
                        <i class="bx bxs-group"></i>
                        <span>Thành viên</span>
                    </button>
                    <button @click="$router.push('/doi-tac/hoa-don')" class="nav-business-item">
                        <i class="bx bxs-receipt"></i>
                        <span>Hóa đơn</span>
                    </button>
                    <button @click="$router.push('/nguoi-dung/danh-sach-goi')" class="nav-business-item">
                        <i class="bx bxs-package"></i>
                        <span>Mua gói</span>
                    </button>
                    <button @click="$router.push('/doi-tac/bao-cao')" class="nav-business-item">
                        <i class="bx bxs-bar-chart-alt-2"></i>
                        <span>Báo cáo</span>
                    </button>
                    <button @click="$router.push('/doi-tac/profile')" class="nav-business-item">
                        <i class="bx bxs-cog"></i>
                        <span>Cài đặt</span>
                    </button>
                </div>

                <div class="px-3 mt-auto pt-5 border-top border-light">
                    <button class="nav-business-item mb-2 border-0 bg-transparent w-100">
                        <i class="bx bx-help-circle"></i>
                        <span>Hỗ trợ</span>
                    </button>
                    <button @click="logout" class="nav-business-item text-danger border-0 bg-transparent w-100">
                        <i class="bx bx-log-out-circle"></i>
                        <span>Đăng xuất</span>
                    </button>
                </div>
            </aside>

            <!-- Main Content Section -->
            <main class="flex-grow-1 p-0 overflow-auto bg-white">
                <!-- Header -->
                <header class="content-header px-5 py-4 d-flex justify-content-between align-items-center">
                    <div class="search-business d-none d-lg-flex">
                        <i class="bx bx-search text-muted fs-5"></i>
                        <input type="text" placeholder="Tìm kiếm dữ liệu, nhân viên...">
                    </div>

                    <div class="header-right d-flex align-items-center gap-4">
                        <div class="header-icon-btns d-flex gap-3">
                            <div class="icon-btn-plain"><i class="bx bxs-bell fs-4"></i><span class="dot-badge"></span>
                            </div>
                            <div class="icon-btn-plain"><i class="bx bxs-calendar fs-4"></i></div>
                            <div class="icon-btn-plain"><i class="bx bxs-message-square-detail fs-4"></i></div>
                        </div>

                        <div class="profile-trigger-business d-flex align-items-center gap-3 cursor-pointer"
                            @click="$router.push('/doi-tac/profile')">
                            <div class="text-end d-none d-md-block">
                                <h6 class="mb-0 fw-800 text-dark" style="font-size: 0.9rem;">{{ partnerName }}</h6>
                                <small class="text-muted" style="font-size: 0.75rem;">{{ partnerPosition }}</small>
                            </div>
                            <img :src="avatarUrl" alt="Avatar" class="header-avatar-business shadow-sm">
                        </div>
                    </div>
                </header>

                <div class="p-5 pt-4">
                    <!-- Title Section -->
                    <!-- Metrics & Quick Join Row -->
                    <div class="row g-4 mb-5">
                        <div class="col-md-3">
                            <div class="metric-card-business p-4 rounded-5 border-0 h-100">
                                <div class="metric-icon bg-soft-orange text-orange mb-4"><i
                                        class="bx bxs-user-detail"></i></div>
                                <label class="text-muted small fw-800 text-uppercase mb-2 d-block">Nhân viên sử
                                    dụng</label>
                                <div class="d-flex align-items-baseline gap-2">
                                    <h2 class="fw-900 mb-0">{{ stats[0].value }}</h2>
                                    <span class="text-success small fw-bold">{{ stats[0].grow }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric-card-business p-4 rounded-5 border-0 h-100">
                                <div class="metric-icon bg-soft-orange text-orange mb-4"><i
                                        class="bx bxs-time-five"></i></div>
                                <label class="text-muted small fw-800 text-uppercase mb-2 d-block">Tổng giờ họp
                                    tháng</label>
                                <div class="d-flex align-items-baseline gap-2">
                                    <h2 class="fw-900 mb-0">{{ stats[1].value }}</h2>
                                    <span class="text-muted fw-bold">/ ∞</span>
                                </div>
                            </div>
                        </div>

                        <!-- NEW: Quick Join Meeting Card for Partners -->
                        <div class="col-md-6">
                            <div class="metric-card-business p-4 rounded-5 border-0 h-100 shadow-sm"
                                style="background: white; border: 1px solid #fee7d1 !important;">
                                <div class="d-flex align-items-center gap-3 mb-4">
                                    <div class="metric-icon bg-soft-orange text-orange"><i class="bx bxs-keyboard"></i>
                                    </div>
                                    <h5 class="fw-800 text-dark mb-0">Tham gia cuộc họp nhanh</h5>
                                </div>
                                <p class="text-muted small fw-500 mb-4">Kết nối ngay lập tức với các phòng ban bằng mã
                                    định danh.</p>
                                <div class="d-flex gap-3">
                                    <input type="text" v-model="ma_phong_tham_gia"
                                        class="form-control bg-light border-0 py-3 px-4 rounded-4 fw-800"
                                        placeholder="Nhập mã phòng..." @keyup.enter="kiemTraTruocKhiJoin">
                                    <button @click="kiemTraTruocKhiJoin" :disabled="isJoining"
                                        class="btn btn-orange-pro px-4 rounded-4 fw-800 shadow-orange border-0 text-white">
                                        {{ isJoining ? '...' : 'Tham Gia' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Dashboard Content -->
                    <div class="row g-5 mb-5">
                        <!-- Chart Column -->
                        <div class="col-xl-8">
                            <div class="glass-section-business p-5 rounded-5 shadow-faint border-0">
                                <div class="d-flex justify-content-between align-items-center mb-5">
                                    <h4 class="fw-800 text-dark mb-0">Thống kê tần suất cuộc họp</h4>
                                    <div class="chart-filters d-flex gap-2">
                                        <button class="btn btn-sm-pill active">Tuần này</button>
                                        <button class="btn btn-sm-pill">Tháng trước</button>
                                    </div>
                                </div>

                                <div class="activity-visualizer-premium">
                                    <div
                                        class="chart-labels-y d-flex flex-column justify-content-between text-muted small fw-bold">
                                        <span>100</span><span>75</span><span>50</span><span>25</span><span>0</span>
                                    </div>
                                    <div
                                        class="chart-bars-area d-flex align-items-end justify-content-around flex-grow-1">
                                        <div v-for="day in weeklyData" :key="day.label"
                                            class="chart-bar-col d-flex flex-column align-items-center">
                                            <div class="bar-business" :style="{ height: day.value + '%' }">
                                                <div class="bar-glow"></div>
                                            </div>
                                            <span class="bar-label-business mt-5">{{ day.label }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Departments Column -->
                        <div class="col-xl-4">
                            <div class="glass-section-business p-5 rounded-5 shadow-faint border-0 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-5">
                                    <h4 class="fw-800 text-dark mb-0">Phòng ban</h4>
                                    <button class="btn-text-orange fw-800 small text-uppercase">Tất cả</button>
                                </div>

                                <div class="dept-list-business mt-4">
                                    <div v-for="dept in departments" :key="dept.name"
                                        class="dept-item-business d-flex align-items-center mb-4">
                                        <div class="dept-icon-mini me-3"
                                            :style="{ backgroundColor: dept.color + '15', color: dept.color }">
                                            {{ dept.code }}
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="fw-800 text-dark mb-0">{{ dept.name }}</h6>
                                            <small class="text-muted fw-bold">{{ dept.members }} nhân viên</small>
                                        </div>
                                        <div :class="['status-pill-business', dept.status]">
                                            <span class="dot"></span> {{ dept.statusLabel || 'Active' }}
                                        </div>
                                    </div>
                                </div>

                                <button class="btn-manage-dept w-100 py-3 mt-4 rounded-4 fw-800 text-dark">
                                    <i class="bx bxs-cog me-2"></i> Quản lý phòng ban
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Exclusive Features Section -->
                    <div class="exclusive-section mt-5 border-top pt-5">
                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <h4 class="fw-800 text-dark mb-0">Tính năng độc quyền Đối tác</h4>
                            <div class="premium-badge-pill">PREMIUM ACCESS</div>
                        </div>

                        <div class="row g-4">
                            <div v-for="feature in exclusiveFeatures" :key="feature.title" class="col-md-4">
                                <div class="feature-card-business p-5 rounded-5 border-0">
                                    <div class="feature-icon-bg mb-4">
                                        <i :class="feature.icon"></i>
                                    </div>
                                    <h5 class="fw-900 text-dark mb-3">{{ feature.title }}</h5>
                                    <p class="text-muted fw-500 mb-0" style="line-height: 1.6;">{{ feature.description
                                    }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Modal Tạo Cuộc Họp AI for Partner -->
        <div v-if="showCreateMeetingModal"
            class="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center z-3"
            style="background-color: rgba(0, 0, 0, 0.6); backdrop-filter: blur(8px);">
            <div class="card border-0 shadow-lg p-5 animate__animated animate__fadeInUp"
                style="border-radius: 30px; width: 550px; background-color: #fff;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-900 text-dark mb-0">Tạo cuộc họp AI mới</h3>
                    <button @click="showCreateMeetingModal = false" class="btn-close shadow-none"></button>
                </div>

                <form @submit.prevent="taoPhongHop">
                    <div class="mb-4">
                        <label class="form-label fw-800 text-muted small text-uppercase mb-2">Tiêu đề cuộc họp</label>
                        <input type="text" v-model="formTaoPhong.ten_phong" required
                            class="form-control form-control-lg bg-light border-0 shadow-none px-4 py-3 rounded-4"
                            placeholder="Ví dụ: Họp chiến lược quý 2" style="font-weight: 600;">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-800 text-muted small text-uppercase mb-2">Mô tả chi tiết</label>
                        <textarea v-model="formTaoPhong.mo_ta"
                            class="form-control form-control-lg bg-light border-0 shadow-none px-4 py-3 rounded-4"
                            rows="4" placeholder="Nội dung cuộc họp..."
                            style="font-weight: 600; resize: none;"></textarea>
                    </div>
                    <div class="mb-5">
                        <label class="form-label fw-800 text-muted small text-uppercase mb-2">Mời qua Email (tùy
                            chọn)</label>
                        <input type="text" v-model="formTaoPhong.email_khach_moi"
                            class="form-control form-control-lg bg-light border-0 shadow-none px-4 py-3 rounded-4"
                            placeholder="email1@company.com, email2@company.com" style="font-weight: 600;">
                    </div>

                    <div class="d-flex gap-3">
                        <button type="button" @click="showCreateMeetingModal = false"
                            class="btn btn-light-orange-pro flex-grow-1 py-3 fw-800 rounded-4 border-0">
                            Hủy bỏ
                        </button>
                        <button type="submit" :disabled="isCreating"
                            class="btn btn-orange-pro flex-grow-1 py-3 fw-800 rounded-4 border-0 text-white shadow-orange">
                            <span v-if="isCreating" class="spinner-border spinner-border-sm me-2"></span>
                            {{ isCreating ? 'Đang tạo...' : 'Khởi tạo ngay' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
const apiUrl = import.meta.env.VITE_API_URL;

export default {
    name: 'TrangChinhDoiTac',
    data() {
        return {
            partnerId: null,
            showCreateMeetingModal: false,
            isCreating: false,
            formTaoPhong: {
                ten_phong: '',
                mo_ta: '',
                email_khach_moi: ''
            },
            ma_phong_tham_gia: '',
            isJoining: false,
            avatarUrl: 'https://i.pravatar.cc/150?u=admin_anhkim',
            currentTime: '',
            currentDate: '',
            timer: null,
            stats: [
                { label: 'Nhân viên sử dụng', value: '0', grow: '+0%', icon: 'bx bxs-user-detail' },
                { label: 'Tổng giờ họp tháng', value: '0h', icon: 'bx bxs-time-five' },
                { label: 'Chính xác Face ID', value: '100%', icon: 'bx bxs-face' },
                { label: 'Lưu trữ đối tác', value: '0 TB', icon: 'bx bxs-cloud' }
            ],
            weeklyData: [
                { label: 'T2', value: 0 },
                { label: 'T3', value: 0 },
                { label: 'T4', value: 0 },
                { label: 'T5', value: 0 },
                { label: 'T6', value: 0 },
                { label: 'T7', value: 0 },
                { label: 'CN', value: 0 }
            ],
            departments: [],
            exclusiveFeatures: [
                {
                    title: 'Quản trị tập trung',
                    icon: 'bx bx-scan',
                    description: 'Điều hành toàn bộ hệ thống phòng họp và tài khoản nhân viên từ một bảng điều khiển duy nhất dành riêng cho đối tác.'
                },
                {
                    title: 'Bảo mật đa lớp AI',
                    icon: 'bx bx-shield-quarter',
                    description: 'Mã hóa đầu cuối kết hợp nhận diện sinh trắc học AI đảm bảo dữ liệu doanh nghiệp tuyệt mật ở cấp độ cao nhất.'
                },
                {
                    title: 'Báo cáo chuyên sâu',
                    icon: 'bx bxs-bar-chart-square',
                    description: 'Phân tích hành vi, hiệu suất làm việc và mức độ tương tác thông qua dữ liệu cuộc họp AI không giới hạn lưu trữ.'
                }
            ]
        }
    },
    mounted() {
        this.updateTime();
        this.timer = setInterval(this.updateTime, 1000);
        this.fetchPartnerData();
        this.fetchStatistics();
    },
    beforeUnmount() {
        if (this.timer) {
            clearInterval(this.timer);
        }
    },
    methods: {
        async fetchPartnerData() {
            try {
                const token = localStorage.getItem('token_doi_tac');
                if (!token) return;
                const res = await axios.get(`${apiUrl}/doi-tac/me`, {
                    headers: { Authorization: 'Bearer ' + token }
                });
                if (res.data.status) {
                    // Update dynamic info
                    this.partnerId = res.data.data.id;
                    this.partnerName = res.data.data.ho_va_ten;
                    this.partnerPosition = res.data.data.chuc_vu?.ten_chuc_vu || (res.data.data.id_doi_tac == 1 ? "Quản trị viên Đối tác" : "Đối tác");
                    const hinh_anh = res.data.data.hinh_anh;
                    if (hinh_anh) {
                        const baseUrl = apiUrl.replace('/api', '');
                        const cleanPath = hinh_anh.includes('uploads/') ? hinh_anh : `uploads/avatars/${hinh_anh}`;
                        this.avatarUrl = hinh_anh.startsWith('http') ? hinh_anh : `${baseUrl}/${cleanPath}`;
                    }
                }
            } catch (e) {
                console.error("Error fetching partner data");
            }
        },
        async fetchStatistics() {
            try {
                const token = localStorage.getItem('token_doi_tac');
                if (!token) return;
                const res = await axios.get(`${apiUrl}/doi-tac/thong-ke`, {
                    headers: { Authorization: 'Bearer ' + token }
                });
                if (res.data.status) {
                    const data = res.data.data;
                    this.stats[0].value = data.total_nhan_vien.toLocaleString();
                    this.stats[1].value = data.total_hours + 'h';
                    this.weeklyData = data.weekly_data;
                    this.departments = data.departments;
                }
            } catch (e) {
                console.error("Error fetching statistics");
            }
        },
        updateTime() {
            const now = new Date();
            this.currentTime = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
            const days = ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'];
            this.currentDate = `${days[now.getDay()]}, ${now.toLocaleDateString('vi-VN')}`;
        },
        logout() {
            localStorage.removeItem('token_nguoi_dung');
            localStorage.removeItem('thong_tin_user');
            localStorage.removeItem('token_doi_tac');
            this.$toast && this.$toast.success("Đăng xuất thành công!");
            this.$router.push('/');
        },
        async taoPhongHop() {
            if (!this.formTaoPhong.ten_phong.trim()) {
                if (this.$toast) this.$toast.error("Vui lòng nhập tiêu đề cuộc họp!");
                return;
            }

            if (!this.partnerId) {
                if (this.$toast) this.$toast.error("Lỗi: Không xác định được danh tính đối tác.");
                return;
            }
            this.isCreating = true;

            try {
                const payload = {
                    ten_phong: this.formTaoPhong.ten_phong,
                    id_chu_phong: this.partnerId,
                    so_nguoi_toi_da: 100,
                };

                const response = await axios.post(`${apiUrl}/phong-hop/create`, payload);

                if (response.data.status) {
                    if (this.$toast) this.$toast.success("Khởi tạo phòng họp thành công!");

                    const phongMoi = response.data.data;
                    alert(`TẠO THÀNH CÔNG!\n\nMã phòng của bạn là: ${phongMoi.ma_phong}\nHãy copy mã này để tham gia.`);

                    // Reset form và đóng modal
                    this.showCreateMeetingModal = false;
                    this.formTaoPhong.ten_phong = '';
                    this.formTaoPhong.mo_ta = '';
                    this.formTaoPhong.email_khach_moi = '';
                }
            } catch (error) {
                console.error("Lỗi khi tạo phòng:", error);
                if (this.$toast) this.$toast.error("Hệ thống bận, không thể tạo phòng lúc này.");
            } finally {
                this.isCreating = false;
            }
        },
        async kiemTraTruocKhiJoin() {
            if (!this.ma_phong_tham_gia.trim()) {
                if (this.$toast) this.$toast.warning("Vui lòng nhập mã phòng họp!");
                return;
            }
            // Điều hướng sang trang tham gia chính thức của đối tác để thực hiện Face ID
            sessionStorage.setItem('join_ma_phong_tmp', this.ma_phong_tham_gia.trim());
            this.$router.push('/doi-tac/phong-hop');
        },
    }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap');

.partner-dashboard-wrapper {
    background-color: #fff;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: #1a1e29;
}

/* Sidebar Business Style */
.sidebar-business {
    width: 320px;
    background: #fbf9f6;
    border-right: 1px solid #f0ece6;
    z-index: 1000;
}

.logo-icon-business {
    width: 48px;
    height: 48px;
    background: #ea580c;
    color: white;
    border-radius: 12px;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 8px 16px rgba(234, 88, 12, 0.15);
}

.nav-business-item {
    width: 100%;
    padding: 18px 25px;
    border: none;
    background: transparent;
    border-radius: 14px;
    color: #5a5a5a;
    font-size: 0.95rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 15px;
    transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-align: left;
}

.nav-business-item i {
    font-size: 1.5rem;
    color: #7a7a7a;
}

.nav-business-item:hover {
    background: rgba(234, 88, 12, 0.05);
    color: #ea580c;
}

.nav-business-item:hover i {
    color: #ea580c;
}

.nav-business-item.active {
    background: #fff;
    color: #ea580c;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.04);
}

.nav-business-item.active i {
    color: #ea580c;
}

/* Header & Search */
.content-header {
    background: white;
    border-bottom: 1px solid rgba(0, 0, 0, 0.02);
}

.search-business {
    background: #f3f0eb;
    border-radius: 16px;
    padding: 12px 25px;
    width: 480px;
    align-items: center;
    gap: 12px;
    transition: 0.3s;
}

.search-business:focus-within {
    background: #fff;
    box-shadow: 0 0 0 2px #ea580c20;
}

.search-business input {
    background: transparent;
    border: none;
    outline: none;
    font-size: 0.9rem;
    font-weight: 600;
    width: 100%;
    color: #1a1e29;
}

.header-avatar-business {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #fff;
    box-shadow: 0 0 0 1px #f0ece6;
}

.icon-btn-plain {
    width: 46px;
    height: 46px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    color: #5a5a5a;
    position: relative;
    border-radius: 12px;
    transition: 0.2s;
}

.icon-btn-plain:hover {
    background: #fbf9f6;
    color: #1a1e29;
}

.dot-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 9px;
    height: 9px;
    background: #ea580c;
    border-radius: 50%;
    border: 2.5px solid white;
}

/* Metric Cards */
.metric-card-business {
    background: #fbf9f6;
    border: 1px solid #f0ece6 !important;
    padding: 30px !important;
    transition: 0.4s;
}

.metric-card-business:hover {
    background: white;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.06);
    transform: translateY(-8px);
    border-color: #fee7d1 !important;
}

.metric-icon {
    width: 52px;
    height: 52px;
    border-radius: 16px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 1.6rem;
}

.bg-soft-orange {
    background: #fee7d1;
}

.text-orange {
    color: #ea580c;
}

.verified-badge-business {
    width: 26px;
    height: 26px;
    background: white;
    color: #10b981;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 1rem;
    box-shadow: 0 2px 5px rgba(16, 185, 129, 0.2);
}

.progress-premium-business {
    background: #e9e5e0;
    height: 6px;
    border-radius: 100px;
    overflow: hidden;
}

.progress-bar-business {
    background: linear-gradient(to right, #ea580c, #fdba74);
    height: 100%;
    border-radius: 100px;
}

/* Sections */
.glass-section-business {
    background: #fbf9f6;
    border: 1px solid #f0ece6 !important;
}

.btn-sm-pill {
    padding: 8px 20px;
    border-radius: 100px;
    border: none;
    font-weight: 800;
    font-size: 0.75rem;
    color: #7a7a7a;
    background: transparent;
    transition: 0.3s;
}

.btn-sm-pill.active {
    background: #fee7d1;
    color: #ea580c;
}

/* Chart Visualizer */
.activity-visualizer-premium {
    display: flex;
    gap: 15px;
    height: 320px;
}

.chart-labels-y {
    padding-bottom: 55px;
    /* Adjust for bar labels height */
}

.chart-bars-area {
    padding-bottom: 25px;
}

.bar-business {
    width: 60px;
    background: #fff;
    border-radius: 12px;
    position: relative;
    cursor: pointer;
    transition: 0.4s;
    border: 1px solid #f0ece6;
}

.bar-glow {
    position: absolute;
    bottom: 0;
    width: 100%;
    height: 10px;
    /* Base height */
    background: #ea580c;
    border-radius: 11px;
    transition: 0.8s cubic-bezier(0.19, 1, 0.22, 1);
    box-shadow: 0 4px 15px rgba(234, 88, 12, 0.1);
}

.chart-bar-col:hover .bar-glow {
    box-shadow: 0 10px 25px rgba(234, 88, 12, 0.25);
}

.bar-label-business {
    font-size: 0.75rem;
    font-weight: 800;
    color: #5a5a5a;
    letter-spacing: 0.5px;
}

/* Dept List */
.dept-item-business {
    padding: 12px;
    border-radius: 18px;
    transition: 0.3s;
}

.dept-item-business:hover {
    background: #fff;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.02);
}

.dept-icon-mini {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-weight: 900;
    font-size: 0.85rem;
}

.status-pill-business {
    padding: 6px 14px;
    border-radius: 100px;
    font-size: 0.7rem;
    font-weight: 900;
    display: flex;
    align-items: center;
    gap: 8px;
    letter-spacing: 0.3px;
}

.status-pill-business.active {
    background: #dcfce7;
    color: #166534;
}

.status-pill-business.idle {
    background: #fef3c7;
    color: #92400e;
}

.status-pill-business .dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: currentColor;
}

.btn-manage-dept {
    background: #f1ede8;
    border: none;
    transition: 0.3s;
}

.btn-manage-dept:hover {
    background: #e9e5e0;
    transform: translateY(-2px);
}

/* Feature Cards */
.feature-card-business {
    background: #fbf9f6;
    border: 1px solid #f0ece6 !important;
    transition: 0.4s;
}

.feature-card-business:hover {
    background: white;
    box-shadow: 0 30px 70px rgba(0, 0, 0, 0.07);
    transform: translateY(-10px);
}

.feature-icon-bg {
    width: 64px;
    height: 64px;
    background: white;
    border-radius: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 2rem;
    color: #ea580c;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.03);
}

.premium-badge-pill {
    background: #fee7d1;
    color: #ea580c;
    padding: 8px 18px;
    border-radius: 100px;
    font-weight: 900;
    font-size: 0.7rem;
    letter-spacing: 1.2px;
}

/* Side Info section */
.greeting-section h2 {
    font-size: 2.2rem;
}

/* Buttons pro */
.btn-orange-pro {
    background: #ea580c;
    color: #fff !important;
}

.btn-light-orange-pro {
    background: #fbf9f6;
    color: #ea580c;
    border: 1.5px solid #f0ece6 !important;
}

.shadow-orange {
    box-shadow: 0 12px 30px rgba(234, 88, 12, 0.25);
}

.btn-text-orange {
    border: none;
    background: transparent;
    color: #ea580c;
    padding: 0;
    transition: 0.2s;
}

.btn-text-orange:hover {
    filter: brightness(1.2);
    text-decoration: underline;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.metric-card-business {
    animation: fadeIn 0.8s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

/* Utilities */
.fw-900 {
    font-weight: 900;
}

.fw-800 {
    font-weight: 800;
}

.tracking-tighter {
    letter-spacing: -1.2px;
}
</style>
