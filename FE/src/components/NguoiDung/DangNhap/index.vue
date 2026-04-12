<template>
    <div class="user-login-wrapper">
        <!-- Background Elements -->
        <div class="sky-container">
            <div class="star-field"></div>
            <div class="grid-overlay"></div>
            <div class="aurora aurora-1"></div>
            <div class="aurora aurora-2"></div>
        </div>

        <div class="login-content-container">
            <div class="main-glass-card">
                <div class="row g-0 h-100">
                    <!-- Left: Interactive Branding -->
                    <div
                        class="col-lg-5 d-none d-lg-flex flex-column justify-content-center p-5 branding-panel text-white">
                        <div class="branding-content-wrapper d-flex flex-column align-items-center gap-5">
                            <div class="brand-top d-flex flex-column align-items-center">
                                <div class="logo-morph">
                                    <div class="nebula"></div>
                                    <i class="bx bx-atom"></i>
                                </div>
                                <h2 class="brand-text">AI-Meet</h2>
                            </div>

                            <div class="brand-center">
                                <h1 class="hero-title">Kiến tạo<br><span class="text-gradient">Không gian số</span><br>thông
                                    minh</h1>
                                <div class="floating-badge mt-4">
                                    <i class="bx bxs-zap"></i>
                                    <span>Powered by Advanced AI</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Aesthetic Login Form -->
                    <div class="col-lg-7 form-panel">
                        <div class="form-scrollable p-4 p-xl-5">
                            <div class="form-header mb-5">
                                <h3 class="welcome-text">Xin Chào !</h3>
                                <p class="sub-text">Khám phá sức mạnh của cộng tác thời đại AI</p>
                            </div>

                            <form @submit.prevent="login" class="neon-form">
                                <div class="creative-input mb-4">
                                    <label>ĐỊA CHỈ EMAIL</label>
                                    <div class="input-glow-wrapper">
                                        <i class="bx bx-envelope"></i>
                                        <input v-model="nguoi_dung.email" type="email" placeholder="yourname@aimet.com"
                                            required>
                                    </div>
                                </div>

                                <div class="creative-input mb-4">
                                    <div class="d-flex justify-content-between">
                                        <label>MẬT KHẨU</label>
                                        <router-link to="/nguoi-dung/quen-mat-khau" class="link-glow">Quên mật
                                            khẩu?</router-link>
                                    </div>
                                    <div class="input-glow-wrapper">
                                        <i class="bx bx-lock-alt"></i>
                                        <input v-model="nguoi_dung.password" type="password" placeholder="••••••••"
                                            required>
                                    </div>
                                </div>

                                <button type="submit" class="cyber-button mt-5" :disabled="isLoading">
                                    <div class="btn-inner">
                                        <span v-if="!isLoading">Đăng Nhập Ngay</span>
                                        <span v-else class="loader"></span>
                                        <i v-if="!isLoading" class="bx bx-right-arrow-alt"></i>
                                    </div>
                                    <div class="btn-glow"></div>
                                </button>
                            </form>

                            <p class="mt-5 text-center switch-auth">
                                Chưa có tài khoản? <router-link to="/nguoi-dung/dang-ky">Đăng ký ngay</router-link>
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
    name: 'DangNhapNguoiDung',
    data() {
        return {
            nguoi_dung: {
                email: '',
                password: '',
            },
            isLoading: false,
        }
    },
    methods: {
        async login() {
            this.isLoading = true;
            try {
                const res = await axios.post(`${apiUrl}/nguoi-dung/login`, this.nguoi_dung);
                if (res.data.status) {
                    localStorage.setItem('token_nguoi_dung', res.data.data.token);
                    if (this.$toast) {
                        this.$toast.success('Đăng nhập thành công! Chào mừng bạn quay trở lại.');
                        localStorage.setItem('thong_tin_user', JSON.stringify(res.data.data.user));
                    }
                    if (res.data.data.user.id_doi_tac) {
                        localStorage.setItem('token_doi_tac', res.data.data.token);
                        this.$router.push('/doi-tac/trang-chinh');
                    } else {
                        this.$router.push('/nguoi-dung/trang-chinh');
                    }
                } else {
                    if (this.$toast) {
                        this.$toast.error(res.data.message || 'Email hoặc mật khẩu không chính xác.');
                    }
                }
            } catch (errors) {
                const msg = errors.response?.data?.message
                    || (errors.response?.data?.errors
                        ? Object.values(errors.response.data.errors)[0]
                        : null)
                    || 'Hệ thống gián đoạn. Vui lòng thử lại sau.';
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

.user-login-wrapper {
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
        radial-gradient(1px 1px at 25px 35px, #fff, rgba(0, 0, 0, 0)),
        radial-gradient(1.5px 1.5px at 100px 150px, #fff, rgba(0, 0, 0, 0)),
        radial-gradient(1px 1px at 200px 50px, #fff, rgba(0, 0, 0, 0));
    background-size: 250px 250px;
    opacity: 0.3;
}

.grid-overlay {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(24, 114, 255, 0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(24, 114, 255, 0.05) 1px, transparent 1px);
    background-size: 60px 60px;
    perspective: 1000px;
    transform: perspective(600px) rotateX(45deg) scale(2);
    transform-origin: center bottom;
}

.aurora {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.4;
    animation: aurora-float 15s infinite alternate ease-in-out;
}

.aurora-1 {
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, #2563eb 0%, transparent 70%);
    top: -10%;
    right: -10%;
}

.aurora-2 {
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, #7e22ce 0%, transparent 70%);
    bottom: -5%;
    left: -5%;
    animation-delay: -5s;
}

@keyframes aurora-float {
    0% {
        transform: translate(0, 0) rotate(0deg);
    }

    100% {
        transform: translate(50px, 30px) rotate(15deg);
    }
}

.login-content-container {
    width: 100%;
    max-width: 1150px;
    height: 720px;
    z-index: 10;
    animation: zoom-in-glass 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes zoom-in-glass {
    from {
        opacity: 0;
        scale: 0.95;
    }

    to {
        opacity: 1;
        scale: 1;
    }
}

.main-glass-card {
    height: 100%;
    background: rgba(10, 15, 30, 0.82);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 36px;
    overflow: hidden;
    box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.8);
}

/* Branding Panel */
.branding-panel {
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(126, 34, 206, 0.1) 100%);
    position: relative;
    border-right: 1px solid rgba(255, 255, 255, 0.05);
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.logo-morph {
    width: 60px;
    height: 60px;
    background: #2563eb;
    border-radius: 18px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 32px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(37, 99, 235, 0.4);
}

.logo-morph .nebula {
    position: absolute;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, #7e22ce 0%, transparent 80%);
    animation: nebula-rotate 3s linear infinite;
}

@keyframes nebula-rotate {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}

.brand-text {
    margin-top: 15px;
    font-weight: 800;
    font-size: 24px;
    letter-spacing: -0.5px;
    background: linear-gradient(90deg, #fff, #cbd5e1);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.hero-title {
    font-size: 48px;
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

@keyframes text-pulse {
    to {
        background-position: 200% center;
    }
}

.floating-badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: rgba(255, 255, 255, 0.05);
    padding: 8px 16px;
    border-radius: 99px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    font-size: 14px;
    color: #cbd5e1;
}

.floating-badge i {
    color: #facc15;
}

.trust-pill {
    display: flex;
    align-items: center;
    gap: 15px;
    background: rgba(0, 0, 0, 0.4);
    padding: 12px 20px;
    border-radius: 20px;
}

.avatars {
    display: flex;
}

.avatars img {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 2px solid #0a0f1e;
    margin-left: -12px;
}

.avatars img:first-child {
    margin-left: 0;
}

/* Form Panel */
.form-panel {
    background: rgba(5, 8, 16, 0.5);
    display: flex;
    flex-direction: column;
}

.form-scrollable {
    flex-grow: 1;
    overflow-y: auto;
}

.welcome-text {
    color: white;
    font-size: 36px;
    font-weight: 800;
    font-family: 'Space Grotesk', sans-serif;
}

.sub-text {
    color: #64748b;
    font-size: 16px;
}

.creative-input label {
    display: block;
    color: #94a3b8;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.5px;
    margin-bottom: 10px;
}

.input-glow-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.input-glow-wrapper i {
    position: absolute;
    left: 20px;
    color: #4b5563;
    font-size: 20px;
    transition: 0.3s;
}

.input-glow-wrapper input {
    width: 100%;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 20px;
    padding: 18px 24px 18px 56px;
    color: white;
    font-size: 16px;
    transition: 0.3s all cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.input-glow-wrapper input::placeholder {
    color: rgba(255, 255, 255, 0.7) !important;
}

.input-glow-wrapper input:focus {
    background: rgba(255, 255, 255, 0.06);
    border-color: #2563eb;
    box-shadow: 0 0 25px rgba(37, 99, 235, 0.15);
    outline: none;
}

.input-glow-wrapper input:focus+i {
    color: #2563eb;
    transform: scale(1.1);
}

.link-glow {
    color: #60a5fa;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
}

.link-glow:hover {
    text-shadow: 0 0 10px rgba(96, 165, 250, 0.5);
}

/* Cyber Button */
.cyber-button {
    width: 100%;
    background: #2563eb;
    border: none;
    border-radius: 20px;
    position: relative;
    cursor: pointer;
    overflow: hidden;
    transition: 0.3s;
}

.btn-inner {
    padding: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 12px;
    color: white;
    font-weight: 700;
    font-size: 17px;
    position: relative;
    z-index: 2;
}

.btn-glow {
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transform: translateX(-100%);
    transition: 0.6s;
}

.cyber-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px rgba(37, 99, 235, 0.3);
}

.cyber-button:hover .btn-glow {
    transform: translateX(100%);
}

.auth-divider {
    display: flex;
    align-items: center;
    gap: 20px;
    color: #334155;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 2px;
}

.auth-divider::before,
.auth-divider::after {
    content: "";
    flex-grow: 1;
    height: 1px;
    background: rgba(255, 255, 255, 0.05);
}

.social-btn {
    width: 60px;
    height: 60px;
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.05);
    color: #cbd5e1;
    font-size: 24px;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: 0.3s;
}

.social-btn:hover {
    background: rgba(255, 255, 255, 0.08);
    border-color: #2563eb;
    transform: translateY(-5px);
    color: white;
}

.switch-auth {
    color: #64748b;
}

.switch-auth a {
    color: #60a5fa;
    text-decoration: none;
    font-weight: 700;
}

.loader {
    width: 22px;
    height: 22px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

/* Custom Scrollbar */
.form-scrollable::-webkit-scrollbar {
    width: 5px;
}

.form-scrollable::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
}

@media (max-width: 991px) {
    .login-content-container {
        height: auto;
    }

    .main-glass-card {
        border-radius: 24px;
    }
}
</style>
