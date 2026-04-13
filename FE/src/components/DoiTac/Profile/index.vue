<template>
    <div class="partner-dashboard-wrapper">
        <div class="main-layout d-flex h-100">
            <!-- Sidebar -->
            <aside class="sidebar-zoom d-flex flex-column py-4">
                <div class="logo-section px-4 mb-5">
                    <div class="logo-circle shadow-glow">
                        <img src="../../../assets/images/logo.pnj.png" alt="" style="height: 50px; width: 50px;">
                    </div>
                    <h5 class="ms-3 fw-800 fs-5 text-primary"><b>Đối Tác</b></h5>
                </div>

                <div class="nav-links d-flex flex-column gap-2 px-3 flex-grow-1">
                    <button @click="$router.push('/doi-tac/trang-chinh')" class="nav-item">
                        <i class="bx bx-home-alt-2"></i>
                        <span>Trang chủ</span>
                    </button>
                    <button @click="$router.push('/doi-tac/phong-hop')" class="nav-item">
                        <i class="bx bx-video"></i>
                        <span>Phòng họp</span>
                    </button>
                    <button class="nav-item active">
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

            <!-- Main Content Area -->
            <main class="flex-grow-1 p-0 overflow-auto">
                <div class="partner-profile-wrapper p-4 p-xl-5">
                    <div class="container-fluid">
                        <div class="row g-4">
                            <!-- Left: Profile Summary & Face ID -->
                            <div class="col-lg-4">
                                <div class="glass-card text-center p-5 rounded-5 border-0 shadow-sm mb-4">
                                    <div class="avatar-edit-wrapper position-relative d-inline-block mb-4">
                                        <img :src="avatarPreview" alt="Avatar" class="profile-avatar shadow-lg">
                                        <label for="avatar-input" class="edit-btn shadow-sm">
                                            <i class="bx bxs-camera"></i>
                                            <input type="file" id="avatar-input" hidden @change="handleAvatarChange">
                                        </label>
                                    </div>
                                    <h3 class="fw-bold mb-1">{{ doi_tac.ho_va_ten }}</h3>
                                    <p class="text-primary fw-semibold mb-4">Đối Tác Cấp Cao</p>

                                    <div
                                        class="profile-stats d-flex justify-content-center gap-4 py-3 border-top border-bottom border-light">
                                        <div class="stat-mini text-center">
                                            <span class="d-block fw-bold fs-5">24</span>
                                            <small class="text-muted">Cuộc họp</small>
                                        </div>
                                        <div class="stat-mini border-start ps-4 text-center">
                                            <span class="d-block fw-bold fs-5">Active</span>
                                            <small class="text-muted">Trạng thái</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Face ID Verification Card -->
                                <div class="glass-card p-4 rounded-5 border-0 shadow-sm face-id-card overflow-hidden">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="fw-bold mb-0">Xác thực Face ID</h6>
                                        <span v-if="doi_tac.du_lieu_khuon_mat"
                                            class="badge bg-success-soft text-success rounded-pill px-3">Đã xác
                                            thực</span>
                                        <span v-else class="badge bg-warning-soft text-warning rounded-pill px-3">Chưa
                                            xác thực</span>
                                    </div>

                                    <div v-if="!isScanning"
                                        class="face-preview-placeholder d-flex flex-column align-items-center justify-content-center py-5 bg-light rounded-4 border border-dashed text-muted">
                                        <i class="bx bx-face fs-1 mb-2 opacity-50"></i>
                                        <p class="small mb-0">Nhấn để bắt đầu quét khuôn mặt</p>
                                    </div>

                                    <div v-else class="face-scanner-container bg-dark rounded-4 position-relative">
                                        <video ref="video" autoplay playsinline class="face-video-feed"></video>
                                        <div class="scan-overlay">
                                            <div class="scan-radar shadow-glow-blue"></div>
                                            <div class="scan-line"></div>
                                        </div>
                                        <div class="scan-status text-white text-center p-3">
                                            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                            {{ scanMessage }}
                                        </div>
                                    </div>

                                    <button @click="toggleScanning" class="btn w-100 mt-4 rounded-pill py-3 fw-bold"
                                        :class="isScanning ? 'btn-danger' : 'btn-primary shadow-primary'">
                                        {{ isScanning ? 'Hủy quét' : (doi_tac.du_lieu_khuon_mat ? 'Quét lại Face ID' :
                                            'Bắt đầu quét Face ID') }}
                                    </button>
                                </div>
                            </div>

                            <!-- Right: Edit Forms -->
                            <div class="col-lg-8">
                                <!-- Info Section -->
                                <div class="glass-card p-4 p-xl-5 rounded-5 border-0 shadow-sm mb-4">
                                    <h5 class="fw-bold mb-4 d-flex align-items-center">
                                        <i class="bx bx-user-pin fs-3 me-2 text-primary"></i> Thông tin cá nhân
                                    </h5>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Họ và tên</label>
                                            <input v-model="doi_tac.ho_va_ten" type="text"
                                                class="form-control rounded-4 p-3 bg-light border-0">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Số điện thoại</label>
                                            <input v-model="doi_tac.so_dien_thoai" type="text"
                                                class="form-control rounded-4 p-3 bg-light border-0">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label small fw-bold">Email (Mã định danh)</label>
                                            <input v-model="doi_tac.email" type="email"
                                                class="form-control rounded-4 p-3 bg-light border-0" readonly>
                                        </div>
                                        <div class="col-12 mt-4">
                                            <button @click="updateProfile"
                                                class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-primary"
                                                :disabled="isLoading">
                                                <span v-if="!isLoading">Cập Nhật Thông Tin</span>
                                                <span v-else class="spinner-border spinner-border-sm"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Password Section -->
                                <div class="glass-card p-4 p-xl-5 rounded-5 border-0 shadow-sm">
                                    <h5 class="fw-bold mb-4 d-flex align-items-center">
                                        <i class="bx bx-lock-open-alt fs-3 me-2 text-primary"></i> Thay đổi mật khẩu
                                    </h5>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Mật khẩu cũ</label>
                                            <input v-model="passwordData.old_password" type="password"
                                                class="form-control rounded-4 p-3 bg-light border-0"
                                                placeholder="••••••••">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Mật khẩu mới</label>
                                            <input v-model="passwordData.new_password" type="password"
                                                class="form-control rounded-4 p-3 bg-light border-0"
                                                placeholder="••••••••">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Xác nhận</label>
                                            <input v-model="passwordData.confirm_password" type="password"
                                                class="form-control rounded-4 p-3 bg-light border-0"
                                                placeholder="••••••••">
                                        </div>
                                        <div class="col-12 mt-4">
                                            <button @click="changePassword"
                                                class="btn btn-dark rounded-pill px-5 py-3 fw-bold shadow-dark"
                                                :disabled="isPasswordLoading">
                                                <span v-if="!isPasswordLoading">Đổi Mật Khẩu</span>
                                                <span v-else class="spinner-border spinner-border-sm"></span>
                                            </button>
                                        </div>
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
                du_lieu_khuon_mat: null,
                id_doi_tac: null
            },
            passwordData: {
                old_password: '',
                new_password: '',
                confirm_password: ''
            },
            avatarPreview: 'https://i.pravatar.cc/300?u=partner',
            isLoading: false,
            isPasswordLoading: false,
            isScanning: false,
            scanMessage: 'Đang khởi tạo camera...',
            stream: null
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
                const token = localStorage.getItem('token_doi_tac') || localStorage.getItem('token_nguoi_dung');
                if (!token) {
                    this.$toast.error("Vui lòng đăng nhập để xem hồ sơ.");
                    this.$router.push('/nguoi-dung/dang-nhap');
                    return;
                }
                const res = await axios.get(`${apiUrl}/doi-tac/me`, {
                    headers: { Authorization: 'Bearer ' + token }
                });
                if (res.data.status) {
                    this.doi_tac = res.data.data;
                    const hinh_anh = this.doi_tac.hinh_anh;
                    if (hinh_anh) {
                        const baseUrl = apiUrl.replace('/api', '');
                        if (hinh_anh.startsWith('http')) {
                            this.avatarPreview = hinh_anh;
                        } else if (hinh_anh.startsWith('uploads/')) {
                            this.avatarPreview = `${baseUrl}/` + hinh_anh;
                        } else {
                            this.avatarPreview = `${baseUrl}/uploads/avatars/` + hinh_anh;
                        }
                    }
                }
            } catch (e) {
                console.error("Profile Load Error:", e);
                const msg = e.response?.data?.message || "Không thể tải thông tin hồ sơ.";
                if (e.response?.status === 401) {
                    this.$router.push('/nguoi-dung/dang-nhap');
                }
                this.$toast.error(msg);
            }
        },
        async toggleScanning() {
            if (this.isScanning) {
                this.stopCamera();
                this.isScanning = false;
            } else {
                this.isScanning = true;
                this.scanMessage = "Đang quét khuôn mặt...";
                try {
                    this.stream = await navigator.mediaDevices.getUserMedia({ video: true });
                    this.$nextTick(() => {
                        this.$refs.video.srcObject = this.stream;
                    });

                    setTimeout(() => { this.scanMessage = "Nhận diện đặc điểm..."; }, 1500);
                    setTimeout(() => { this.scanMessage = "Đang mã hóa dữ liệu biometrics..."; }, 3000);
                    setTimeout(async () => {
                        await this.saveFaceData();
                        this.stopCamera();
                        this.isScanning = false;
                    }, 5000);

                } catch (e) {
                    this.$toast.error("Không thể truy cập camera. Vui lòng cấp quyền.");
                    this.isScanning = false;
                }
            }
        },
        async saveFaceData() {
            try {
                const fakeFaceHash = "FACE_ID_" + Math.random().toString(36).substring(7).toUpperCase();
                const token = localStorage.getItem('token_doi_tac') || localStorage.getItem('token_nguoi_dung');
                const res = await axios.post(`${apiUrl}/doi-tac/profile/update-face-data`,
                    { face_data: fakeFaceHash },
                    { headers: { Authorization: 'Bearer ' + token } }
                );
                if (res.data.status) {
                    this.$toast.success("Xác thực Face ID thành công!");
                    this.doi_tac.du_lieu_khuon_mat = fakeFaceHash;
                }
            } catch (e) {
                this.$toast.error("Lỗi khi lưu dữ liệu khuôn mặt.");
            }
        },
        stopCamera() {
            if (this.stream) {
                this.stream.getTracks().forEach(track => track.stop());
                this.stream = null;
            }
        },
        async handleAvatarChange(event) {
            const file = event.target.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('hinh_anh', file);

            try {
                const token = localStorage.getItem('token_doi_tac') || localStorage.getItem('token_nguoi_dung');
                const res = await axios.post(`${apiUrl}/doi-tac/profile/update-avatar`, formData, {
                    headers: { Authorization: 'Bearer ' + token }
                });
                if (res.data.status) {
                    const hinh_anh = res.data.hinh_anh;
                    const baseUrl = apiUrl.replace('/api', '');
                    if (hinh_anh.startsWith('http')) {
                        this.avatarPreview = hinh_anh;
                    } else if (hinh_anh.startsWith('uploads/')) {
                        this.avatarPreview = `${baseUrl}/` + hinh_anh;
                    } else {
                        this.avatarPreview = `${baseUrl}/uploads/avatars/` + hinh_anh;
                    }
                    this.$toast.success("Đã cập nhật ảnh đại diện.");
                }
            } catch (e) {
                this.$toast.error("Lỗi khi tải ảnh lên.");
            }
        },
        async updateProfile() {
            this.isLoading = true;
            try {
                const token = localStorage.getItem('token_doi_tac') || localStorage.getItem('token_nguoi_dung');
                const res = await axios.post(`${apiUrl}/doi-tac/profile/update`, this.doi_tac, {
                    headers: { Authorization: 'Bearer ' + token }
                });
                if (res.data.status) {
                    this.$toast.success(res.data.message);
                }
            } catch (e) {
                this.$toast.error(e.response?.data?.message || "Lỗi cập nhật hồ sơ");
            } finally {
                this.isLoading = false;
            }
        },
        async changePassword() {
            this.isPasswordLoading = true;
            try {
                const token = localStorage.getItem('token_doi_tac') || localStorage.getItem('token_nguoi_dung');
                const res = await axios.post(`${apiUrl}/doi-tac/profile/change-password`, this.passwordData, {
                    headers: { Authorization: 'Bearer ' + token }
                });
                if (res.data.status) {
                    this.$toast.success(res.data.message);
                    this.passwordData = { old_password: '', new_password: '', confirm_password: '' };
                }
            } catch (e) {
                this.$toast.error(e.response?.data?.message || "Lỗi đổi mật khẩu");
            } finally {
                this.isPasswordLoading = false;
            }
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

.nav-item:hover,
.nav-item.active {
    background: #eff6ff;
    color: #3b82f6;
}

.partner-profile-wrapper {
    min-height: 100vh;
    background: #f8fafc;
}

.glass-card {
    background: white;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.profile-avatar {
    width: 180px;
    height: 180px;
    border-radius: 60px;
    object-fit: cover;
    border: 8px solid #fff;
}

.edit-btn {
    position: absolute;
    bottom: 5px;
    right: 5px;
    background: #3b82f6;
    color: white;
    width: 48px;
    height: 48px;
    border-radius: 18px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.edit-btn:hover {
    background: #1d4ed8;
    transform: rotate(15deg) scale(1.1);
}

.bg-success-soft {
    background: #ecfdf5;
}

.bg-warning-soft {
    background: #fffbeb;
}

.face-scanner-container {
    height: 240px;
    overflow: hidden;
    position: relative;
    border: 2px solid #3b82f6;
}

.face-video-feed {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.scan-radar {
    position: absolute;
    width: 160px;
    height: 160px;
    border: 2px solid rgba(59, 130, 246, 0.6);
    border-radius: 50%;
    animation: pulseRadar 2s infinite;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
}

.scan-line {
    position: absolute;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, transparent, #3b82f6, transparent);
    top: 0;
    animation: scanLineMove 3s linear infinite;
    box-shadow: 0 0 15px #3b82f6;
}

@keyframes pulseRadar {
    0% {
        transform: translate(-50%, -50%) scale(0.8);
        opacity: 0.8;
    }

    100% {
        transform: translate(-50%, -50%) scale(1.2);
        opacity: 0;
    }
}

@keyframes scanLineMove {
    0% {
        top: 10%;
    }

    50% {
        top: 90%;
    }

    100% {
        top: 10%;
    }
}

.shadow-primary {
    box-shadow: 0 10px 25px rgba(59, 130, 246, 0.25);
}

@media (max-width: 992px) {
    .sidebar-zoom {
        width: 80px;
        min-width: 80px;
    }

    .nav-item span,
    .logo-section span {
        display: none;
    }

    .nav-item {
        justify-content: center;
        padding: 14px 0;
    }

    .logo-section {
        justify-content: center;
        padding: 0;
    }
}
</style>
