<template>
    <div class="auth-page">
        <!-- Header -->
        <header class="auth-header">
            <div class="auth-logo">AI-Meet</div>
            <button class="help-btn"><i class="bx bx-help-circle"></i></button>
        </header>

        <!-- Background blobs -->
        <div class="bg-blob blob-1"></div>
        <div class="bg-blob blob-2"></div>

        <main class="page-body">
            <!-- ── STEP 1: Enter Email ── -->
            <div v-if="step === 1" class="card step-fade">
                <div class="card-icon-wrap">
                    <div class="card-icon">
                        <i class="bx bx-key"></i>
                    </div>
                </div>
                <h2 class="card-title">Quên mật khẩu?</h2>
                <p class="card-desc">Đừng lo lắng, chuyện này thường xuyên xảy ra. Nhập email của bạn và chúng tôi sẽ
                    gửi liên kết khôi phục.</p>

                <form @submit.prevent="sendResetCode">
                    <div class="field-group">
                        <label class="field-label">Địa chỉ Email</label>
                        <div class="input-wrap">
                            <span class="input-icon-left"><i class="bx bx-envelope"></i></span>
                            <input v-model="email" type="email" placeholder="name@company.com" required />
                        </div>
                    </div>

                    <button type="submit" class="btn-primary" :disabled="isLoading">
                        <span v-if="!isLoading">Gửi mã xác minh <i class="bx bx-right-arrow-alt"></i></span>
                        <span v-else class="btn-loader"></span>
                    </button>
                </form>

                <router-link to="/dang-nhap" class="back-link">
                    <i class="bx bx-left-arrow-alt"></i> Quay lại trang Đăng nhập
                </router-link>
            </div>

            <!-- ── STEP 2: Enter OTP + New Password ── -->
            <div v-if="step === 2" class="card step-fade">
                <h2 class="card-title">Đặt lại mật khẩu</h2>
                <p class="card-desc">Vui lòng nhập mã OTP đã gửi tới <strong>{{ email }}</strong> và đặt mật khẩu mới
                    cho tài khoản AI-Meet.</p>

                <form @submit.prevent="resetPassword">
                    <div class="field-group">
                        <label class="field-label">MÃ OTP (6 CHỮ SỐ)</label>
                        <div class="input-wrap">
                            <span class="input-icon-left"><i class="bx bx-hash"></i></span>
                            <input v-model="resetData.ma_quen_mat_khau" type="text" placeholder="######" required
                                maxlength="6" />
                        </div>
                    </div>

                    <div class="field-group">
                        <label class="field-label">MẬT KHẨU MỚI</label>
                        <div class="input-wrap">
                            <span class="input-icon-left"><i class="bx bx-lock-alt"></i></span>
                            <input v-model="resetData.password" :type="showPass ? 'text' : 'password'"
                                placeholder="••••••••" required />
                            <span class="input-icon-right clickable" @click="showPass = !showPass">
                                <i :class="showPass ? 'bx bx-show' : 'bx bx-hide'"></i>
                            </span>
                        </div>
                        <span class="field-hint"><i class="bx bx-info-circle"></i> Mật khẩu cần ít nhất 8 ký tự.</span>
                    </div>

                    <div class="field-group">
                        <label class="field-label">XÁC NHẬN MẬT KHẨU</label>
                        <div class="input-wrap">
                            <span class="input-icon-left"><i class="bx bx-shield-check"></i></span>
                            <input v-model="resetData.confirm_password" :type="showConfirm ? 'text' : 'password'"
                                placeholder="••••••••" required />
                            <span class="input-icon-right clickable" @click="showConfirm = !showConfirm">
                                <i :class="showConfirm ? 'bx bx-show' : 'bx bx-hide'"></i>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary" :disabled="isLoading">
                        <span v-if="!isLoading">Cập nhật mật khẩu</span>
                        <span v-else class="btn-loader"></span>
                    </button>
                </form>

                <button @click="step = 1" class="back-link" type="button"
                    style="background:none;border:none;cursor:pointer;">
                    <i class="bx bx-left-arrow-alt"></i> Quay lại trang đăng nhập
                </button>
            </div>
        </main>

        <!-- Footer -->
        <footer class="auth-footer">
            <span>© 2024 AI-MEET. PROFESSIONAL NETWORKING EXCELLENCE.</span>
            <div class="footer-links">
                <a href="#">ĐIỀU KHOẢN</a>
                <a href="#">BẢO MẬT</a>
                <a href="#">HỖ TRỢ</a>
            </div>
        </footer>
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
            showPass: false,
            showConfirm: false,
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
                    this.$router.push('/dang-nhap');
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
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

