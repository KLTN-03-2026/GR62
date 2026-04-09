<template>
    <div class="user-register-wrapper">
        <!-- AI Background Image -->
        <div class="bg-image-layer"></div>
        <div class="bg-overlay"></div>

        <!-- Canvas for Particles -->
        <canvas id="particle-canvas" ref="particleCanvas"></canvas>

        <!-- Animated Background Glows -->
        <div class="bg-glow bg-glow-1"></div>
        <div class="bg-glow bg-glow-2"></div>
        <div class="bg-glow bg-glow-3"></div>

        <div class="register-container">
            <div class="glass-card">
                <div class="row g-0">
                    <!-- Left Side: Branding & Marketing -->
                    <div class="col-lg-5 d-none d-lg-flex flex-column justify-content-between p-5 branding-section">
                        <div class="branding-content">
                            <div class="logo-box mb-4">
                                <div class="logo-icon">
                                    <i class="bx bx-camera-movie"></i>
                                </div>
                                <span class="brand-name">AI-Meet</span>
                            </div>
                            <h1 class="main-title">Kết nối thông minh<br>qua sức mạnh <span class="highlight">AI</span>.</h1>
                            <p class="description">
                                Trải nghiệm nền tảng họp trực tuyến thế hệ mới với khả năng tóm tắt cuộc họp, dịch thuật thời gian thực và tự động hóa ghi chú.
                            </p>
                            <div class="feature-list mt-5">
                                <div class="feature-item">
                                    <i class="bx bxs-check-circle"></i>
                                    <span>Bảo mật dữ liệu tuyệt đối</span>
                                </div>
                                <div class="feature-item">
                                    <i class="bx bxs-check-circle"></i>
                                    <span>Trợ lý ảo thông minh 24/7</span>
                                </div>
                                <div class="feature-item">
                                    <i class="bx bxs-check-circle"></i>
                                    <span>Chất lượng hình ảnh 4K HDR</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Mini Preview -->
                        <div class="mt-auto preview-box">
                            <img src="https://images.unsplash.com/photo-1573164713988-8665fc963095?auto=format&fit=crop&q=80&w=800" alt="Team meeting">
                        </div>
                    </div>

                    <!-- Right Side: Form -->
                    <div class="col-lg-7 form-section">
                        <div class="form-content p-4 p-xl-5">
                            <div class="form-header mb-4">
                                <h2 class="form-title">Đăng Ký Tài Khoản</h2>
                                <p class="form-subtitle">Tham gia cộng đồng AI-Meet ngay hôm nay.</p>
                            </div>

                            <form @submit.prevent="register()" class="auth-form">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="input-group-custom">
                                            <label>Họ và tên</label>
                                            <div class="input-wrapper">
                                                <i class="bx bxs-user"></i>
                                                <input v-model="dang_ky.ho_va_ten" type="text" placeholder="Nguyễn Văn A" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-group-custom">
                                            <label>Số điện thoại</label>
                                            <div class="input-wrapper">
                                                <i class="bx bxs-phone"></i>
                                                <input v-model="dang_ky.so_dien_thoai" type="text" placeholder="0123456789" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="input-group-custom mb-3">
                                    <label>Email</label>
                                    <div class="input-wrapper">
                                        <i class="bx bxs-envelope"></i>
                                        <input v-model="dang_ky.email" type="email" placeholder="example@email.com" required>
                                    </div>
                                </div>

                                <div class="input-group-custom mb-3">
                                    <label>Mật khẩu</label>
                                    <div class="input-wrapper">
                                        <i class="bx bxs-lock-alt"></i>
                                        <input v-model="dang_ky.password" type="password" placeholder="••••••••" required>
                                    </div>
                                </div>

                                <div class="input-group-custom mb-3">
                                    <label>Xác nhận mật khẩu</label>
                                    <div class="input-wrapper">
                                        <i class="bx bx-rotate-left"></i>
                                        <input v-model="dang_ky.re_password" type="password" placeholder="••••••••" required>
                                    </div>
                                </div>

                                <div class="form-check mb-4 mt-3 custom-checkbox">
                                    <input class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        Tôi đồng ý với <a href="#">Điều khoản dịch vụ</a> và <a href="#">Chính sách bảo mật</a>.
                                    </label>
                                </div>

                                <button type="submit" class="btn-submit" :disabled="isLoading">
                                    <span v-if="!isLoading">Đăng Ký Ngay</span>
                                    <span v-else class="loader"></span>
                                </button>
                            </form>

                            <div class="form-footer mt-4 text-center">
                                <span class="footer-text">Đã có tài khoản?</span>
                                <router-link to="/nguoi-dung/dang-nhap" class="login-link">Đăng nhập ngay</router-link>
                            </div>
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
            isLoading: false,
            animationId: null
        }
    },
    mounted() {
        setTimeout(() => {
            this.initParticles();
        }, 100);
    },
    beforeUnmount() {
        if (this.animationId) {
            cancelAnimationFrame(this.animationId);
        }
        window.removeEventListener('resize', this.handleResize);
    },
    methods: {
        async register() {
            if (this.dang_ky.password != this.dang_ky.re_password) {
                if (this.$toast) {
                    this.$toast.error('Mật khẩu nhập lại không khớp!');
                } else {
                    alert('Mật khẩu nhập lại không khớp!');
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
                        this.$toast.error(res.data.message || 'Đăng ký thất bại!');
                    }
                }
            } catch (errors) {
                const msg = errors.response?.data?.message
                    || (errors.response?.data?.errors
                        ? Object.values(errors.response.data.errors)[0][0]
                        : null)
                    || 'Đăng ký thất bại!';
                if (this.$toast) {
                    this.$toast.error(msg);
                }
            } finally {
                this.isLoading = false;
            }
        },
        initParticles() {
            const canvas = this.$refs.particleCanvas;
            const ctx = canvas.getContext('2d');
            let particles = [];
            
            const handleResize = () => {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            };
            this.handleResize = handleResize;
            window.addEventListener('resize', handleResize);
            handleResize();

            class Particle {
                constructor() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.size = Math.random() * 2 + 1;
                    this.speedX = (Math.random() - 0.5) * 0.6;
                    this.speedY = (Math.random() - 0.5) * 0.6;
                    this.opacity = Math.random() * 0.5 + 0.2;
                }
                update() {
                    this.x += this.speedX;
                    this.y += this.speedY;

                    if (this.x > canvas.width) this.x = 0;
                    else if (this.x < 0) this.x = canvas.width;
                    if (this.y > canvas.height) this.y = 0;
                    else if (this.y < 0) this.y = canvas.height;
                }
                draw() {
                    ctx.fillStyle = `rgba(234, 88, 12, ${this.opacity})`;
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fill();
                }
            }

            const createParticles = () => {
                const count = Math.min(40, (canvas.width * canvas.height) / 50000);
                particles = [];
                for (let i = 0; i < count; i++) {
                    particles.push(new Particle());
                }
            };
            createParticles();

            const drawLines = () => {
                for (let i = 0; i < particles.length; i++) {
                    for (let j = i + 1; j < particles.length; j++) {
                        const dx = particles[i].x - particles[j].x;
                        const dy = particles[i].y - particles[j].y;
                        const distance = dx * dx + dy * dy;

                        if (distance < 160 * 160) {
                            ctx.strokeStyle = `rgba(234, 88, 12, ${0.1 * (1 - Math.sqrt(distance)/160)})`;
                            ctx.lineWidth = 0.8;
                            ctx.beginPath();
                            ctx.moveTo(particles[i].x, particles[i].y);
                            ctx.lineTo(particles[j].x, particles[j].y);
                            ctx.stroke();
                        }
                    }
                }
            };

            const animate = () => {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                particles.forEach(p => {
                    p.update();
                    p.draw();
                });
                drawLines();
                this.animationId = requestAnimationFrame(animate);
            };
            animate();
        }
    }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

