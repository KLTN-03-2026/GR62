<template>
    <div class="partner-dashboard-wrapper">
        <!-- Main Content Area -->
        <div class="main-layout d-flex h-100">
            <!-- Sidebar (Classic Zoom-style with Labels) -->
            <aside class="sidebar-zoom d-flex flex-column py-4">
                <div class="logo-section px-4 mb-5">
                    <div class="logo-circle shadow-glow">
                        <img src="../../../assets/images/logo.pnj.png" alt="" style="height: 50px; width: 50px;">
                    </div>
                    <span class="ms-3 fw-800 fs-5 text-primary">Đối Tác</span>
                </div>

                <div class="nav-links d-flex flex-column gap-2 px-3 flex-grow-1">
                    <button class="nav-item active">
                        <i class="bx bx-home-alt-2"></i>
                        <span>Trang chủ</span>
                    </button>
                    <button @click="$router.push('/doi-tac/phong-hop')" class="nav-item">
                        <i class="bx bx-video"></i>
                        <span>Phòng họp</span>
                    </button>
                    <button @click="$router.push('/doi-tac/profile')" class="nav-item">
                        <i class="bx bx-user-circle"></i>
                        <span>Hồ sơ</span>
                    </button>
                    <button class="nav-item">
                        <i class="bx bx-history"></i>
                        <span>Lịch sử</span>
                    </button>
                </div>

                <div class="px-3 mt-auto">
                    <button @click="logout" class="nav-item text-danger border-0 w-100 justify-content-start">
                        <i class="bx bx-log-out"></i>
                        <span>Đăng xuất</span>
                    </button>
                </div>
            </aside>

            <!-- Right Content Section -->
            <main class="flex-grow-1 p-0 overflow-auto">
                <!-- Header -->
                <header class="content-header p-4 d-flex justify-content-between align-items-center">
                    <div class="date-header">
                        <h5 class="mb-0 fw-bold animate__animated animate__fadeIn" style="font-variant-numeric: tabular-nums;">{{ currentTime }}</h5>
                        <p class="mb-0 text-muted small" style="font-weight: 500;">{{ currentDate }}</p>
                    </div>
                    <div class="header-actions d-flex align-items-center gap-3">
                        <div class="search-bar-zoom d-none d-md-flex">
                            <i class="bx bx-search"></i>
                            <input type="text" placeholder="Tìm kiếm cuộc họp...">
                        </div>
                        <div class="profile-area" @click="$router.push('/doi-tac/profile')">
                            <img :src="avatarUrl" alt="Partner Avatar" class="header-avatar shadow-sm">
                        </div>
                    </div>
                </header>

                <div class="p-4 p-xl-5">
                    <!-- Welcome Section -->
                    <section class="welcome-banner mb-5 p-5 rounded-5 overflow-hidden position-relative shadow-lg">
                        <div class="banner-content position-relative z-2">
                            <h1 class="display-5 fw-bold text-white mb-2">Chào {{ partnerName }}!</h1>
                            <p class="text-white text-opacity-75 fs-5">Sẵn sàng cho các cuộc họp đột phá hôm nay?</p>
                        </div>
                        <div class="banner-bg-graphics">
                            <div class="blob blob-1"></div>
                            <div class="blob blob-2"></div>
                        </div>
                    </section>

                    <!-- Zoom Quick Actions -->
                    <div class="row g-4 mb-5">
                        <div class="col-md-6 col-lg-3">
                            <div class="quick-card action-orange shadow-hover" data-bs-toggle="modal"
                                data-bs-target="#newMeetingModal">
                                <div class="action-icon-bg">
                                    <i class="bx bxs-video-plus"></i>
                                </div>
                                <h5 class="mt-3 fw-bold">Cuộc họp mới</h5>
                                <p class="text-muted small">Bắt đầu ngay lập tức</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="quick-card action-blue shadow-hover" data-bs-toggle="modal"
                                data-bs-target="#joinMeetingModal">
                                <div class="action-icon-bg"><i class="bx bx-plus-circle"></i></div>
                                <h5 class="mt-3 fw-bold">Tham gia</h5>
                                <p class="text-muted small">Bằng ID hoặc mã code</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="quick-card action-blue shadow-hover" data-bs-toggle="modal"
                                data-bs-target="#scheduleModal">
                                <div class="action-icon-bg">
                                    <i class="bx bxs-calendar"></i>
                                </div>
                                <h5 class="mt-3 fw-bold">Lên lịch</h5>
                                <p class="text-muted small">Lên kế hoạch cuộc họp</p>
                            </div>
                        </div>
                        <!-- Screen Share -->
                        <div class="col-md-6 col-lg-3">
                            <div class="quick-card action-blue shadow-hover" data-bs-toggle="modal"
                                data-bs-target="#shareScreenModal">
                                <div class="action-icon-bg">
                                    <i class="bx bxs-share-alt"></i>
                                </div>
                                <h5 class="mt-3 fw-bold">Chia sẻ màn hình</h5>
                                <p class="text-muted small">Trình bày nhanh chóng</p>
                            </div>
                        </div>
                    </div>

                    <!-- Stats & Meetings -->
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="glass-section p-4 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="fw-bold mb-0">Thống kê hội thoại</h5>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light rounded-pill px-3"
                                            data-bs-toggle="dropdown">Hàng tuần <i
                                                class="bx bx-chevron-down ms-1"></i></button>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div v-for="(stat, idx) in stats" :key="idx" class="col-md-4">
                                        <div class="stat-box p-4 rounded-4 shadow-sm">
                                            <div class="d-flex align-items-center gap-3 mb-2">
                                                <div class="small-icon"
                                                    :style="{ backgroundColor: stat.color + '20', color: stat.color }">
                                                    <i :class="stat.icon"></i>
                                                </div>
                                                <span class="text-muted small fw-medium">{{ stat.label }}</span>
                                            </div>
                                            <h3 class="mb-0 fw-bold">{{ stat.value }}</h3>
                                        </div>
                                    </div>
                                </div>

                                <!-- Weekly Activity Chart -->
                                <div class="weekly-chart-container mt-4 p-4 rounded-4 bg-light-soft border border-light animate__animated animate__fadeIn">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h6 class="fw-bold mb-0">Biểu đồ cuộc họp (7 ngày qua)</h6>
                                        <div class="chart-legend d-flex gap-3">
                                            <div class="d-flex align-items-center gap-1 small text-muted">
                                                <span class="dot bg-primary"></span> Cuộc họp
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chart-wrapper d-flex align-items-end justify-content-between">
                                        <div v-for="day in weeklyData" :key="day.label" class="chart-bar-group d-flex flex-column align-items-center flex-grow-1">
                                            <div class="chart-bar-container w-100 d-flex flex-column align-items-center">
                                                <div class="chart-bar bg-primary shadow-sm" :style="{ height: day.value + 'px' }">
                                                    <div class="bar-tooltip shadow-sm">{{ day.count }} cuộc họp</div>
                                                </div>
                                            </div>
                                            <span class="day-label mt-3 small fw-bold text-muted text-uppercase">{{ day.label }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="glass-section p-4 h-100">
                                <h5 class="fw-bold mb-4">Cuộc họp sắp tới</h5>
                                <div class="meeting-list">
                                    <div v-for="m in upcomingMeetings" :key="m.id"
                                        class="meeting-card p-3 mb-3 rounded-4 border-start border-4"
                                        :style="{ borderColor: m.color }">
                                        <h6 class="mb-1 fw-bold">{{ m.title }}</h6>
                                        <p class="text-muted small mb-2"><i class="bx bx-time-five me-1"></i> {{ m.time
                                        }}</p>
                                        <button class="btn btn-sm w-100 rounded-pill text-white"
                                            :style="{ backgroundColor: m.color }">Bắt đầu</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Join Meeting Modal (Zen Design) -->
        <div class="modal fade" id="joinMeetingModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 rounded-5 shadow-2xl overflow-hidden zen-modal">
                    <div class="modal-header border-0 p-4 pb-0">
                        <div class="d-flex align-items-center gap-3">
                            <div class="modal-icon-header bg-primary-soft text-primary">
                                <i class="bx bxs-video"></i>
                            </div>
                            <h4 class="modal-title fw-800 mb-0">Tham gia cuộc họp</h4>
                        </div>
                        <button type="button" class="btn-close-custom" data-bs-dismiss="modal">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                    <div class="modal-body p-4 p-xl-5">
                        <p class="text-secondary opacity-75 mb-4">Kết nối ngay với đồng nghiệp bằng cách nhập mã định
                            danh cuộc họp bên dưới.</p>

                        <div class="input-group-premium mb-4">
                            <div class="input-icon"><i class="bx bx-hash"></i></div>
                            <input v-model="meetingId" type="text" class="input-field"
                                placeholder="Nhập ID cuộc họp (ví dụ: 888-222-111)">
                        </div>

                        <div class="options-grid mb-4">
                            <div
                                class="option-item d-flex justify-content-between align-items-center p-3 rounded-4 bg-light-soft mb-2">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bx bx-microphone-off text-muted fs-4"></i>
                                    <span class="small fw-600">Không kết nối âm thanh</span>
                                </div>
                                <div class="form-check form-switch pe-0">
                                    <input class="form-check-input custom-switch" type="checkbox" id="noAudio">
                                </div>
                            </div>
                            <div
                                class="option-item d-flex justify-content-between align-items-center p-3 rounded-4 bg-light-soft">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bx bx-video-off text-muted fs-4"></i>
                                    <span class="small fw-600">Tắt video của tôi</span>
                                </div>
                                <div class="form-check form-switch pe-0">
                                    <input class="form-check-input custom-switch" type="checkbox" id="noVideo" checked>
                                </div>
                            </div>
                        </div>

                        <button @click="confirmJoin" class="btn-join-premium w-100 py-3 mb-3" :disabled="!meetingId">
                            <span>THAM GIA NGAY</span>
                            <i class="bx bx-right-arrow-alt ms-2"></i>
                        </button>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0 justify-content-center">
                        <p class="small text-muted opacity-50 mb-0">Tham gia an toàn với bảo mật đầu cuối</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- New Meeting Modal -->
        <div class="modal fade" id="newMeetingModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 rounded-5 shadow-2xl overflow-hidden zen-modal">
                    <div class="modal-header border-0 p-4 pb-0">
                        <div class="d-flex align-items-center gap-3">
                            <div class="modal-icon-header bg-orange-soft text-orange">
                                <i class="bx bxs-video-plus"></i>
                            </div>
                            <h4 class="modal-title fw-800 mb-0">Cuộc họp mới</h4>
                        </div>
                        <button type="button" class="btn-close-custom" data-bs-dismiss="modal"><i
                                class="bx bx-x"></i></button>
                    </div>
                    <div class="modal-body p-4 p-xl-5">
                        <div class="options-grid mb-4">
                            <div
                                class="option-item d-flex justify-content-between align-items-center p-3 rounded-4 bg-light-soft mb-2">
                                <span class="small fw-600">Bắt đầu với Video</span>
                                <div class="form-check form-switch pe-0">
                                    <input v-model="newMeetingData.video" class="form-check-input custom-switch"
                                        type="checkbox">
                                </div>
                            </div>
                            <div
                                class="option-item d-flex justify-content-between align-items-center p-3 rounded-4 bg-light-soft">
                                <span class="small fw-600">Sử dụng ID cuộc họp cá nhân (PMI)</span>
                                <div class="form-check form-switch pe-0">
                                    <input v-model="newMeetingData.usePMI" class="form-check-input custom-switch"
                                        type="checkbox">
                                </div>
                            </div>
                        </div>
                        <div class="p-3 bg-blue-soft rounded-4 mb-4 border border-primary border-opacity-10">
                            <small class="text-primary fw-bold d-block mb-1">ID Cá nhân của bạn</small>
                            <h5 class="fw-bold mb-0">888 999 0000</h5>
                        </div>
                        <button @click="startInstantMeeting" class="btn-orange-premium w-100 py-3 fw-bold">
                            BẮT ĐẦU CUỘC HỌP
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Schedule Modal -->
        <div class="modal fade" id="scheduleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 rounded-5 shadow-2xl overflow-hidden zen-modal">
                    <div class="modal-header border-0 p-4 pb-0">
                        <div class="d-flex align-items-center gap-3">
                            <div class="modal-icon-header bg-blue-soft text-primary">
                                <i class="bx bxs-calendar"></i>
                            </div>
                            <h4 class="modal-title fw-800 mb-0">Lên lịch cuộc họp</h4>
                        </div>
                        <button type="button" class="btn-close-custom" data-bs-dismiss="modal"><i
                                class="bx bx-x"></i></button>
                    </div>
                    <div class="modal-body p-4 p-xl-5">
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="small fw-700 text-muted mb-2">Chủ đề cuộc họp</label>
                                <input v-model="scheduleData.topic" type="text" class="input-field-simple"
                                    placeholder="Ví dụ: Họp định kỳ tuần 4">
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-700 text-muted mb-2">Ngày bắt đầu</label>
                                <input v-model="scheduleData.date" type="date" class="input-field-simple">
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-700 text-muted mb-2">Thời gian</label>
                                <input v-model="scheduleData.time" type="time" class="input-field-simple">
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-700 text-muted mb-2">Thời lượng (Phút)</label>
                                <select v-model="scheduleData.duration" class="input-field-simple">
                                    <option value="30">30 Phút</option>
                                    <option value="60">60 Phút</option>
                                    <option value="90">90 Phút</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-700 text-muted mb-2">Mật khẩu (Tùy chọn)</label>
                                <input v-model="scheduleData.password" type="text" class="input-field-simple"
                                    placeholder="Mã bảo vệ">
                            </div>
                        </div>
                        <button @click="confirmSchedule" class="btn-join-premium w-100 py-3 mt-5 fw-bold">
                            LƯU LỊCH TRÌNH
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Share Screen Modal -->
        <div class="modal fade" id="shareScreenModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 rounded-5 shadow-2xl overflow-hidden zen-modal">
                    <div class="modal-header border-0 p-4 pb-0">
                        <div class="d-flex align-items-center gap-3">
                            <div class="modal-icon-header bg-blue-soft text-primary">
                                <i class="bx bxs-share-alt"></i>
                            </div>
                            <h4 class="modal-title fw-800 mb-0">Chia sẻ màn hình</h4>
                        </div>
                        <button type="button" class="btn-close-custom" data-bs-dismiss="modal"><i
                                class="bx bx-x"></i></button>
                    </div>
                    <div class="modal-body p-4 p-xl-5">
                        <p class="text-secondary opacity-75 mb-4">Nhập ID cuộc họp hoặc Khóa chia sẻ để bắt đầu trình
                            chiếu.</p>
                        <div class="input-group-premium mb-4">
                            <div class="input-icon"><i class="bx bx-cast"></i></div>
                            <input v-model="shareData.key" type="text" class="input-field" placeholder="Mã chia sẻ">
                        </div>
                        <button @click="confirmShare" class="btn-join-premium w-100 py-3 fw-bold"
                            :disabled="!shareData.key">
                            BẮT ĐẦU CHIA SẺ
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: 'TrangChinhDoiTac',
    data() {
        return {
            partnerName: 'Đối Tác',
            avatarUrl: 'https://i.pravatar.cc/150?u=partner',
            currentTime: '',
            currentDate: '',
            timer: null,
            meetingId: '',
            newMeetingData: { video: true, usePMI: false },
            scheduleData: { topic: '', date: '', time: '', duration: '30', password: '' },
            shareData: { key: '' },
            stats: [
                { label: 'Số Người Dùng', value: '1,284', icon: 'bx bxs-group', color: '#3b82f6' },
                { label: 'Số Phòng Họp', value: '542', icon: 'bx bxs-video', color: '#a855f7' },
                { label: 'Hài Lòng', value: '98%', icon: 'bx bxs-star', color: '#10b981' }
            ],
            upcomingMeetings: [
                { id: 1, title: 'Họp Chiến Lược Q2', time: '10:30 AM', color: '#3b82f6' },
                { id: 2, title: 'Review Giao Diện', time: '02:00 PM', color: '#10b981' }
            ],
            weeklyData: [
                { label: 'Thứ 2', value: 85, count: 12 },
                { label: 'Thứ 3', value: 120, count: 18 },
                { label: 'Thứ 4', value: 60, count: 8 },
                { label: 'Thứ 5', value: 140, count: 22 },
                { label: 'Thứ 6', value: 100, count: 15 },
                { label: 'Thứ 7', value: 40, count: 5 },
                { label: 'Chủ Nhật', value: 25, count: 2 }
            ]
        }
    },
    mounted() {
        this.updateTime();
        this.timer = setInterval(this.updateTime, 1000);
        this.fetchPartnerData();
    },
    beforeUnmount() {
        if (this.timer) {
            clearInterval(this.timer);
        }
    },
    methods: {
        async fetchPartnerData() {
            try {
                const res = await axios.get('http://localhost:8000/api/doi-tac/me', {
                    headers: { Authorization: 'Bearer ' + localStorage.getItem('token_doi_tac') }
                });
                if (res.data.status) {
                    this.partnerName = res.data.data.ho_va_ten;
                    this.avatarUrl = res.data.data.hinh_anh ? 'http://localhost:8000/uploads/avatars/' + res.data.data.hinh_anh : 'https://i.pravatar.cc/150?u=' + res.data.data.id;
                }
            } catch (e) {
                console.error("Lỗi lấy thông tin đối tác");
            }
        },
        updateTime() {
            const now = new Date();
            this.currentTime = now.toLocaleTimeString('en-US', { 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit', 
                hour12: true 
            });
            
            const days = ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'];
            const dayName = days[now.getDay()];
            const dateStr = now.toLocaleDateString('vi-VN', { 
                day: '2-digit', 
                month: '2-digit', 
                year: 'numeric' 
            });
            this.currentDate = `${dayName}, ${dateStr}`;
        },
        createMeeting() {
            // This is now triggered via data-bs-toggle in template
        },
        startInstantMeeting() {
            this.$toast.success("Đang khởi tạo cuộc họp tức thì...");
            this.hideModal('newMeetingModal');
        },
        confirmSchedule() {
            this.$toast.success("Đã lên lịch cuộc họp: " + this.scheduleData.topic);
            this.hideModal('scheduleModal');
        },
        confirmShare() {
            this.$toast.info("Đang chuẩn bị chia sẻ màn hình...");
            this.hideModal('shareScreenModal');
        },
        confirmJoin() {
            this.$toast.success("Đang kết nối tới phòng họp: " + this.meetingId);
            this.hideModal('joinMeetingModal');
            this.meetingId = '';
        },
        hideModal(id) {
            const modal = document.getElementById(id);
            const bsModal = bootstrap.Modal.getInstance(modal);
            if (bsModal) bsModal.hide();
        },
        logout() {
            localStorage.removeItem('token_doi_tac');
            this.$router.push('/nguoi-dung/dang-nhap');
        }
    }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

.partner-dashboard-wrapper {
    height: 100vh;
    background-color: #f8fafc;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: #0f172a;
}

/* Sidebar Zoom-style */
.sidebar-zoom {
    width: 260px;
    min-width: 260px;
    flex-shrink: 0;
    background: #ffffff;
    border-right: 1px solid #f1f5f9;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 1000;
}

.logo-section {
    display: flex;
    align-items: center;
}

.logo-circle {
    width: 44px;
    height: 44px;
    background: #3b82f6;
    color: white;
    border-radius: 12px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.nav-item {
    width: 100%;
    padding: 14px 20px;
    border: none !important;
    outline: none !important;
    background: transparent;
    border-radius: 16px;
    color: #64748b;
    font-size: 15px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 16px;
    transition: 0.2s all ease;
    text-align: left;
    white-space: nowrap;
}

.nav-item i {
    font-size: 22px;
}

.nav-item:hover,
.nav-item.active {
    background: #eff6ff;
    color: #3b82f6;
}

.content-header {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid #f1f5f9;
}

.search-bar-zoom {
    background: #f1f5f9;
    border-radius: 100px;
    padding: 10px 20px;
    gap: 10px;
}

.search-bar-zoom input {
    background: transparent;
    border: none;
    outline: none;
    font-size: 14px;
}

.header-avatar {
    width: 42px;
    height: 42px;
    border-radius: 14px;
    cursor: pointer;
    transition: 0.2s;
}

.header-avatar:hover {
    transform: scale(1.05);
}

.welcome-banner {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
}

.blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(60px);
    opacity: 0.3;
}

.blob-1 {
    width: 300px;
    height: 300px;
    background: #93c5fd;
    top: -100px;
    right: -50px;
}

.blob-2 {
    width: 250px;
    height: 250px;
    background: #60a5fa;
    bottom: -50px;
    left: -50px;
}

.quick-card {
    background: white;
    padding: 35px 20px;
    border-radius: 35px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    border: 1.5px solid transparent;
}

.quick-card:hover {
    border-color: #3b82f6;
    transform: translateY(-10px);
}

.action-icon-bg {
    width: 64px;
    height: 64px;
    border-radius: 22px;
    margin: 0 auto;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 32px;
    color: white;
}

.action-orange .action-icon-bg {
    background: #f59e0b;
    box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3);
}

