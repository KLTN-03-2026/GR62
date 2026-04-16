<template>
    <div class="auth-page">

        <!-- Header -->
        <header class="auth-header">
            <div class="auth-logo">AI-Meet</div>
            <button class="help-btn" title="Trợ giúp"><i class="bx bx-help-circle"></i></button>
        </header>

        <!-- Content -->
        <div class="login-layout">

            <!-- LEFT: Branding Panel -->
            <div class="login-left">
                <div class="left-content">
                    <div class="left-top">
                        <h1 class="left-headline">AI-Meet</h1>
                        <p class="left-tagline">Kết nối trí tuệ, Nâng tầm sự nghiệp.</p>
                    </div>

                    <div class="ai-card">
                        <img
                            src="https://images.unsplash.com/photo-1677442135703-1787eea5ce01?w=600&q=80&auto=format&fit=crop"
                            alt="AI Technology"
                            class="ai-img"
                        />
                        <div class="ai-card-overlay">
                            <span class="ai-label">TRẢI NGHIỆM TƯƠNG LAI</span>
                            <p class="ai-desc">Nền tảng kết nối chuyên gia tối ưu hóa bởi AI.</p>
                        </div>
                    </div>

                    <div class="feature-pills">
                        <span class="pill"><i class="bx bx-git-merge"></i> Matching thông minh</span>
                        <span class="pill"><i class="bx bx-shield-check"></i> Bảo mật cao</span>
                        <span class="pill"><i class="bx bx-calendar-check"></i> Lịch trình tự động</span>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Form Panel -->
            <div class="login-right">
                <div class="form-area">
                    <h2 class="form-title">Chào mừng trở lại</h2>
                    <p class="form-subtitle">Vui lòng nhập thông tin để truy cập tài khoản AI-Meet của bạn.</p>

                    <form @submit.prevent="login" class="auth-form">
                        <!-- Email -->
                        <div class="field-group">
                            <label class="field-label">Địa chỉ Email</label>
                            <div class="input-wrap">
                                <input v-model="nguoi_dung.email" type="email" placeholder="name@company.com" required />
                                <span class="icon-right"><i class="bx bx-envelope"></i></span>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="field-group">
                            <div class="label-row">
                                <label class="field-label">Mật khẩu</label>
                                <router-link to="/nguoi-dung/quen-mat-khau" class="forgot-link">Quên mật khẩu?</router-link>
                            </div>
                            <div class="input-wrap">
                                <input
                                    v-model="nguoi_dung.password"
                                    :type="showPass ? 'text' : 'password'"
                                    placeholder="••••••••"
                                    required
                                />
                                <span class="icon-right clickable" @click="showPass = !showPass">
                                    <i :class="showPass ? 'bx bx-show' : 'bx bx-hide'"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Remember -->
                        <div class="remember-row">
                            <label class="checkbox-label">
                                <input type="checkbox" v-model="rememberMe" />
                                <span>Ghi nhớ đăng nhập</span>
                            </label>
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="btn-primary" :disabled="isLoading">
                            <template v-if="!isLoading">Đăng nhập <i class="bx bx-right-arrow-alt"></i></template>
                            <span v-else class="btn-loader"></span>
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="divider"><span>Hoặc đăng nhập với</span></div>

                    <!-- Social -->
                    <div class="social-row">
                        <button class="social-btn">
                            <img src="https://www.google.com/favicon.ico" width="18" alt="Google" />
                            Google
                        </button>
                        <button class="social-btn">
                            <img src="https://static.licdn.com/sc/h/al2o9zrvru7aqj8e1x2rzsrca" width="18" alt="LinkedIn" />
                            LinkedIn
                        </button>
                    </div>

                    <!-- Switch -->
                    <p class="switch-auth">
                        Chưa có tài khoản? <router-link to="/nguoi-dung/dang-ky">Đăng ký ngay</router-link>
                    </p>
                </div>
            </div>

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
</template>