.user-register-wrapper {
    min-height: 100vh;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #020617;
    font-family: 'Inter', sans-serif;
    position: relative;
    overflow: hidden;
    padding: 20px;
}

.bg-image-layer {
    position: absolute;
    inset: 0;
    background-image: url('/ai_login_bg.png');
    background-size: cover;
    background-position: center;
    filter: blur(6px) brightness(0.5) saturate(1.3);
    transform: scale(1.05);
    z-index: 0;
}

.bg-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        135deg,
        rgba(2, 6, 23, 0.7) 0%,
        rgba(15, 23, 42, 0.55) 50%,
        rgba(2, 6, 23, 0.75) 100%
    );
    z-index: 1;
}

#particle-canvas {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
    pointer-events: none;
}

/* Background Globals */
.bg-glow {
    position: absolute;
    border-radius: 50%;
    z-index: 0;
    opacity: 0.4;
    will-change: transform, opacity;
}

.bg-glow-1 {
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, #1e3a8a 0%, transparent 70%);
    top: -10%;
    right: -10%;
}

.bg-glow-2 {
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, #431407 0%, transparent 70%);
    bottom: -15%;
    left: -10%;
}

.bg-glow-3 {
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, #0f172a 0%, transparent 70%);
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.register-container {
    width: 100%;
    max-width: 1150px;
    z-index: 2;
    animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    will-change: transform, opacity;
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(40px); }
    to { opacity: 1; transform: translateY(0); }
}

