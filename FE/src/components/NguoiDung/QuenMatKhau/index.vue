<template>
    <div class="user-login-wrapper">
        <!-- AI Background Image -->
        <div class="bg-image-layer"></div>
        <div class="bg-overlay"></div>

        <!-- Canvas for Particles -->
        <canvas id="particle-canvas" ref="particleCanvas"></canvas>

        <div class="login-container">
            <div class="glass-card">
                <div class="row g-0">
                    <!-- Left Side: Branding -->
                    <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-center p-5 branding-section">
                        <div class="branding-content">
                            <div class="logo-box mb-4">
                                <div class="logo-icon">
                                    <i class="bx bx-lock-open-alt"></i>
                                </div>
                                <span class="brand-name">AI-Meet</span>
                            </div>
                            <h1 class="main-title">Khôi Phục<br>Truy Cập.</h1>
                            <p class="description">
                                Đừng lo lắng, chúng tôi sẽ giúp bạn lấy lại quyền truy cập vào tài khoản phòng họp thông minh của mình.
                            </p>
                            <div class="feature-list mt-5">
                                <div class="feature-item">
                                    <i class="bx bx-mail-send"></i>
                                    <span>Gửi mã xác thực qua Email</span>
                                </div>
                                <div class="feature-item">
                                    <i class="bx bx-shield-quarter"></i>
                                    <span>Bảo mật 2 lớp an toàn</span>
                                </div>
                                <div class="feature-item">
                                    <i class="bx bx-refresh"></i>
                                    <span>Khôi phục trong 30 giây</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side: Form -->
                    <div class="col-lg-6 form-section">
                        <div class="form-content p-4 p-xl-5">
                            <div v-if="step === 1" class="fade-in">
                                <div class="form-header mb-5">
                                    <h2 class="form-title">Quên Mật Khẩu?</h2>
                                    <p class="form-subtitle">Nhập email của bạn để nhận mã xác nhận khôi phục.</p>
                                </div>

                                <form @submit.prevent="sendResetCode" class="auth-form">
                                    <div class="input-group-custom">
                                        <label>Email Của Bạn</label>
                                        <div class="input-wrapper">
                                            <i class="bx bxs-envelope"></i>
                                            <input 
                                                v-model="email" 
                                                type="email" 
                                                placeholder="example@gmail.com"
                                                required
                                            >
                                        </div>
                                    </div>

                                    <button type="submit" class="btn-submit" :disabled="isLoading">
                                        <span v-if="!isLoading">Gửi Mã Xác Nhận</span>
                                        <span v-else class="loader"></span>
                                        <i v-if="!isLoading" class="bx bx-paper-plane ms-2"></i>
                                    </button>

                                    <div class="text-center mt-4">
                                        <router-link to="/nguoi-dung/dang-nhap" class="back-link">
                                            <i class="bx bx-left-arrow-alt"></i> Quay lại đăng nhập
                                        </router-link>
                                    </div>
                                </form>
                            </div>

                            <div v-if="step === 2" class="fade-in">
                                <div class="form-header mb-5">
                                    <h2 class="form-title">Đặt Lại Mật Khẩu</h2>
                                    <p class="form-subtitle">Mã xác nhận đã được gửi đến <strong>{{ email }}</strong></p>
                                </div>

                                <form @submit.prevent="resetPassword" class="auth-form">
                                    <div class="input-group-custom">
                                        <label>Mã Xác Nhận (OTP)</label>
                                        <div class="input-wrapper">
                                            <i class="bx bx-key"></i>
                                            <input 
                                                v-model="resetData.ma_quen_mat_khau" 
                                                type="text" 
                                                placeholder="Nhập 6 chữ số"
                                                required
                                            >
                                        </div>
                                    </div>

                                    <div class="input-group-custom mt-3">
                                        <label>Mật Khẩu Mới</label>
                                        <div class="input-wrapper">
                                            <i class="bx bxs-lock-alt"></i>
                                            <input 
                                                v-model="resetData.password" 
                                                type="password" 
                                                placeholder="••••••••"
                                                required
                                            >
                                        </div>
                                    </div>

                                    <div class="input-group-custom mt-3">
                                        <label>Xác Nhận Mật Khẩu</label>
                                        <div class="input-wrapper">
                                            <i class="bx bxs-check-shield"></i>
                                            <input 
                                                v-model="resetData.confirm_password" 
                                                type="password" 
                                                placeholder="••••••••"
                                                required
                                            >
                                        </div>
                                    </div>

                                    <button type="submit" class="btn-submit" :disabled="isLoading">
                                        <span v-if="!isLoading">Cập Nhật Mật Khẩu</span>
                                        <span v-else class="loader"></span>
                                        <i v-if="!isLoading" class="bx bx-check-double ms-2"></i>
                                    </button>

                                    <div class="text-center mt-4">
                                        <button @click="step = 1" type="button" class="btn-link-custom">
                                            Thanh đổi email nhận mã?
                                        </button>
                                    </div>
                                </form>
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
    name: 'QuenMatKhau',
    data() {
        return {
            step: 1,
            email: '',
            resetData: {
                ma_quen_mat_khau: '',
                password: '',
                confirm_password: ''
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
    methods: {
        async sendResetCode() {
            this.isLoading = true;
            try {
                const res = await axios.post('http://localhost:8000/api/nguoi-dung/quen-mat-khau', { email: this.email });
                if (res.data.status) {
                    this.$toast.success(res.data.message);
                    this.step = 2;
                }
            } catch (error) {
                this.$toast.error(error.response?.data?.message || "Lỗi khi gửi mã!");
            } finally {
                this.isLoading = false;
            }
        },
        async resetPassword() {
            this.isLoading = true;
            try {
                const payload = {
                    email: this.email,
                    ...this.resetData
                };
                const res = await axios.post('http://localhost:8000/api/nguoi-dung/reset-password', payload);
                if (res.data.status) {
                    this.$toast.success(res.data.message);
                    this.$router.push('/nguoi-dung/dang-nhap');
                }
            } catch (error) {
                this.$toast.error(error.response?.data?.message || "Lỗi khi đặt lại mật khẩu!");
            } finally {
                this.isLoading = false;
            }
        },
        initParticles() {
            const canvas = this.$refs.particleCanvas;
            if(!canvas) return;
            const ctx = canvas.getContext('2d');
            let particles = [];
            
            const handleResize = () => {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            };
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

            for (let i = 0; i < 40; i++) particles.push(new Particle());

            const animate = () => {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                particles.forEach(p => { p.update(); p.draw(); });
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
    background-image: url('https://images.unsplash.com/photo-1639322537228-f710d846310a?auto=format&fit=crop&w=1920&q=80');
    background-size: cover;
    background-position: center;
    filter: blur(8px) brightness(0.3);
    transform: scale(1.1);
    z-index: 0;
}

.bg-overlay {
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at center, rgba(15, 23, 42, 0.4) 0%, rgba(2, 6, 23, 0.9) 100%);
    z-index: 1;
}

#particle-canvas {
    position: absolute;
    inset: 0;
    z-index: 1;
    pointer-events: none;
}

.login-container {
    width: 100%;
    max-width: 1000px;
    z-index: 2;
    animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.glass-card {
    background: rgba(15, 23, 42, 0.8);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 32px;
    overflow: hidden;
    box-shadow: 0 40px 100px rgba(0, 0, 0, 0.5);
}

.branding-section {
    background: linear-gradient(135deg, rgba(30, 41, 59, 0.5) 0%, rgba(15, 23, 42, 0.8) 100%);
    border-right: 1px solid rgba(255, 255, 255, 0.05);
}

.logo-icon {
    background: #f97316;
    color: white;
    width: 44px; height: 44px;
    display: flex; justify-content: center; align-items: center;
    border-radius: 12px; font-size: 24px;
    box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3);
}

.brand-name { color: white; font-size: 24px; font-weight: 700; margin-left: 12px; }

.main-title { color: white; font-size: 44px; font-weight: 800; line-height: 1.1; margin: 24px 0; }

.description { color: #94a3b8; font-size: 16px; line-height: 1.6; max-width: 400px; }

.feature-item { display: flex; align-items: center; gap: 12px; color: #cbd5e1; margin-bottom: 16px; }
.feature-item i { color: #f97316; font-size: 20px; }

.form-title { color: white; font-size: 30px; font-weight: 700; margin-bottom: 8px; }
.form-subtitle { color: #64748b; font-size: 15px; }

.input-group-custom label { display: block; color: #cbd5e1; font-size: 14px; margin-bottom: 8px; }

.input-wrapper { position: relative; display: flex; align-items: center; }
.input-wrapper i { position: absolute; left: 18px; color: #64748b; font-size: 20px; }
.input-wrapper input {
    width: 100%; background: rgba(30, 41, 59, 0.5);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px; padding: 15px 15px 15px 50px;
    color: white; outline: none; transition: 0.3s;
}
.input-wrapper input:focus { border-color: #f97316; background: rgba(30, 41, 59, 0.8); }

.btn-submit {
    width: 100%; margin-top: 30px; padding: 16px;
    background: #f97316; color: white; border: none;
    border-radius: 16px; font-weight: 700; font-size: 16px;
    cursor: pointer; transition: 0.3s;
    display: flex; justify-content: center; align-items: center;
}
.btn-submit:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(249, 115, 22, 0.2); }

.back-link { color: #64748b; text-decoration: none; font-size: 14px; transition: 0.3s; }
.back-link:hover { color: #f97316; }

.btn-link-custom { background: none; border: none; color: #f97316; font-size: 14px; cursor: pointer; }

.fade-in { animation: fadeIn 0.5s ease-out; }
@keyframes fadeIn { from { opacity: 0; transform: scale(0.98); } to { opacity: 1; transform: scale(1); } }

.loader {
    width: 20px; height: 20px; border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%; border-top-color: #fff; animation: spin 1s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }
</style>