.auth-page {
    min-height: 100vh;
    background: #FDF0EA;
    font-family: 'Inter', sans-serif;
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
}

/* ── Background Blobs ── */
.bg-blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    pointer-events: none;
    z-index: 0;
}

.blob-1 {
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(200, 75, 17, 0.18) 0%, transparent 70%);
    top: -100px;
    left: -100px;
}

.blob-2 {
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(200, 75, 17, 0.1) 0%, transparent 70%);
    bottom: 0;
    right: 0;
}

/* ── Header ── */
.auth-header {
    position: relative;
    z-index: 10;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 40px;
}

.auth-logo {
    font-size: 20px;
    font-weight: 800;
    color: #C84B11;
}

.help-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #1a1a1a;
    border: none;
    color: white;
    font-size: 18px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* ── Page Body ── */
.page-body {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px 20px 40px;
    position: relative;
    z-index: 1;
}

/* ── Card ── */
.card {
    background: white;
    border-radius: 24px;
    padding: 48px 52px;
    width: 100%;
    max-width: 500px;
    box-shadow: 0 20px 60px rgba(200, 75, 17, 0.1), 0 4px 20px rgba(0, 0, 0, 0.06);
}

.card-icon-wrap {
    display: flex;
    justify-content: center;
    margin-bottom: 24px;
}

.card-icon {
    width: 64px;
    height: 64px;
    background: #FDF0EA;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: #C84B11;
    border: 2px solid rgba(200, 75, 17, 0.15);
}

.card-title {
    font-size: 28px;
    font-weight: 800;
    color: #1a1a1a;
    text-align: center;
    letter-spacing: -0.5px;
    margin-bottom: 12px;
}

.card-desc {
    font-size: 14px;
    color: #6B7280;
    text-align: center;
    line-height: 1.7;
    margin-bottom: 32px;
}

/* ── Fields ── */
.field-group {
    margin-bottom: 18px;
}

.field-label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: #374151;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.field-hint {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    color: #9CA3AF;
    margin-top: 6px;
}

.input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

.input-wrap input {
    width: 100%;
    background: #FDF6F2;
    border: 1.5px solid #E8D5CC;
    border-radius: 12px;
    padding: 14px 44px 14px 44px;
    font-size: 14px;
    color: #1a1a1a;
    font-family: 'Inter', sans-serif;
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
}

.input-wrap input::placeholder {
    color: #BBAA9A;
}

.input-wrap input:focus {
    border-color: #C84B11;
    box-shadow: 0 0 0 3px rgba(200, 75, 17, 0.1);
    background: #FFFAF8;
}

.input-icon-left {
    position: absolute;
    left: 14px;
    color: #BBAA9A;
    font-size: 18px;
    display: flex;
    align-items: center;
    z-index: 1;
}

.input-icon-right {
    position: absolute;
    right: 14px;
    color: #BBAA9A;
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

/* ── Button ── */
.btn-primary {
    width: 100%;
    background: linear-gradient(135deg, #C84B11 0%, #E05F20 100%);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 15px;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: transform 0.2s, box-shadow 0.2s, opacity 0.2s;
    font-family: 'Inter', sans-serif;
    margin-top: 8px;
    margin-bottom: 20px;
}

.btn-primary:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(200, 75, 17, 0.35);
}

.btn-primary:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.btn-loader {
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-top-color: white;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

/* ── Back Link ── */
.back-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    color: #9CA3AF;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    font-family: 'Inter', sans-serif;
    transition: color 0.2s;
}

.back-link:hover {
    color: #C84B11;
}

/* ── Step animation ── */
.step-fade {
    animation: fadeUp 0.4s ease-out;
}

@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(16px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ── Footer ── */
.auth-footer {
    position: relative;
    z-index: 1;
    padding: 18px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 11px;
    color: #9CA3AF;
    letter-spacing: 0.5px;
}

.footer-links {
    display: flex;
    gap: 20px;
}

.footer-links a {
    color: #9CA3AF;
    text-decoration: none;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.footer-links a:hover {
    color: #C84B11;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

@media (max-width: 600px) {
    .card {
        padding: 36px 24px;
    }

    .auth-footer {
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }
}
</style>