.action-blue .action-icon-bg {
    background: #3b82f6;
    box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
}

.glass-section {
    background: white;
    border-radius: 35px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
}

.stat-box {
    background: #f8fafc;
    border: 1px solid #f1f5f9;
}

.small-icon {
    width: 38px;
    height: 38px;
    border-radius: 12px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.shadow-primary {
    box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
}

.shadow-glow {
    box-shadow: 0 0 20px rgba(59, 130, 246, 0.4);
}

/* Zen Modal Theme */
.zen-modal {
    background: #ffffff;
    box-shadow: 0 50px 100px -20px rgba(0, 0, 0, 0.25);
}

.modal-icon-header {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 24px;
}

.bg-primary-soft {
    background: #eff6ff;
}

.bg-orange-soft {
    background: #fff7ed;
}

.bg-blue-soft {
    background: #eff6ff;
}

.text-orange {
    color: #f59e0b;
}

.fw-800 {
    font-weight: 800;
}

.fw-700 {
    font-weight: 700;
}

.fw-600 {
    font-weight: 600;
}

.btn-close-custom {
    background: #f1f5f9;
    border: none;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #64748b;
    transition: 0.2s;
}

.btn-close-custom:hover {
    background: #e2e8f0;
    color: #0f172a;
}

.input-group-premium {
    position: relative;
    display: flex;
    align-items: center;
}

.input-icon {
    position: absolute;
    left: 20px;
    color: #94a3b8;
    font-size: 20px;
}

.input-field {
    width: 100%;
    padding: 18px 20px 18px 55px;
    background: #f8fafc;
    border: 2px solid #f1f5f9;
    border-radius: 20px;
    outline: none;
    transition: 0.3s;
    font-weight: 500;
}

.input-field:focus {
    background: white;
    border-color: #3b82f6;
    box-shadow: 0 10px 20px rgba(59, 130, 246, 0.05);
}

.bg-light-soft {
    background: #f8fafc;
}

.custom-switch {
    width: 3rem !important;
    height: 1.5rem !important;
    cursor: pointer;
}

.btn-join-premium {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
    border: none;
    border-radius: 20px;
    font-weight: 700;
    letter-spacing: 0.5px;
    transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    box-shadow: 0 15px 30px -5px rgba(59, 130, 246, 0.4);
}

.btn-join-premium:hover:not(:disabled) {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px -5px rgba(59, 130, 246, 0.5);
}

.btn-join-premium:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    background: #94a3b8;
    box-shadow: none;
}