<script>
const apiUrl = import.meta.env.VITE_API_URL;
import axios from 'axios';
export default {
    name: 'DangNhapNguoiDung',
    data() {
        return {
            nguoi_dung: { email: '', password: '' },
            isLoading: false,
            showPass: false,
            rememberMe: false,
        };
    },
    methods: {
        async login() {
            this.isLoading = true;
            try {
                const res = await axios.post(`${apiUrl}/nguoi-dung/login`, this.nguoi_dung);
                if (res.data.status) {
                    localStorage.setItem('token_nguoi_dung', res.data.data.token);
                    localStorage.setItem('thong_tin_user', JSON.stringify(res.data.data.user));
                    if (this.$toast) this.$toast.success('Đăng nhập thành công! Chào mừng bạn quay trở lại.');
                    if (res.data.data.user.id_doi_tac) {
                        localStorage.setItem('token_doi_tac', res.data.data.token);
                        this.$router.push('/doi-tac/trang-chinh');
                    } else {
                        this.$router.push('/nguoi-dung/trang-chinh');
                    }
                } else {
                    if (this.$toast) this.$toast.error(res.data.message || 'Email hoặc mật khẩu không chính xác.');
                }
            } catch (errors) {
                const msg = errors.response?.data?.message
                    || (errors.response?.data?.errors ? Object.values(errors.response.data.errors)[0] : null)
                    || 'Hệ thống gián đoạn. Vui lòng thử lại sau.';
                if (this.$toast) this.$toast.error(msg);
            } finally {
                this.isLoading = false;
            }
        },
    },
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

/* ══ Page ══ */
.auth-page {
    min-height: 100vh;
    background: #FDF0EA;
    font-family: 'Inter', sans-serif;
    display: flex;
    flex-direction: column;
}

/* ══ Header ══ */
.auth-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 40px;
    flex-shrink: 0;
}
.auth-logo {
    font-size: 20px;
    font-weight: 800;
    color: #C84B11;
    letter-spacing: -0.5px;
}
.help-btn {
    width: 36px; height: 36px;
    border-radius: 50%;
    background: #1C1C1E;
    border: none;
    color: white;
    font-size: 20px;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.2s;
}
.help-btn:hover { background: #C84B11; }

/* ══ Layout ══ */
.login-layout {
    flex: 1;
    display: flex;
    gap: 28px;
    padding: 0 40px 32px;
    max-width: 1200px;
    width: 100%;
    margin: 0 auto;
    align-items: stretch;
}

/* ══ LEFT PANEL ══ */
.login-left {
    width: 44%;
    flex-shrink: 0;
    background: linear-gradient(150deg, #F5E0D3 0%, #EDD0BC 100%);
    border-radius: 24px;
    display: flex;
    flex-direction: column;
}
.left-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 44px 44px 40px;
    gap: 28px;
}
.left-headline {
    font-size: 30px;
    font-weight: 900;
    color: #C84B11;
    letter-spacing: -1px;
}
.left-tagline {
    font-size: 15px;
    color: #8B4A2E;
    font-weight: 500;
    margin-top: 6px;
}

/* AI Card */
.ai-card {
    border-radius: 16px;
    overflow: hidden;
    position: relative;
    box-shadow: 0 12px 36px rgba(0,0,0,0.14);
    flex-shrink: 0;
}
.ai-img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    display: block;
}
.ai-card-overlay {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    padding: 18px 20px;
    background: linear-gradient(0deg, rgba(0,0,0,0.72) 0%, transparent 100%);
    color: white;
}
.ai-label {
    display: block;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.8px;
    color: #FFB38A;
    margin-bottom: 4px;
}
.ai-desc {
    font-size: 14px;
    font-weight: 600;
    line-height: 1.4;
}

/* Pills */
.feature-pills {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}
.pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(200, 75, 17, 0.1);
    color: #A83A08;
    font-size: 13px;
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 99px;
    border: 1.5px solid rgba(200, 75, 17, 0.2);
}

