<template>
    <div class="admin-login-wrapper">
        <!-- AI Background Image -->
        <div class="bg-image-layer"></div>
        <div class="bg-overlay"></div>

        <!-- Canvas for Particles -->
        <canvas id="particle-canvas" ref="particleCanvas"></canvas>

        <!-- Animated Background Elements -->
        <div class="bg-glow bg-glow-1"></div>
        <div class="bg-glow bg-glow-2"></div>
        <div class="bg-glow bg-glow-3"></div>

        <div class="login-container">
            <div class="glass-card">
                <div class="card-header">
                    <div class="logo-wrapper">
                        <div class="logo-inner">
                            <img src="../../../assets/images/logo.pnj.png" alt="AI Meeting" class="img-fluid custom-logo">
                        </div>
                    </div>
                    <h1 class="title">Đăng Nhập ADmin</h1>

                </div>

                <form @submit.prevent="login()" class="login-form">
                    <div class="input-group-custom">
                        <label for="email">Email </label>
                        <div class="input-wrapper">
                            <i class="bx bxs-envelope"></i>
                            <input id="email" v-model="admin.email" type="email" placeholder="name@company.com"
                                required>
                        </div>
                    </div>

                    <div class="input-group-custom mt-4">
                        <label for="password">Mật Khẩu</label>
                        <div class="input-wrapper">
                            <i class="bx bxs-lock-alt"></i>
                            <input id="password" v-model="admin.password" type="password" placeholder="••••••••"
                                required>
                        </div>
                    </div>

                    <button type="submit" class="btn-login" :disabled="isLoading">
                        <span v-if="!isLoading">Đăng Nhập Ngay</span>
                        <span v-else class="loader"></span>
                    </button>
                </form>


            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: 'DangNhapAdmin',
    data() {
        return {
            admin: {
                email: '',
                password: '',
            },
            isLoading: false,
            animationId: null
        }
    },
    mounted() {
        this.initParticles();
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
                const res = await axios.post('http://127.0.0.1:8000/api/admin/login', this.admin);
                if (res.data.status) {
                    localStorage.setItem('token_admin', res.data.data.token);
                    if (this.$toast) {
                        this.$toast.success('Đăng nhập Admin thành công!');
                    }
                    this.$router.push('/admin/phong-hop');
                } else {
                    if (this.$toast) {
                        this.$toast.error(res.data.message || 'Email hoặc mật khẩu không chính xác!');
                    }
                }
            } catch (errors) {
                const msg = errors.response?.data?.message
                    || (errors.response?.data?.errors
                        ? Object.values(errors.response.data.errors)[0][0]
                        : null)
                    || 'Đã có lỗi xảy ra. Vui lòng thử lại sau!';
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
                    this.speedX = (Math.random() - 0.5) * 0.8;
                    this.speedY = (Math.random() - 0.5) * 0.8;
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
                const count = (canvas.width * canvas.height) / 15000;
                particles = [];
                for (let i = 0; i < count; i++) {
                    particles.push(new Particle());
                }
            };
            createParticles();

            const drawLines = () => {
                for (let i = 0; i < particles.length; i++) {
                    for (let j = i; j < particles.length; j++) {
                        const dx = particles[i].x - particles[j].x;
                        const dy = particles[i].y - particles[j].y;
                        const distance = Math.sqrt(dx * dx + dy * dy);

                        if (distance < 150) {
                            ctx.strokeStyle = `rgba(234, 88, 12, ${0.15 * (1 - distance / 150)})`;
                            ctx.lineWidth = 1;
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
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap');

.admin-login-wrapper {
    min-height: 100vh;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #020617;
    font-family: 'Outfit', sans-serif;
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
    filter: blur(8px) brightness(0.4) saturate(1.2);
    transform: scale(1.05);
    z-index: 0;
}

.bg-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        135deg,
        rgba(2, 6, 40, 0.75) 0%,
        rgba(15, 23, 42, 0.6) 50%,
        rgba(2, 6, 40, 0.8) 100%
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

/* Background Glow Effects */
.bg-glow {
    position: absolute;
    border-radius: 50%;
    filter: blur(100px);
    z-index: 0;
    /* Behind canvas */
    opacity: 0.3;
    animation: pulse 12s infinite alternate;
}

.bg-glow-1 {
    width: 500px;
    height: 500px;
    background: #1e1b4b;
    top: -150px;
    right: -100px;
}

.bg-glow-2 {
    width: 450px;
    height: 450px;
    background: #431407;
    bottom: -100px;
    left: -150px;
}

.bg-glow-3 {
    width: 400px;
    height: 400px;
    background: #0f172a;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

@keyframes pulse {
    0% {
        transform: translate(0, 0) scale(1);
    }

    100% {
        transform: translate(30px, 30px) scale(1.1);
    }
}

.login-container {
    width: 100%;
    max-width: 460px;
    z-index: 2;
    animation: fadeIn 0.8s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.glass-card {
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 28px;
    padding: 56px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
}

.card-header {
    text-align: center;
    margin-bottom: 48px;
}

.logo-wrapper {
    position: relative;
    width: 80px;
    height: 80px;
    margin: 0 auto 28px;
}

.logo-inner {
    width: 100%;
    height: 100%;
    background: #ffffff; /* Sửa màu nền thành trắng để hoà quyện logo */
    border-radius: 22px;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 12px 24px rgba(255, 255, 255, 0.15);
    position: relative;
    z-index: 2;
    overflow: hidden; /* Cắt góc viền xung quanh */
}

/* Thêm styling riêng cho hình logo */
.custom-logo {
    width: 100%;
    height: 100%;
    object-fit: contain; /* Có thể đổi thành cover tuỳ ý */
    border-radius: 22px;
}

.logo-inner i {
    font-size: 36px;
    color: white;
}

.logo-pulse {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #ea580c;
    border-radius: 22px;
    z-index: 1;
    animation: logoPulse 2.5s infinite;
}

@keyframes logoPulse {
    0% {
        transform: scale(1);
        opacity: 0.5;
    }

    100% {
        transform: scale(1.6);
        opacity: 0;
    }
}

.title {
    color: #f8fafc;
    font-size: 30px;
    font-weight: 700;
    letter-spacing: -0.5px;
    margin-bottom: 10px;
}

.subtitle {
    color: #94a3b8;
    font-size: 15px;
    line-height: 1.5;
}

.input-group-custom {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.input-group-custom label {
    color: #cbd5e1;
    font-size: 13px;
    font-weight: 500;
    margin-left: 4px;
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
    transition: color 0.3s;
}

.input-wrapper input {
    width: 100%;
    background: rgba(30, 41, 59, 0.4);
    border: 1px solid rgba(71, 85, 105, 0.3);
    border-radius: 16px;
    padding: 16px 18px 16px 52px;
    color: white;
    font-size: 15px;
    transition: all 0.3s;
    outline: none;
}

.input-wrapper input:focus {
    background: rgba(30, 41, 59, 0.7);
    border-color: #ea580c;
    box-shadow: 0 0 0 4px rgba(234, 88, 12, 0.12);
}

.input-wrapper input:focus+i {
    color: #ea580c;
}

.btn-login {
    width: 100%;
    margin-top: 40px;
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    color: white;
    border: none;
    border-radius: 16px;
    padding: 18px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 12px 20px -5px rgba(234, 88, 12, 0.4);
}

.btn-login:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 20px 30px -8px rgba(234, 88, 12, 0.5);
}

.btn-login:active {
    transform: translateY(0) scale(0.98);
}

.btn-login:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

.card-footer {
    margin-top: 40px;
    text-align: center;
}

.back-link {
    color: #64748b;
    text-decoration: none;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s;
    padding: 8px 16px;
    border-radius: 12px;
}

.back-link:hover {
    color: #f8fafc;
    background: rgba(255, 255, 255, 0.05);
}

.loader {
    width: 22px;
    height: 22px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: #fff;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

@media (max-width: 480px) {
    .glass-card {
        padding: 40px 24px;
    }

    .title {
        font-size: 26px;
    }
}
</style>
