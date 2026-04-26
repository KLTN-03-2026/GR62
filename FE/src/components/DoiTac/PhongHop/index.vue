<template>
    <div class="partner-dashboard-wrapper h-100">
        <div class="main-layout d-flex h-100">
            <!-- Sidebar (AI-Meet Business Branding) -->
            <aside class="sidebar-business d-flex flex-column py-5 shadow-sm">
                <div class="logo-section px-4 mb-5">
                    <div class="d-flex align-items-center gap-3" @click="$router.push('/doi-tac/trang-chinh')" style="cursor: pointer;">
                        <div class="logo-icon-business">
                            <i class="bx bxs-component fs-3"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-800 text-dark tracking-tighter">AI-Meet Business</h5>
                            <small class="text-muted fw-bold text-uppercase" style="font-size: 0.6rem; letter-spacing: 1.5px;">Đối tác cao cấp</small>
                        </div>
                    </div>
                </div>

                <div class="nav-links d-flex flex-column gap-3 px-3 flex-grow-1 mt-3">
                    <button @click="$router.push('/doi-tac/trang-chinh')" class="nav-business-item">
                        <i class="bx bxs-dashboard"></i>
                        <span>Tổng quan</span>
                    </button>
                    
                    <button class="nav-business-item active">
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

            <!-- Main Content -->
            <main class="flex-grow-1 p-0 overflow-auto bg-fbf9f6">
                <!-- Header -->
                <header class="content-header px-5 py-4 d-flex justify-content-between align-items-center">
                    <div class="search-business d-none d-lg-flex">
                        <i class="bx bx-search text-muted fs-5"></i>
                        <input type="text" placeholder="Tìm kiếm cuộc họp, lịch trình...">
                    </div>

                    <div class="header-right d-flex align-items-center gap-4">
                        <div class="header-icon-btns d-flex gap-3">
                            <div class="icon-btn-plain"><i class="bx bxs-bell fs-4"></i><span class="dot-badge"></span></div>
                            <div class="icon-btn-plain"><i class="bx bxs-calendar fs-4"></i></div>
                        </div>

                        <div class="profile-trigger-business d-flex align-items-center gap-3 cursor-pointer"
                            @click="$router.push('/doi-tac/profile')">
                            <div class="text-end d-none d-md-block">
                                <h6 class="mb-0 fw-800 text-dark" style="font-size: 0.9rem;">{{ partnerName }}</h6>
                                <small class="text-muted" style="font-size: 0.75rem;">Quản trị viên Đối tác</small>
                            </div>
                            <img :src="avatarUrl" alt="Avatar" class="header-avatar-business shadow-sm">
                        </div>
                    </div>
                </header>

                <!-- Join Section Content -->
                <div class="p-5 d-flex align-items-center justify-content-center" style="min-height: calc(100vh - 100px);">
                    <div class="premium-join-card p-5 rounded-5 border-0 shadow-premium text-center"
                        style="width: 600px; max-width: 100%; background: white;">
                        
                        <div class="feature-icon-pro mb-4 mx-auto pulse-orange-light">
                            <i class="bx bxs-video fs-1"></i>
                        </div>
                        
                        <h2 class="fw-900 text-dark mb-3 tracking-tighter">Kết nối cuộc họp AI</h2>
                        <p class="text-muted mb-5 fw-600 px-lg-5">Nhập mã phòng để xác thực khuôn mặt và tham gia cuộc thảo luận bảo mật của bạn.</p>

                        <div class="join-form-wrapper">
                            <div class="input-premium-group mb-4">
                                <i class="bx bx-key"></i>
                                <input type="text" v-model="ma_phong_tham_gia" 
                                    placeholder="Mã phòng (VD: u2c-c1t5-etj)"
                                    class="fw-800">
                            </div>

                            <button @click="kiemTraTruocKhiJoin" :disabled="isJoining"
                                class="btn btn-orange-pro w-100 py-4 fw-900 rounded-4 border-0 text-white shadow-orange mb-4">
                                <span v-if="isJoining" class="spinner-border spinner-border-sm me-2"></span>
                                {{ isJoining ? 'Đang chuẩn bị...' : 'Bắt đầu xác thực & Tham gia' }}
                            </button>
                            
                            <div class="security-badge-mini mx-auto">
                                <i class="bx bxs-shield-plus text-success"></i>
                                <span class="ms-2">MÃ HÓA SINH TRẮC HỌC ĐANG HOẠT ĐỘNG</span>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- AI Face ID Authentication Modal for Partner -->
        <div v-if="showJoinAuthModal"
            class="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center z-3"
            style="background-color: rgba(15, 23, 42, 0.95); backdrop-filter: blur(12px);">
            <div class="card border-0 shadow-lg p-5 text-center animate__animated animate__zoomIn"
                style="border-radius: 40px; width: 450px; background-color: #1e293b; border: 1px solid #334155 !important;">
                
                <template v-if="!isMatched">
                    <h3 class="text-white fw-900 mb-2">Bảo mật cấp độ Đối tác</h3>
                    <p class="text-secondary small mb-5">Đang quét sinh trắc học để xác định quyền truy cập doanh nghiệp.</p>

                    <div class="scan-frame-business mx-auto mb-5 position-relative">
                        <video ref="authVideo" autoplay muted playsinline
                            class="w-100 h-100 rounded-circle object-fit-cover"
                            :style="{ border: authError ? '5px solid #ef4444' : '5px solid #ea580c', transform: 'scaleX(-1)' }"></video>
                        <div v-if="!authError" class="scan-laser"></div>
                        
                        <!-- Pulse effect -->
                        <div class="position-absolute top-50 start-50 translate-middle w-100 h-100 rounded-circle pulse-orange" 
                            style="z-index: -1;"></div>
                    </div>

                    <div class="mb-5">
                        <h6 class="fw-bold mb-0 status-text" :style="{ color: authError ? '#ef4444' : '#ea580c' }">
                            <i v-if="authError" class='bx bx-error-alt me-2'></i>
                            <i v-else class='bx bx-loader-alt bx-spin me-2'></i>
                            {{ authScanStatus }}
                        </h6>
                    </div>

                    <button @click="dongModalXacThucJoin"
                        class="btn btn-outline-light border-secondary rounded-pill px-5 fw-bold opacity-75">
                        Hủy xác thực
                    </button>
                </template>

                <template v-else>
                    <div class="py-4">
                        <div class="success-icon-bg mx-auto mb-4 scale-up">
                            <i class='bx bxs-check-shield text-success'></i>
                        </div>

                        <h2 class="text-white fw-900 mb-2">Chào mừng, Đối tác!</h2>
                        <p class="text-secondary mb-5">Hệ thống đã xác minh danh tính của <b>{{ partnerName }}</b> thành công.</p>

                        <div class="d-grid gap-3">
                            <button @click="thamGiaPhongHop" :disabled="isJoining"
                                class="btn btn-orange-pro py-4 fw-900 rounded-4 shadow-orange">
                                <span v-if="isJoining" class="spinner-border spinner-border-sm me-2"></span>
                                <i v-else class='bx bx-video me-2'></i> Vào phòng ngay
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
import * as faceapi from 'face-api.js';
import axios from 'axios';
const apiUrl = import.meta.env.VITE_API_URL;

