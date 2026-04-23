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
        <section id="pricing" class="py-5" style="background-color: #fafaf9;">
            <div class="container py-5 mt-4">
                <div class="text-center mb-5" style="max-width: 800px; margin: 0 auto;">
                    <h2 class="display-5 fw-bold mb-3" style="color: #1a1e29; letter-spacing: -1px;">Lựa chọn gói dịch
                        vụ phù hợp<br>cho sự nghiệp của bạn</h2>
                    <p class="text-muted fs-5 lh-base">
                        Trải nghiệm hội nghị truyền hình thế hệ mới với sức mạnh từ trí tuệ nhân tạo.<br>
                        Tối ưu hóa quy trình làm việc từ cá nhân đến doanh nghiệp lớn.
                    </p>
                </div>

                <div class="row g-4 align-items-stretch mb-5">
                    <template v-for="(value, index) in list_goi" :key="index">
                        <div v-if="value.is_hien_thi" :class="index == 1 ? 'col-lg-4 position-relative' : 'col-lg-4'">
                            <!-- Popular Badge -->
                            <div v-if="index == 1"
                                class="position-absolute start-50 translate-middle d-inline-block rounded-pill text-white fw-bold px-3 py-1 shadow-sm"
                                style="background-color: #ea580c; top: 0; font-size: 0.75rem; letter-spacing: 0.5px; z-index: 10;">
                                PHỔ BIẾN NHẤT
                            </div>

                            <div :class="['card h-100 border-0 p-5 rounded-4 shadow-sm', index == 1 ? 'bg-white pricing-pro' : '']"
                                :style="index != 1 ? 'background-color: #fdf5f3;' : 'box-shadow: 0 10px 40px rgba(0,0,0,0.06);'">
                                <h5 class="fw-bold mb-3" style="color: #1a1e29; font-size: 1.1rem;">{{ value.ten_goi }}</h5>
                                <div class="d-flex align-items-baseline mb-4">
                                    <h1 class="display-5 fw-bold mb-0" :style="index == 1 ? 'color: #ea580c;' : 'color: #1a1e29;'">
                                        {{ value.gia_goi > 0 ? formatVND(value.gia_goi) : (value.gia_goi == 0 ? '0đ' : 'Liên hệ') }}
                                    </h1>
                                    <span v-if="value.gia_goi >= 0" class="text-muted ms-1" style="font-size: 0.9rem;">/tháng</span>
                                </div>

                                <ul class="list-unstyled mb-5 mt-2 flex-grow-1">
                                    <li class="mb-3 d-flex align-items-center">
                                        <div :class="['rounded-circle d-flex align-items-center justify-content-center me-3', index == 1 ? '' : 'bg-white shadow-sm']"
                                            :style="index == 1 ? 'width: 24px; height: 24px; min-width: 24px; background-color: #ea580c;' : 'width: 24px; height: 24px; min-width: 24px;'">
                                            <i class="bx bx-check" :style="index == 1 ? 'color: white; font-size: 18px;' : 'color: #c2410c; font-size: 18px;'"></i>
                                        </div>
                                        <span class="text-dark fw-medium" style="font-size: 0.9rem;">Tối đa {{ value.so_nguoi_toi_da }} người tham gia</span>
                                    </li>
                                    <li class="mb-3 d-flex align-items-center">
                                        <div :class="['rounded-circle d-flex align-items-center justify-content-center me-3', index == 1 ? '' : 'bg-white shadow-sm']"
                                            :style="index == 1 ? 'width: 24px; height: 24px; min-width: 24px; background-color: #ea580c;' : 'width: 24px; height: 24px; min-width: 24px;'">
                                            <i class="bx bx-check" :style="index == 1 ? 'color: white; font-size: 18px;' : 'color: #c2410c; font-size: 18px;'"></i>
                                        </div>
                                        <span class="text-dark fw-medium" style="font-size: 0.9rem;">Tối đa {{ value.so_phong_toi_da }} phòng họp</span>
                                    </li>
                                    <li class="mb-3 d-flex align-items-center">
                                        <div :class="['rounded-circle d-flex align-items-center justify-content-center me-3', index == 1 ? '' : 'bg-white shadow-sm']"
                                            :style="index == 1 ? 'width: 24px; height: 24px; min-width: 24px; background-color: #ea580c;' : 'width: 24px; height: 24px; min-width: 24px;'">
                                            <i class="bx bx-check" :style="index == 1 ? 'color: white; font-size: 18px;' : 'color: #c2410c; font-size: 18px;'"></i>
                                        </div>
                                        <span class="text-dark fw-medium" style="font-size: 0.9rem;">Thời hạn: {{ value.thoi_han }} ngày</span>
                                    </li>
                                    <li class="mb-3 d-flex align-items-center">
                                        <div :class="['rounded-circle d-flex align-items-center justify-content-center me-3', index == 1 ? '' : 'bg-white shadow-sm']"
                                            :style="index == 1 ? 'width: 24px; height: 24px; min-width: 24px; background-color: #ea580c;' : 'width: 24px; height: 24px; min-width: 24px;'">
                                            <i class="bx bx-check" :style="index == 1 ? 'color: white; font-size: 18px;' : 'color: #c2410c; font-size: 18px;'"></i>
                                        </div>
                                        <span class="text-dark fw-medium" style="font-size: 0.9rem;">{{ value.mo_ta }}</span>
                                    </li>
                                </ul>

                                <button :class="['btn border-0 fw-bold py-3 rounded-3 w-100 mt-auto', index == 1 ? 'text-white' : 'text-dark']"
                                    :style="index == 1 ? 'background-color: #ea580c; font-size: 0.9rem;' : 'background-color: #fce7df; font-size: 0.9rem;'">
                                    {{ value.gia_goi == 0 ? 'Bắt đầu miễn phí' : (value.gia_goi > 0 ? 'Nâng cấp ngay' : 'Liên hệ đội ngũ Sales') }}
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- So sánh tính năng chi tiết -->
                <div class="mt-5 pt-4">
                    <h3 class="text-center fw-bold mb-5" style="color: #1a1e29; font-size: 1.6rem;">So sánh tính năng
                        chi tiết</h3>
                    <div class="table-responsive rounded-4 overflow-hidden border-0" style="background-color: #fdf5f3;">
                        <table class="table table-borderless align-middle mb-0" style="min-width: 800px;">
                            <thead>
                                <tr style="border-bottom: 1px solid #f6e6e0;">
                                    <th scope="col" class="py-4 ps-4 fw-medium text-muted bg-transparent"
                                        style="width: 30%; font-size: 0.9rem;">Tính năng</th>
                                    <th scope="col" class="py-4 text-center fw-bold text-dark bg-transparent"
                                        style="font-size: 0.9rem;">Cơ bản</th>
                                    <th scope="col" class="py-4 text-center fw-bold bg-transparent"
                                        style="color: #c2410c; font-size: 0.9rem;">Chuyên nghiệp</th>
                                    <th scope="col" class="py-4 text-center fw-bold text-dark bg-transparent"
                                        style="font-size: 0.9rem;">Doanh nghiệp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #f6e6e0;">
                                    <td class="py-4 ps-4 fw-bold text-dark bg-transparent" style="font-size: 0.9rem;">
                                        Thời gian họp</td>
                                    <td class="py-4 text-center text-secondary bg-transparent"
                                        style="font-size: 0.9rem;">40 phút</td>
                                    <td class="py-4 text-center fw-bold text-dark bg-transparent"
                                        style="font-size: 0.9rem;">Không giới hạn</td>
                                    <td class="py-4 text-center fw-bold text-dark bg-transparent"
                                        style="font-size: 0.9rem;">Không giới hạn</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #f6e6e0;">
                                    <td class="py-4 ps-4 fw-bold text-dark bg-transparent" style="font-size: 0.9rem;">Số
                                        lượng người tham gia</td>
                                    <td class="py-4 text-center text-secondary bg-transparent"
                                        style="font-size: 0.9rem;">100</td>
                                    <td class="py-4 text-center fw-bold text-dark bg-transparent"
                                        style="font-size: 0.9rem;">500</td>
                                    <td class="py-4 text-center fw-bold text-dark bg-transparent"
                                        style="font-size: 0.9rem;">Tùy chỉnh</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #f6e6e0;">
                                    <td class="py-4 ps-4 fw-bold text-dark bg-transparent" style="font-size: 0.9rem;">
                                        Nhận diện khuôn mặt AI</td>
                                    <td class="py-4 text-center text-secondary bg-transparent"
                                        style="font-size: 0.9rem;">Cơ bản</td>
                                    <td class="py-4 text-center fw-bold text-dark bg-transparent"
                                        style="font-size: 0.9rem;">Nâng cao (Face ID)</td>
                                    <td class="py-4 text-center fw-bold text-dark bg-transparent"
                                        style="font-size: 0.9rem;">Nâng cao & Tùy biến</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #f6e6e0;">
                                    <td class="py-4 ps-4 fw-bold text-dark bg-transparent" style="font-size: 0.9rem;">
                                        Tóm tắt cuộc họp AI</td>
                                    <td class="py-4 text-center text-secondary bg-transparent"><span
                                            style="color: #fbceb1; font-size: 1.5rem;">—</span></td>
                                    <td class="py-4 text-center bg-transparent"><i class="bx bxs-check-circle"
                                            style="color: #c2410c; font-size: 1.25rem;"></i></td>
                                    <td class="py-4 text-center bg-transparent"><i class="bx bxs-check-circle"
                                            style="color: #c2410c; font-size: 1.25rem;"></i></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #f6e6e0;">
                                    <td class="py-4 ps-4 fw-bold text-dark bg-transparent" style="font-size: 0.9rem;">
                                        Dung lượng lưu trữ</td>
                                    <td class="py-4 text-center text-secondary bg-transparent"
                                        style="font-size: 0.9rem;">1GB Cloud</td>
                                    <td class="py-4 text-center fw-bold text-dark bg-transparent"
                                        style="font-size: 0.9rem;">100GB Cloud</td>
                                    <td class="py-4 text-center fw-bold text-dark bg-transparent"
                                        style="font-size: 0.9rem;">Không giới hạn</td>
                                </tr>
                                <tr>
                                    <td class="py-4 ps-4 fw-bold text-dark bg-transparent" style="font-size: 0.9rem;">Hỗ
                                        trợ kỹ thuật</td>
                                    <td class="py-4 text-center text-secondary bg-transparent"
                                        style="font-size: 0.9rem;">Trung tâm trợ giúp</td>
                                    <td class="py-4 text-center fw-bold text-dark bg-transparent"
                                        style="font-size: 0.9rem;">Email & Chat</td>
                                    <td class="py-4 text-center fw-bold text-dark bg-transparent"
                                        style="font-size: 0.9rem;">24/7 Ưu tiên</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </section>


    </div>
</template>

<script>
import axios from 'axios';
const API = import.meta.env.VITE_API_URL;

export default {
    name: "TrangChu",
    data() {
        return {
            list_goi: [],
        }
    },
    mounted() {
        this.loadDataGoi();
    },
    methods: {
        loadDataGoi() {
            axios
                .get(API + '/goi/data')
                .then((res) => {
                    this.list_goi = res.data.data;
                });
        },

        formatVND(number) {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND',
            }).format(number);
        },
    }
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
