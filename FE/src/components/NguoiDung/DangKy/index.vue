<template>
    <div class="user-register-wrapper">
        <!-- Background Elements -->
        <div class="sky-container">
            <div class="star-field"></div>
            <div class="grid-overlay"></div>
            <div class="aurora aurora-1"></div>
            <div class="aurora aurora-2"></div>
        </div>

        <div class="register-content-container">
            <div class="main-glass-card shadow-lg">
                <div class="row g-0 h-100">
                    <!-- Left: Interactive Branding -->
                    <div
                        class="col-lg-5 d-none d-lg-flex flex-column justify-content-center p-5 branding-panel text-white">
                        <div class="branding-content-wrapper d-flex flex-column align-items-center gap-5">
                            <div class="brand-top d-flex flex-column align-items-center">
                                <div class="logo-morph">
                                    <div class="nebula"></div>
                                    <i class="bx bx-planet"></i>
                                </div>
                                <h2 class="brand-text">AI-Meet</h2>
                            </div>

                            <div class="brand-center">
                                <h1 class="hero-title">Khởi đầu<br><span class="text-gradient">Hành trình mới</span><br>cùng
                                    AI</h1>
                                <p class="mt-3 opacity-75">Tham gia mạng lưới họp trực tuyến bảo mật nhất hành tinh.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Aesthetic Register Form -->
                    <div class="col-lg-7 form-panel">
                        <div class="form-scrollable p-4 p-xl-5">
                            <div class="form-header mb-4">
                                <h3 class="welcome-text">Tạo Tài Khoản</h3>
                                <p class="sub-text">Chỉ mất vài giây để bắt đầu trải nghiệm 4K HDR</p>
                            </div>

                            <form @submit.prevent="register" class="neon-form">
                                <div class="row g-3">
                                    <div class="col-md-6 mb-2">
                                        <div class="creative-input">
                                            <label>HỌ VÀ TÊN</label>
                                            <div class="input-glow-wrapper">
                                                <i class="bx bx-user"></i>
                                                <input v-model="dang_ky.ho_va_ten" type="text" placeholder="Nguyễn Văn A" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="creative-input">
                                            <label>SỐ ĐIỆN THOẠI</label>
                                            <div class="input-glow-wrapper">
                                                <i class="bx bx-phone"></i>
                                                <input v-model="dang_ky.so_dien_thoai" type="text" placeholder="0123 456 789" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="creative-input">
                                            <label>ĐỊA CHỈ EMAIL</label>
                                            <div class="input-glow-wrapper">
                                                <i class="bx bx-envelope"></i>
                                                <input v-model="dang_ky.email" type="email" placeholder="email@example.com" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="creative-input">
                                            <label>MẬT KHẨU</label>
                                            <div class="input-glow-wrapper">
                                                <i class="bx bx-lock-alt"></i>
                                                <input v-model="dang_ky.password" type="password" placeholder="••••••••" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="creative-input">
                                            <label>XÁC NHẬN</label>
                                            <div class="input-glow-wrapper">
                                                <i class="bx bx-shield-check"></i>
                                                <input v-model="dang_ky.re_password" type="password" placeholder="••••••••" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-check mt-3 custom-check">
                                    <input class="form-check-input" type="checkbox" id="terms" required checked>
                                    <label class="form-check-label text-muted small" for="terms">
                                        Tôi đồng ý với <a href="#" class="link-glow">Điều khoản</a> & <a href="#" class="link-glow">Chính sách bảo mật</a>
                                    </label>
                                </div>

                                <button type="submit" class="cyber-button mt-4" :disabled="isLoading">
                                    <div class="btn-inner">
                                        <span v-if="!isLoading">Đăng Ký Tài Khoản</span>
                                        <span v-else class="loader"></span>
                                        <i v-if="!isLoading" class="bx bx-plus-circle"></i>
                                    </div>
                                    <div class="btn-glow"></div>
                                </button>
                            </form>

                            <p class="mt-4 text-center switch-auth">
                                Đã có tài khoản? <router-link to="/nguoi-dung/dang-nhap">Đăng nhập</router-link>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