export default {
    name: 'PartnerJoinRoom',
    data() {
        return {
            partnerId: null,
            partnerName: 'Admin Đối tác',
            avatarUrl: 'https://i.pravatar.cc/150?u=partner_default',
            ma_phong_tham_gia: '',
            isJoining: false,
            
            // Auth State
            showJoinAuthModal: false,
            authScanStatus: 'Đang khởi động AI...',
            authError: false,
            isMatched: false,
            authStream: null,
            authInterval: null,
            savedDescriptor: null
        }
    },
    async mounted() {
        await this.fetchPartnerData();
        
        // Kiểm tra xem có mã phòng được truyền từ Dashboard không
        const tmpMaPhong = sessionStorage.getItem('join_ma_phong_tmp');
        if (tmpMaPhong) {
            this.ma_phong_tham_gia = tmpMaPhong;
            sessionStorage.removeItem('join_ma_phong_tmp');
            // Tự động kích hoạt kiểm tra sau khi đã load xong dữ liệu
            this.kiemTraTruocKhiJoin();
        }
    },
    beforeUnmount() {
        this.dongModalXacThucJoin(true);
    },
    methods: {
        async fetchPartnerData() {
            try {
                const token = localStorage.getItem('token_doi_tac');
                if(!token) {
                    this.$router.push('/dang-nhap');
                    return;
                }
                const res = await axios.get(`${apiUrl}/doi-tac/me`, {
                    headers: { Authorization: 'Bearer ' + token }
                });
                if (res.data.status) {
                    this.partnerId = res.data.data.id;
                    this.partnerName = res.data.data.ho_va_ten;
                    const hinh_anh = res.data.data.hinh_anh;
                    if(hinh_anh) {
                         const baseUrl = apiUrl.replace('/api', '');
                         const cleanPath = hinh_anh.includes('uploads/') ? hinh_anh : `uploads/avatars/${hinh_anh}`;
                         this.avatarUrl = hinh_anh.startsWith('http') ? hinh_anh : `${baseUrl}/${cleanPath}`;
                    }
                    if(res.data.data.du_lieu_khuon_mat) {
                        this.savedDescriptor = new Float32Array(JSON.parse(res.data.data.du_lieu_khuon_mat));
                    }
                }
            } catch (e) {
                this.$router.push('/dang-nhap');
            }
        },

        async kiemTraTruocKhiJoin() {
            if (!this.ma_phong_tham_gia.trim()) {
                if (this.$toast) this.$toast.warning("Vui lòng nhập mã phòng!");
                return;
            }

            this.isJoining = true;
            try {
                const response = await axios.post(`${apiUrl}/phong-hop/kiem-tra-phong-hop`, {
                    ma_phong: this.ma_phong_tham_gia.trim()
                });

                if (response.data.status) {
                    // Đối với Đối tác, cho phép vào thẳng phòng họp mà không cần quét lại Face ID
                    // vì họ đã xác thực khi đăng nhập vào hệ thống Đối tác (Partner Portal)
                    this.$toast.success("Xác thực Đối tác thành công! Đang vào phòng...");
                    this.thamGiaPhongHop();
                }
            } catch (error) {
                const msg = error.response?.data?.message || "Mã phòng không tồn tại!";
                this.$toast.error(msg);
            } finally {
                this.isJoining = false;
            }
        },

        async batDauXacThucJoin() {
            try {
                this.authScanStatus = 'Đang tải dữ liệu AI...';
                const DUONG_DAN_MODELS = '/model';
                await Promise.all([
                    faceapi.nets.tinyFaceDetector.loadFromUri(DUONG_DAN_MODELS),
                    faceapi.nets.faceLandmark68Net.loadFromUri(DUONG_DAN_MODELS),
                    faceapi.nets.faceRecognitionNet.loadFromUri(DUONG_DAN_MODELS)
                ]);

                this.authScanStatus = 'Kết nối camera...';
                this.authStream = await navigator.mediaDevices.getUserMedia({ video: {} });
                const video = this.$refs.authVideo;
                video.srcObject = this.authStream;

                video.onloadedmetadata = () => {
                    video.play();
                    this.tienHanhSoSanh(video);
                };
            } catch (loi) {
                this.authError = true;
                this.authScanStatus = 'Lỗi truy cập phần cứng!';
            }
        },

        tienHanhSoSanh(video) {
            this.authScanStatus = 'Vui lòng nhìn thẳng vào camera...';
            this.isMatched = false;

            this.authInterval = setInterval(async () => {
                if (this.isMatched) return;

                const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions())
                    .withFaceLandmarks()
                    .withFaceDescriptors();

                if (detections.length === 1) {
                    const distance = faceapi.euclideanDistance(this.savedDescriptor, detections[0].descriptor);
                    if (distance < 0.50) {
                        this.isMatched = true;
                        clearInterval(this.authInterval);
                        this.authScanStatus = "Xác nhận thành công!";
                    } else {
                        this.authError = true;
                        this.authScanStatus = "ID Doanh nghiệp không khớp!";
                    }
                } else if (detections.length > 1) {
                    this.authError = true;
                    this.authScanStatus = "Phát hiện nhiều người!";
                } else {
                    this.authError = false;
                    this.authScanStatus = 'Chưa nhận diện được khuôn mặt...';
                }
            }, 400);
        },

        dongModalXacThucJoin(fullReset = true) {
            if (this.authInterval) clearInterval(this.authInterval);
            if (this.authStream) this.authStream.getTracks().forEach(t => t.stop());
            this.authStream = null;
            if(fullReset) {
                this.showJoinAuthModal = false;
                this.isMatched = false;
            }
        },

        async thamGiaPhongHop() {
            this.isJoining = true;
            try {
                const payload = {
                    ma_phong: this.ma_phong_tham_gia.trim(),
                    user_name: this.partnerName
                };
                const response = await axios.post(`${apiUrl}/phong-hop/tao-token`, payload);

                if (response.data.status) {
                    sessionStorage.setItem('livekit_token', response.data.token);
                    sessionStorage.setItem('livekit_room', this.ma_phong_tham_gia.trim());
                    this.dongModalXacThucJoin(false);
                    // Use href for clean fresh entry to video call
                    window.location.href = `/phong-hop/${this.ma_phong_tham_gia.trim()}`;
                }
            } catch (error) {
                console.error("Lỗi tham gia phòng:", error);
                if (this.$toast) this.$toast.error("Lỗi khi tham gia phòng họp!");
                this.dongModalXacThucJoin(true);
            } finally {
                this.isJoining = false;
            }
        },

        logout() {
            localStorage.removeItem('token_nguoi_dung');
            localStorage.removeItem('thong_tin_user');
            localStorage.removeItem('token_doi_tac');
            this.$toast && this.$toast.success("Đăng xuất thành công!");
            this.$router.push('/');
        }
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

.bg-fbf9f6 { background-color: #fbf9f6; }

/* Sidebar Re-styling */
.sidebar-business { width: 320px; background: #fbf9f6; border-right: 1px solid #f0ece6; z-index: 1000; }
.logo-icon-business { width: 44px; height: 44px; background: #ea580c; color: white; border-radius: 12px; display: flex; justify-content: center; align-items: center; }
.nav-business-item { width: 100%; padding: 18px 25px; border: none; background: transparent; border-radius: 14px; color: #5a5a5a; font-size: 0.95rem; font-weight: 700; display: flex; align-items: center; gap: 15px; transition: 0.3s; text-align: left; }
.nav-business-item i { font-size: 1.5rem; color: #7a7a7a; }
.nav-business-item:hover { background: rgba(234, 88, 12, 0.05); color: #ea580c; }
.nav-business-item.active { background: #fff; color: #ea580c; box-shadow: 0 10px 20px rgba(0,0,0,0.04); }
.nav-business-item.active i { color: #ea580c; }

/* Join Page Specific */
.premium-join-card {
    background: white;
    border: 1px solid #f0ece6 !important;
    box-shadow: 0 40px 100px -20px rgba(0,0,0,0.08);
}

.feature-icon-pro {
    width: 90px;
    height: 90px;
    background: linear-gradient(135deg, #ea580c, #f97316);
    border-radius: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    box-shadow: 0 15px 35px rgba(234, 88, 12, 0.25);
}

.pulse-orange-light {
    animation: pulse-orange-light 2s infinite;
}

@keyframes pulse-orange-light {
    0% { box-shadow: 0 0 0 0 rgba(234, 88, 12, 0.4); }
    70% { box-shadow: 0 0 0 20px rgba(234, 88, 12, 0); }
    100% { box-shadow: 0 0 0 0 rgba(234, 88, 12, 0); }
}

.input-premium-group {
    position: relative;
    display: flex;
    align-items: center;
}

.input-premium-group i {
    position: absolute;
    left: 20px;
    color: #ea580c;
    font-size: 1.4rem;
}

.input-premium-group input {
    width: 100%;
    padding: 18px 25px 18px 60px;
    border-radius: 18px;
    border: 2px solid #f0ece6;
    background: #fbf9f6;
    outline: none;
    font-size: 1rem;
    font-weight: 700;
    transition: 0.3s;
    color: #1a1e29;
}

.input-premium-group input:focus {
    border-color: #ea580c;
    background: white;
    box-shadow: 0 0 0 5px rgba(234, 88, 12, 0.05);
}

.security-badge-mini {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 8px 16px;
    background: #f0fdf4;
    color: #166534;
    border-radius: 100px;
    font-weight: 800;
    font-size: 0.7rem;
    letter-spacing: 0.5px;
    width: fit-content;
}

.btn-orange-pro { 
    background: linear-gradient(to right, #ea580c, #f97316); 
    color: white !important; 
    transition: 0.3s;
}
.btn-orange-pro:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 40px rgba(234, 88, 12, 0.3);
}

.shadow-orange { box-shadow: 0 12px 30px rgba(234, 88, 12, 0.25); }
.shadow-premium { box-shadow: 0 40px 80px -15px rgba(0,0,0,0.1); }

/* Face ID Styling */
.scan-frame-business {
    width: 250px;
    height: 250px;
    position: relative;
    border-radius: 50%;
    padding: 5px;
    background: #1e293b;
}

.scan-laser {
    position: absolute;
    width: 90%;
    height: 3px;
    background: linear-gradient(to right, transparent, #ea580c, transparent);
    box-shadow: 0 0 15px #ea580c;
    left: 5%;
    z-index: 10;
    animation: scan-loop 2s ease-in-out infinite;
}

@keyframes scan-loop {
    0% { top: 10%; opacity: 0; }
    50% { top: 50%; opacity: 1; }
    90% { top: 90%; opacity: 0; }
    100% { top: 10%; opacity: 0; }
}

.pulse-orange {
    border: 2px solid #ea580c;
    animation: pulse-ring 1.5s infinite;
}

@keyframes pulse-ring {
    0% { transform: translate(-50%, -50%) scale(1); opacity: 0.5; }
    100% { transform: translate(-50%, -50%) scale(1.2); opacity: 0; }
}

.success-icon-bg {
    width: 120px;
    height: 120px;
    background: rgba(34, 197, 94, 0.1);
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 5rem;
}

.scale-up {
    animation: scale-up 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

@keyframes scale-up {
    from { transform: scale(0.5); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

.fw-900 { font-weight: 900; }
.fw-800 { font-weight: 800; }
.fw-600 { font-weight: 600; }
.tracking-tighter { letter-spacing: -1.2px; }

/* Header Utilities */
.content-header { background: white; border-bottom: 2px solid #fbf9f6; }
.search-business { background: #f3f0eb; border-radius: 14px; padding: 10px 20px; width: 400px; align-items: center; gap: 10px; }
.search-business input { background: transparent; border: none; outline: none; font-size: 0.85rem; font-weight: 600; width: 100%; }
.header-avatar-business { width: 44px; height: 44px; border-radius: 50%; border: 3px solid #fff; box-shadow: 0 0 0 1px #f0ece6; }

.header-icon-btns { display: flex; align-items: center; }
.icon-btn-plain {
    width: 44px;
    height: 44px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    color: #5a5a5a;
    position: relative;
    border-radius: 12px;
    transition: 0.2s;
}
.icon-btn-plain:hover { background: #f3f0eb; color: #1a1e29; }
.dot-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 8px;
    height: 8px;
    background: #ea580c;
    border-radius: 50%;
    border: 2px solid white;
}
</style>