/* ══ RIGHT PANEL ══ */
.login-right {
    flex: 1;
    background: white;
    border-radius: 24px;
    display: flex;
    flex-direction: column;
}
.form-area {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 48px 52px;
}

.form-title {
    font-size: 28px;
    font-weight: 800;
    color: #1C1C1E;
    letter-spacing: -0.6px;
    margin-bottom: 8px;
}
.form-subtitle {
    font-size: 14px;
    color: #6B7280;
    line-height: 1.6;
    margin-bottom: 30px;
}

/* Fields */
.field-group { margin-bottom: 18px; }
.field-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}
.label-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}
.forgot-link {
    font-size: 13px;
    font-weight: 600;
    color: #C84B11;
    text-decoration: none;
}
.forgot-link:hover { text-decoration: underline; }

.input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}
.input-wrap input {
    width: 100%;
    background: #FBF3EF;
    border: 1.5px solid #E8D5CC;
    border-radius: 11px;
    padding: 13px 46px 13px 16px;
    font-size: 14px;
    color: #1C1C1E;
    font-family: 'Inter', sans-serif;
    transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    outline: none;
}
.input-wrap input::placeholder { color: #C4A899; }
.input-wrap input:focus {
    border-color: #C84B11;
    box-shadow: 0 0 0 3px rgba(200, 75, 17, 0.12);
    background: #FFFAF8;
}
.icon-right {
    position: absolute;
    right: 14px;
    color: #C4A899;
    font-size: 18px;
    display: flex; align-items: center;
    pointer-events: none;
}
.icon-right.clickable { pointer-events: auto; cursor: pointer; }
.icon-right.clickable:hover { color: #C84B11; }

/* Remember */
.remember-row { margin-bottom: 22px; }
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
    width: 16px; height: 16px;
    accent-color: #C84B11;
    cursor: pointer;
}

/* Button */
.btn-primary {
    width: 100%;
    background: linear-gradient(135deg, #C84B11 0%, #E8621A 100%);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 15px;
    font-size: 15px;
    font-weight: 700;
    font-family: 'Inter', sans-serif;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: transform 0.2s, box-shadow 0.2s, opacity 0.2s;
    margin-bottom: 22px;
}
.btn-primary:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(200, 75, 17, 0.38);
}
.btn-primary:disabled { opacity: 0.65; cursor: not-allowed; transform: none; }
.btn-loader {
    width: 20px; height: 20px;
    border: 3px solid rgba(255,255,255,0.35);
    border-top-color: white;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

/* Divider */
.divider {
    text-align: center;
    position: relative;
    margin-bottom: 18px;
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
    padding: 0 14px;
    font-size: 13px;
    color: #9CA3AF;
}

/* Social */
.social-row { display: flex; gap: 12px; margin-bottom: 24px; }
.social-btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 11px;
    background: #FBF3EF;
    border: 1.5px solid #E8D5CC;
    border-radius: 11px;
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    cursor: pointer;
    transition: all 0.2s;
    font-family: 'Inter', sans-serif;
}
.social-btn:hover { background: #F5E5DC; border-color: #C84B11; }

/* Switch */
.switch-auth { text-align: center; font-size: 14px; color: #6B7280; }
.switch-auth a { color: #C84B11; font-weight: 700; text-decoration: none; }
.switch-auth a:hover { text-decoration: underline; }

/* Footer */
.auth-footer {
    padding: 18px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 11px;
    color: #9CA3AF;
    letter-spacing: 0.4px;
    flex-shrink: 0;
}
.footer-links { display: flex; gap: 20px; }
.footer-links a {
    color: #9CA3AF;
    text-decoration: none;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.5px;
}
.footer-links a:hover { color: #C84B11; }

@keyframes spin { to { transform: rotate(360deg); } }

/* Responsive */
@media (max-width: 960px) {
    .login-left { display: none; }
    .login-layout { padding: 0 20px 24px; }
    .form-area { padding: 36px 32px; }
    .auth-footer { padding: 18px 20px; flex-direction: column; gap: 8px; text-align: center; }
}
</style>
