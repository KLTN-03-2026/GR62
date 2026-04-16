<template>
    <div class="admin-login-page">

        <!-- ══ LEFT PANEL ══ -->
        <div class="left-panel">
            <!-- Particle Canvas -->
            <canvas id="particle-canvas" ref="particleCanvas"></canvas>

            <!-- Dark overlay on top of bg -->
            <div class="left-overlay"></div>

            <!-- Content -->
            <div class="left-content">
                <!-- Secure Badge -->
                <div class="secure-badge">
                    <i class="bx bx-shield-check"></i>
                    <span>SECURE ENTERPRISE ACCESS</span>
                </div>

                <!-- Title -->
                <h1 class="left-title">AI-Meet Admin </h1>
                <p class="left-desc">
                    Hệ thống quản trị trung tâm cho các giải pháp trí tuệ nhân tạo của AI-Meet.
                    Giám sát, quản lý và tối ưu hóa hiệu suất doanh nghiệp.
                </p>

                <!-- Stats Cards -->
                <div class="stat-cards">
                    <div class="stat-card">
                        <div class="stat-value">99.9%</div>
                        <div class="stat-label">UP TIME</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">24/7</div>
                        <div class="stat-label">MONITORING</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ══ RIGHT PANEL ══ -->
        <div class="right-panel">
            <!-- Form Area -->
            <div class="form-area">
                <h2 class="form-title">Quản trị hệ thống</h2>
                <p class="form-subtitle">Vui lòng đăng nhập để truy cập trang quản trị AI-Meet</p>

                <form @submit.prevent="login" class="admin-form">
                    <!-- Email -->
                    <div class="field-group">
                        <label class="field-label">EMAIL ADMIN</label>
                        <div class="input-wrap">
                            <span class="icon-left"><i class="bx bx-at"></i></span>
                            <input id="email" v-model="admin.email" type="email" placeholder="admin@ai-meet.com"
                                required />
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="field-group">
                        <label class="field-label">MẬT KHẨU</label>
                        <div class="input-wrap">
                            <span class="icon-left"><i class="bx bx-lock-alt"></i></span>
                            <input id="password" v-model="admin.password" :type="showPass ? 'text' : 'password'"
                                placeholder="••••••••" required />
                            <span class="icon-right clickable" @click="showPass = !showPass">
                                <i :class="showPass ? 'bx bx-show' : 'bx bx-hide'"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Remember + Forgot -->
                    <div class="options-row">
                        <label class="checkbox-label">
                            <input type="checkbox" v-model="rememberMe" />
                            <span>Ghi nhớ đăng nhập</span>
                        </label>
                        <a href="#" class="forgot-link">Quên mật khẩu?</a>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn-login" :disabled="isLoading">
                        <span v-if="!isLoading">Đăng nhập</span>
                        <span v-else class="btn-loader"></span>
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <footer class="right-footer">
                <div class="footer-links">
                    <a href="#">Security Policy</a>
                    <a href="#">System Status</a>
                    <a href="#">Admin Support</a>
                </div>
                <p class="footer-copy">© 2024 AI-Meet Enterprise. All rights reserved.</p>
            </footer>
        </div>

        <!-- Help button -->
        <button class="help-fab" title="Trợ giúp">
            <i class="bx bx-question-mark"></i>
        </button>

    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: 'DangNhapAdmin',
    data() {
        return {
            admin: { email: '', password: '' },
            isLoading: false,
            showPass: false,
            rememberMe: false,
            animationId: null,
        };
    },
    mounted() {
        this.initParticles();
    },
    beforeUnmount() {
        if (this.animationId) cancelAnimationFrame(this.animationId);
        window.removeEventListener('resize', this.handleResize);
    },
    methods: {
        async login() {
            this.isLoading = true;
            try {
                const res = await axios.post('http://127.0.0.1:8000/api/admin/login', this.admin);
                if (res.data.status) {
                    localStorage.setItem('token_admin', res.data.data.token);
                    if (this.$toast) this.$toast.success('Đăng nhập Admin thành công!');
                    this.$router.push('/admin/phong-hop');
                } else {
                    if (this.$toast) this.$toast.error(res.data.message || 'Email hoặc mật khẩu không chính xác!');
                }
            } catch (errors) {
                const msg = errors.response?.data?.message
                    || (errors.response?.data?.errors ? Object.values(errors.response.data.errors)[0][0] : null)
                    || 'Đã có lỗi xảy ra. Vui lòng thử lại sau!';
                if (this.$toast) this.$toast.error(msg);
            } finally {
                this.isLoading = false;
            }
        },

        initParticles() {
            const canvas = this.$refs.particleCanvas;
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            let particles = [];

            const handleResize = () => {
                canvas.width = canvas.offsetWidth;
                canvas.height = canvas.offsetHeight;
                createParticles();
            };
            this.handleResize = handleResize;
            window.addEventListener('resize', handleResize);
            setTimeout(handleResize, 100);

            class Particle {
                constructor() {
                    this.reset();
                }
                reset() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.size = Math.random() * 2 + 0.5;
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
                    ctx.fillStyle = `rgba(249, 155, 100, ${this.opacity})`;
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fill();
                }
            }

            const createParticles = () => {
                const count = Math.floor((canvas.width * canvas.height) / 12000);
                particles = Array.from({ length: count }, () => new Particle());
            };

            const drawLines = () => {
                for (let i = 0; i < particles.length; i++) {
                    for (let j = i + 1; j < particles.length; j++) {
                        const dx = particles[i].x - particles[j].x;
                        const dy = particles[i].y - particles[j].y;
                        const dist = Math.sqrt(dx * dx + dy * dy);
                        if (dist < 140) {
                            ctx.strokeStyle = `rgba(249, 155, 100, ${0.18 * (1 - dist / 140)})`;
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
                particles.forEach(p => { p.update(); p.draw(); });
                drawLines();
                this.animationId = requestAnimationFrame(animate);
            };
            animate();
        },
    },
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

*,
*::before,
*::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

/* ══ Page ══ */
.admin-login-page {
    display: flex;
    height: 100vh;
    width: 100%;
    overflow: hidden;
    font-family: 'Inter', sans-serif;
    position: relative;
}

/* ══════════════════════════
   LEFT PANEL
══════════════════════════ */
.left-panel {
    width: 50%;
    flex-shrink: 0;
    position: relative;
    overflow: hidden;
    background:
        url('https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=900&q=80&auto=format&fit=crop') center/cover no-repeat;
}

#particle-canvas {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    z-index: 2;
    pointer-events: none;
}

.left-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(145deg,
            rgba(80, 25, 5, 0.88) 0%,
            rgba(40, 15, 3, 0.82) 50%,
            rgba(60, 20, 4, 0.90) 100%);
    z-index: 1;
}

