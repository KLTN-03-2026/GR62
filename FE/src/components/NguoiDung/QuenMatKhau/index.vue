<template>
    <div class="user-recovery-wrapper">
        <!-- Background Elements -->
        <div class="sky-container">
            <div class="star-field"></div>
            <div class="grid-overlay"></div>
            <div class="aurora aurora-recovery"></div>
        </div>

        <div class="recovery-content-container">
            <div class="main-glass-card shadow-lg">
                <div class="row g-0 h-100">
                    <!-- Left: Interactive Branding -->
                    <div
                        class="col-lg-5 d-none d-lg-flex flex-column justify-content-center p-5 branding-panel text-white">
                        <div class="branding-content-wrapper d-flex flex-column align-items-center gap-5">
                            <div class="brand-top d-flex flex-column align-items-center">
                                <div class="logo-morph">
                                    <div class="nebula"></div>
                                    <i class="bx bx-key"></i>
                                </div>
                                <h2 class="brand-text">AI-Meet</h2>
                            </div>

                            <div class="brand-center">
                                <h1 class="hero-title">Khôi phục<br><span class="text-gradient">Quyền truy cập</span></h1>
                                <p class="mt-3 opacity-75">Hệ thống bảo mật sinh trắc học và OTP đa tầng bảo vệ bạn.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Aesthetic Recovery Form -->
                    <div class="col-lg-7 form-panel">
                        <div class="form-body p-4 p-xl-5">
                            <!-- Step 1: Send Code -->
                            <div v-if="step === 1" class="step-fade">
                                <div class="form-header mb-5">
                                    <h3 class="welcome-text">Quên mật khẩu?</h3>
                                    <p class="sub-text">Đừng lo, hãy nhập email để nhận mã xác minh OTP.</p>
                                </div>

                                <form @submit.prevent="sendResetCode" class="neon-form">
                                    <div class="creative-input mb-4">
                                        <label>EMAIL KHÔI PHỤC</label>
                                        <div class="input-glow-wrapper">
                                            <i class="bx bx-envelope"></i>
                                            <input 
                                                v-model="email" 
                                                type="email" 
                                                placeholder="your-email@aimet.com"
                                                required
                                            >
                                        </div>
                                    </div>

                                    <button type="submit" class="cyber-button mt-4" :disabled="isLoading">
                                        <div class="btn-inner">
                                            <span v-if="!isLoading">Gửi Mã Xác Minh</span>
                                            <span v-else class="loader"></span>
                                            <i v-if="!isLoading" class="bx bx-paper-plane"></i>
                                        </div>
                                        <div class="btn-glow"></div>
                                    </button>
                                </form>
                            </div>

                            <!-- Step 2: Reset Password -->
                            <div v-if="step === 2" class="step-fade">
                                <div class="form-header mb-4">
                                    <h3 class="welcome-text">Đặt lại mật khẩu</h3>
                                    <p class="sub-text">Mã xác minh đã gửi tới: <b class="text-white">{{ email }}</b></p>
                                </div>

                                <form @submit.prevent="resetPassword" class="neon-form">
                                    <div class="creative-input mb-3">
                                        <label>MÃ OTP (6 CHỮ SỐ)</label>
                                        <div class="input-glow-wrapper">
                                            <i class="bx bx-hash"></i>
                                            <input v-model="resetData.ma_quen_mat_khau" type="text" placeholder="######" required maxlength="6">
                                        </div>
                                    </div>

                                    <div class="creative-input mb-3">
                                        <label>MẬT KHẨU MỚI</label>
                                        <div class="input-glow-wrapper">
                                            <i class="bx bx-lock-alt"></i>
                                            <input v-model="resetData.password" type="password" placeholder="••••••••" required>
                                        </div>
                                    </div>

                                    <div class="creative-input mb-4">
                                        <label>XÁC NHẬN MẬT KHẨU</label>
                                        <div class="input-glow-wrapper">
                                            <i class="bx bx-shield-check"></i>
                                            <input v-model="resetData.confirm_password" type="password" placeholder="••••••••" required>
                                        </div>
                                    </div>

                                    <button type="submit" class="cyber-button" :disabled="isLoading">
                                        <div class="btn-inner">
                                            <span v-if="!isLoading">Cập Nhật Mật Khẩu</span>
                                            <span v-else class="loader"></span>
                                            <i v-if="!isLoading" class="bx bx-check-double"></i>
                                        </div>
                                        <div class="btn-glow"></div>
                                    </button>

                                    <div class="text-center mt-3">
                                        <button @click="step = 1" type="button" class="btn-link-action">Thay đổi email?</button>
                                    </div>
                                </form>
                            </div>

                            <div class="mt-5 text-center switch-auth">
                                <router-link to="/nguoi-dung/dang-nhap" class="back-link">
                                    <i class="bx bx-left-arrow-alt"></i> Quay lại Đăng nhập
                                </router-link>
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
        }
    },
    methods: {
        async sendResetCode() {
            this.isLoading = true;
            try {
                const res = await axios.post(`${apiUrl}/nguoi-dung/quen-mat-khau`, { email: this.email });
                if (res.data.status) {
                    if (this.$toast) this.$toast.success(res.data.message);
                    this.step = 2;
                } else {
                    if (this.$toast) this.$toast.error(res.data.message);
                }
            } catch (error) {
                if (this.$toast) this.$toast.error(error.response?.data?.message || "Lỗi hệ thống khi gửi mã!");
            } finally {
                this.isLoading = false;
            }
        },
        async resetPassword() {
            if (this.resetData.password !== this.resetData.confirm_password) {
                if (this.$toast) this.$toast.error('Mật khẩu không trùng khớp!');
                return;
            }
            this.isLoading = true;
            try {
                const payload = { email: this.email, ...this.resetData };
                const res = await axios.post(`${apiUrl}/nguoi-dung/reset-password`, payload);
                if (res.data.status) {
                    if (this.$toast) this.$toast.success(res.data.message);
                    this.$router.push('/nguoi-dung/dang-nhap');
                } else {
                   if (this.$toast) this.$toast.error(res.data.message);
                }
            } catch (error) {
                if (this.$toast) this.$toast.error(error.response?.data?.message || "Lỗi khi đặt lại mật khẩu!");
            } finally {
                this.isLoading = false;
            }
        }
    }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@300;400;500;600;700&display=swap');

