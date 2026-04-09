<template>
    <div class="user-login-wrapper">
        <!-- AI Background Image -->
        <div class="bg-image-layer"></div>
        <div class="bg-overlay"></div>

        <!-- Canvas for Particles -->
        <canvas id="particle-canvas" ref="particleCanvas"></canvas>

        <!-- Animated Background Glows -->
        <div class="bg-glow bg-glow-1"></div>
        <div class="bg-glow bg-glow-2"></div>
        <div class="bg-glow bg-glow-3"></div>

        <div class="login-container">
            <div class="glass-card">
                <div class="row g-0">
                    <!-- Left Side: Branding -->
                    <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-center p-5 branding-section">
                        <div class="branding-content">
                            <div class="logo-box mb-4">
                                <div class="logo-icon">
                                    <i class="bx bx-camera-movie"></i>
                                </div>
                                <span class="brand-name">AI-Meet</span>
                            </div>
                            <h1 class="main-title">Kết nối thông minh,<br>Hợp tác hiệu quả.</h1>
                            <p class="description">
                                Nền tảng họp trực tuyến thế hệ mới tích hợp trí tuệ nhân tạo để tối ưu hóa công việc của bạn.
                            </p>
                            <div class="feature-list mt-5">
                                <div class="feature-item">
                                    <i class="bx bx-check-shield"></i>
                                    <span>Bảo mật tuyệt đối</span>
                                </div>
                                <div class="feature-item">
                                    <i class="bx bx-bolt-circle"></i>
                                    <span>Tốc độ vượt trội</span>
                                </div>
                                <div class="feature-item">
                                    <i class="bx bx-brain"></i>
                                    <span>Tích hợp AI thông minh</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side: Form -->
                    <div class="col-lg-6 form-section">
                        <div class="form-content p-4 p-xl-5">
                            <div class="form-header mb-5">
                                <h2 class="form-title">Chào Mừng Trở Lại</h2>
                                <p class="form-subtitle">Vui lòng nhập thông tin để truy cập phòng họp.</p>
                            </div>

                            <form @submit.prevent="login()" class="auth-form">
                                <div class="input-group-custom">
                                    <label>Email</label>
                                    <div class="input-wrapper">
                                        <i class="bx bxs-envelope"></i>
                                        <input 
                                            v-model="nguoi_dung.email" 
                                            type="email" 
                                            placeholder="ten@congty.com"
                                            required
                                        >
                                    </div>
                                </div>

                                <div class="input-group-custom mt-4">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label>Mật Khẩu</label>
                                        <a href="/nguoi-dung/quen-mat-khau" class="forgot-link">Quên mật khẩu?</a>
                                    </div>
                                    <div class="input-wrapper">
                                        <i class="bx bxs-lock-alt"></i>
                                        <input 
                                            v-model="nguoi_dung.password" 
                                            type="password" 
                                            placeholder="••••••••"
                                            required
                                        >
                                    </div>
                                </div>

                                <button type="submit" class="btn-submit" :disabled="isLoading">
                                    <span v-if="!isLoading">Đăng Nhập</span>
                                    <span v-else class="loader"></span>
                                    <i v-if="!isLoading" class="bx bx-right-arrow-alt ms-2"></i>
                                </button>
                            </form>

                            <div class="form-footer mt-5 text-center">
                                <span class="footer-text">Chưa có tài khoản?</span>
                                <router-link to="/nguoi-dung/dang-ky" class="signup-link">Đăng ký ngay</router-link>
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
    name: 'DangNhapNguoiDung',
    data() {
        return {
            nguoi_dung: {
                email: '',
                password: '',
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
        async login() {
            this.isLoading = true;
            try {
                const res = await axios.post(`${apiUrl}/nguoi-dung/login`, this.nguoi_dung);
                if (res.data.status) {
                    localStorage.setItem('token_nguoi_dung', res.data.data.token);
                    if (this.$toast) {
                        this.$toast.success('Đăng nhập thành công!');
                        localStorage.setItem('thong_tin_user', JSON.stringify(res.data.data.user));
                    }
                    this.$router.push('/nguoi-dung/trang-chinh');
                } else {
                    if (this.$toast) {
                        this.$toast.error(res.data.message || 'Đăng nhập thất bại!');
                    }
                }
            } catch (errors) {
                const msg = errors.response?.data?.message
                    || (errors.response?.data?.errors
                        ? Object.values(errors.response.data.errors)[0]
                        : null)
                    || 'Đăng nhập thất bại!';
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
                    ctx.fillStyle = `rgba(249, 115, 22, ${this.opacity})`;
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

                        if (distance < 150 * 150) {
                            ctx.strokeStyle = `rgba(249, 115, 22, ${0.1 * (1 - Math.sqrt(distance)/150)})`;
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

.user-login-wrapper {
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
    transform: scale(1.05); /* prevents blur edge artifacts */
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
    background: radial-gradient(circle, #7c2d12 0%, transparent 70%);
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

.login-container {
    width: 100%;
    max-width: 1100px;
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
    background: #f97316;
    color: white;
    width: 42px;
    height: 42px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 12px;
    font-size: 24px;
    box-shadow: 0 8px 15px rgba(249, 115, 22, 0.3);
}

.brand-name {
    color: white;
    font-size: 24px;
    font-weight: 700;
    letter-spacing: -0.5px;
}

.main-title {
    color: white;
    font-size: 42px;
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 24px;
    letter-spacing: -0.5px;
}

.description {
    color: #94a3b8;
    font-size: 17px;
    line-height: 1.6;
    max-width: 440px;
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
    color: #cbd5e1;
    font-size: 15px;
}

.feature-item i {
    color: #f97316;
    font-size: 20px;
}

/* Form Section */
.form-section {
    background: rgba(15, 23, 42, 0.2);
}

.form-title {
    color: white;
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 12px;
}

.form-subtitle {
    color: #64748b;
    font-size: 15px;
}

.input-group-custom label {
    color: #cbd5e1;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 8px;
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
    font-size: 20px;
    transition: all 0.3s;
}

.input-wrapper input {
    width: 100%;
    background: rgba(30, 41, 59, 0.4);
    border: 1px solid rgba(71, 85, 105, 0.3);
    border-radius: 16px;
    padding: 16px 20px 16px 52px;
    color: white;
    font-size: 15px;
    transition: all 0.3s;
    outline: none;
}

.input-wrapper input:focus {
    border-color: #f97316;
    background: rgba(30, 41, 59, 0.7);
    box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
}

.input-wrapper input:focus + i {
    color: #f97316;
}

.forgot-link {
    color: #f97316;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
}

.btn-submit {
    width: 100%;
    margin-top: 36px;
    padding: 18px;
    background: #0f172a;
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    justify-content: center;
    align-items: center;
}

.btn-submit:hover {
    background: #1e293b;
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    border-color: #f97316;
}

.btn-submit:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.footer-text {
    color: #64748b;
    font-size: 14px;
}

.signup-link {
    color: #f97316;
    text-decoration: none;
    font-weight: 700;
    font-size: 14px;
    margin-left: 6px;
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
    .glass-card {
        border-radius: 24px;
    }
    .form-content {
        padding: 40px 24px;
    }
}
</style>
