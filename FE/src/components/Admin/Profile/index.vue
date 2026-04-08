<template>
    <div class="container-fluid py-4">
        <!-- Floating shapes for background decoration (optional but adds to premium feel if we don't have global backgrounds) -->
        
        <div class="row w-100 m-0">
            <div class="col-12 text-center p-0">
                <!-- Custom Pill Navigation -->
                <ul class="nav nav-pills custom-nav-pills justify-content-center" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#profile-tab"
                            type="button" role="tab" aria-selected="true">
                            <i class="bx bx-user me-2"></i>Hồ Sơ
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#update-tab" type="button"
                            role="tab" aria-selected="false">
                            <i class="bx bx-edit me-2"></i>Tính Chỉnh
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#password-tab"
                            type="button" role="tab" aria-selected="false">
                            <i class="bx bx-shield-quarter me-2"></i>Bảo Mật
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content text-start mt-3 px-3">
                    <!-- Thông Tin Cá Nhân -->
                    <div class="tab-pane fade show active" id="profile-tab" role="tabpanel">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <div class="card profile-card">
                                    <div class="primary-header-gradient text-white text-center">
                                        <h4 class="mb-0 text-white fw-bold">Thông Tin Cá Nhân</h4>
                                        <p class="text-white-50 mb-0 mt-2 small">Quản lý không gian hồ sơ của bạn</p>
                                    </div>
                                    <div class="card-body p-4 pt-0">
                                        <div class="text-center mb-4 mt-n5 position-relative" style="top: -65px;">
                                            <div class="avatar-wrapper">
                                                <img :src="anh_tmp || (profile.hinh_anh ? (profile.hinh_anh.startsWith('http') ? profile.hinh_anh : 'http://127.0.0.1:8000' + profile.hinh_anh) : '../../../assets/images/avatars/avatar-1.png')"
                                                    class="avatar-img shadow-sm">
                                                <label for="inputAvatar" class="camera-btn" title="Thay đổi ảnh đại diện">
                                                    <i class="bx bx-camera"></i>
                                                </label>
                                                <input id="inputAvatar" type="file" class="d-none" accept="image/*"
                                                    @change="loadAnhTuLocal($event); uploadAvatar()">
                                            </div>
                                            <h4 class="mt-3 fw-bold mb-1 text-dark">{{ profile.ho_ten }}</h4>
                                            <span class="text-primary fw-bold" style="font-size: 0.9rem;">
                                                <i class="bx bx-crown me-1 text-warning"></i>{{ profile.ten_chuc_vu }}
                                            </span>
                                        </div>
                                        
                                        <div class="row g-3 mt-n5 justify-content-center">
                                            <div class="col-md-5">
                                                <div class="info-item d-flex align-items-center">
                                                    <div class="icon-box">
                                                        <i class="bx bx-user"></i>
                                                    </div>
                                                    <div>
                                                        <p class="text-muted mb-0 small fw-bold text-uppercase">Họ và Tên</p>
                                                        <h6 class="mb-0 fw-bold text-dark">{{ profile.ho_ten}}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="info-item d-flex align-items-center">
                                                    <div class="icon-box">
                                                        <i class="bx bx-envelope"></i>
                                                    </div>
                                                    <div>
                                                        <p class="text-muted mb-0 small fw-bold text-uppercase">Email</p>
                                                        <h6 class="mb-0 fw-bold text-dark text-truncate" style="max-width: 180px;">{{ profile.email}}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="info-item d-flex align-items-center">
                                                    <div class="icon-box">
                                                        <i class="bx bx-phone"></i>
                                                    </div>
                                                    <div>
                                                        <p class="text-muted mb-0 small fw-bold text-uppercase">Số Điện Thoại</p>
                                                        <h6 class="mb-0 fw-bold text-dark">{{ profile.so_dien_thoai}}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="info-item d-flex align-items-center">
                                                    <div class="icon-box">
                                                        <i class="bx bx-briefcase"></i>
                                                    </div>
                                                    <div>
                                                        <p class="text-muted mb-0 small fw-bold text-uppercase">Chức Vụ</p>
                                                        <h6 class="mb-0 fw-bold text-dark">{{ profile.ten_chuc_vu}}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Cập Nhật Thông Tin -->
                    <div class="tab-pane fade" id="update-tab" role="tabpanel">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-12">
                                <div class="card profile-card">
                                    <div class="primary-header-gradient text-white text-center">
                                        <h4 class="mb-0 text-white fw-bold">Cập Nhật Hồ Sơ</h4>
                                        <p class="text-white-50 mb-0 mt-2 small">Đảm bảo thông tin của bạn luôn mới nhất</p>
                                    </div>
                                    <div class="card-body p-4">
                                        <form>
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label class="form-label fw-bold text-dark small mb-1 ms-1">Họ và Tên</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                                                        <input type="text" class="form-control custom-input"
                                                            v-model="update_profile.ho_va_ten"
                                                            placeholder="Nhập họ và tên">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold text-dark small mb-1 ms-1">Email</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                                        <input type="email" class="form-control custom-input"
                                                            v-model="update_profile.email" placeholder="example@mail.com">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold text-dark small mb-1 ms-1">Số Điện Thoại</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bx bx-phone"></i></span>
                                                        <input type="text" class="form-control custom-input"
                                                            v-model="update_profile.so_dien_thoai"
                                                            placeholder="09xxx">
                                                    </div>
                                                </div>
                                                <div class="col-12 text-center mt-4">
                                                    <button type="button" class="btn btn-update w-100" @click="updateProfile()">
                                                        <i class="bx bx-save me-2"></i>Lưu Thay Đổi
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Đổi Mật Khẩu -->
                    <div class="tab-pane fade" id="password-tab" role="tabpanel">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-12">
                                <div class="card profile-card">
                                    <div class="primary-header-gradient text-white text-center">
                                        <h4 class="mb-0 text-white fw-bold">Đổi Mật Khẩu</h4>
                                        <p class="text-white-50 mb-0 mt-2 small">Bảo vệ tài khoản của bạn</p>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-dark small mb-1 ms-1">Mật Khẩu Hiện Tại</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bx bx-lock-open"></i></span>
                                                <input :type="showPassword.password ? 'text' : 'password'"
                                                    class="form-control custom-input"
                                                    v-model="update_password_profile.password"
                                                    placeholder="Nhập mật khẩu hiện tại">
                                                <button @click="showPassword.password = !showPassword.password"
                                                    class="btn password-icon" type="button">
                                                    <i :class="showPassword.password ? 'bx bx-hide' : 'bx bx-show'"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-dark small mb-1 ms-1">Mật Khẩu Mới</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bx bx-lock"></i></span>
                                                <input :type="showPassword.new_password ? 'text' : 'password'"
                                                    class="form-control custom-input"
                                                    v-model="update_password_profile.new_password"
                                                    placeholder="Ít nhất 6 ký tự">
                                                <button @click="showPassword.new_password = !showPassword.new_password"
                                                    class="btn password-icon" type="button">
                                                    <i :class="showPassword.new_password ? 'bx bx-hide' : 'bx bx-show'"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label fw-bold text-dark small mb-1 ms-1">Xác Nhận Mật Khẩu Mới</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bx bx-check-shield"></i></span>
                                                <input :type="showPassword.re_newpassword ? 'text' : 'password'"
                                                    class="form-control custom-input"
                                                    v-model="update_password_profile.re_newpassword"
                                                    placeholder="Nhập lại mật khẩu mới">
                                                <button @click="showPassword.re_newpassword = !showPassword.re_newpassword"
                                                    class="btn password-icon" type="button">
                                                    <i :class="showPassword.re_newpassword ? 'bx bx-hide' : 'bx bx-show'"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="button" class="btn btn-update w-100" @click="updatePassword()">
                                                <i class="bx bx-shield-quarter me-2"></i>Cập Nhật Mật Khẩu
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            profile: {},
            update_profile: {},
            update_password_profile: {
                password: '',
                new_password: '',
                re_newpassword: ''
            },
            file_anh: null,
            anh_tmp: '',
            showPassword: {
                password: false,
                new_password: false,
                re_newpassword: false
            },
            list_chuc_vu: []
        }
    },
    mounted() {
        this.loadProfile();
        this.loadChucVu();
    },
    methods: {
        loadChucVu() {
            axios.get('http://127.0.0.1:8000/api/admin/chuc-vu/data')
                .then((res) => {
                    if (res.data.status) {
                        this.list_chuc_vu = res.data.data;
                    } else {
                        this.$toast.error(res.data.message);
                    }
                })
                .catch((err) => {
                    const listErr = err.response.data.errors;
                    Object.values(listErr).forEach((error) => {
                        this.$toast.error(error[0]);
                    });
                });
        },
        loadProfile() {
            axios.get('http://127.0.0.1:8000/api/admin/profile/data', {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token_admin"),
                },
            })
                .then(res => {
                    if (res.data.status) {
                        this.profile = res.data.data;
                        this.update_profile = { ...res.data.data };
                    } else {
                        this.$toast.error(res.data.message);
                    }
                })
                .catch((err) => {
                    const listErr = err.response.data.errors;
                    Object.values(listErr).forEach((error) => {
                        this.$toast.error(error[0]);
                    });
                });
        },
        updateProfile() {
            axios.post('http://127.0.0.1:8000/api/admin/profile/update', this.update_profile, {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token_admin"),
                },
            })
                .then(res => {
                    if (res.data.status) {
                        this.loadProfile();
                        this.$toast.success(res.data.message);
                    } else {
                        this.$toast.error(res.data.message);
                    }
                })
                .catch((err) => {
                    console.error('Lỗi khi cập nhật profile:', err);
                    if (err.response && err.response.data && err.response.data.errors) {
                        const listErr = err.response.data.errors;
                        Object.values(listErr).forEach((error) => {
                            this.$toast.error(error[0]);
                        });
                    } else {
                        this.$toast.error('Không thể cập nhật thông tin');
                    }
                });
        },
        updatePassword() {
            axios.post('http://127.0.0.1:8000/api/admin/profile/change-password', this.update_password_profile, {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token_admin"),
                },
            })
                .then(res => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.update_password_profile = {
                            password: '',
                            new_password: '',
                            re_newpassword: ''
                        };
                        this.showPassword = {
                            password: false,
                            new_password: false,
                            re_newpassword: false
                        };
                    } else {
                        this.$toast.error(res.data.message);
                    }
                })
                .catch((err) => {
                    const listErr = err.response.data.errors;
                    Object.values(listErr).forEach((error) => {
                        this.$toast.error(error[0]);
                    });
                });
        },
        loadAnhTuLocal(event) {
            this.file_anh = event.target.files[0];
            this.anh_tmp = this.createImage(this.file_anh);
        },
        createImage(file) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                vm.anh_tmp = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        uploadAvatar() {
            const formData = new FormData();
            formData.append('hinh_anh', this.file_anh);
            axios.post('http://127.0.0.1:8000/api/admin/profile/update-avatar', formData, {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token_admin"),
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.loadProfile();
                    } else {
                        this.$toast.error(res.data.message);
                    }
                })
                .catch((err) => {
                    const listErr = err.response.data.errors;
                    Object.values(listErr).forEach((error) => {
                        this.$toast.error(error[0]);
                    });
                });
        }
    }
}
</script>

