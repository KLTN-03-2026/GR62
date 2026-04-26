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
                    <button @click="$router.push('/doi-tac/bao-cao')" class="nav-business-item">
                        <i class="bx bxs-bar-chart-alt-2"></i>
                        <span>Báo cáo</span>
                    </button>
                    <button class="nav-business-item active">
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

            <!-- Main Content Area -->
            <main class="flex-grow-1 p-0 overflow-auto bg-white">
                <header class="content-header px-5 py-4 d-flex justify-content-between align-items-center">
                    <div class="welcome-text">
                        <h4 class="mb-0 fw-800 text-dark">Hồ sơ đối tác</h4>
                        <p class="mb-0 text-muted small fw-500">Thiết lập bảo mật và quản trị tài khoản doanh nghiệp</p>
                    </div>
                    <div class="header-actions">
                        <button @click="$router.push('/doi-tac/trang-chinh')" class="btn btn-light-orange-pro px-4 py-2 fw-800 rounded-4 border-0">
                            <i class="bx bx-left-arrow-alt me-2"></i> Quay lại Dashboard
                        </button>
                    </div>
                </header>

                <div class="p-5 pt-4">
                    <div class="row g-5">
                        <!-- Left Column: Avatar & Face ID -->
                        <div class="col-xl-4">
                            <!-- Avatar Card -->
                            <div class="metric-card-business p-5 rounded-5 border-0 text-center mb-5">
                                <div class="avatar-business-container position-relative mb-4 mx-auto">
                                    <img :src="avatarPreview" alt="Avatar" class="avatar-business-main shadow-lg">
                                    <label for="avatar-input" class="btn-avatar-edit-business shadow-orange">
                                        <i class="bx bxs-camera-plus"></i>
                                        <input type="file" id="avatar-input" hidden @change="handleAvatarChange">
                                    </label>
                                </div>
                                <h4 class="fw-900 text-dark mb-1">{{ doi_tac.ho_va_ten }}</h4>
                                <p class="text-orange fw-800 small text-uppercase mb-4">{{ partnerPosition }}</p>
                                
                                <div class="d-flex justify-content-center gap-4 py-4 border-top border-light">
                                    <div class="text-center px-3">
                                        <h5 class="mb-0 fw-900">PREMIUM</h5>
                                        <small class="text-muted fw-bold">Cấp độ</small>
                                    </div>
                                    <div class="text-center border-start border-light ps-4 px-3">
                                        <h5 class="mb-0 fw-900 text-success">ACTIVE</h5>
                                        <small class="text-muted fw-bold">Trạng thái</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Face ID Calibration -->
                            <div class="metric-card-business p-5 rounded-5 border-0 overflow-hidden">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="fw-800 text-dark mb-0">Xác thực Face ID</h5>
                                    <div v-if="doi_tac.du_lieu_khuon_mat" class="status-pill-business active">
                                        <span class="dot"></span> Đã kích hoạt
                                    </div>
                                    <div v-else class="status-pill-business idle">
                                        <span class="dot"></span> Chưa thiết lập
                                    </div>
                                </div>

                                <div class="face-preview-business rounded-4 overflow-hidden position-relative mb-4">
                                    <template v-if="!isScanning">
                                        <div class="d-flex flex-column align-items-center justify-content-center h-100 bg-dark text-white p-5 text-center">
                                            <i class="bx bx-shield-quarter fs-1 mb-3 text-orange opacity-50"></i>
                                            <p class="small fw-bold mb-0 text-white-50">Khuôn mặt là chìa khóa truy cập bảo mật của bạn.</p>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <video ref="video" autoplay playsinline class="video-feed-business"></video>
                                        <div class="scanner-layer-business">
                                            <div class="scanner-circle-business"></div>
                                            <div class="scanner-beam-business"></div>
                                        </div>
                                        <div class="scanner-status-business text-white">
                                            <div class="spinner-grow spinner-grow-sm text-orange me-2" role="status"></div>
                                            <span class="small fw-800 text-uppercase letter-spacing-1">{{ scanMessage }}</span>
                                        </div>
                                    </template>
                                </div>

                                <button @click="toggleScanning" class="btn w-100 py-3 rounded-4 fw-800 shadow-orange"
                                    :class="isScanning ? 'btn-danger text-white' : 'btn-orange-pro text-white'">
                                    <i v-if="!isScanning" class="bx bx-scan me-2"></i>
                                    {{ isScanning ? 'Hủy thiết lập' : (doi_tac.du_lieu_khuon_mat ? 'Thiết lập lại Face ID' : 'Bắt đầu thiết lập') }}
                                </button>
                                <p class="text-center text-muted small mt-4 mb-0 fw-500">Dữ liệu được mã hóa chuẩn biometrics</p>
                            </div>
                        </div>

                        <!-- Right Column: Forms -->
                        <div class="col-xl-8">
                            <!-- Info Form -->
                            <div class="metric-card-business p-5 rounded-5 border-0 mb-5">
                                <div class="d-flex align-items-center justify-content-between mb-5">
                                    <h4 class="fw-900 text-dark mb-0">Thông tin cơ bản</h4>
                                    <div class="feature-icon-bg-mini"><i class="bx bxs-user-pin"></i></div>
                                </div>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="fw-800 small text-muted mb-2">Họ và tên hiển thị</label>
                                        <div class="input-premium-group">
                                            <i class="bx bx-user"></i>
                                            <input v-model="doi_tac.ho_va_ten" type="text" placeholder="Nhập họ và tên...">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fw-800 small text-muted mb-2">Điện thoại liên lạc</label>
                                        <div class="input-premium-group">
                                            <i class="bx bx-phone"></i>
                                            <input v-model="doi_tac.so_dien_thoai" type="text" placeholder="Số điện thoại...">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="fw-800 small text-muted mb-2">Email Doanh nghiệp</label>
                                        <div class="input-premium-group">
                                            <i class="bx bx-envelope"></i>
                                            <input v-model="doi_tac.email" type="email" placeholder="email@domain.com">
                                        </div>
                                        <small class="text-muted fw-600 ms-2 mt-1 d-block" style="font-size: 0.72rem;"><i class="bx bx-info-circle me-1"></i>Thay đổi email sẽ ảnh hưởng đến việc đăng nhập lần sau.</small>
                                    </div>
                                    <div class="col-12 mt-5">
                                        <button @click="updateProfile" class="btn btn-orange-pro py-3 px-5 rounded-4 fw-800 text-white shadow-orange" :disabled="isLoading">
                                            <span v-if="!isLoading">Lưu thay đổi hồ sơ</span>
                                            <div v-else class="spinner-border spinner-border-sm"></div>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Security Form -->
                            <div class="metric-card-business p-5 rounded-5 border-0">
                                <div class="d-flex align-items-center justify-content-between mb-5">
                                    <h4 class="fw-900 text-dark mb-0">Quản lý bảo mật</h4>
                                    <div class="feature-icon-bg-mini"><i class="bx bxs-lock-alt"></i></div>
                                </div>
                                <div class="row g-4">
                                    <div class="col-md-4">
                                        <label class="fw-800 small text-muted mb-2">Mật khẩu hiện tại</label>
                                        <input v-model="passwordData.old_password" type="password" class="form-business-input" placeholder="••••••••">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fw-800 small text-muted mb-2">Mật khẩu mới</label>
                                        <input v-model="passwordData.new_password" type="password" class="form-business-input" placeholder="••••••••">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fw-800 small text-muted mb-2">Xác nhận mật khẩu</label>
                                        <input v-model="passwordData.confirm_password" type="password" class="form-business-input" placeholder="••••••••">
                                    </div>
                                    <div class="col-12 mt-5">
                                        <button @click="changePassword" class="btn btn-light-orange-pro py-3 px-5 rounded-4 fw-800 border-0" :disabled="isPasswordLoading">
                                            <span v-if="!isPasswordLoading">Cập nhật mật khẩu mới</span>
                                            <div v-else class="spinner-border spinner-border-sm"></div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import * as faceapi from 'face-api.js';
