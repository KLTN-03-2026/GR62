<template>
    <div class="homepage">
        <!-- Hero Section -->
        <section class="hero-section text-white py-5 position-relative"
            style="background-color: #0d121c; min-height: 85vh; display: flex; align-items: center;">
            <div class="container py-5 mt-4">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-5 mb-lg-0 pe-lg-5">
                        <div class="d-inline-flex align-items-center rounded-pill px-3 py-1 mb-4"
                            style="background-color: rgba(6, 182, 212, 0.1);">
                            <i class="bx bxs-circle me-2" style="color: #06b6d4; font-size: 10px;"></i>
                            <span class="fw-medium text-info" style="font-size: 13px; color: #06b6d4 !important;">Công
                                nghệ AI tiên tiến nhất 2026</span>
                        </div>
                        <h1 class="display-3 fw-bold mb-4 pe-lg-5" style="line-height: 1.1;">
                            Phòng họp trực tuyến <span class="text-white">&</span> <br>
                            <span style="color: #06b6d4;">Nhận diện khuôn mặt AI</span>
                        </h1>
                        <p class="mb-5 lh-lg text-white-50" style="max-width: 500px; font-size: 1.1rem;">
                            Nâng tầm hiệu suất cuộc họp với tính năng điểm danh tự động, bảo mật
                            khuôn mặt và tóm tắt nội dung thông minh bằng trí tuệ nhân tạo.
                        </p>
                        <div class="d-flex align-items-center gap-3 mt-2">
                            <a href="#" class="btn px-4 py-2 text-white fw-bold shadow-none"
                                style="background-color: #0d9488; border-radius: 8px;">Thử nghiệm miễn phí</a>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="position-relative hero-image-wrapper mx-auto" style="max-width: 550px;">
                            <!-- Face Recognition Graphic -->
                            <div class="rounded-4 overflow-hidden position-relative"
                                style="aspect-ratio: 1/1; background: #000;">
                                <img src="../../assets/images/hero-face.png" class="w-100 h-100 object-fit-cover"
                                    alt="AI Face Recognition" style="filter: brightness(0.85) contrast(1.1);">
                                <div
                                    class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center">

                                    <!-- Scanning Box -->
                                    <div class="position-relative" style="width: 300px; height: 350px;">
                                        <!-- Corner brackets -->
                                        <div class="position-absolute top-0 start-0 border-top border-start"
                                            style="width: 40px; height: 40px; border-color: #3b82f6 !important; border-width: 2px !important; border-top-left-radius: 12px;">
                                        </div>
                                        <div class="position-absolute top-0 end-0 border-top border-end"
                                            style="width: 40px; height: 40px; border-color: #3b82f6 !important; border-width: 2px !important; border-top-right-radius: 12px;">
                                        </div>
                                        <div class="position-absolute bottom-0 start-0 border-bottom border-start"
                                            style="width: 40px; height: 40px; border-color: #3b82f6 !important; border-width: 2px !important; border-bottom-left-radius: 12px;">
                                        </div>
                                        <div class="position-absolute bottom-0 end-0 border-bottom border-end"
                                            style="width: 40px; height: 40px; border-color: #3b82f6 !important; border-width: 2px !important; border-bottom-right-radius: 12px;">
                                        </div>

                                        <!-- Green Outline Box mimicking shape -->
                                        <div class="position-absolute border"
                                            style="top: -40px; left: -30px; right: -30px; bottom: -80px; border-color: #10b981 !important; border-width: 2px !important; border-radius: 20px; opacity: 0.8;">
                                        </div>

                                        <!-- Face Box matching cyan lines -->
                                        <div class="position-absolute border-top border-start border-end"
                                            style="top: 80px; left: 30px; right: 30px; height: 120px; border-color: #0ea5e9 !important; border-width: 2px !important;">
                                        </div>
                                        <div class="position-absolute border-bottom border-start border-end"
                                            style="bottom: 70px; left: 30px; right: 30px; height: 50px; border-color: #0ea5e9 !important; border-width: 2px !important;">
                                        </div>

                                        <!-- Horizontal scanning line -->
                                        <div class="position-absolute w-100 scan-line"
                                            style="height: 1px; background-color: #bae6fd; box-shadow: 0 0 10px 2px #38bdf8;">
                                        </div>

                                        <!-- Badge -->
                                        <div class="position-absolute w-100 text-center"
                                            style="bottom: 40px; z-index: 10;">
                                            <div class="d-inline-flex flex-column align-items-start px-3 py-2 fw-bold text-dark rounded-1"
                                                style="background-color: #38bdf8; font-size: 11px;">
                                                <span style="letter-spacing: 0.5px;">AUTHENTICATED:</span>
                                                <span>USER 01</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Trusted By -->
        <section class="py-4 border-bottom bg-white shadow-sm">
            <div class="container text-center">
                <p class="text-muted small fw-bold mb-3 ls-1 text-uppercase">Được tin dùng bởi các doanh nghiệp hàng đầu
                </p>
                <div
                    class="d-flex justify-content-center align-items-center gap-4 gap-md-5 flex-wrap opacity-50 grayscale">
                    <i class='bx bxl-microsoft fs-2'></i>
                    <i class='bx bxl-amazon fs-2'></i>
                    <i class='bx bxl-google fs-2'></i>
                    <i class='bx bxl-meta fs-2'></i>
                    <i class='bx bxl-apple fs-2'></i>
                </div>
            </div>
        </section>

        <!-- Features -->
        <section class="py-5 bg-light">
            <div class="container py-5">
                <div class="text-center mb-5">
                    <span class="text-success fw-bold small text-uppercase ls-1">Ưu điểm vượt trội</span>
                    <h2 class="display-6 fw-bold mt-2">Giải pháp hội nghị AI toàn diện</h2>
                </div>
                <div class="row g-4 pt-4">
                    <!-- Card 1 -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center text-md-start hover-lift">
                            <div class="mb-4">
                                <div class="bg-success bg-opacity-10 d-inline-flex justify-content-center align-items-center rounded-circle"
                                    style="width: 60px; height: 60px;">
                                    <i class='bx bxs-check-shield text-success fs-2'></i>
                                </div>
                            </div>
                            <h4 class="fw-bold mb-3">Bảo mật sinh trắc học</h4>
                            <p class="text-muted mb-4 small">
                                Ngăn chặn truy cập trái phép bằng nhận diện khuôn mặt thời gian thực.
                                Đảm bảo đúng người, đúng quyền trong mọi cuộc họp quan trọng.
                            </p>
                            <ul class="list-unstyled text-start small mb-0">
                                <li class="mb-2"><i class='bx bx-check-circle text-success me-2'></i> Điểm danh tự động
                                </li>
                                <li><i class='bx bx-check-circle text-success me-2'></i> Phát hiện giả mạo AI</li>
                            </ul>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center text-md-start hover-lift">
                            <div class="mb-4">
                                <div class="bg-success bg-opacity-10 d-inline-flex justify-content-center align-items-center rounded-circle"
                                    style="width: 60px; height: 60px;">
                                    <i class='bx bx-message-square-detail text-success fs-2'></i>
                                </div>
                            </div>
                            <h4 class="fw-bold mb-3">Tóm tắt nội dung thông minh</h4>
                            <p class="text-muted mb-4 small">
                                Không cần ghi chép thủ công. AI tự động chuyển đổi giọng nói thành văn bản
                                và trích xuất các quyết định, hành động quan trọng.
                            </p>
                            <ul class="list-unstyled text-start small mb-0">
                                <li class="mb-2"><i class='bx bx-check-circle text-success me-2'></i> Trích xuất Action
                                    Items</li>
                                <li><i class='bx bx-check-circle text-success me-2'></i> Hỗ trợ đa ngôn ngữ</li>
                            </ul>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center text-md-start hover-lift">
                            <div class="mb-4">
                                <div class="bg-success bg-opacity-10 d-inline-flex justify-content-center align-items-center rounded-circle"
                                    style="width: 60px; height: 60px;">
                                    <i class='bx bx-video text-success fs-2'></i>
                                </div>
                            </div>
                            <h4 class="fw-bold mb-3">Chất lượng 4K Ultra HD</h4>
                            <p class="text-muted mb-4 small">
                                Trải nghiệm hình ảnh sắc nét và âm thanh trung thực.
                                Công nghệ nền AI giúp duy trì sự ổn định ngay cả khi đường truyền yếu.
                            </p>
                            <ul class="list-unstyled text-start small mb-0">
                                <li class="mb-2"><i class='bx bx-check-circle text-success me-2'></i> Lọc nhiễu môi
                                    trường AI</li>
                                <li><i class='bx bx-check-circle text-success me-2'></i> Tự động cân bằng sáng</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="py-5" style="background-color: #1a1e29;">
            <div class="container py-5">
                <div class="row mb-5">
                    <div class="col-lg-6">
                        <span class="text-info fw-bold small text-uppercase ls-1">Khách hàng nói gì</span>
                        <h2 class="display-6 fw-bold mt-2 text-white">Được sự tin tưởng từ <br> các chuyên gia</h2>
                    </div>
                    <div class="col-lg-6 d-flex align-items-end justify-content-lg-end mt-4 mt-lg-0">
                        <div class="d-flex gap-2">
                            <button
                                class="btn btn-outline-secondary rounded-pill d-flex justify-content-center align-items-center"
                                style="width: 50px; height: 35px;"><i
                                    class='bx bx-left-arrow-alt fs-5 text-white'></i></button>
                            <button class="btn btn-info rounded-pill d-flex justify-content-center align-items-center"
                                style="width: 50px; height: 35px; background-color: #06b6d4; border-color: #06b6d4;"><i
                                    class='bx bx-right-arrow-alt fs-5 text-white'></i></button>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Testimonial 1 -->
                    <div class="col-md-4">
                        <div
                            class="card h-100 bg-secondary bg-opacity-25 border border-secondary border-opacity-50 p-4 rounded-4 shadow hover-lift">
                            <div class="mb-3">
                                <i class='bx bxs-star text-warning'></i>
                                <i class='bx bxs-star text-warning'></i>
                                <i class='bx bxs-star text-warning'></i>
                                <i class='bx bxs-star text-warning'></i>
                                <i class='bx bxs-star text-warning'></i>
                            </div>
                            <p class="fst-italic text-white-50 mb-4 small lh-lg">"Tính năng nhận diện khuôn mặt giúp
                                việc điểm danh nhân viên trong các buổi họp giao ban sáng trở nên cực kỳ nhanh chóng và
                                chính xác."</p>
                            <div class="d-flex align-items-center mt-auto">
                                <div class="bg-success text-white rounded-circle d-flex justify-content-center align-items-center fw-bold me-3"
                                    style="width: 45px; height: 45px;">TH</div>
                                <div>
                                    <h6 class="mb-0 text-white fw-bold">Trần Hoàng</h6>
                                    <small class="text-muted" style="font-size: 0.75rem;">CTO @ TECHFLOW</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Testimonial 2 -->
                    <div class="col-md-4">
                        <div
                            class="card h-100 bg-secondary bg-opacity-25 border border-secondary border-opacity-50 p-4 rounded-4 shadow hover-lift">
                            <div class="mb-3">
                                <i class='bx bxs-star text-warning'></i>
                                <i class='bx bxs-star text-warning'></i>
                                <i class='bx bxs-star text-warning'></i>
                                <i class='bx bxs-star text-warning'></i>
                                <i class='bx bxs-star text-warning'></i>
                            </div>
                            <p class="fst-italic text-white-50 mb-4 small lh-lg">"Tóm tắt họp tự động của AI-Meet rất
                                thông minh, giúp đội ngũ của tôi tiết kiệm ít nhất 2 giờ mỗi tuần cho việc ghi chép biên
                                bản."</p>
                            <div class="d-flex align-items-center mt-auto">
                                <div class="bg-info text-white rounded-circle d-flex justify-content-center align-items-center fw-bold me-3"
                                    style="width: 45px; height: 45px;">ML</div>
                                <div>
                                    <h6 class="mb-0 text-white fw-bold">Mai Lan</h6>
                                    <small class="text-muted" style="font-size: 0.75rem;">OPERATIONS DIRECTOR</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Testimonial 3 -->
                    <div class="col-md-4">
                        <div
                            class="card h-100 bg-secondary bg-opacity-25 border border-secondary border-opacity-50 p-4 rounded-4 shadow hover-lift">
                            <div class="mb-3">
                                <i class='bx bxs-star text-warning'></i>
                                <i class='bx bxs-star text-warning'></i>
                                <i class='bx bxs-star text-warning'></i>
                                <i class='bx bxs-star text-warning'></i>
                                <i class='bx bxs-star text-warning'></i>
                            </div>
                            <p class="fst-italic text-white-50 mb-4 small lh-lg">"Dịch vụ khách hàng tuyệt vời và chất
                                lượng hình ảnh ổn định hơn hẳn các nền tảng quốc tế mà chúng tôi từng sử dụng trước
                                đây."</p>
                            <div class="d-flex align-items-center mt-auto">
                                <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center fw-bold me-3"
                                    style="width: 45px; height: 45px;">PQ</div>
                                <div>
                                    <h6 class="mb-0 text-white fw-bold">Phạm Quang</h6>
                                    <small class="text-muted" style="font-size: 0.75rem;">HR MANAGER @ J.CORP</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing -->
        <section class="py-5 bg-white">
            <div class="container py-5">
                <div class="text-center mb-5">
                    <span class="text-success fw-bold small text-uppercase ls-1">Lựa chọn gói dịch vụ</span>
                    <h2 class="display-6 fw-bold mt-2">Phù hợp cho mọi quy mô</h2>
                    <div class="d-inline-flex bg-light rounded-pill p-1 mt-4 border">
                        <button class="btn btn-white shadow-sm rounded-pill px-4 py-2 fw-medium text-dark small">Dành
                            cho cá nhân / Nhóm nhỏ</button>
                        <button class="btn btn-transparent rounded-pill px-4 py-2 fw-medium text-muted small">Dành cho
                            Doanh nghiệp</button>
                    </div>
                </div>

                <div class="row align-items-center g-4 pt-4 px-lg-5">
                    <!-- Basic Plan -->
                    <div class="col-lg-4">
                        <div class="card border rounded-4 bg-white p-5 shadow-sm h-100 hover-lift">
                            <h4 class="fw-bold mb-1">Basic</h4>
                            <p class="text-muted small">Khám phá sức mạnh AI</p>
                            <div class="my-4">
                                <h2 class="display-5 fw-bold mb-0 d-inline-block">0đ</h2><span
                                    class="text-muted fs-6">/tháng</span>
                            </div>
                            <ul class="list-unstyled mb-5 mt-2">
                                <li class="mb-3 small d-flex align-items-center"><i
                                        class='bx bx-check-circle text-success me-2 fs-5'></i> Tối đa 40 phút/cuộc họp
                                </li>
                                <li class="mb-3 small d-flex align-items-center"><i
                                        class='bx bx-check-circle text-success me-2 fs-5'></i> 100 người tham gia</li>
                                <li class="mb-3 small d-flex align-items-center text-muted"><i
                                        class='bx bx-check-circle me-2 fs-5'></i> Nhận diện khuôn mặt AI</li>
                            </ul>
                            <button class="btn btn-outline-dark rounded-3 px-4 py-2 w-100 fw-medium mt-auto">Bắt đầu
                                miễn phí</button>
                        </div>
                    </div>

                    <!-- Pro Plan -->
                    <div class="col-lg-4 position-relative">
                        <div class="position-absolute start-50 translate-middle badge rounded-pill bg-info px-4 py-2 text-dark shadow fw-bold"
                            style="top: -12px; font-size: 0.75rem; letter-spacing: 0.5px; z-index: 15;">PHỔ BIẾN NHẤT
                        </div>
                        <div class="card border-0 rounded-4 p-5 shadow-lg text-white h-100 pricing-pro"
                            style="background-color: #0c1a25;">
                            <h4 class="fw-bold mb-1 text-white">Professional</h4>
                            <p class="text-info small">Cho nhà chuyên gia & Freelancer</p>
                            <div class="my-4 text-white">
                                <h2 class="display-5 fw-bold mb-0 d-inline-block text-white">499.000đ</h2><span
                                    class="text-white-50 fs-6">/tháng</span>
                            </div>
                            <ul class="list-unstyled mb-5 mt-2">
                                <li class="mb-3 small d-flex align-items-center"><i
                                        class='bx bxs-check-circle text-info me-2 fs-5'></i> Họp không giới hạn thời
                                    gian</li>
                                <li class="mb-3 small d-flex align-items-center"><i
                                        class='bx bxs-check-circle text-info me-2 fs-5'></i> AI Face Recognition (Full)
                                </li>
                                <li class="mb-3 small d-flex align-items-center"><i
                                        class='bx bxs-check-circle text-info me-2 fs-5'></i> Tóm tắt AI tự động (50
                                    buổi/tháng)</li>
                                <li class="mb-3 small d-flex align-items-center"><i
                                        class='bx bxs-check-circle text-info me-2 fs-5'></i> Lưu trữ Cloud 100GB</li>
                            </ul>
                            <button
                                class="btn btn-info rounded-3 px-4 py-2 w-100 fw-medium mt-auto text-dark shadow-sm">Nâng
                                cấp ngay</button>
                        </div>
                    </div>

                    <!-- Enterprise Plan -->
                    <div class="col-lg-4">
                        <div class="card border rounded-4 bg-white p-5 shadow-sm h-100 hover-lift">
                            <h4 class="fw-bold mb-1">Enterprise</h4>
                            <p class="text-muted small">Giải pháp cho mọi doanh nghiệp</p>
                            <div class="my-4">
                                <h2 class="display-5 fw-bold mb-0">Liên hệ</h2>
                                <span class="text-muted small">*Tùy chỉnh theo yêu cầu thực tế</span>
                            </div>
                            <ul class="list-unstyled mb-5 mt-2">
                                <li class="mb-3 small d-flex align-items-center"><i
                                        class='bx bx-check text-muted me-2 fs-5'></i> Không giới hạn người tham gia</li>
                                <li class="mb-3 small d-flex align-items-center"><i
                                        class='bx bx-check text-muted me-2 fs-5'></i> SDK & API Integration</li>
                                <li class="mb-3 small d-flex align-items-center"><i
                                        class='bx bx-check text-muted me-2 fs-5'></i> Hosting riêng (On-premise)</li>
                                <li class="mb-3 small d-flex align-items-center"><i
                                        class='bx bx-check text-muted me-2 fs-5'></i> Quản trị hệ thống toàn diện 24/7
                                </li>
                            </ul>
                            <button class="btn btn-outline-dark rounded-3 px-4 py-2 w-100 fw-medium mt-auto">Liên hệ đối
                                tác</button>
                        </div>
                    </div>

                </div>
            </div>
        </section>


    </div>
</template>

<script>
export default {
    name: "TrangChu"
}
</script>

<style scoped>
.grayscale {
    filter: grayscale(100%);
}

.ls-1 {
    letter-spacing: 1px;
}

.nav-link {
    color: #4b5563;
}

.nav-link.active {
    color: #111827;
}

.hover-lift {
    transition: transform 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-8px);
}

@media (min-width: 992px) {
    .pricing-pro {
        transform: scale(1.08);
        z-index: 10;
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
    }
}

.pricing-pro {
    transition: transform 0.3s ease;
}

@keyframes scan-animation {
    0% {
        top: 80px;
        opacity: 1;
    }

    50% {
        top: 260px;
        opacity: 1;
    }

    100% {
        top: 80px;
        opacity: 1;
    }
}

.scan-line {
    animation: scan-animation 3s ease-in-out infinite;
}
</style>