.left-content {
    position: relative;
    z-index: 3;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 56px 52px;
    gap: 28px;
    color: white;
}

/* Secure Badge */
.secure-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 99px;
    padding: 8px 18px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 1px;
    color: #FFD0A8;
    backdrop-filter: blur(6px);
    width: fit-content;
}

.secure-badge i {
    font-size: 16px;
    color: #FFB380;
}

/* Title */
.left-title {
    font-size: 38px;
    font-weight: 900;
    line-height: 1.15;
    letter-spacing: -1px;
    color: white;
}

.left-desc {
    font-size: 15px;
    line-height: 1.7;
    color: rgba(255, 255, 255, 0.65);
    max-width: 340px;
}

/* Stat Cards */
.stat-cards {
    display: flex;
    gap: 16px;
}

.stat-card {
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 16px;
    padding: 20px 28px;
    backdrop-filter: blur(8px);
    min-width: 120px;
}

.stat-value {
    font-size: 28px;
    font-weight: 800;
    color: #FF9F60;
    letter-spacing: -0.5px;
    line-height: 1;
    margin-bottom: 6px;
}

.stat-label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.5px;
    color: rgba(255, 255, 255, 0.5);
}

/* ══════════════════════════
   RIGHT PANEL
══════════════════════════ */
.right-panel {
    flex: 1;
    background: #FBF0EA;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    overflow-y: auto;
}