<style scoped>
.profile-card {
    border-radius: 15px;
    border: none;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    background: #fff;
}

.primary-header-gradient {
    background: linear-gradient(135deg, #008cff 0%, #005bc4 100%);
    padding: 2rem 1.5rem 5rem 1.5rem;
}

.avatar-wrapper {
    position: relative;
    display: inline-block;
    padding: 5px;
    border-radius: 50%;
    background: #fff;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    z-index: 10;
}

.avatar-img {
    width: 130px;
    height: 130px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #fff;
}

.camera-btn {
    position: absolute;
    bottom: 0px;
    right: 5px;
    background: #008cff;
    color: #fff;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 3px 10px rgba(0,0,0,0.2);
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 11;
}

.camera-btn:hover {
    transform: scale(1.1);
    background: #007bdd;
}

/* Custom Tabs */
.custom-nav-pills {
    background: #fff;
    padding: 6px;
    border-radius: 10px;
    display: inline-flex;
    margin-bottom: 2rem;
    box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    border: 1px solid #edf2f7;
}

.custom-nav-pills .nav-link {
    border-radius: 8px;
    padding: 10px 25px;
    color: #4a5568;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    background: transparent;
    font-size: 0.9rem;
}

.custom-nav-pills .nav-link:hover:not(.active) {
    color: #008cff;
    background: rgba(0, 140, 255, 0.05);
}

.custom-nav-pills .nav-link.active {
    background: #008cff;
    color: #fff;
    box-shadow: 0 4px 12px rgba(0, 140, 255, 0.25);
}

/* Info Items */
.info-item {
    background: #f8fafc;
    border: 1px solid #edf2f7;
    padding: 1.5rem;
    border-radius: 12px;
    transition: all 0.3s ease;
    height: 100%;
}

.info-item:hover {
    background: #fff;
    border-color: #008cff;
    box-shadow: 0 10px 20px rgba(0,0,0,0.05);
}

.icon-box {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-right: 15px;
    background: rgba(0, 140, 255, 0.1);
    color: #008cff;
}

/* Form Controls */
.input-group {
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
    transition: all 0.3s;
}

.input-group:focus-within {
    border-color: #008cff;
    box-shadow: 0 0 0 3px rgba(0, 140, 255, 0.1);
}

.input-group-text {
    background: #fff;
    border: none;
    color: #008cff;
    padding-left: 1.25rem;
}

.custom-input {
    border: none;
    padding: 12px 15px;
    font-size: 0.95rem;
}

.custom-input:focus {
    box-shadow: none;
}

.btn-update {
    background: #008cff;
    border: none;
    border-radius: 10px;
    padding: 12px 25px;
    font-weight: 700;
    color: white;
    transition: all 0.3s;
}

.btn-update:hover {
    background: #007bdd;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 140, 255, 0.3);
}

.password-icon {
    background: #fff;
    border: none;
    color: #a0aec0;
}

.password-icon:hover {
    color: #008cff;
}
</style>
