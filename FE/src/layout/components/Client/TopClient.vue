<template>
    <!-- Navbar -->
    <header class="header-nav py-3 border-bottom bg-white shadow-sm sticky-top">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="logo d-flex align-items-center">
                <img src="../../../assets/images/logo.pnj.png" alt="" class="img-fluid"
                    style="height: 60px; width: 60px;">
                <router-link to="/" class="h3 fw-bold mb-0 text-orange"> AI-Meet</router-link>
            </div>
            <nav class="nav-links d-none d-md-flex gap-4">
                <router-link to="/" class="nav-link-item active">Trang chủ</router-link>
                <a href="#features" class="nav-link-item">Tính năng</a>
                <a href="#pricing" class="nav-link-item">Bảng giá</a>
                <a href="#" class="nav-link-item">Liên hệ</a>
            </nav>
            <div class="auth-buttons d-flex gap-2 align-items-center">
                <router-link to="/nguoi-dung/dang-nhap" class="btn-text">Đăng nhập</router-link>
                <router-link to="/nguoi-dung/dang-ky" class="btn-orange rounded-pill px-4">Đăng ký</router-link>
            </div>
        </div>
    </header>
</template>

<script>
export default {
    name: "TopClient",
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

.header-nav {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #ffffff;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
    z-index: 1050;
}

.text-orange {
    color: #FF6600 !important;
}

.nav-link-item {
    text-decoration: none;
    color: #1a1e29;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.3s ease;
    position: relative;
    padding: 8px 0;
}

.nav-link-item:hover,
.nav-link-item.active {
    color: #FF6600 !important;
}

.nav-link-item::after {
    content: '';
    position: absolute;
    bottom: 0px;
    left: 0;
    width: 0;
    height: 2px;
    background: #FF6600;
    transition: width 0.3s ease;
}

.nav-link-item:hover::after,
.nav-link-item.active::after {
    width: 100%;
}

.btn-text {
    text-decoration: none;
    color: #1a1e29 !important;
    font-weight: 600;
    font-size: 15px;
    padding: 8px 16px;
    transition: color 0.3s ease;
}

.btn-text:hover {
    color: #FF6600 !important;
}

.btn-orange {
    background: #FF6600 !important;
    color: #ffffff !important;
    border: none !important;
    padding: 10px 24px !important;
    font-weight: 700 !important;
    transition: all 0.3s ease !important;
    text-decoration: none !important;
    display: inline-block !important;
}

.btn-orange:hover {
    background: #e65c00 !important;
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(255, 102, 0, 0.2);
    color: #ffffff !important;
}

@media (max-width: 768px) {
    .h3 {
        font-size: 1.25rem;
    }

    .nav-links {
        display: none !important;
    }
}
</style>