const apiUrl = import.meta.env.VITE_API_URL;

export default {
    name: 'PartnerProfile',
    data() {
        return {
            doi_tac: {
                ho_va_ten: '',
                so_dien_thoai: '',
                email: '',
                hinh_anh: '',
                du_lieu_khuon_mat: null
            },
            passwordData: {
                old_password: '',
                new_password: '',
                confirm_password: ''
            },
            partnerPosition: '...',
            avatarPreview: 'https://i.pravatar.cc/300?u=partner_anhkim',
            isLoading: false,
            isPasswordLoading: false,
            isScanning: false,
            scanMessage: 'Đang khởi tạo camera...',
            stream: null,
            scanInterval: null,
            stableFaceCounter: 0,
            requiredStability: 20
        }
    },
    mounted() {
        this.fetchProfile();
    },
    unmounted() {
        this.stopCamera();
    },
    methods: {
        async fetchProfile() {
            try {
                const token = localStorage.getItem('token_doi_tac');
                if (!token) {
                    this.$toast.error("Vui lòng đăng nhập lại.");
                    this.$router.push('/dang-nhap');
                    return;
                }
                const res = await axios.get(`${apiUrl}/doi-tac/me`, {
                    headers: { Authorization: 'Bearer ' + token }
                });
                if (res.data.status) {
                    this.doi_tac = res.data.data;
                    this.partnerPosition = res.data.data.chuc_vu?.ten_chuc_vu || (res.data.data.id_doi_tac == 1 ? "Quản trị viên Đối tác" : "Đối tác");
                    const hinh_anh = this.doi_tac.hinh_anh;
                    if (hinh_anh) {
                        const baseUrl = apiUrl.replace('/api', '');
                        const cleanPath = hinh_anh.includes('uploads/') ? hinh_anh : `uploads/avatars/${hinh_anh}`;
                        this.avatarPreview = hinh_anh.startsWith('http') ? hinh_anh : `${baseUrl}/${cleanPath}`;
                    }
                }
            } catch (e) {
                this.$toast.error("Lỗi tải thông tin đối tác.");
                if (e.response?.status === 401) this.$router.push('/dang-nhap');
            }
        },

        async loadModels() {
            try {
                this.scanMessage = "Đang tải dữ liệu AI...";
                const MODEL_URL = '/model';
                await Promise.all([
                    faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL),
                    faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
                    faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL)
                ]);
                return true;
            } catch (e) {
                console.error("Lỗi tải model:", e);
                this.$toast.error("Lỗi khởi tạo hệ thống AI!");
                return false;
            }
        },

        async toggleScanning() {
            if (this.isScanning) {
                this.stopCamera();
                this.isScanning = false;
            } else {
                const modelsLoaded = await this.loadModels();
                if (!modelsLoaded) return;

                this.isScanning = true;
                this.scanMessage = "Đang khởi động camera...";
                this.stableFaceCounter = 0;

                try {
                    this.stream = await navigator.mediaDevices.getUserMedia({ video: {} });
                    this.$nextTick(() => {
                        const video = this.$refs.video;
                        if (video) {
                            video.srcObject = this.stream;
                            video.onplay = () => {
                                this.startAnalysis(video);
                            };
                        }
                    });
                } catch (e) {
                    this.$toast.error("Không thể truy cập camera.");
                    this.isScanning = false;
                }
            }
        },

        startAnalysis(video) {
            this.scanMessage = "Vui lòng nhìn thẳng vào camera...";
            
            this.scanInterval = setInterval(async () => {
                if (!this.isScanning) return;

                const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions())
                    .withFaceLandmarks()
                    .withFaceDescriptors();

                if (detections.length === 1) {
                    this.stableFaceCounter++;
                    const progress = Math.min(Math.round((this.stableFaceCounter / this.requiredStability) * 100), 100);
                    this.scanMessage = `Đang phân tích sinh trắc học... ${progress}%`;

                    if (this.stableFaceCounter >= this.requiredStability) {
                        clearInterval(this.scanInterval);
                        this.scanMessage = "Đã nhận diện thành công!";
                        const descriptor = Array.from(detections[0].descriptor);
                        await this.saveFaceData(descriptor);
                    }
                } else if (detections.length > 1) {
                    this.stableFaceCounter = 0;
                    this.scanMessage = "Cảnh báo: Phát hiện nhiều người!";
                } else {
                    this.stableFaceCounter = 0;
                    this.scanMessage = "Vui lòng đưa mặt vào khung hình";
                }
            }, 250);
        },

        async saveFaceData(descriptor) {
            try {
                const token = localStorage.getItem('token_doi_tac');
                const res = await axios.post(`${apiUrl}/doi-tac/profile/update-face-data`, 
                    { face_data: JSON.stringify(descriptor) }, 
                    { headers: { Authorization: 'Bearer ' + token } }
                );
                if (res.data.status) {
                    this.$toast.success("Đăng ký Face ID doanh nghiệp thành công!");
                    this.doi_tac.du_lieu_khuon_mat = JSON.stringify(descriptor);
                    this.stopCamera();
                    this.isScanning = false;
                }
            } catch (e) {
                const msg = e.response?.data?.message || "Lỗi đồng bộ sinh trắc học.";
                this.$toast.error(msg);
                this.stopCamera();
                this.isScanning = false;
            }
        },

        stopCamera() {
            if (this.scanInterval) {
                clearInterval(this.scanInterval);
                this.scanInterval = null;
            }
            if (this.stream) {
                this.stream.getTracks().forEach(t => t.stop());
                this.stream = null;
            }
            if (this.vong_lap_nhan_dien) {
                clearInterval(this.vong_lap_nhan_dien);
                this.vong_lap_nhan_dien = null;
            }
        },

        async handleAvatarChange(e) {
            const file = e.target.files[0];
            if (!file) return;

            const fd = new FormData();
            fd.append('hinh_anh', file);

            try {
                const token = localStorage.getItem('token_doi_tac');
                const res = await axios.post(`${apiUrl}/doi-tac/profile/update-avatar`, fd, {
                    headers: { 
                        'Content-Type': 'multipart/form-data',
                        Authorization: 'Bearer ' + token 
                    }
                });
                if (res.data.status) {
                    this.$toast.success("Đã cập nhật ảnh đại diện.");
                    await this.fetchProfile();
                }
            } catch (e) {
                this.$toast.error("Lỗi khi tải ảnh lên.");
            }
        },

        async updateProfile() {
            this.isLoading = true;
            try {
                const token = localStorage.getItem('token_doi_tac');
                const res = await axios.post(`${apiUrl}/doi-tac/profile/update`, this.doi_tac, {
                    headers: { Authorization: 'Bearer ' + token }
                });
                if (res.data.status) this.$toast.success("Thông tin đã được lưu!");
            } catch (e) {
                this.$toast.error("Lỗi cập nhật hồ sơ!");
            } finally {
                this.isLoading = false;
            }
        },

        async changePassword() {
            this.isPasswordLoading = true;
            try {
                const token = localStorage.getItem('token_doi_tac');
                const res = await axios.post(`${apiUrl}/doi-tac/profile/change-password`, this.passwordData, {
                    headers: { Authorization: 'Bearer ' + token }
                });
                if (res.data.status) {
                    this.$toast.success("Thay đổi mật khẩu thành công!");
                    this.passwordData = { old_password: '', new_password: '', confirm_password: '' };
                }
            } catch (e) {
                this.$toast.error(e.response?.data?.message || "Lỗi đổi mật khẩu!");
            } finally {
                this.isPasswordLoading = false;
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

/* Sidebar Business Style (Exact match with Dashboard) */
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

.nav-business-item i { font-size: 1.5rem; color: #7a7a7a; }
.nav-business-item:hover { background: rgba(234, 88, 12, 0.05); color: #ea580c; }
.nav-business-item:hover i { color: #ea580c; }

.nav-business-item.active {
    background: #fff;
    color: #ea580c;
    box-shadow: 0 10px 20px rgba(0,0,0,0.04);
}
.nav-business-item.active i { color: #ea580c; }

/* Header */
.content-header { border-bottom: 1px solid rgba(0,0,0,0.02); }

/* Avatar Section Business */
.avatar-business-container { width: 160px; height: 160px; }
.avatar-business-main {
    width: 100%;
    height: 100%;
    border-radius: 45px;
    object-fit: cover;
    border: 6px solid #fff;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
}
.btn-avatar-edit-business {
    position: absolute;
    bottom: -5px;
    right: -5px;
    width: 48px;
    height: 48px;
    background: #ea580c;
    color: white;
    border-radius: 16px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: 0.3s;
    border: 3px solid #fff;
}
.btn-avatar-edit-business:hover { transform: scale(1.1) rotate(5deg); }

/* Metric Card Style for Forms (Matching Dashboard) */
.metric-card-business {
    background: #fbf9f6;
    border: 1px solid #f0ece6 !important;
    padding: 30px !important;
    transition: 0.4s;
}

/* Face ID UI Modernized */
.face-preview-business { height: 280px; background: #1a1e29; border: 1px solid #f0ece6; }
.video-feed-business { width: 100%; height: 100%; object-fit: cover; opacity: 0.7; }
.scanner-layer-business {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 200px;
    height: 200px;
}
.scanner-circle-business {
    width: 100%;
    height: 100%;
    border: 2px dashed #ea580c;
    border-radius: 50%;
    animation: rotateScan 10s linear infinite;
}
.scanner-beam-business {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(to right, transparent, #ea580c, transparent);
    animation: scanMoveBusiness 3s ease-in-out infinite;
    box-shadow: 0 0 15px rgba(234, 88, 12, 0.5);
}
.scanner-status-business {
    position: absolute;
    bottom: 20px;
    left: 0;
    width: 100%;
    text-align: center;
}

@keyframes rotateScan { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
@keyframes scanMoveBusiness { 0% { top: 10%; } 50% { top: 90%; } 100% { top: 10%; } }

/* Form Elements Business */
.input-premium-group {
    position: relative;
    display: flex;
    align-items: center;
}
.input-premium-group i { position: absolute; left: 20px; color: #94a3b8; font-size: 1.3rem; }
.input-premium-group input {
    width: 100%;
    padding: 16px 20px 16px 55px;
    border-radius: 18px;
    border: 2px solid #f0ece6;
    background: #fff;
    outline: none;
    font-weight: 600;
    transition: 0.3s;
}
.input-premium-group input:focus { border-color: #ea580c; box-shadow: 0 0 0 4px rgba(234, 88, 12, 0.05); }

.form-business-input {
    width: 100%;
    padding: 16px 20px;
    border-radius: 18px;
    border: 2px solid #f0ece6;
    background: #fff;
    outline: none;
    font-weight: 600;
    transition: 0.3s;
}
.form-business-input:focus { border-color: #ea580c; box-shadow: 0 0 0 4px rgba(234, 88, 12, 0.05); }

.status-pill-business {
    padding: 6px 14px;
    border-radius: 100px;
    font-size: 0.7rem;
    font-weight: 900;
    display: flex;
    align-items: center;
    gap: 8px;
}
.status-pill-business.active { background: #dcfce7; color: #166534; }
.status-pill-business.idle { background: #fef3c7; color: #92400e; }
.status-pill-business .dot { width: 7px; height: 7px; border-radius: 50%; background: currentColor; }

.feature-icon-bg-mini {
    width: 44px;
    height: 44px;
    background: #fff;
    border-radius: 12px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 1.3rem;
    color: #ea580c;
    box-shadow: 0 4px 10px rgba(0,0,0,0.02);
}

/* Common Components */
.btn-orange-pro { background: #ea580c; border: none; }
.btn-light-orange-pro { background: #fbf9f6; color: #ea580c; border: 1.5px solid #f0ece6 !important; }
.shadow-orange { box-shadow: 0 12px 30px rgba(234, 88, 12, 0.25); }

/* Utilities */
.fw-900 { font-weight: 900; }
.fw-800 { font-weight: 800; }
.letter-spacing-1 { letter-spacing: 1px; }
.bg-light-faint { background-color: #fbf9f6 !important; }

@media (max-width: 1200px) {
    .sidebar-business { width: 100px; }
    .nav-business-item span, .logo-section { display: none; }
}
</style>
