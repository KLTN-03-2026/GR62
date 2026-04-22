<template>
    <div class="auth-page">
        <!-- Header -->
        <header class="auth-header">
            <div class="auth-logo">AI-Meet</div>
            <button class="help-btn"><i class="bx bx-help-circle"></i></button>
        </header>

        <div class="register-layout">
            <!-- Left Panel: Brown branding -->
            <div class="register-left">
                <div class="left-content">
                    <h1 class="left-headline">Kết nối thông minh.<br />Phát triển vượt trội.</h1>
                    <p class="left-desc">Tham gia cộng đồng chuyên gia sử dụng AI để tối ưu hóa mạng lưới quan hệ của bạn.</p>
                </div>
                <div class="left-social-proof">
                    <div class="sp-avatars">
                        <img src="https://i.pravatar.cc/40?img=1" alt="user" />
                        <img src="https://i.pravatar.cc/40?img=5" alt="user" />
                        <img src="https://i.pravatar.cc/40?img=9" alt="user" />
                    </div>
                    <span class="sp-text">Hơn 5,000 chuyên gia đã tham gia</span>
                </div>
            </div>

            <!-- Right Panel: Form -->
            <div class="register-right">
                <div class="form-box">
                    <h2 class="form-title">Tạo tài khoản mới</h2>
                    <p class="form-subtitle">Bắt đầu hành trình kết nối chuyên nghiệp của bạn ngay hôm nay.</p>

                    <form @submit.prevent="register" class="auth-form">
                        <div class="field-group">
                            <label class="field-label">HỌ VÀ TÊN</label>
                            <div class="input-wrap">
                                <input v-model="dang_ky.ho_va_ten" type="text" placeholder="Nguyễn Văn A" />
                            </div>
                        </div>

                        <div class="field-group">
                            <label class="field-label">SỐ ĐIỆN THOẠI</label>
                            <div class="input-wrap">
                                <input v-model="dang_ky.so_dien_thoai" type="text" placeholder="0123 456 789" />
                            </div>
                        </div>

                        <div class="field-group">
                            <label class="field-label">EMAIL</label>
                            <div class="input-wrap">
                                <input v-model="dang_ky.email" type="email" placeholder="email@example.com" />
                            </div>
                        </div>

                        <div class="field-row">
                            <div class="field-group">
                                <label class="field-label">MẬT KHẨU</label>
                                <div class="input-wrap">
                                    <input v-model="dang_ky.password" :type="showPass ? 'text' : 'password'" placeholder="••••••••" />
                                    <span class="input-icon clickable" @click="showPass = !showPass">
                                        <i :class="showPass ? 'bx bx-show' : 'bx bx-hide'"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="field-group">
                                <label class="field-label">XÁC NHẬN MẬT KHẨU</label>
                                <div class="input-wrap">
                                    <input v-model="dang_ky.re_password" :type="showRePass ? 'text' : 'password'" placeholder="••••••••" />
                                    <span class="input-icon clickable" @click="showRePass = !showRePass">
                                        <i :class="showRePass ? 'bx bx-show' : 'bx bx-hide'"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="terms-row">
                            <label class="checkbox-label">
                                <input type="checkbox" id="terms" required checked />
                                <span>Tôi đồng ý với <a href="#" class="orange-link">Điều khoản dịch vụ</a> và <a href="#" class="orange-link">Chính sách bảo mật.</a></span>
                            </label>
                        </div>

                        <button type="submit" class="btn-primary" :disabled="isLoading">
                            <span v-if="!isLoading">Đăng ký ngay <i class="bx bx-right-arrow-alt"></i></span>
                            <span v-else class="btn-loader"></span>
                        </button>
                    </form>

                    <p class="switch-auth">Đã có tài khoản? <router-link to="/dang-nhap">Đăng nhập</router-link></p>
                </div>

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
            showPass: false,
            showRePass: false,
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
                    this.$router.push('/dang-nhap');
                } else {
                    if (this.$toast) {
                        this.$toast.error(res.data.message || 'Gặp sự cố khi đăng ký.');
                    }
                }
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    const errors = error.response.data.errors;
                    Object.values(errors).forEach(errList => {
                        errList.forEach(message => {
                            if (this.$toast) this.$toast.error(message);
                        });
                    });
                } else {
                    const msg = error.response?.data?.message || 'Lỗi hệ thống, vui lòng thử lại sau.';
                    if (this.$toast) this.$toast.error(msg);
                }
            } finally {
                this.isLoading = false;
            }
        }
    }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

* { box-sizing: border-box; margin: 0; padding: 0; }

.auth-page {
    min-height: 100vh;
    background: #FDF0EA;
    font-family: 'Inter', sans-serif;
    display: flex;
    flex-direction: column;
}

/* ── Header ── */
.auth-header {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 100;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 40px;
}
.auth-logo {
    font-size: 20px;
    font-weight: 800;
    color: #C84B11;
}
.help-btn {
    width: 36px; height: 36px;
    border-radius: 50%;
    background: #1a1a1a;
    border: none;
    color: white;
    font-size: 18px;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
}

/* ── Layout ── */
.register-layout {
    display: flex;
    min-height: 100vh;
    padding: 80px 40px 40px;
    gap: 32px;
    align-items: stretch;
    max-width: 1200px;
    margin: 0 auto;
    width: 100%;
}

