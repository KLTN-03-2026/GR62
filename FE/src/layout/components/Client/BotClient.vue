<template>
    <footer class="footer py-6 border-top bg-light-offwhite">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 mb-5 mb-lg-0">
                    <h4 class="h5 fw-bold text-orange mb-3">AI-Meet</h4>
                    <p class="text-muted small">Kiến tạo không gian hội thoại tương lai bằng những công nghệ hàng đầu thế giới.</p>
                    <div class="d-flex gap-3 social-links">
                        <a href="#"><i class='bx bxl-facebook'></i></a>
                        <a href="#"><i class='bx bxl-twitter'></i></a>
                        <a href="#"><i class='bx bxl-instagram'></i></a>
                    </div>
                </div>
                <div class="col-6 col-md-3 col-lg-2 ms-lg-auto mb-4 mb-lg-0">
                    <h5 class="small fw-bold text-uppercase mb-3 ls-1">Sản phẩm</h5>
                    <ul class="list-unstyled p-0 m-0 footer-links">
                        <li><a href="#">Tính năng</a></li>
                        <li><a href="#">Bảng giá</a></li>
                        <li><a href="#">Tải xuống</a></li>
                        <li><a href="#">AI Face ID</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-3 col-lg-2 mb-4 mb-lg-0">
                    <h5 class="small fw-bold text-uppercase mb-3 ls-1">Thông tin</h5>
                    <ul class="list-unstyled p-0 m-0 footer-links">
                        <li><a href="#">Điều khoản</a></li>
                        <li><a href="#">Bảo mật</a></li>
                        <li><a href="#">Trợ giúp</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h5 class="small fw-bold text-uppercase mb-3 ls-1">Văn phòng</h5>
                    <p class="text-muted small mb-1">Tòa nhà TechCenter, Đường số 7,</p>
                    <p class="text-muted small mb-1">Khu công nghệ cao, TP. Hồ Chí Minh</p>
                    <p class="text-muted small mb-0">support@ai-meet.vn</p>
                </div>
            </div>
            <div class="border-top mt-5 pt-4 text-center">
                <p class="x-small text-muted mb-0">&copy; 2024 AI-Meet. Kiến tạo không gian hội thoại tương lai.</p>
            </div>
        </div>
    </footer>
</template>

<script>
export default {
    name: "BotClient",
}
</script>

<style scoped>
.footer { font-family: 'Plus Jakarta Sans', sans-serif; }
.bg-light-offwhite { background: #fafafa; }
.text-orange { color: #FF6600; }
.ls-1 { letter-spacing: 1px; }
.x-small { font-size: 11px; }
.py-6 { padding-top: 5rem; padding-bottom: 5rem; }

.footer-links li { margin-bottom: 12px; }
.footer-links a { 
    text-decoration: none; 
    color: #6c757d; 
    font-size: 14px; 
    transition: 0.3s;
}
.footer-links a:hover { color: #FF6600; }

.social-links a {
    width: 36px;
    height: 36px;
    background: #f0f0f0;
    color: #1a1e29;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: 0.3s;
}

.social-links a:hover {
    background: #FF6600;
    color: #fff;
}
</style>