.btn-orange-premium {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    border: none;
    border-radius: 20px;
    padding: 15px;
    font-weight: 700;
    box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3);
    transition: 0.3s;
}

.btn-orange-premium:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(245, 158, 11, 0.4);
}

.input-field-simple {
    width: 100%;
    padding: 12px 18px;
    background: #f8fafc;
    border: 2px solid #f1f5f9;
    border-radius: 14px;
    outline: none;
    transition: 0.2s;
}

.input-field-simple:focus {
    border-color: #3b82f6;
    background: white;
}

.shadow-2xl {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
}

.modal-content {
    background: white !important;
}

.bg-light {
    background-color: #f1f5f9 !important;
}

@media (max-width: 1200px) {
    .sidebar-zoom {
        width: 220px;
    }

    .nav-item span {
        font-size: 14px;
        gap: 10px;
    }
}

@media (max-width: 992px) {
    .sidebar-zoom {
        width: 80px;
    }

    .nav-item span,
    .logo-section span {
        display: none;
    }

    .nav-item {
        justify-content: center;
        padding: 12px 0;
    }

    .logo-section {
        justify-content: center;
        padding: 0;
    }
}

/* Weekly Chart Styles */
.chart-wrapper {
    height: 180px;
    padding-top: 20px;
    border-bottom: 2px solid #f1f5f9;
}

.chart-bar-container {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
}

.chart-bar {
    width: 32px;
    border-radius: 10px 10px 0 0;
    position: relative;
    transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    cursor: pointer;
}

.chart-bar:hover {
    filter: brightness(1.1);
    transform: scaleX(1.1);
}

.bar-tooltip {
    position: absolute;
    top: -40px;
    left: 50%;
    transform: translateX(-50%) translateY(10px);
    background: #1e293b;
    color: white;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: 0.3s;
    z-index: 10;
}

.chart-bar:hover .bar-tooltip {
    opacity: 1;
    visibility: visible;
    transform: translateX(-50%) translateY(0);
}

.dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
}

.day-label {
    font-size: 10px;
    letter-spacing: 0.5px;
}
</style>
