<template>
    <div class="row g-0 vh-100" style="background-color: #f8fafc;">
        <!-- Left Side -->
        <div class="col-lg-5 col-md-5 d-none d-md-flex flex-column justify-content-between p-4 p-xl-5 text-white position-relative overflow-hidden"
            style="background: linear-gradient(145deg, #0f172a 0%, #1e293b 100%);">
            
            <div class="position-relative z-1 mb-4">
                <div class="d-flex align-items-center mb-5">
                    <div class="d-flex justify-content-center align-items-center rounded-3 me-3 shadow-sm"
                        style="background-color: #3b82f6; width: 44px; height: 44px;">
                        <i class="bx bx-briefcase text-white fs-4"></i>
                    </div>
                    <span class="fs-4 fw-bold">AI-Meet Partner</span>
                </div>

                <h1 class="display-5 fw-bolder mb-4" style="line-height: 1.25;">
                    Trở thành <span style="color: #3b82f6;">Đối tác</span><br>của AI-Meet.
                </h1>

                <p class="fs-6 lh-lg pe-lg-4 mb-5" style="color: #cbd5e1;">
                    Mở rộng mạng lưới kinh doanh và cung cấp giá trị vượt trội cho khách hàng của bạn thông qua giải pháp AI-Meet.
                </p>

                <ul class="list-unstyled d-flex flex-column gap-3">
                    <li class="d-flex align-items-center">
                        <i class='bx bxs-check-circle me-3 fs-5' style="color: #3b82f6;"></i>
                        <span>Chiết khấu hấp dẫn</span>
                    </li>
                    <li class="d-flex align-items-center">
                        <i class='bx bxs-check-circle me-3 fs-5' style="color: #3b82f6;"></i>
                        <span>Hỗ trợ kỹ thuật 24/7</span>
                    </li>
                    <li class="d-flex align-items-center">
                        <i class='bx bxs-check-circle me-3 fs-5' style="color: #3b82f6;"></i>
                        <span>Quản lý dễ dàng</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Right Side (Form) -->
        <div class="col-lg-7 col-md-7 d-flex align-items-center justify-content-center p-4 p-xl-5"
            style="background-color: #f8fafc; overflow-y: auto;">
            <div style="max-width: 520px; width: 100%;">

                <div class="mb-5">
                    <h2 class="fw-bolder mb-3" style="color: #0f172a;">Đăng ký Hợp tác</h2>
                    <p class="mb-0" style="color: #64748b;">Vui lòng điền thông tin để chúng tôi liên hệ với bạn.</p>
                </div>

                <form @submit.prevent="register()">
                    <div class="mb-4">
                        <label class="form-label fw-bold small mb-2">Họ và tên Người đại diện</label>
                        <input v-model="dang_ky.ho_va_ten" type="text" class="form-control form-control-lg bg-white shadow-none py-3"
                            placeholder="Nhập họ và tên">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small mb-2">Email Doanh nghiệp</label>
                        <input v-model="dang_ky.email" type="email" class="form-control form-control-lg bg-white shadow-none py-3"
                            placeholder="partner@company.com">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small mb-2">Số điện thoại</label>
                        <input v-model="dang_ky.so_dien_thoai" type="text" class="form-control form-control-lg bg-white shadow-none py-3"
                            placeholder="Nhập số điện thoại">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small mb-2">Địa chỉ trụ sở</label>
                        <input v-model="dang_ky.dia_chi" type="text" class="form-control form-control-lg bg-white shadow-none py-3"
                            placeholder="Nhập địa chỉ công ty">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small mb-2">Mật khẩu</label>
                        <input v-model="dang_ky.password" type="password" class="form-control form-control-lg bg-white shadow-none py-3"
                            placeholder="••••••••" style="letter-spacing: 2px;">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small mb-2">Xác nhận mật khẩu</label>
                        <input v-model="dang_ky.re_password" type="password" class="form-control form-control-lg bg-white shadow-none py-3"
                            placeholder="••••••••" style="letter-spacing: 2px;">
                    </div>

                    <button type="submit" class="btn w-100 text-white fw-bold py-3 mb-4 rounded-3"
                        style="background-color: #3b82f6;">
                        Đăng ký Hợp tác
                    </button>
                </form>

                <div class="text-center mb-5">
                    <span class="small fw-medium" style="color: #64748b;">Đã là đối tác?</span>
                    <a href="/doi-tac/dang-nhap" class="text-decoration-none fw-bold ms-1"
                        style="color: #3b82f6;">Đăng nhập</a>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: 'DangKyDoiTac',
    data() {
        return {
            dang_ky: {
                ho_va_ten: '',
                email: '',
                so_dien_thoai: '',
                dia_chi: '',
                password: '',
                re_password: '',
            }
        }
    },
    methods: {
        async register() {
            if (this.dang_ky.password != this.dang_ky.re_password) {
                try { this.$toast.error('Mật khẩu không khớp!'); } catch (e) {}
                return;
            }

            try {
                const res = await axios.post('http://127.0.0.1:8000/api/doi-tac/register', this.dang_ky);
                if (res.data.status) {
                    try { this.$toast.success(res.data.message); } catch (e) {}
                    this.$router.push('/doi-tac/dang-nhap');
                } else {
                    try { this.$toast.error(res.data.message || 'Đăng ký thất bại!'); } catch (e) {}
                }
            } catch (errors) {
                const msg = errors.response?.data?.message
                    || (errors.response?.data?.errors
                        ? Object.values(errors.response.data.errors)[0][0]
                        : null)
                    || 'Đăng ký thất bại!';
                try { this.$toast.error(msg); } catch (e) {}
            }
        }
    }
}
</script>

<style scoped>
.form-control:focus {
    border-color: #3b82f6 !important;
}
</style>