.form-area {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 60px 72px;
}

.form-title {
    font-size: 30px;
    font-weight: 800;
    color: #1C1C1E;
    letter-spacing: -0.6px;
    margin-bottom: 8px;
}

.form-subtitle {
    font-size: 14px;
    color: #6B7280;
    line-height: 1.6;
    margin-bottom: 36px;
}

/* ── Fields ── */
.field-group {
    margin-bottom: 20px;
}

.field-label {
    display: block;
    font-size: 11px;
    font-weight: 700;
    color: #9CA3AF;
    letter-spacing: 1px;
    margin-bottom: 8px;
}

.input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

.input-wrap input {
    width: 100%;
    background: #FFFFFF;
    border: 1.5px solid #E5D5CC;
    border-radius: 12px;
    padding: 14px 46px 14px 46px;
    font-size: 14px;
    color: #1C1C1E;
    font-family: 'Inter', sans-serif;
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
}

.input-wrap input::placeholder {
    color: #C4A899;
}

.input-wrap input:focus {
    border-color: #C84B11;
    box-shadow: 0 0 0 3px rgba(200, 75, 17, 0.12);
}

.icon-left {
    position: absolute;
    left: 14px;
    color: #C4A899;
    font-size: 18px;
    display: flex;
    align-items: center;
    z-index: 1;
}

.icon-right {
    position: absolute;
    right: 14px;
    color: #C4A899;
    font-size: 18px;
    display: flex;
    align-items: center;
}

.clickable {
    cursor: pointer;
}

.clickable:hover {
    color: #C84B11;
}

/* ── Options Row ── */
.options-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 28px;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: #6B7280;
    cursor: pointer;
    user-select: none;
}

.checkbox-label input[type="checkbox"] {
    width: 16px;
    height: 16px;
    accent-color: #C84B11;
    cursor: pointer;
}

.forgot-link {
    font-size: 13px;
    font-weight: 600;
    color: #C84B11;
    text-decoration: none;
}

.forgot-link:hover {
    text-decoration: underline;
}

/* ── Button ── */
.btn-login {
    width: 100%;
    background: linear-gradient(135deg, #C84B11 0%, #E8621A 100%);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 16px;
    font-size: 16px;
    font-weight: 700;
    font-family: 'Inter', sans-serif;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: transform 0.2s, box-shadow 0.2s, opacity 0.2s;
    letter-spacing: 0.2px;
}

.btn-login:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(200, 75, 17, 0.4);
}

.btn-login:disabled {
    opacity: 0.65;
    cursor: not-allowed;
    transform: none;
}

.btn-loader {
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255, 255, 255, 0.35);
    border-top-color: white;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

/* ── Footer ── */
.right-footer {
    padding: 24px 72px;
    border-top: 1px solid #EDD5C8;
    flex-shrink: 0;
}

.footer-links {
    display: flex;
    gap: 24px;
    margin-bottom: 8px;
}

.footer-links a {
    font-size: 13px;
    color: #9CA3AF;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s;
}

.footer-links a:hover {
    color: #C84B11;
}

.footer-copy {
    font-size: 12px;
    color: #B4A099;
}

/* ── Help FAB ── */
.help-fab {
    position: fixed;
    bottom: 28px;
    right: 28px;
    z-index: 999;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #1C1C1E;
    border: none;
    color: white;
    font-size: 22px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
    transition: background 0.2s, transform 0.2s;
}

.help-fab:hover {
    background: #C84B11;
    transform: scale(1.08);
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

/* ── Responsive ── */
@media (max-width: 960px) {
    .left-panel {
        display: none;
    }

    .form-area {
        padding: 60px 40px;
    }

    .right-footer {
        padding: 20px 40px;
    }
}

@media (max-width: 480px) {
    .form-area {
        padding: 48px 24px;
    }

    .right-footer {
        padding: 20px 24px;
    }

    .form-title {
        font-size: 24px;
    }
}
</style>