.user-recovery-wrapper {
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
        radial-gradient(1.5px 1.5px at 150px 50px, #fff, rgba(0,0,0,0)),
        radial-gradient(1px 1px at 300px 200px, #fff, rgba(0,0,0,0));
    background-size: 400px 400px;
    opacity: 0.2;
}

.grid-overlay {
    position: absolute;
    inset: 0;
    background-image: 
        linear-gradient(rgba(126, 34, 206, 0.05) 1.5px, transparent 1.5px),
        linear-gradient(90deg, rgba(126, 34, 206, 0.05) 1.5px, transparent 1.5px);
    background-size: 60px 60px;
    perspective: 1000px;
    transform: perspective(600px) rotateX(45deg) scale(2);
    transform-origin: center bottom;
}

.aurora-recovery {
    position: absolute;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, #7e22ce 0%, transparent 60%);
    top: -10%;
    left: 20%;
    filter: blur(100px);
    opacity: 0.25;
}

.recovery-content-container {
    width: 100%;
    max-width: 1100px;
    z-index: 10;
    animation: scale-up 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes scale-up {
    from { opacity: 0; scale: 0.95; }
    to { opacity: 1; scale: 1; }
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
    background: linear-gradient(135deg, rgba(126, 34, 206, 0.1) 0%, rgba(37, 99, 235, 0.1) 100%);
    border-right: 1px solid rgba(255, 255, 255, 0.05);
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.logo-morph {
    width: 50px; height: 50px; background: #7e22ce;
    border-radius: 14px; display: flex; justify-content: center; align-items: center;
    font-size: 28px; position: relative; overflow: hidden;
}

.logo-morph .nebula {
    position: absolute; width: 140%; height: 140%;
    background: radial-gradient(circle, #2563eb 0%, transparent 50%);
    animation: nebula-rotate 3.5s linear infinite;
}

@keyframes nebula-rotate { to { transform: rotate(360deg); } }

.brand-text { margin-top: 10px; font-weight: 800; font-size: 22px; color: white; }
.hero-title { font-size: 42px; font-weight: 800; line-height: 1.1; font-family: 'Space Grotesk', sans-serif; }

.text-gradient {
    background: linear-gradient(90deg, #c084fc, #60a5fa, #c084fc);
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: text-pulse 4s linear infinite;
}

@keyframes text-pulse { to { background-position: 200% center; } }

/* Form Panel */
.form-panel { background: rgba(5, 8, 16, 0.4); }

.welcome-text { color: white; font-size: 32px; font-weight: 800; }
.sub-text { color: #64748b; }

.creative-input label {
    display: block; color: #475569; font-size: 11px; font-weight: 700;
    letter-spacing: 1.2px; margin-bottom: 8px;
}

.input-glow-wrapper { position: relative; display: flex; align-items: center; }
.input-glow-wrapper i { position: absolute; left: 16px; color: #334155; font-size: 18px; }

.input-glow-wrapper input {
    width: 100%; background: rgba(255, 255, 255, 0.02);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 16px; padding: 14px 20px 14px 48px; color: white; transition: 0.3s;
}

.input-glow-wrapper input::placeholder {
    color: rgba(255, 255, 255, 0.7) !important;
}

.input-glow-wrapper input:focus {
    background: rgba(255, 255, 255, 0.05); border-color: #7e22ce;
    box-shadow: 0 0 20px rgba(126, 34, 206, 0.15); outline: none;
}

.input-glow-wrapper input:focus + i { color: #7e22ce; }

/* Cyber Button */
.cyber-button {
    width: 100%; background: #7e22ce; border: none; border-radius: 16px;
    position: relative; cursor: pointer; overflow: hidden; transition: 0.3s;
}

.btn-inner { padding: 16px; display: flex; justify-content: center; align-items: center; gap: 10px; color: white; font-weight: 700; position: relative; z-index: 2; }
.btn-glow { position: absolute; inset: 0; background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent); transform: translateX(-100%); transition: 0.5s; }

.cyber-button:hover { transform: translateY(-2px); box-shadow: 0 15px 30px rgba(126, 34, 206, 0.3); }
.cyber-button:hover .btn-glow { transform: translateX(100%); }

.btn-link-action { background: none; border: none; color: #7e22ce; font-weight: 600; font-size: 13px; cursor: pointer; }
.btn-link-action:hover { text-decoration: underline; }

.back-link { color: #64748b; text-decoration: none; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 5px; }
.back-link:hover { color: #7e22ce; }

.step-fade { animation: fade-in 0.5s ease-out; }
@keyframes fade-in { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

.loader { width: 20px; height: 20px; border: 3px solid rgba(255, 255, 255, 0.3); border-radius: 50%; border-top-color: white; animation: spin 0.8s linear infinite; }
@keyframes spin { to { transform: rotate(360deg); } }
</style>