const apiUrl = import.meta.env.VITE_API_URL;
import axios from 'axios';
export default {
    name: 'DangKyNguoiDung',
    data() {
        return {
            dang_ky: {
                ho_va_ten: '',
                email: '',
                so_dien_thoai: '',
                password: '',
                re_password: '',
            },
            isLoading: false
        }
    },
    methods: {
        async register() {
            if (this.dang_ky.password != this.dang_ky.re_password) {
                if (this.$toast) {
                    this.$toast.error('Nhật mật khẩu lần 2 không trùng khớp!');
                }
                return;
            }
            this.isLoading = true;
            try {
                const res = await axios.post(`${apiUrl}/nguoi-dung/register`, this.dang_ky);
                if (res.data.status) {
                    if (this.$toast) {
                        this.$toast.success(res.data.message);
                    }
                    this.$router.push('/nguoi-dung/dang-nhap');
                } else {
                    if (this.$toast) {
                        this.$toast.error(res.data.message || 'Gặp sự cố khi đăng ký.');
                    }
                }
            } catch (errors) {
                const msg = errors.response?.data?.message
                    || (errors.response?.data?.errors
                        ? Object.values(errors.response.data.errors)[0][0]
                        : null)
                    || 'Lỗi hệ thống, vui lòng thử lại sau.';
                if (this.$toast) {
                    this.$toast.error(msg);
                }
            } finally {
                this.isLoading = false;
            }
        }
    }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@300;400;500;600;700&display=swap');

.user-register-wrapper {
    min-height: 100vh;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #050810;
    font-family: 'Outfit', sans-serif;
    position: relative;
    overflow: hidden;
    padding: 20px;
}

/* Sky Background Elements */
.sky-container {
    position: absolute;
    inset: 0;
    z-index: 0;
}

.star-field {
    position: absolute;
    inset: 0;
    background-image: 
        radial-gradient(1px 1px at 25px 35px, #fff, rgba(0,0,0,0)),
        radial-gradient(1.5px 1.5px at 100px 150px, #fff, rgba(0,0,0,0)),
        radial-gradient(1px 1px at 150px 250px, #fff, rgba(0,0,0,0));
    background-size: 300px 300px;
    opacity: 0.25;
}

.grid-overlay {
    position: absolute;
    inset: 0;
    background-image: 
        linear-gradient(rgba(37, 99, 235, 0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(37, 99, 235, 0.05) 1px, transparent 1px);
    background-size: 50px 50px;
    perspective: 800px;
    transform: perspective(500px) rotateX(35deg) scale(2);
    transform-origin: center bottom;
}

.aurora {
    position: absolute;
    border-radius: 50%;
    filter: blur(100px);
    opacity: 0.3;
}

.aurora-1 {
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, #1e3a8a 0%, transparent 60%);
    top: -20%;
    right: -10%;
}

.aurora-2 {
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, #7e22ce 0%, transparent 60%);
    bottom: -10%;
    left: -10%;
}

.register-content-container {
    width: 100%;
    max-width: 1150px;
    z-index: 10;
    animation: fade-in-up 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes fade-in-up {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.main-glass-card {
    background: rgba(10, 15, 30, 0.82);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 40px;
    overflow: hidden;
}

/* Branding Panel */
.branding-panel {
    background: linear-gradient(165deg, rgba(37, 99, 235, 0.1) 0%, rgba(126, 34, 206, 0.1) 100%);
    position: relative;
    border-right: 1px solid rgba(255, 255, 255, 0.05);
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.logo-morph {
    width: 50px;
    height: 50px;
    background: #2563eb;
    border-radius: 14px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 28px;
    position: relative;
    overflow: hidden;
}

.logo-morph .nebula {
    position: absolute;
    width: 150%;
    height: 150%;
    background: radial-gradient(circle, #7e22ce 0%, transparent 50%);
    animation: nebula-rotate 4s linear infinite;
}

@keyframes nebula-rotate {
    to { transform: rotate(360deg); }
}

.brand-text {
    margin-top: 10px;
    font-weight: 800;
    font-size: 22px;
    color: white;
}

.hero-title {
    font-size: 42px;
    font-weight: 800;
    line-height: 1.1;
    font-family: 'Space Grotesk', sans-serif;
}

.text-gradient {
    background: linear-gradient(90deg, #60a5fa, #c084fc, #60a5fa);
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: text-pulse 4s linear infinite;
}

@keyframes text-pulse { to { background-position: 200% center; } }

/* Form Panel */
.form-panel {
    background: rgba(5, 8, 16, 0.4);
}

.welcome-text {
    color: white;
    font-size: 32px;
    font-weight: 800;
}

.sub-text {
    color: #64748b;
}

.creative-input label {
    display: block;
    color: #475569;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.2px;
    margin-bottom: 8px;
}

.input-glow-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.input-glow-wrapper i {
    position: absolute;
    left: 16px;
    color: #334155;
    font-size: 18px;
    transition: 0.3s;
}

.input-glow-wrapper input {
    width: 100%;
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 16px;
    padding: 14px 20px 14px 48px;
    color: white;
    font-size: 15px;
    transition: 0.3s;
}

.input-glow-wrapper input::placeholder {
    color: rgba(255, 255, 255, 0.7) !important;
}

.input-glow-wrapper input:focus {
    background: rgba(255, 255, 255, 0.05);
    border-color: #2563eb;
    box-shadow: 0 0 20px rgba(37, 99, 235, 0.15);
    outline: none;
}

.input-glow-wrapper input:focus + i {
    color: #2563eb;
}

.link-glow {
    color: #60a5fa;
    text-decoration: none;
    font-weight: 600;
}

/* Cyber Button */
.cyber-button {
    width: 100%;
    background: #2563eb;
    border: none;
    border-radius: 16px;
    position: relative;
    cursor: pointer;
    overflow: hidden;
    transition: 0.3s;
}

.btn-inner {
    padding: 16px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    color: white;
    font-weight: 700;
    position: relative;
    z-index: 2;
}

.btn-glow {
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transform: translateX(-100%);
    transition: 0.5s;
}

.cyber-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 30px rgba(37, 99, 235, 0.3);
}

.cyber-button:hover .btn-glow {
    transform: translateX(100%);
}

.switch-auth { color: #64748b; }
.switch-auth a { color: #60a5fa; text-decoration: none; font-weight: 700; }

.loader {
    width: 20px; height: 20px; border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%; border-top-color: white; animation: spin 0.8s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

@media (max-width: 991px) {
    .main-glass-card { border-radius: 20px; }
}
</style>
