<template>
    <div class="d-flex justify-content-center align-items-center vh-100 p-3 p-md-4" style="background-color: #f0f4f8;">
        <div class="card border-0 shadow-lg overflow-hidden"
            style="max-width: 950px; width: 100%; border-radius: 20px;">
            <div class="row g-0 h-100" style="min-height: 600px;">
                <!-- Left Side (Branding) -->
                <div class="col-md-6 d-none d-md-flex flex-column justify-content-center p-5 text-white position-relative"
                    style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                    <div class="position-relative z-1 mb-5 ps-xl-3">
                        <div class="d-flex align-items-center mb-4">
                            <div class="d-flex justify-content-center align-items-center rounded-3 me-3 shadow-sm"
                                style="background-color: #3b82f6; width: 44px; height: 44px;">
                                <i class="bx bx-briefcase text-white fs-4"></i>
                            </div>
                            <span class="fs-4 fw-bold" style="letter-spacing: -0.5px;">AI-Meet Partner</span>
                        </div>
                        <h1 class="display-6 fw-bold mb-4 text-white" style="line-height: 1.35; letter-spacing: -1px;">
                            Đồng hành cùng<br>sự phát triển.
                        </h1>
                        <p class="fs-6 lh-lg pe-4" style="color: #94a3b8; font-weight: 400;">
                            Cung cấp giải pháp họp trực tuyến tối ưu cho doanh nghiệp và đối tác của bạn.
                        </p>
                    </div>
                </div>

                <!-- Right Side (Form) -->
                <div class="col-md-6 bg-white p-4 p-xl-5 d-flex flex-column justify-content-center">
                    <div class="px-xl-4 pb-4">
                        <div class="mb-4">
                            <h2 class="fw-bolder mb-2"
                                style="color: #0f172a; font-size: 1.75rem; letter-spacing: -0.5px;">Đăng nhập Đối tác</h2>
                            <p class="small mb-0" style="color: #64748b;">Dành riêng cho các đối tác của AI-Meet.</p>
                        </div>

                        <form @submit.prevent="login()">
                            <!-- Email Input -->
                            <div class="mb-4">
                                <label class="form-label fw-bold small mb-2" style="color: #334155;">Email Đăng nhập</label>
                                <input v-model="doi_tac.email" type="email"
                                    class="form-control form-control-lg bg-transparent shadow-none px-3 py-3 fs-6"
                                    placeholder="partner@company.com"
                                    style="border-radius: 10px; border: 1px solid #e2e8f0; color: #475569;">
                            </div>

                            <!-- Password Input -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label fw-bold small mb-0" style="color: #334155;">Mật khẩu</label>
                                </div>
                                <input v-model="doi_tac.password" type="password"
                                    class="form-control form-control-lg bg-transparent shadow-none px-3 py-3 fs-6"
                                    placeholder="••••••••"
                                    style="border-radius: 10px; border: 1px solid #e2e8f0; color: #475569; letter-spacing: 2px;">
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                class="btn w-100 text-white fw-bold py-3 mt-2 mb-4 rounded-3 d-flex justify-content-center align-items-center"
                                style="background-color: #3b82f6; transition: all 0.2s;">
                                <span class="me-2" style="font-size: 0.95rem;">Đăng nhập ngay</span>
                                <i class='bx bx-right-arrow-alt fs-5'></i>
                            </button>
                        </form>

                        <!-- Signup Link -->
                        <div class="text-center mt-3 pb-2">
                            <span class="small fw-medium" style="color: #64748b;">Chưa là đối tác?</span>
                            <a href="/doi-tac/dang-ky" class="text-decoration-none fw-bold ms-1"
                                style="color: #3b82f6; font-size: 0.9rem;">Đăng ký hợp tác</a>
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
    name: 'DangNhapDoiTac',
    data() {
        return {
            doi_tac: {
                email: '',
                password: '',
            }
        }
    },
    methods: {
        async login() {
            try {
                const res = await axios.post('http://127.0.0.1:8000/api/doi-tac/login', this.doi_tac);
                if (res.data.status) {
                    localStorage.setItem('token_doi_tac', res.data.data.token);
                    try { this.$toast.success('Đăng nhập đối tác thành công!'); } catch(e) {}
                    this.$router.push('/doi-tac/dashboard'); // Adjust redirection if needed
                } else {
                    try { this.$toast.error(res.data.message || 'Đăng nhập thất bại!'); } catch(e) {}
                }
            } catch (errors) {
                const msg = errors.response?.data?.message
                    || (errors.response?.data?.errors
                        ? Object.values(errors.response.data.errors)[0][0]
                        : null)
                    || 'Đăng nhập thất bại!';
                try { this.$toast.error(msg); } catch(e) {}
            }
        }
    }
}
</script>

<style scoped>
input.form-control::placeholder {
    color: #94a3b8;
    letter-spacing: normal;
}

input.form-control:focus {
    border-color: #3b82f6 !important;
    background-color: #fff !important;
}

button.btn:hover {
    background-color: #2563eb !important;
}
</style>