.glass-card {
    background: rgba(15, 23, 42, 0.75);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 32px;
    overflow: hidden;
    box-shadow: 0 50px 100px -20px rgba(0, 0, 0, 0.55);
}

/* Branding Section */
.branding-section {
    background: linear-gradient(135deg, rgba(30, 41, 59, 0.4) 0%, rgba(15, 23, 42, 0.6) 100%);
    border-right: 1px solid rgba(255, 255, 255, 0.05);
}

.logo-box {
    display: flex;
    align-items: center;
    gap: 12px;
}

.logo-icon {
    background: #ea580c;
    color: white;
    width: 42px;
    height: 42px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 12px;
    font-size: 24px;
    box-shadow: 0 8px 15px rgba(234, 88, 12, 0.3);
}

.brand-name {
    color: white;
    font-size: 24px;
    font-weight: 700;
}

.main-title {
    color: white;
    font-size: 38px;
    font-weight: 700;
    line-height: 1.25;
    margin-bottom: 24px;
    letter-spacing: -0.5px;
}

.highlight {
    color: #ea580c;
}

.description {
    color: #cbd5e1;
    font-size: 16px;
    line-height: 1.6;
    max-width: 420px;
}

.feature-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #e2e8f0;
    font-size: 15px;
}

.feature-item i {
    color: #ea580c;
    font-size: 20px;
}

.preview-box {
    border-radius: 20px;
    overflow: hidden;
    height: 180px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.preview-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.8;
}

/* Form Section */
.form-section {
    background: rgba(15, 23, 42, 0.2);
}

.form-title {
    color: white;
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 8px;
}

.form-subtitle {
    color: #64748b;
    font-size: 15px;
}

.input-group-custom label {
    color: #cbd5e1;
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 6px;
}

.input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.input-wrapper i {
    position: absolute;
    left: 18px;
    color: #64748b;
    font-size: 18px;
    transition: all 0.3s;
}

.input-wrapper input {
    width: 100%;
    background: rgba(30, 41, 59, 0.5);
    border: 1px solid rgba(71, 85, 105, 0.3);
    border-radius: 14px;
    padding: 14px 18px 14px 48px;
    color: white;
    font-size: 15px;
    transition: all 0.3s;
    outline: none;
}

.input-wrapper input:focus {
    border-color: #ea580c;
    background: rgba(30, 41, 59, 0.8);
    box-shadow: 0 0 0 4px rgba(234, 88, 12, 0.1);
}

.input-wrapper input:focus + i {
    color: #ea580c;
}

.custom-checkbox label {
    color: #64748b;
    font-size: 13px;
}

.custom-checkbox a {
    color: #ea580c;
    text-decoration: none;
    font-weight: 600;
}

.btn-submit {
    width: 100%;
    margin-top: 20px;
    padding: 16px;
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    color: white;
    border: none;
    border-radius: 14px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 10px 15px -3px rgba(234, 88, 12, 0.4);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 25px -5px rgba(234, 88, 12, 0.5);
}

.btn-submit:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.login-link {
    color: #ea580c;
    text-decoration: none;
    font-weight: 700;
    font-size: 14px;
    margin-left: 6px;
}

.footer-text {
    color: #64748b;
    font-size: 14px;
}

.loader {
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: #fff;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

@media (max-width: 991px) {
    .main-title { font-size: 32px; }
}
</style>