/* ── Left Panel ── */
.register-left {
    width: 42%;
    background: linear-gradient(160deg, #B84010 0%, #8B3009 100%);
    border-radius: 24px;
    padding: 56px 48px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    color: white;
}
.left-headline {
    font-size: 36px;
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 20px;
    letter-spacing: -0.5px;
}
.left-desc {
    font-size: 15px;
    line-height: 1.7;
    color: rgba(255,255,255,0.75);
    max-width: 280px;
}
.left-social-proof {
    display: flex;
    align-items: center;
    gap: 12px;
}
.sp-avatars { display: flex; }
.sp-avatars img {
    width: 36px; height: 36px;
    border-radius: 50%;
    border: 2px solid #B84010;
    margin-left: -10px;
    object-fit: cover;
}
.sp-avatars img:first-child { margin-left: 0; }
.sp-text { font-size: 13px; color: rgba(255,255,255,0.8); font-weight: 500; }

/* ── Right Panel ── */
.register-right {
    flex: 1;
    background: white;
    border-radius: 24px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    overflow: hidden;
}
.form-box {
    padding: 48px 56px 32px;
}
.form-title {
    font-size: 28px;
    font-weight: 800;
    color: #1a1a1a;
    letter-spacing: -0.5px;
    margin-bottom: 6px;
}
.form-subtitle {
    font-size: 14px;
    color: #6B7280;
    margin-bottom: 28px;
    line-height: 1.6;
}

/* ── Fields ── */
.field-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
.field-group { margin-bottom: 16px; }
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
    background: #FDF6F2;
    border: 1.5px solid #E8D5CC;
    border-radius: 10px;
    padding: 12px 44px 12px 14px;
    font-size: 14px;
    color: #1a1a1a;
    font-family: 'Inter', sans-serif;
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
}
.input-wrap input::placeholder { color: #BBAA9A; }
.input-wrap input:focus {
    border-color: #C84B11;
    box-shadow: 0 0 0 3px rgba(200, 75, 17, 0.1);
    background: #FFFAF8;
}
.input-icon {
    position: absolute;
    right: 14px;
    color: #BBAA9A;
    font-size: 18px;
    display: flex; align-items: center;
}
.input-icon.clickable { cursor: pointer; }
.input-icon.clickable:hover { color: #C84B11; }

/* ── Terms ── */
.terms-row { margin-bottom: 20px; }
.checkbox-label {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    font-size: 13px;
    color: #6B7280;
    cursor: pointer;
    line-height: 1.5;
}
.checkbox-label input[type="checkbox"] {
    width: 16px; height: 16px;
    flex-shrink: 0;
    margin-top: 2px;
    accent-color: #C84B11;
    cursor: pointer;
}
.orange-link { color: #C84B11; font-weight: 600; text-decoration: none; }
.orange-link:hover { text-decoration: underline; }

/* ── Button ── */
.btn-primary {
    width: 100%;
    background: linear-gradient(135deg, #C84B11 0%, #E05F20 100%);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 14px;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: transform 0.2s, box-shadow 0.2s, opacity 0.2s;
    font-family: 'Inter', sans-serif;
}
.btn-primary:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(200, 75, 17, 0.35);
}
.btn-primary:disabled { opacity: 0.7; cursor: not-allowed; }
.btn-loader {
    width: 20px; height: 20px;
    border: 3px solid rgba(255,255,255,0.3);
    border-top-color: white;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

/* ── Switch ── */
.switch-auth {
    text-align: center;
    font-size: 14px;
    color: #6B7280;
    margin-top: 16px;
}
.switch-auth a { color: #C84B11; font-weight: 700; text-decoration: none; }
.switch-auth a:hover { text-decoration: underline; }

/* ── Divider ── */
.divider {
    text-align: center;
    margin: 20px 0 16px;
    position: relative;
}
.divider::before {
    content: '';
    position: absolute;
    top: 50%; left: 0; right: 0;
    height: 1px;
    background: #F0E4DC;
}
.divider span {
    background: white;
    position: relative;
    padding: 0 16px;
    font-size: 11px;
    color: #9CA3AF;
    font-weight: 700;
    letter-spacing: 1px;
}

/* ── Social ── */
.social-row { display: flex; gap: 12px; }
.social-btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 11px;
    background: #FDF6F2;
    border: 1.5px solid #E8D5CC;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    cursor: pointer;
    transition: background 0.2s, border-color 0.2s;
    font-family: 'Inter', sans-serif;
}
.social-btn:hover { background: #FBEde6; border-color: #C84B11; }

/* ── Footer ── */
.auth-footer {
    padding: 16px 56px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid #F0E4DC;
    font-size: 11px;
    color: #9CA3AF;
    letter-spacing: 0.5px;
}
.footer-links { display: flex; gap: 20px; }
.footer-links a { color: #9CA3AF; text-decoration: none; font-size: 11px; font-weight: 600; letter-spacing: 0.5px; }
.footer-links a:hover { color: #C84B11; }

@keyframes spin { to { transform: rotate(360deg); } }

@media (max-width: 900px) {
    .register-layout { flex-direction: column; padding: 80px 20px 20px; }
    .register-left { width: 100%; padding: 36px 32px; min-height: auto; }
    .left-headline { font-size: 26px; }
    .form-box { padding: 32px 24px; }
    .field-row { grid-template-columns: 1fr; }
    .auth-footer { flex-direction: column; gap: 10px; text-align: center; padding: 16px 24px; }
}
</style>
