<template>
    <div class="trang-chinh-wrapper">
        <div class="d-flex vh-100 w-100 overflow-hidden"
            style="background-color: #f8fafc; font-family: 'Inter', sans-serif;">
            <!-- Left Sidebar -->
            <aside class="bg-white border-end d-flex flex-column flex-shrink-0" style="width: 260px;">
                <!-- Logo -->
                <div class="px-4 py-4 d-flex align-items-center mb-2">
                    <div class="d-flex justify-content-center align-items-center rounded-3 me-3 shadow-sm"
                        style="background-color: #ea580c; width: 44px; height: 44px;">
                        <i class="bx bx-camera-movie text-white fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bolder" style="color: #0f172a; font-size: 1.15rem; letter-spacing: -0.5px;">
                            AI-Meet</h5>

                        <small class="text-muted fw-medium" style="font-size: 0.75rem;">Video Intelligence</small>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="px-3 flex-grow-1 mt-2">
                    <ul class="nav nav-pills flex-column mb-auto gap-2">
                        <li class="nav-item">
                            <a href="#" @click.prevent="currentTab = 'dashboard'"
                                :class="['nav-link d-flex align-items-center fw-medium py-2 px-3 rounded-3', currentTab === 'dashboard' ? 'active-tab fw-bold' : 'text-dark text-muted-hover']">
                                <i class='bx bxs-dashboard me-3 fs-5'
                                    :style="currentTab === 'dashboard' ? '' : 'color: #64748b;'"></i> Bảng điều khiển
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" @click.prevent="currentTab = 'meetings'"
                                :class="['nav-link d-flex align-items-center fw-medium py-2 px-3 rounded-3', currentTab === 'meetings' ? 'active-tab fw-bold' : 'text-dark text-muted-hover']">
                                <i class='bx bx-camera-movie me-3 fs-5'
                                    :style="currentTab === 'meetings' ? '' : 'color: #64748b;'"></i> Cuộc họp
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="#" @click.prevent="currentTab = 'settings'"
                                :class="['nav-link d-flex align-items-center fw-medium py-2 px-3 rounded-3', currentTab === 'settings' ? 'active-tab fw-bold' : 'text-dark text-muted-hover']">
                                <i class='bx bx-cog me-3 fs-5'
                                    :style="currentTab === 'settings' ? '' : 'color: #64748b;'"></i> Cài đặt
                            </a>
                        </li>
                        <hr class="my-2 opacity-10">
                        <li class="nav-item" v-if="la_doi_tac">
                            <a href="/doi-tac/trang-chinh"
                                class="nav-link d-flex align-items-center fw-medium py-2 px-3 rounded-3 text-dark text-muted-hover animate__animated animate__pulse">
                                <i class='bx bxs-business me-3 fs-5 text-orange'></i> Quản trị Đối tác
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Pro Plan -->
                <div class="p-4 mt-auto">
                    <div class="p-3 rounded-4 pt-4 text-center"
                        style="background-color: #fff7ed; border: 1px solid #ffedd5;">
                        <div class="text-start mb-2">
                            <h6 class="fw-bolder mb-1"
                                style="color: #ea580c; font-size: 0.75rem; letter-spacing: 0.5px;">

                                GÓI Đối Tác</h6>
                            <p class="small text-muted mb-3 lh-sm"
                                style="font-size: 0.8rem; color: #64748b !important;">
                                Theo dõi khuôn mặt AI không giới hạn & lưu trữ.</p>
                        </div>
                        <router-link to="/nguoi-dung/danh-sach-goi" class="btn w-100 fw-bold text-white shadow-sm"
                            style="background-color: #ea580c; font-size: 0.85rem; padding: 10px 0; border-radius: 8px; text-decoration: none;">
                            Nâng cấp gói
                        </router-link>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-grow-1 d-flex flex-column overflow-hidden h-100">
                <!-- Topbar -->
                <header
                    class="bg-white border-bottom d-flex align-items-center justify-content-between px-4 p-xl-4 flex-shrink-0"
                    style="height: 80px;">
                    <!-- Search -->
                    <div class="position-relative" style="width: 380px;">
                        <i class='bx bx-search position-absolute top-50 translate-middle-y text-muted fs-5'
                            style="left: 16px; color: #94a3b8 !important;"></i>
                        <input type="text" class="form-control bg-light border-0 shadow-none ps-5"
                            placeholder="Tìm kiếm cuộc họp, bản ghi, hoặc người..."
                            style="border-radius: 12px; font-size: 0.95rem; padding-top: 12px; padding-bottom: 12px; color: #64748b;">
                    </div>

                    <!-- Right Actions -->
                    <div class="d-flex align-items-center gap-3">
                        <button
                            class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center bg-white border position-relative shadow-sm"
                            style="width: 44px; height: 44px; border-color: #e2e8f0 !important;">
                            <i class='bx bxs-bell fs-5' style="color: #334155;"></i>
                        </button>
                        <button
                            class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center bg-white border shadow-sm"
                            style="width: 44px; height: 44px; border-color: #e2e8f0 !important;">
                            <i class='bx bxs-message-square-dots fs-5' style="color: #334155;"></i>
                        </button>

                        <div class="position-relative border-start ms-2 ps-4 d-flex align-items-center"
                            style="border-color: #e2e8f0 !important;">

                            <div @click.stop="showDropdown = !showDropdown"
                                class="d-flex align-items-center user-profile-link" style="cursor: pointer;">
                                <div class="text-end me-3 d-none d-md-block">
                                    <h6 class="mb-0 fw-bolder" style="font-size: 0.95rem; color: #0f172a;">
                                        {{ ten_nguoi_dung }}
                                    </h6>

                                    <small v-if="da_xac_minh" class="fw-bold"
                                        style="font-size: 0.75rem; color: #ea580c;">
                                        <i class='bx bxs-check-shield'></i> Đã xác minh danh tính
                                    </small>
                                    <small v-else class="fw-bold" style="font-size: 0.75rem; color: #64748b;">
                                        <i class='bx bx-error-circle'></i> Chưa xác minh
                                    </small>
                                </div>

                                <img :src="avatar_url" alt="Profile" class="rounded-circle border border-2 shadow-sm"
                                    width="46" height="46"
                                    :style="{ borderColor: '#fff !important', outline: da_xac_minh ? '2px solid #ea580c' : '2px solid #cbd5e1' }">
                            </div>

                            <div v-if="showDropdown"
                                class="position-absolute end-0 bg-white shadow-lg border rounded-3 py-2 animate__animated animate__fadeInUp"
                                style="top: 120%; width: 180px; z-index: 1050; border-color: #f1f5f9 !important;">

                                <div class="px-3 py-2 border-bottom mb-1">
                                    <span class="text-muted"
                                        style="font-size: 0.7rem; text-transform: uppercase; font-weight: 700;">Tài
                                        khoản</span>
                                </div>

                                <button @click="dang_xuat"
                                    class="dropdown-item px-3 py-2 d-flex align-items-center text-danger fw-bold border-0 bg-transparent w-100 text-start">
                                    <i class="bx bx-log-out-circle me-2 fs-5"></i>
                                    <span>Đăng xuất</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!--  -->
                </header>

                <!-- Scrollable Content Area -->
                <div class="flex-grow-1 overflow-auto p-4 p-xl-5">
                    <div style="max-width: 1100px; margin: 0 auto;">

                        <!-- TAB: DASHBOARD -->
                        <div v-if="currentTab === 'dashboard'">
                            <!-- User Welcome Row -->
                            <div class="row mb-4">
                                <div class="col-md-6 d-flex flex-column justify-content-end">
                                    <h2 class="fw-bolder mb-2"
                                        style="color: #0f172a; letter-spacing: -0.5px; font-size: 2rem;">Chào mừng trở
                                        lại,
                                        {{ ten_nguoi_dung }}
                                    </h2>
                                    <p class="mb-0" style="font-size: 1rem; color: #64748b;">Bạn có <strong>3
                                            cuộc họp</strong> được lên lịch cho hôm nay.</p>
                                </div>
                                <div
                                    class="col-md-6 d-none d-md-flex flex-column justify-content-end align-items-end mb-1">
                                    <p class="text-muted fw-bold mb-1" style="font-size: 0.75rem; letter-spacing: 1px;">
                                        GIỜ ĐỊA PHƯƠNG</p>
                                    <h3 class="fw-bolder mb-0"
                                        style="color: #0f172a; font-size: 1.5rem; letter-spacing: -0.5px;">10:45 AM</h3>
                                </div>
                            </div>

                            <!-- Action Cards Row -->
                            <div class="row g-4 mb-5">
                                <!-- New Meeting -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card border-0 h-100 p-4 text-white shadow-sm d-flex flex-column"
                                        style="background-color: #ea580c; border-radius: 16px;">
                                        <div>
                                            <div class="d-flex justify-content-center align-items-center rounded mb-4 shadow-sm"
                                                style="background-color: rgba(255,255,255,0.25); width: 44px; height: 44px;">
                                                <i class="bx bx-video-plus fs-4"></i>
                                            </div>

                                            <h4 class="fw-bolder mb-2" style="font-size: 1.35rem;">Cuộc họp mới</h4>
                                            <p class="mb-4 text-white"
                                                style="font-size: 0.95rem; opacity: 0.9; line-height: 1.5;">Bắt đầu cuộc
                                                họp
                                                tức thì
                                                với theo dõi khuôn mặt AI đang hoạt động.</p>
                                        </div>
                                        <div class="mt-auto">
                                            <button @click="currentTab = 'meetings'"
                                                class="btn bg-white fw-bolder w-100 py-2"
                                                style="border-radius: 8px; color: #ea580c; font-size: 1rem;">Bắt đầu
                                                ngay</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Join Meeting -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card border-0 h-100 p-4 shadow-sm d-flex flex-column"
                                        style="background-color: #ffffff; border-radius: 16px; border: 1px solid #f1f5f9 !important;">
                                        <div>
                                            <div class="d-flex justify-content-center align-items-center rounded-3 mb-4 shadow-sm"
                                                style="background-color: #fff7ed; width: 44px; height: 44px;">
                                                <i class="bx bxs-keyboard fs-4" style="color: #ea580c;"></i>
                                            </div>

                                            <h4 class="fw-bolder mb-2 text-dark" style="font-size: 1.35rem;">Tham gia
                                                cuộc
                                                họp
                                            </h4>
                                            <p class="mb-4"
                                                style="font-size: 0.95rem; color: #64748b; line-height: 1.5;">
                                                Nhập ID cuộc họp hoặc liên kết để kết nối.</p>
                                        </div>
                                        <div class="d-flex mt-auto gap-3">
                                            <div class="flex-grow-1 position-relative">
                                                <input type="text" v-model="ma_phong_tham_gia"
                                                    class="form-control bg-light border-0 shadow-none h-100 ps-3 fw-medium"
                                                    placeholder="ID: 000-000-000"
                                                    style="font-size: 0.9rem; border-radius: 8px; color: #475569;"
                                                    @keyup.enter="kiemTraTruocKhiJoin">
                                            </div>
                                            <button @click="kiemTraTruocKhiJoin" :disabled="isJoining"
                                                class="btn text-white fw-bold px-4"
                                                style="background-color: #ea580c; border-radius: 8px;">
                                                <span v-if="isJoining" class="spinner-border spinner-border-sm"></span>
                                                <span v-else>Tham Gia</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Face ID Status -->
                                <div class="col-lg-4 col-md-12">
                                    <div class="card border-0 h-100 p-4 text-white shadow-sm position-relative overflow-hidden d-flex flex-column"
                                        style="background-color: #0f172a; border-radius: 16px;">
                                        <div class="d-flex justify-content-between align-items-start mb-4">
                                            <div>

                                                <h4 class="fw-bolder mb-2" style="font-size: 1.3rem;">Trạng thái Face ID
                                                </h4>
                                                <div v-if="da_xac_minh" class="d-flex align-items-center"
                                                    style="color: #ea580c;">
                                                    <i class='bx bxs-check-shield me-2 fs-5'></i>
                                                    <span class="fw-semibold small">Đã đồng bộ hoàn toàn</span>
                                                </div>
                                                <div v-else class="d-flex align-items-center text-muted">
                                                    <i class='bx bx-x-circle me-2 fs-5'></i>
                                                    <span class="fw-semibold small">Chưa đăng ký Face ID</span>
                                                </div>
                                            </div>
                                            <div class="rounded-3 overflow-hidden"
                                                style="width: 55px; height: 55px; background-color: #334155; border: 2px solid #334155;">
                                                <img v-if="da_xac_minh" :src="avatar_url"
                                                    class="w-100 h-100 object-fit-cover" alt="Face Scanned"
                                                    style="filter: contrast(1.1) brightness(0.9);">
                                                <i v-else class='bx bx-user'
                                                    style="font-size: 2rem; color: #94a3b8; display: flex; align-items: center; justify-content: center; height: 100%;"></i>
                                            </div>
                                        </div>

                                        <div class="mt-auto pt-2">
                                            <div class="progress mb-3 shadow-none"
                                                style="height: 6px; background-color: #334155; border-radius: 10px;">
                                                <div class="progress-bar rounded-pill" role="progressbar"
                                                    :style="{ width: da_xac_minh ? '100%' : '0%', backgroundColor: da_xac_minh ? '#ea580c' : 'transparent' }">
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-end">
                                                <div>
                                                    <p class="small mb-0 fw-medium"
                                                        style="color: #94a3b8; font-size: 0.75rem;">Điểm tin cậy:</p>
                                                    <h5 class="fw-bolder mb-0 mt-1"
                                                        :class="da_xac_minh ? 'text-white' : 'text-muted'">{{
                                                        da_xac_minh ? '100%' : '0%' }}</h5>
                                                </div>
                                                <a href="#" class="small text-decoration-none fw-semibold"
                                                    @click.prevent="currentTab = 'faceid'"
                                                    style="color: #ea580c; line-height: 1.3; text-align: right;">Quản
                                                    lý<br>Sinh trắc học</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Lists Row -->
                            <div class="row g-4">
                                <!-- Upcoming Meetings -->
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h4 class="fw-bolder mb-0 text-dark" style="font-size: 1.25rem;">Danh sách phòng họp đang diễn ra</h4>
                                        <button @click="getDanhSachPhongHop" class="btn btn-sm btn-light fw-bold text-muted"><i class='bx bx-refresh'></i> Làm mới</button>
                                    </div>

                                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0 border-0">
                                                <thead style="background-color: #f8fafc;">
                                                    <tr>
                                                        <th class="px-4 py-3 text-muted fw-bold border-bottom-0" style="font-size: 0.85rem;">PHÒNG HỌP</th>
                                                        <th class="px-4 py-3 text-muted fw-bold border-bottom-0" style="font-size: 0.85rem;">CHỦ PHÒNG</th>
                                                        <th class="px-4 py-3 text-muted fw-bold border-bottom-0" style="font-size: 0.85rem;">BẮT ĐẦU LÚC</th>
                                                        <th class="px-4 py-3 text-muted fw-bold border-bottom-0 text-end" style="font-size: 0.85rem;">THAO TÁC</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(v, k) in danh_sach_phong_hop.filter(p => p.thoi_gian_ket_thuc === null)" :key="k">
                                                        <td class="px-4 py-3 border-light">
                                                            <div class="d-flex align-items-center">
                                                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: #fff7ed; color: #ea580c;">
                                                                    <i class='bx bx-party fs-5'></i>
                                                                </div>
                                                                <div>
                                                                    <h6 class="mb-0 fw-bold text-dark">{{ v.ten_phong }}</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-4 py-3 fw-medium text-dark border-light">{{ v.chu_phong ? v.chu_phong.ho_va_ten : 'N/A' }}</td>
                                                        <td class="px-4 py-3 text-muted border-light">
                                                            {{ v.thoi_gian_bat_dau ? new Date(v.thoi_gian_bat_dau).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : '00:00' }}
                                                        </td>
                                                        <td class="px-4 py-3 text-end border-light">
                                                            <button @click="moModalNhapMaPhong()" class="btn text-white fw-bold px-4 py-2 shadow-sm animate__animated animate__pulse animate__infinite"
                                                                style="background-color: #ea580c; border-radius: 8px; font-size: 0.85rem;">Join</button>
                                                        </td>
                                                    </tr>
                                                    <tr v-if="danh_sach_phong_hop.filter(p => p.thoi_gian_ket_thuc === null).length === 0">
                                                        <td colspan="4" class="text-center py-5 text-muted border-light">
                                                            <div class="mb-3"><i class='bx bx-coffee fs-1' style="color: #cbd5e1;"></i></div>
                                                            Hiện không có cuộc họp nào đang diễn ra
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <h4 class="fw-bolder mb-3 mt-5 text-dark" style="font-size: 1.25rem;">Lịch họp sắp tới</h4>
                                    <div class="row g-4" v-if="chi_tiet_phong_hop.length > 0">
                                        <div class="col-md-6" v-for="phong in chi_tiet_phong_hop" :key="phong.id">
                                            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 12px;" :class="{'bg-white': phong.trang_thai_phong == 0}" :style="phong.trang_thai_phong == 0 ? 'border: 1px solid #f1f5f9 !important;' : ''">
                                                <div class="d-flex align-items-center h-100">
                                                    <div class="rounded-3 d-flex flex-column justify-content-center align-items-center px-3 py-2 me-4"
                                                        :style="phong.trang_thai_phong == 0 ? 'background-color: #f8fafc; min-width: 65px; opacity: 0.7;' : 'background-color: #f8fafc; min-width: 65px; border: 1px solid #f1f5f9;'">
                                                        <span class="fw-bolder"
                                                            :style="phong.trang_thai_phong == 0 ? 'color: #94a3b8; font-size: 1.15rem;' : 'color: #ea580c; font-size: 1.15rem;'">
                                                            {{ formatDay(phong.thoi_gian_bat_dau) }}
                                                        </span>
                                                        <span class="small fw-bolder text-muted"
                                                            style="font-size: 0.65rem;">{{ formatMonth(phong.thoi_gian_bat_dau) }}</span>
                                                    </div>
                                                    <div class="flex-grow-1 pe-3">
                                                        <h6 class="fw-bolder mb-1 text-dark"
                                                            style="font-size: 0.95rem;">{{ phong.ten_phong }}</h6>
                                                        <div class="d-flex align-items-center fw-medium mt-1"
                                                            style="color: #94a3b8; font-size: 0.8rem;">
                                                            <span>{{ formatTime(phong.thoi_gian_bat_dau) }}</span>
                                                            <span class="mx-2">•</span>
                                                            <span>ID: {{ phong.ma_phong }}</span>
                                                        </div>
                                                    </div>
                                                    <button v-if="phong.trang_thai_phong == 1" @click="thamGiaTuLich(phong.ma_phong)" class="btn text-white fw-bold px-4 py-2"
                                                        style="background-color: #ea580c; border-radius: 8px; font-size: 0.9rem;">Join</button>
                                                    <button v-else class="btn fw-semibold px-4 py-2 bg-white" disabled
                                                        style="border-radius: 8px; border: 1px solid #e2e8f0; color: #64748b; font-size: 0.9rem;">Đã kết thúc</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else class="text-center py-5">
                                        <div class="mb-3">
                                            <i class="bx bx-calendar-x fs-1 text-muted opacity-50"></i>
                                        </div>
                                        <p class="text-muted fw-medium">Bạn chưa có lịch họp nào sắp tới.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB: MEETINGS -->
                        <div v-if="currentTab === 'meetings'">
                            <h2 class="fw-bolder mb-5" style="color: #0f172a; letter-spacing: -0.5px; font-size: 2rem;">

                                Cuộc họp</h2>

                            <div class="row g-4">
                                <!-- Left Col: Create Room -->
                                <div class="col-lg-7">
                                    <div class="card border-0 shadow-sm p-4 p-md-5" style="border-radius: 16px;">
                                        <div class="d-flex align-items-center mb-5">
                                            <div class="d-flex justify-content-center align-items-center rounded me-3 shadow-sm"
                                                style="background-color: #fff7ed; width: 44px; height: 44px;">
                                                <i class="bx bx-calendar-check fs-4" style="color: #ea580c;"></i>
                                            </div>

                                            <h4 class="fw-bolder mb-0 text-dark" style="font-size: 1.35rem;">Tạo phòng
                                                họp
                                            </h4>
                                        </div>

                                        <form @submit.prevent="taoPhongHop">
                                            <div class="mb-4">
                                                <label class="form-label fw-bold mb-2 text-muted"
                                                    style="font-size: 0.75rem; letter-spacing: 1px;">TIÊU ĐỀ CUỘC
                                                    HỌP</label>
                                                <input type="text" v-model="formTaoPhong.ten_phong" required
                                                    class="form-control form-control-lg bg-light border-0 shadow-none px-3 py-3"
                                                    placeholder="ví dụ, Đồng bộ nhóm hàng tuần"
                                                    style="border-radius: 12px; font-size: 0.95rem; color: #475569;">
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label fw-bold mb-2 text-muted"
                                                    style="font-size: 0.75rem; letter-spacing: 1px;">MÔ TẢ</label>
                                                <textarea v-model="formTaoPhong.mo_ta"
                                                    class="form-control form-control-lg bg-light border-0 shadow-none px-3 py-3"
                                                    rows="4"
                                                    placeholder="Phác thảo chương trình nghị sự cuộc họp hoặc mục tiêu..."
                                                    style="border-radius: 12px; font-size: 0.95rem; color: #475569; resize: none;"></textarea>
                                            </div>
                                            <div class="mb-5">
                                                <div class="d-flex justify-content-between">
                                                    <label class="form-label fw-bold mb-2 text-muted"
                                                        style="font-size: 0.75rem; letter-spacing: 1px;">MỜI NGƯỜI THAM
                                                        GIA</label>
                                                    <button type="submit" class="btn btn-sm" style="background-color: rgba(234, 88, 12, 0.1); color: #ea580c; border: 1px solid #ea580c; border-radius: 6px; font-weight: 600;">
                                                        <i class='bx bx-paper-plane me-1'></i>Mời Người
                                                    </button>
                                                </div>
                                                <div class="position-relative">
                                                    <i class='bx bx-at position-absolute top-50 translate-middle-y fs-5'
                                                        style="left: 1rem; color: #94a3b8;"></i>
                                                    <input type="text" v-model="formTaoPhong.email_khach_moi"
                                                        @input="handleEmailInput"
                                                        class="form-control form-control-lg bg-light border-0 shadow-none ps-5 py-3"
                                                        placeholder="Thêm địa chỉ email được phân tách bằng dấu phẩy"
                                                        style="border-radius: 12px; font-size: 0.95rem; color: #475569;">

                                                    <!-- Dropdown kết quả tìm kiếm -->
                                                    <ul v-if="searchResults.length > 0"
                                                        class="dropdown-menu show w-100 position-absolute shadow-lg border-0 mt-1"
                                                        style="top: 100%; z-index: 1000; max-height: 250px; overflow-y: auto; border-radius: 12px;">
                                                        <li v-for="user in searchResults" :key="user.id">
                                                            <a class="dropdown-item d-flex align-items-center py-2 px-3"
                                                                href="#" @click.prevent="selectEmail(user.email)">
                                                                <div class="rounded-circle bg-secondary me-3 d-flex align-items-center justify-content-center"
                                                                    style="width: 36px; height: 36px; overflow: hidden;">
                                                                    <img v-if="user.avatar" :src="user.avatar"
                                                                        class="w-100 h-100 object-fit-cover">
                                                                    <i v-else class="bx bx-user text-white fs-5"></i>
                                                                </div>
                                                                <div>
                                                                    <div class="fw-bold"
                                                                        style="font-size: 0.9rem; color: #1e293b;">{{
                                                                        user.ho_va_ten }}</div>
                                                                    <div class="text-muted" style="font-size: 0.8rem;">
                                                                        {{ user.email }}</div>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <button type="submit"
                                                class="btn text-white fw-bold px-4 py-3 d-flex justify-content-center align-items-center"
                                                :disabled="isCreating"
                                                style="background-color: #ea580c; border-radius: 8px; font-size: 1rem; min-width: 180px;">
                                                <span v-if="isCreating"
                                                    class="spinner-border spinner-border-sm me-2"></span>
                                                {{ isCreating ? 'Đang khởi tạo...' : 'Tạo cuộc họp' }}
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Right Col: Join Card -->
                                <div class="col-lg-5">
                                    <div class="card border-0 shadow-sm p-4 p-md-5 text-center h-100 d-flex flex-column justify-content-center"
                                        style="border-radius: 16px;">
                                        <div class="mb-4">
                                            <div class="d-flex justify-content-center align-items-center rounded-3 mx-auto mb-3 shadow-sm"
                                                style="background-color: #fff7ed; width: 56px; height: 56px;">
                                                <i class="bx bxs-keyboard fs-3" style="color: #ea580c;"></i>
                                            </div>
                                            <h4 class="fw-bolder mb-2 text-dark">Tham gia cuộc họp</h4>
                                            <p class="text-muted small">Nhập mã phòng để kết nối ngay lập tức.</p>
                                        </div>
                                        <div class="mt-2">
                                            <div class="d-flex gap-3 mb-3">
                                                <div class="flex-grow-1">
                                                    <input type="text" v-model="ma_phong_tham_gia"
                                                        class="form-control form-control-lg bg-light border-0 shadow-none ps-3 fw-medium"
                                                        placeholder="Mã phòng..."
                                                        style="font-size: 1rem; border-radius: 12px; height: 56px; color: #475569;">
                                                </div>
                                            </div>
                                            <button @click="kiemTraTruocKhiJoin" :disabled="isJoining"
                                                class="btn text-white fw-bold w-100 py-3"
                                                style="background-color: #ea580c; border-radius: 10px; font-size: 1.1rem;">
                                                <span v-if="isJoining"
                                                    class="spinner-border spinner-border-sm me-2"></span>
                                                <span v-else>Tham gia ngay</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB: SETTINGS -->
                        <div v-if="currentTab === 'settings'">
                            <h2 class="fw-bolder mb-1" style="color: #0f172a; letter-spacing: -0.5px; font-size: 2rem;">

                                Cài đặt</h2>
                            <p class="mb-5" style="color: #64748b; font-size: 0.95rem;">Quản lý hồ sơ, bảo mật và
                                tùy chọn xác thực sinh trắc học của bạn.</p>

                            <!-- Profile Information -->
                            <!-- Avatar Upload Section -->
                            <div class="row mb-5 align-items-center">
                                <div class="col-auto">
                                    <div class="position-relative">
                                        <img :src="avatar_preview || avatar_url" alt="Profile"
                                            class="rounded-circle border border-4 shadow-sm" width="100" height="100"
                                            style="border-color: #fff !important; outline: 2px solid #ea580c; object-fit: cover;">
                                        <button @click="$refs.avatarInput.click()"
                                            class="btn btn-sm btn-dark position-absolute bottom-0 end-0 rounded-circle d-flex align-items-center justify-content-center shadow"
                                            style="width: 32px; height: 32px; border: 2px solid #fff;">
                                            <i class="bx bx-camera fs-6"></i>
                                        </button>
                                        <input type="file" ref="avatarInput" @change="handleAvatarChange" class="d-none"
                                            accept="image/*">
                                    </div>
                                </div>
                                <div class="col">
                                    <h6 class="fw-bold mb-1 text-dark">Ảnh đại diện</h6>
                                    <p class="text-muted small mb-0">Hỗ trợ JPG, PNG. Kích thước tối đa 2MB.</p>
                                    <button v-if="avatar_file" @click="capNhatAvatar" :disabled="isUploadingAvatar"
                                        class="btn btn-sm text-white fw-bold px-3 py-1 mt-2 animate__animated animate__fadeIn"
                                        style="background-color: #ea580c; border-radius: 8px; font-size: 0.8rem;">
                                        <span v-if="isUploadingAvatar"
                                            class="spinner-border spinner-border-sm me-1"></span>
                                        Xác nhận lưu
                                    </button>
                                </div>
                            </div>

                            <!-- Profile Information -->
                            <div class="card border-0 shadow-sm p-4 p-md-5 mb-4" style="border-radius: 16px;">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="d-flex justify-content-center align-items-center rounded me-3"
                                        style="background-color: #fff7ed; width: 36px; height: 36px;">
                                        <i class="bx bxs-user fs-5" style="color: #ea580c;"></i>
                                    </div>

                                    <h5 class="fw-bolder mb-0 text-dark">Thông tin hồ sơ</h5>
                                </div>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small mb-2" style="color: #334155;">Họ và
                                            tên
                                            đầy đủ</label>
                                        <input type="text" v-model="settings.ho_va_ten"
                                            class="form-control form-control-lg bg-light border-0 shadow-none px-3"
                                            placeholder="Họ và tên"
                                            style="border-radius: 10px; font-size: 0.95rem; color: #475569;">
                                    </div>
                                    <div class="col-md-6">

                                        <label class="form-label fw-semibold small mb-2" style="color: #334155;">Địa chỉ
                                            email</label>
                                        <input type="email" v-model="settings.email"
                                            class="form-control form-control-lg bg-light border-0 shadow-none px-3"
                                            placeholder="Email"
                                            style="border-radius: 10px; font-size: 0.95rem; color: #475569;">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button @click="capNhatHoSo" :disabled="isUpdatingProfile"
                                        class="btn text-white fw-bold px-4 py-2"
                                        style="background-color: #ea580c; border-radius: 10px; font-size: 0.95rem;">
                                        <span v-if="isUpdatingProfile"
                                            class="spinner-border spinner-border-sm me-2"></span>
                                        Cập nhật hồ sơ
                                    </button>
                                </div>
                            </div>

                            <!-- Security -->
                            <div class="card border-0 shadow-sm p-4 p-md-5 mb-4" style="border-radius: 16px;">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="d-flex justify-content-center align-items-center rounded me-3"
                                        style="background-color: #fff7ed; width: 36px; height: 36px;">
                                        <i class="bx bxs-lock fs-5" style="color: #ea580c;"></i>
                                    </div>

                                    <h5 class="fw-bolder mb-0 text-dark">Bảo mật</h5>
                                </div>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold small mb-2" style="color: #334155;">Mật
                                            khẩu
                                            hiện tại</label>
                                        <input type="password" v-model="settings.current_password"
                                            class="form-control form-control-lg bg-light border-0 shadow-none px-3"
                                            placeholder="••••••••"
                                            style="border-radius: 10px; font-size: 0.95rem; letter-spacing: 2px;">
                                    </div>
                                    <div class="col-md-4">

                                        <label class="form-label fw-semibold small mb-2" style="color: #334155;">Mật
                                            khẩu
                                            mới</label>
                                        <input type="password" v-model="settings.new_password"
                                            class="form-control form-control-lg bg-light border-0 shadow-none px-3"
                                            placeholder="••••••••"
                                            style="border-radius: 10px; font-size: 0.95rem; letter-spacing: 2px;">
                                    </div>
                                    <div class="col-md-4">

                                        <label class="form-label fw-semibold small mb-2" style="color: #334155;">Xác
                                            nhận
                                            mật khẩu</label>
                                        <input type="password" v-model="settings.confirm_password"
                                            class="form-control form-control-lg bg-light border-0 shadow-none px-3"
                                            placeholder="••••••••"
                                            style="border-radius: 10px; font-size: 0.95rem; letter-spacing: 2px;">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button @click="doiMatKhau" :disabled="isChangingPassword"
                                        class="btn text-white fw-bold px-4 py-2"
                                        style="background-color: #ea580c; border-radius: 10px; font-size: 0.95rem;">
                                        <span v-if="isChangingPassword"
                                            class="spinner-border spinner-border-sm me-2"></span>
                                        Thay đổi mật khẩu
                                    </button>
                                </div>
                            </div>

                            <!-- AI Face ID -->
                            <div class="card border-0 shadow-sm p-4 p-md-5" style="border-radius: 16px;">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="d-flex justify-content-center align-items-center rounded me-3"
                                        style="background-color: #fff7ed; width: 36px; height: 36px;">
                                        <i class="bx bx-face fs-5" style="color: #ea580c;"></i>
                                    </div>
                                    <h5 class="fw-bolder mb-0 text-dark">Xác thực Face ID AI</h5>
                                </div>

                                <div class="row align-items-center g-4">
                                    <template v-if="da_xac_minh">
                                        <div class="col-12 text-center py-4">
                                            <div class="position-relative d-inline-block mb-4">
                                                <div class="rounded-circle d-flex justify-content-center align-items-center shadow-sm"
                                                    style="width: 150px; height: 150px; background-color: #f0fdf4; border: 2px solid #bbf7d0;">
                                                    <i class="bx bx-check-double"
                                                        style="font-size: 5rem; color: #22c55e;"></i>
                                                </div>
                                                <div class="position-absolute bottom-0 end-0 bg-success rounded-circle d-flex justify-content-center align-items-center border border-3 border-white"
                                                    style="width: 40px; height: 40px;">
                                                    <i class="bx bxs-shield-alt-2 text-white"></i>
                                                </div>
                                            </div>

                                            <h3 class="fw-bolder text-dark mb-2">Tài khoản đã xác thực</h3>
                                            <p class="text-muted mx-auto mb-4" style="max-width: 500px;">
                                                Hệ thống AI đã ghi nhận mẫu khuôn mặt của bạn. Danh tính của bạn hiện đã
                                                được bảo vệ và sẵn sàng cho các cuộc họp bảo mật.
                                            </p>

                                            <span class="badge px-4 py-2 fw-bold"
                                                style="background-color: #dcfce7; color: #15803d; border-radius: 30px; font-size: 0.85rem;">
                                                <i class="bx bxs-lock-alt me-1"></i> Mã hóa sinh trắc học
                                            </span>
                                        </div>
                                    </template>

                                    <template v-else>
                                        <div class="col-md-5 d-flex justify-content-center">
                                            <div class="position-relative d-flex justify-content-center align-items-center"
                                                style="width: 200px; height: 200px;">
                                                <template v-if="!isScanning">
                                                    <div class="position-absolute rounded-circle"
                                                        style="width: 200px; height: 200px; border: 2px solid #fed7aa; background: #fff7ed;">
                                                    </div>
                                                    <div class="position-absolute rounded-circle d-flex justify-content-center align-items-center"
                                                        style="width: 150px; height: 150px; background: #f1f5f9;">
                                                        <i class="bx bx-user"
                                                            style="font-size: 4rem; color: #cbd5e1;"></i>
                                                    </div>
                                                    <div class="position-absolute bottom-0 bg-dark text-white px-3 py-1 rounded-pill"
                                                        style="font-size: 0.7rem; font-weight: 700; letter-spacing: 1px; margin-bottom: 8px;">
                                                        SẴN SÀNG QUÉT
                                                    </div>
                                                </template>

                                                <template v-else>
                                                    <video ref="videoElement" autoplay muted playsinline
                                                        style="width: 200px; height: 200px; border-radius: 50%; object-fit: cover; border: 4px solid #ea580c; transform: scaleX(-1); z-index: 10;">
                                                    </video>
                                                    <canvas ref="overlayCanvas"
                                                        style="position: absolute; top: 0; left: 0; width: 200px; height: 200px; border-radius: 50%; z-index: 11; pointer-events: none;">
                                                    </canvas>
                                                    <div class="scan-line-circle"></div>
                                                </template>
                                            </div>
                                            <div class="mt-3 text-center" style="min-height: 24px;">
                                                <small v-if="isScanning" class="status-text-anim"
                                                    :style="{ color: isScanning ? '#ea580c' : '#64748b' }">
                                                    <i class='bx bx-loader-alt bx-spin me-1'></i>
                                                    {{ scanStatus }}
                                                </small>
                                            </div>
                                        </div>

                                        <div class="col-md-7">
                                            <span class="badge mb-3 fw-bold px-3 py-2"
                                                style="background-color: #fef9c3; color: #854d0e; font-size: 0.75rem; border-radius: 20px;">
                                                <i class="bx bxs-circle me-1"
                                                    style="font-size: 0.5rem; vertical-align: middle; color: #ca8a04;"></i>
                                                Yêu cầu xác thực
                                            </span>
                                            <h4 class="fw-bolder mb-2"
                                                style="color: #0f172a; font-size: 1.3rem; line-height: 1.3;">
                                                Bảo mật cuộc họp với Face ID AI
                                            </h4>
                                            <p class="mb-4"
                                                style="color: #64748b; font-size: 0.9rem; line-height: 1.6;">
                                                Vui lòng xác thực khuôn mặt để kích hoạt các tính năng bảo mật nâng cao
                                                và tham gia phòng họp nhanh.
                                            </p>

                                            <div class="d-flex gap-2">
                                                <button @click="startFaceScan"
                                                    class="btn text-white fw-bold px-4 py-3 d-inline-flex align-items-center gap-2"
                                                    style="background-color: #0f172a; border-radius: 10px; font-size: 0.95rem;">
                                                    <i class="bx bx-scan fs-5"></i> Bắt đầu quét khuôn mặt
                                                </button>
                                                <button v-if="isScanning" @click="stopFaceScan"
                                                    class="btn btn-outline-danger fw-bold px-4 py-3"
                                                    style="border-radius: 10px;">
                                                    Dừng quét
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </main>
        </div>
        <!-- Modal xác thực khuôn mặt -->
        <div v-if="showJoinAuthModal"
            class="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center z-3"
            style="background-color: rgba(15, 23, 42, 0.95); backdrop-filter: blur(10px);">
            <div class="card border-0 shadow-lg p-4 text-center animate__animated animate__fadeInUp"
                style="border-radius: 24px; width: 420px; background-color: #1e293b; border: 1px solid #334155 !important;">
                <template v-if="!isMatched">
                    <h4 class="text-white fw-bolder mb-3">Xác nhận danh tính</h4>
                    <p class="text-secondary small mb-4">Hệ thống đang đối chiếu sinh trắc học để bảo mật cuộc họp.</p>

                    <div class="position-relative mx-auto mb-4" style="width: 220px; height: 220px;">
                        <video ref="authVideo" autoplay muted playsinline
                            class="w-100 h-100 rounded-circle object-fit-cover shadow-lg"
                            :style="{ border: authError ? '4px solid #ef4444' : '4px solid #ea580c', transform: 'scaleX(-1)' }"></video>
                        <div v-if="!authError" class="scan-line-circle"></div>
                    </div>

                    <div class="mb-4" style="min-height: 24px;">
                        <p class="fw-bold mb-0" :style="{ color: authError ? '#ef4444' : '#ea580c' }">
                            <i v-if="authError" class='bx bx-error-circle fs-5 align-middle me-1'></i>
                            <i v-else class='bx bx-loader-alt bx-spin fs-5 align-middle me-1'></i>
                            {{ authScanStatus }}
                        </p>
                    </div>

                    <button @click="dongModalXacThucJoin"
                        class="btn btn-link text-secondary text-decoration-none fw-medium">
                        Hủy bỏ
                    </button>
                </template>

                <template v-else>
                    <div class="py-4 animate__animated animate__zoomIn">
                        <div class="mx-auto mb-4 d-flex justify-content-center align-items-center rounded-circle"
                            style="width: 100px; height: 100px; background-color: #f0fdf4;">
                            <i class='bx bxs-check-shield' style="font-size: 4rem; color: #22c55e;"></i>
                        </div>

                        <h3 class="text-white fw-bolder mb-2">Xác thực thành công!</h3>
                        <p class="text-secondary mb-4">Chào mừng <b>{{ ten_nguoi_dung }}</b>. Hệ thống đã xác nhận danh
                            tính của bạn.</p>

                        <div class="d-grid gap-2">
                            <button @click="thamGiaPhongHop" :disabled="isJoining"
                                class="btn text-white fw-bold py-3 shadow-lg"
                                style="background-color: #ea580c; border-radius: 12px; font-size: 1.1rem;">
                                <span v-if="isJoining" class="spinner-border spinner-border-sm me-2"></span>
                                <template v-else><i class='bx bx-video me-2'></i> Tham gia phòng họp</template>
                            </button>
                            <button @click="dongModalXacThucJoin"
                                class="btn btn-link text-secondary text-decoration-none small">
                                Để sau
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
    <!-- Modal Hiển thị mã phòng -->
    <div v-if="showRoomModal"
        class="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center z-3"
        style="background-color: rgba(15, 23, 42, 0.85); backdrop-filter: blur(5px);">
        <div class="card border-0 shadow-lg p-4 text-center animate__animated animate__zoomIn"
            style="border-radius: 20px; width: 400px; background-color: #ffffff;">
            <div class="mx-auto mb-3 d-flex justify-content-center align-items-center rounded-circle"
                style="width: 80px; height: 80px; background-color: #fff7ed;">
                <i class='bx bx-party' style="font-size: 3rem; color: #ea580c;"></i>
            </div>
            <h4 class="fw-bolder mb-2 text-dark">Tạo thành công!</h4>
            <p class="text-muted small mb-4">Mã phòng họp của bạn đã sẵn sàng. Hãy copy mã này để tham gia.</p>

            <div class="d-flex align-items-center justify-content-between p-3 rounded-3 mb-4"
                style="background-color: #f8fafc; border: 1px dashed #cbd5e1;">
                <span class="fw-bolder fs-5" style="color: #0f172a; letter-spacing: 2px;">{{ createdRoomCode }}</span>
                <button @click="copyRoomCode" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-bold">
                    <i class='bx bx-copy me-1'></i> Copy
                </button>
            </div>

            <button @click="showRoomModal = false" class="btn text-white w-100 fw-bold py-2"
                style="background-color: #ea580c; border-radius: 10px;">
                Đóng
            </button>
        </div>
    </div>

    <!-- Modal Nhập mã phòng để Join -->
    <div v-if="showJoinInputModal"
        class="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center z-3"
        style="background-color: rgba(15, 23, 42, 0.85); backdrop-filter: blur(5px);">
        <div class="card border-0 shadow-lg p-4 text-center animate__animated animate__zoomIn"
            style="border-radius: 20px; width: 400px; background-color: #ffffff;">
            <div class="mx-auto mb-3 d-flex justify-content-center align-items-center rounded-circle"
                style="width: 80px; height: 80px; background-color: #fff7ed;">
                <i class='bx bxs-keyboard' style="font-size: 3rem; color: #ea580c;"></i>
            </div>
            <h4 class="fw-bolder mb-2 text-dark">Tham gia cuộc họp</h4>
            <p class="text-muted small mb-4">Vui lòng nhập mã phòng để tham gia cuộc họp này.</p>

            <div class="mb-4">
                <input type="text" v-model="roomCodeToJoin" class="form-control form-control-lg text-center fw-bold"
                    placeholder="Nhập mã phòng..."
                    style="border-radius: 12px; border: 2px solid #ea580c; color: #0f172a; letter-spacing: 2px;"
                    @keyup.enter="xacNhanJoin">
            </div>

            <div class="d-flex gap-2">
                <button @click="showJoinInputModal = false" class="btn btn-light w-100 fw-bold py-2"
                    style="border-radius: 10px;">
                    Hủy
                </button>
                <button @click="xacNhanJoin" class="btn text-white w-100 fw-bold py-2"
                    style="background-color: #ea580c; border-radius: 10px;">
                    Tham gia
                </button>
            </div>
        </div>
    </div>
</template>

<script>
const apiUrl = import.meta.env.VITE_API_URL;
import * as faceapi from 'face-api.js';
import axios from 'axios';

export default {
    name: 'TrangChinhNguoiDung',
    components: {
    },
    data() {
        return {
            currentTab: 'dashboard',
            user: {
                ho_va_ten: '',
                email: '',
                hinh_anh: ''
            },
            dem_thoi_gian: 0, // Biến đếm thời gian quét
            giay_can_thiet: 15,
            settings: {
                ho_va_ten: '',
                email: '',
                current_password: '',
                new_password: '',
                confirm_password: '',
            },
            formTaoPhong: {
                ten_phong: '',
                mo_ta: '',
                email_khach_moi: ''
            },
            isCreating: false,
            isUploadingAvatar: false,
            isChangingPassword: false,
            isUpdatingProfile: false,
            avatar_url: 'https://images.unsplash.com/photo-1599566150163-29194dcaad36?auto=format&fit=crop&w=150&q=80',
            avatar_file: null,
            avatar_preview: null,
            ma_phong_tham_gia: '', // Lưu mã phòng người dùng nhập vào
            isJoining: false,
            // --- Khối 1: Các biến trạng thái AI ---
            isScanning: false, // Dang quet hay khong
            scanStatus: '', // Dong chu thong bao trang thai
            detectedFaces: 0, // So luong mat phat hien duoc
            faceSaved: false, // Da luu mat len server chua
            luong_video: null, // Luu tru media stream tu webcam
            vong_lap_nhan_dien: null, // Dung de dung setInterval khi thoi quet
            da_xac_minh_phu: false,
            showDropdown: false,
            // --- Khối 7: Modal Xác thực trước khi Join vào phòng ---
            showJoinAuthModal: false,
            authScanStatus: 'Đang khởi động camera...',
            authError: false,
            authStream: null,
            authInterval: null,
            isMatched: false, // biến này để tránh quét trúng nhiều lần
            list_goi: [],
            chi_tiet_phong_hop: [],
            danh_sach_phong_hop: [],
            showRoomModal: false,
            createdRoomCode: '',
            showJoinInputModal: false,
            roomCodeToJoin: '',
            searchResults: [],
            searchTimeout: null,
        }
    },
    mounted() {
        this.layThongTinHoSo();
        const user = JSON.parse(localStorage.getItem('thong_tin_user'));
        if (user && user.du_lieu_khuon_mat) {
            this.da_xac_minh_phu = true;
        }
        // Đóng dropdown khi click ra ngoài
        window.addEventListener('click', () => {
            this.showDropdown = false;
        });
        this.getGoi();
        this.getChiTietPhongHop();
        this.getDanhSachPhongHop();
    },
    computed: {
        id_nguoi_dung() {
            // Lấy chuỗi JSON từ localStorage
            const user_data = localStorage.getItem('thong_tin_user');
            if (user_data) {
                try {
                    // Chuyển chuỗi JSON thành object và trả về id
                    const user = JSON.parse(user_data);
                    return user.id;
                } catch (e) {
                    console.error('Lỗi đọc dữ liệu người dùng:', e);
                    return null; // Trả về null thay vì 1 để an toàn
                }
            }
            return null; // Nếu chưa đăng nhập
        },
        // 1. Lấy toàn bộ thông tin người dùng từ LocalStorage
        thong_tin_dang_nhap() {
            const du_lieu = localStorage.getItem('thong_tin_user');
            return du_lieu ? JSON.parse(du_lieu) : null;
        },

        // 2. Lấy tên người dùng
        ten_nguoi_dung() {
            return this.thong_tin_dang_nhap ? this.thong_tin_dang_nhap.ho_va_ten : 'Khách';
        },

        // 3. Kiểm tra xem người dùng đã có dữ liệu khuôn mặt hay chưa
        da_xac_minh() {
            // Nếu cột du_lieu_khuon_mat không trống (null) thì coi như đã xác minh
            // Vue sẽ tự động theo dõi biến da_xac_minh_phu
            return this.da_xac_minh_phu;
        },
        // 4. Kiểm tra quyền Đối tác
        la_doi_tac() {
            return this.thong_tin_dang_nhap ? (!!this.thong_tin_dang_nhap.id_doi_tac) : false;
        }
    },
    methods: {
        moModalNhapMaPhong() {
            this.roomCodeToJoin = '';
            this.showJoinInputModal = true;
        },
        xacNhanJoin() {
            if (!this.roomCodeToJoin.trim()) {
                if(this.$toast) this.$toast.warning("Vui lòng nhập mã phòng!");
                return;
            }
            this.ma_phong_tham_gia = this.roomCodeToJoin;
            this.showJoinInputModal = false;
            this.kiemTraTruocKhiJoin();
        },
        async handleEmailInput() {
            const emails = this.formTaoPhong.email_khach_moi.split(',');
            const lastPart = emails[emails.length - 1].trim();

            if (lastPart.length < 2) {
                this.searchResults = [];
                return;
            }

            if (this.searchTimeout) clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(async () => {
                try {
                    const response = await axios.post(`${apiUrl}/nguoi-dung/tim-kiem`, { keyword: lastPart });
                    if (response.data.status) {
                        // Lọc bỏ những email đã được chọn
                        const selectedEmails = emails.slice(0, -1).map(e => e.trim().toLowerCase()).filter(e => e.length > 0);
                        this.searchResults = response.data.data.filter(u =>
                            !selectedEmails.includes(u.email.toLowerCase())
                        );
                    }
                } catch (error) {
                    console.error("Lỗi tìm kiếm email:", error);
                }
            }, 300);
        },
        selectEmail(email) {
            const emails = this.formTaoPhong.email_khach_moi.split(',');
            emails.pop(); // Xóa chuỗi đang gõ dở

            // Thêm email đã chọn vào mảng và chuẩn hóa chuỗi
            const cleanedEmails = emails.map(e => e.trim()).filter(e => e.length > 0);
            cleanedEmails.push(email);

            this.formTaoPhong.email_khach_moi = cleanedEmails.join(', ') + ', ';
            this.searchResults = [];
        },
        copyRoomCode() {
            navigator.clipboard.writeText(this.createdRoomCode).then(() => {
                if (this.$toast) this.$toast.success("Đã copy mã phòng!");
            }).catch(err => {
                console.error('Lỗi khi copy', err);
            });
        },
        getChiTietPhongHop() {
            const user = JSON.parse(localStorage.getItem('thong_tin_user'));
            if (!user) return;

            axios
                .get(`${apiUrl}/chi-tiet-phong-hop/data`, {
                    params: {
                        id_nguoi_dung: user.id
                    }
                })
                .then((res) => {
                    if (res.data.status) {
                        this.chi_tiet_phong_hop = res.data.data
                    }
                    else {
                        this.$toast.info(res.data.message)
                    }
                })
                .catch((err) => {
                    console.error("Lỗi lấy chi tiết phòng họp:", err);
                    this.$toast.error("Không thể tải chi tiết phòng họp.");
                });
        },
        formatDay(dateStr) {
            if (!dateStr) return '--';
            const d = new Date(dateStr);
            return d.getDate().toString().padStart(2, '0');
        },
        formatMonth(dateStr) {
            if (!dateStr) return 'MON';
            const d = new Date(dateStr);
            const months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
            return months[d.getMonth()];
        },
        formatTime(dateStr) {
            if (!dateStr) return '--:--';
            const d = new Date(dateStr);
            return d.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        },
        thamGiaTuLich(ma_phong) {
            this.ma_phong_tham_gia = ma_phong;
            this.kiemTraTruocKhiJoin();
        },
        getGoi() {
            axios
                .get(`${apiUrl}/goi/data`)
                .then((res) => {
                    if (res.data.status) {
                        this.list_goi = res.data.data
                    }
                    else {
                        this.$toast.info(res.data.message)
                    }
                })
        },
        getDanhSachPhongHop() {
            axios
                .get(`${apiUrl}/phong-hop/data`)
                .then((res) => {
                    if (res.data.status) {
                        // Lọc chỉ lấy những phòng có trạng thái 1 (đang hoạt động)
                        this.danh_sach_phong_hop = res.data.data.filter(phong => phong.trang_thai == 1);
                    }
                    else {
                        this.$toast.info(res.data.message)
                    }
                })
                .catch((err) => {
                    console.error("Lỗi lấy danh sách phòng họp:", err);
                });
        },
        dang_xuat() {
            localStorage.removeItem('token_nguoi_dung');
            localStorage.removeItem('thong_tin_user');

            if (this.$toast) {
                this.$toast.success("Đã đăng xuất");
            }

            this.$router.push('/');
        },
        async layThongTinHoSo() {
            try {
                const token = localStorage.getItem('token_nguoi_dung');
                if (!token) return;

                const response = await axios.get(`${apiUrl}/nguoi-dung/profile`, {
                    headers: { Authorization: `Bearer ${token}` }
                });

                if (response.data.status) {
                    const data = response.data.data;
                    this.settings.ho_va_ten = data.ho_va_ten;
                    this.settings.email = data.email;
                    this.user.ho_va_ten = data.ho_va_ten;
                    this.user.email = data.email;
                    if (data.avatar) {
                        this.avatar_url = data.avatar;
                    }
                }
            } catch (error) {
                console.error("Lỗi lấy thông tin hồ sơ:", error);
            }
        },
        handleAvatarChange(event) {
            const file = event.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    if (this.$toast) this.$toast.error("Ảnh không được vượt quá 2MB!");
                    return;
                }
                this.avatar_file = file;
                this.avatar_preview = URL.createObjectURL(file);
            }
        },
        async capNhatAvatar() {
            if (!this.avatar_file) return;

            this.isUploadingAvatar = true;
            try {
                const token = localStorage.getItem('token_nguoi_dung');
                const formData = new FormData();
                formData.append('avatar', this.avatar_file);

                const response = await axios.post(`${apiUrl}/nguoi-dung/update-avatar`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        Authorization: `Bearer ${token}`
                    }
                });

                if (response.data.status) {
                    this.avatar_url = response.data.avatar;
                    this.avatar_file = null;
                    this.avatar_preview = null;
                    if (this.$toast) this.$toast.success("Cập nhật ảnh đại diện thành công!");
                }
            } catch (error) {
                console.error("Lỗi cập nhật ảnh:", error);
                if (this.$toast) this.$toast.error("Không thể cập nhật ảnh đại diện.");
            } finally {
                this.isUploadingAvatar = false;
            }
        },
        async doiMatKhau() {
            if (!this.settings.current_password || !this.settings.new_password || !this.settings.confirm_password) {
                if (this.$toast) this.$toast.warning("Vui lòng nhập đầy đủ thông tin mật khẩu!");
                return;
            }

            this.isChangingPassword = true;
            try {
                const token = localStorage.getItem('token_nguoi_dung');
                const response = await axios.post(`${apiUrl}/nguoi-dung/change-password`, {
                    current_password: this.settings.current_password,
                    new_password: this.settings.new_password,
                    confirm_password: this.settings.confirm_password
                }, {
                    headers: { Authorization: `Bearer ${token}` }
                });

                if (response.data.status) {
                    if (this.$toast) this.$toast.success("Đổi mật khẩu thành công!");
                    // Reset fields
                    this.settings.current_password = '';
                    this.settings.new_password = '';
                    this.settings.confirm_password = '';
                }
            } catch (error) {
                let message = "Có lỗi xảy ra khi đổi mật khẩu.";
                if (error.response && error.response.data && error.response.data.message) {
                    message = error.response.data.message;
                }
                if (this.$toast) this.$toast.error(message);
            } finally {
                this.isChangingPassword = false;
            }
        },
        async capNhatHoSo() {
            if (!this.settings.ho_va_ten || !this.settings.email) {
                if (this.$toast) this.$toast.warning("Họ tên và Email không được để trống!");
                return;
            }

            this.isUpdatingProfile = true;
            try {
                const token = localStorage.getItem('token_nguoi_dung');
                const response = await axios.post(`${apiUrl}/nguoi-dung/update-profile`, {
                    ho_va_ten: this.settings.ho_va_ten,
                    email: this.settings.email
                }, {
                    headers: { Authorization: `Bearer ${token}` }
                });

                if (response.data.status) {
                    if (this.$toast) this.$toast.success("Cập nhật hồ sơ thành công!");

                    // Cập nhật state nội bộ để giao diện đổi ngay lập tức
                    this.user.ho_va_ten = response.data.data.ho_va_ten;
                    this.user.email = response.data.data.email;

                    // Cập nhật lại thông tin user trong LocalStorage để các component khác đồng bộ
                    let userLocal = JSON.parse(localStorage.getItem('thong_tin_user')) || {};
                    userLocal.ho_va_ten = response.data.data.ho_va_ten;
                    userLocal.email = response.data.data.email;
                    localStorage.setItem('thong_tin_user', JSON.stringify(userLocal));
                }
            } catch (error) {
                let message = "Có lỗi xảy ra khi cập nhật hồ sơ.";
                if (error.response && error.response.data && error.response.data.message) {
                    message = error.response.data.message;
                }
                if (this.$toast) this.$toast.error(message);
            } finally {
                this.isUpdatingProfile = false;
            }
        },
        toggleDropdown() {
            this.showDropdown = !this.showDropdown;
        },
        // --- Khối 2: Tai mo hinh AI (Models) ---
        // tai cac file tu thu muc public/models
        async tai_mo_hinh_ai() {
            this.scanStatus = 'Dang tai du lieu mat...';
            const DUONG_DAN_MODELS = '/model'; // public model folder served from root in Vite
            try {
                await Promise.all([
                    faceapi.nets.tinyFaceDetector.loadFromUri(DUONG_DAN_MODELS),
                    faceapi.nets.faceLandmark68Net.loadFromUri(DUONG_DAN_MODELS),
                    faceapi.nets.faceRecognitionNet.loadFromUri(DUONG_DAN_MODELS)
                ]);
                return true;
            } catch (loi) {
                this.scanStatus = 'Loi tai du lieu AI!';
                console.error(loi);
                return false;
            }
        },
        // --- Khối 3: Khoi dong Camera ---
        async startFaceScan() {
            const tai_xong = await this.tai_mo_hinh_ai();
            if (!tai_xong) return;

            this.isScanning = true;
            this.scanStatus = 'Dang mo camera...';

            try {
                // Bat webcam
                this.luong_video = await navigator.mediaDevices.getUserMedia({ video: {} });
                const video = this.$refs.videoElement;
                const canvas = this.$refs.overlayCanvas;

                video.style.display = 'block';
                canvas.style.display = 'block';
                video.srcObject = this.luong_video;

                // Khi video bat dau phat thi moi bat dau nhan dien
                video.onloadedmetadata = () => {
                    video.play();
                };
                video.onplay = () => {
                    // Cập nhật kích thước canvas theo video
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    this.bat_dau_nhan_dien();
                };
            } catch (loi) {
                this.scanStatus = 'Loi truy cap camera!';
                this.isScanning = false;
            }
        },
        // --- Khối 4: Logic Nhan dien & Ve khung ---
        bat_dau_nhan_dien() {
            const video = this.$refs.videoElement;
            const canvas = this.$refs.overlayCanvas;

            const kich_thuoc_hien_thi = { width: 200, height: 200 };
            canvas.width = kich_thuoc_hien_thi.width;
            canvas.height = kich_thuoc_hien_thi.height;
            faceapi.matchDimensions(canvas, kich_thuoc_hien_thi);

            this.vong_lap_nhan_dien = setInterval(async () => {
                const ket_qua = await faceapi.detectAllFaces(
                    video,
                    new faceapi.TinyFaceDetectorOptions()
                ).withFaceLandmarks().withFaceDescriptors();

                this.detectedFaces = ket_qua.length;

                // Xóa vẽ ô vuông xanh (Xóa dòng drawDetections cũ)
                const ctx = canvas.getContext('2d');
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                if (ket_qua.length === 1) {
                    // Tăng biến đếm
                    this.dem_thoi_gian++;

                    // Tính toán phần trăm
                    let phan_tram = Math.min(Math.round((this.dem_thoi_gian / this.giay_can_thiet) * 100), 100);

                    // CẬP NHẬT TRẠNG THÁI (Chỉ cập nhật dòng này khi có 1 mặt)
                    this.scanStatus = `Đang phân tích sinh trắc học... ${phan_tram}%`;

                    if (this.dem_thoi_gian >= this.giay_can_thiet && !this.faceSaved) {
                        this.faceSaved = true;
                        this.scanStatus = "Xác nhận thực thể sống thành công!";
                        const véc_tơ_khuon_mat = Array.from(ket_qua[0].descriptor);
                        this.gui_du_lieu_len_laravel(véc_tơ_khuon_mat);
                    }
                } else {
                    // RESET nếu không thấy mặt hoặc quá nhiều mặt
                    this.dem_thoi_gian = 0;
                    if (ket_qua.length === 0) {
                        this.scanStatus = 'Vui lòng đưa mặt vào khung hình';
                    } else {
                        this.scanStatus = 'Cảnh báo: Phát hiện quá nhiều người!';
                    }
                }
            }, 200);
        },
        // --- Khối 5: Gui du lieu ve Database (Laravel) ---
        async gui_du_lieu_len_laravel(mang_so) {
            try {
                this.scanStatus = 'Dang luu vao he thong...';
                // Dung ngay viec quet de tranh gui API nhieu lan
                clearInterval(this.vong_lap_nhan_dien);

                const phan_hoi = await axios.post(`${apiUrl}/nguoi-dung/xac-thuc-khuon-mat`, {
                    id: this.id_nguoi_dung,
                    du_lieu_khuon_mat: JSON.stringify(mang_so)
                });

                if (phan_hoi.status === 200) {
                    this.scanStatus = 'Cap nhat thanh cong!';
                    this.$toast.success("Xác Thực Thành Công");

                    // 1. Cập nhật LocalStorage (để dành cho lần sau vào lại trang)
                    const user = JSON.parse(localStorage.getItem('thong_tin_user'));
                    if (user) {
                        user.du_lieu_khuon_mat = JSON.stringify(mang_so);
                        localStorage.setItem('thong_tin_user', JSON.stringify(user));
                    }

                    // 2. QUAN TRỌNG: Cập nhật biến phụ để giao diện đổi NGAY LẬP TỨC
                    this.da_xac_minh_phu = true;

                    // 3. Tat camera va don dep
                    this.stopFaceScan();
                }
            } catch (loi) {
                // --- ĐOẠN XỬ LÝ LỖI TRÙNG LẶP ---
                if (loi.response && loi.response.status === 400) {
                    // Lấy thông báo "Khuôn mặt đã tồn tại..." từ Backend
                    const thong_bao_loi = loi.response.data.message;
                    this.scanStatus = thong_bao_loi;
                    this.$toast.warning(thong_bao_loi);
                } else {
                    this.scanStatus = 'Lỗi kết nối server!';
                    this.$toast.error("Có lỗi xảy ra, vui lòng thử lại.");
                }

                // QUAN TRỌNG: Cho phép người dùng thử lại nếu bị báo trùng (có thể do quét nhầm người khác)
                this.faceSaved = false;
                this.isScanning = false; // Dừng camera để họ bấm quét lại từ đầu
                console.error(loi);
            }
        },
        // Khối 6: Quản Lý Phòng Họp
        async taoPhongHop() {
            // Kiểm tra validation cơ bản
            if (!this.formTaoPhong.ten_phong.trim()) {
                if (this.$toast) this.$toast.error("Vui lòng nhập tiêu đề cuộc họp!");
                return;
            }

            if (!this.id_nguoi_dung) {
                if (this.$toast) this.$toast.error("Lỗi: Không xác định được danh tính của bạn.");
                return;
            }
            this.isCreating = true;

            try {
                // Chuẩn bị dữ liệu gửi lên (Map với các cột trong DB)
                const payload = {
                    ten_phong: this.formTaoPhong.ten_phong,
                    id_chu_phong: this.id_nguoi_dung,
                    so_nguoi_toi_da: 100,
                    // mo_ta: this.formTaoPhong.mo_ta (Nếu DB bạn có cột này thì bật lên)
                    email_khach_moi: this.formTaoPhong.email_khach_moi,
                };

                const response = await axios.post(`${apiUrl}/phong-hop/create`, payload);

                if (response.data.status) {
                    if (this.$toast) this.$toast.success(response.data.message || "Khởi tạo phòng họp thành công!");

                    const phongMoi = response.data.data;
                    console.log("Mã phòng vừa tạo:", phongMoi.ma_phong);

                    // Mở Modal hiển thị mã phòng
                    this.createdRoomCode = phongMoi.ma_phong;
                    this.showRoomModal = true;

                    // Reset form sau khi tạo xong
                    this.formTaoPhong.ten_phong = '';
                    this.formTaoPhong.mo_ta = '';
                    this.formTaoPhong.email_khach_moi = '';
                }
            } catch (error) {
                console.error("Lỗi khi tạo phòng:", error);
                if (this.$toast) this.$toast.error("Hệ thống bận, không thể tạo phòng lúc này.");
            } finally {
                this.isCreating = false;
            }
        },
        async thamGiaPhongHop() {
            axios
                .get(`${apiUrl}/phong-hop/ma-phong`, { params: { ma_phong: this.ma_phong_tham_gia } })
                .then(response => {
                    if (response.data.status) {
                        console.log("Mã phòng hợp lệ:", response.data.data.ma_phong);
                    } else {
                        console.warn("Mã phòng không tồn tại:", this.ma_phong_tham_gia);
                    }
                });
            // 1. Kiểm tra xem người dùng đã nhập mã phòng chưa
            if (!this.ma_phong_tham_gia.trim()) {
                if (this.$toast) this.$toast.warning("Vui lòng nhập mã phòng họp!");
                return;
            }

            // 2. BẢO MẬT BẰNG AI: Chặn cửa nếu chưa quét Face ID
            if (!this.da_xac_minh) {
                if (this.$toast) this.$toast.error("Bảo mật: Vui lòng xác thực khuôn mặt trước khi vào họp!");
                // Tự động chuyển họ về tab Dashboard để quét mặt
                this.currentTab = 'dashboard';
                return;
            }
            this.isJoining = true;

            try {
                // 3. Gọi API Laravel để lấy vé (Token) vào LiveKit
                const payload = {
                    ma_phong: this.ma_phong_tham_gia.trim(),
                    user_name: this.ten_nguoi_dung
                };

                const response = await axios.post(`${apiUrl}/phong-hop/tao-token`, payload);

                if (response.data.status) {
                    // 4. Lấy token thành công
                    const token = response.data.token;

                    // Lưu token tạm thời vào sessionStorage để mang sang trang Video Call
                    sessionStorage.setItem('livekit_token', token);
                    sessionStorage.setItem('livekit_room', this.ma_phong_tham_gia.trim());

                    if (this.$toast) this.$toast.success("Kết nối an toàn thành công! Đang vào phòng...");

                    // 5. Chuyển hướng sang trang hiển thị Video Call (bạn sẽ tạo trang này tiếp theo)
                    this.$router.push(`/phong-hop/${this.ma_phong_tham_gia.trim()}`);
                }
            } catch (error) {
                console.error("Lỗi khi tham gia phòng:", error);
                if (this.$toast) {
                    this.$toast.error("Mã phòng không tồn tại hoặc hệ thống từ chối kết nối.");
                }
            } finally {
                this.isJoining = false;
            }
        },
        async kiemTraTruocKhiJoin() {
            if (!this.ma_phong_tham_gia.trim()) {
                this.$toast.warning("Vui lòng nhập mã phòng họp!");
                return;
            }
            if (!this.da_xac_minh) {
                this.$toast.error("Vui lòng đăng ký Face ID trước khi tham gia!");
                this.currentTab = 'dashboard';
                return;
            }

            this.isJoining = true;
            try {
                // Gọi API để kiểm tra mã phòng tồn tại hay không
                const response = await axios.post(`${apiUrl}/phong-hop/kiem-tra-phong-hop`, {
                    ma_phong: this.ma_phong_tham_gia.trim()
                });

                if (response.data.status) {
                    // NẾU PHÒNG TỒN TẠI -> Mở Modal và kích hoạt Camera
                    this.showJoinAuthModal = true;
                    this.authError = false;
                    this.authScanStatus = 'Đang tải dữ liệu sinh trắc học...';

                    this.$nextTick(() => {
                        this.batDauXacThucJoin();
                    });
                }
            } catch (error) {
                // NẾU PHÒNG KHÔNG TỒN TẠI (Lỗi 404) -> Báo lỗi và không làm gì cả
                let message = "Mã phòng không tồn tại!";
                if (error.response && error.response.data && error.response.data.message) {
                    message = error.response.data.message;
                }
                if (this.$toast) this.$toast.error(message);
            } finally {
                // Tắt vòng xoay loading ở nút Join
                this.isJoining = false;
            }
        },

        async batDauXacThucJoin() {
            const tai_xong = await this.tai_mo_hinh_ai();
            if (!tai_xong) return;

            this.authScanStatus = 'Đang kết nối camera...';

            try {
                this.authStream = await navigator.mediaDevices.getUserMedia({ video: {} });
                const video = this.$refs.authVideo;
                video.srcObject = this.authStream;

                video.onloadedmetadata = () => {
                    video.play();
                    this.tienHanhSoSanhKhuonMat(video);
                };
            } catch (loi) {
                this.authError = true;
                this.authScanStatus = 'Lỗi truy cập camera!';
            }
        },

        tienHanhSoSanhKhuonMat(video) {
            // Lấy véc-tơ chuẩn đã lưu trong LocalStorage (được đồng bộ từ DB)
            const userData = JSON.parse(localStorage.getItem('thong_tin_user'));
            const savedVectorArray = JSON.parse(userData.du_lieu_khuon_mat);
            const savedDescriptor = new Float32Array(savedVectorArray);

            this.authScanStatus = 'Vui lòng nhìn thẳng vào camera...';
            this.isMatched = false;

            this.authInterval = setInterval(async () => {
                // 1. CHẶN NGAY TỪ ĐẦU: Nếu đã khớp rồi thì dừng mọi xử lý quét mặt
                if (this.isMatched) return;

                // Lấy véc-tơ của khuôn mặt hiện tại trên camera
                const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions())
                    .withFaceLandmarks()
                    .withFaceDescriptors();

                if (detections.length === 1) {
                    const liveDescriptor = detections[0].descriptor;

                    // SO SÁNH: Tính khoảng cách Euclidean giữa 2 véc-tơ
                    const distance = faceapi.euclideanDistance(savedDescriptor, liveDescriptor);

                    // Ngưỡng 0.5 là mức độ an toàn cao (càng nhỏ càng giống)
                    if (distance < 0.50) {
                        this.isMatched = true; // Đánh dấu đã quét trúng
                        clearInterval(this.authInterval); // Dừng vòng lặp
                        this.authInterval = null;

                        this.authError = false;
                        this.authScanStatus = "Xác nhận thành công!";

                        // Tắt camera modal
                        this.dongModalXacThucJoin(false);


                        // Đợi 800ms để nhả camera phần cứng, sau đó mới gọi API và chuyển trang


                        // ĐÃ XÓA CÁC DÒNG CODE BỊ LẶP Ở ĐÂY
                    }
                    else {
                        this.authError = true;
                        this.authScanStatus = "Khuôn mặt không khớp dữ liệu gốc!";
                    }
                } else if (detections.length > 1) {
                    this.authError = true;
                    this.authScanStatus = "Phát hiện nhiều hơn 1 khuôn mặt!";
                } else {
                    this.authError = false;
                    this.authScanStatus = 'Đang tìm kiếm khuôn mặt...';
                }
            }, 300); // Quét 300ms một lần
        },

        dongModalXacThucJoin(an_modal = true) {
            if (this.authInterval) {
                clearInterval(this.authInterval);
                this.authInterval = null;
            }
            if (this.authStream) {
                this.authStream.getTracks().forEach(track => track.stop());
                this.authStream = null;
            }
            if (an_modal) {
                this.showJoinAuthModal = false;
            }
        },
        // Sửa lại hàm thamGiaPhongHop cũ một chút: Bỏ phần check da_xac_minh đi vì đã check ở hàm trên rồi
        async thamGiaPhongHop() {
            this.isJoining = true;
            try {
                const payload = {
                    ma_phong: this.ma_phong_tham_gia.trim(),
                    user_name: this.ten_nguoi_dung
                };
                const response = await axios.post(`${apiUrl}/phong-hop/tao-token`, payload);

                if (response.data.status) {
                    sessionStorage.setItem('livekit_token', response.data.token);
                    sessionStorage.setItem('livekit_room', this.ma_phong_tham_gia.trim());
                    if (this.$toast) this.$toast.success("Đang tham gia phòng họp");
                    // Lưu ID phòng
                    sessionStorage.setItem('id_phong_hop', response.data.id_phong_hop);
                    // Ẩn modal và sang phòng
                    this.showJoinAuthModal = false;
                    window.location.href = `/phong-hop/${this.ma_phong_tham_gia.trim()}`;
                }
            } catch (error) {
                let message = "Mã phòng không tồn tại hoặc lỗi máy chủ.";
                if (error.response && error.response.data && error.response.data.message) {
                    message = error.response.data.message;
                }
                if (this.$toast) {
                    this.$toast.error(message);
                }

                //phòng không tồn tại,  đóng Modal xác thực để người dùng nhập lại
                this.dongModalXacThucJoin(true);
            } finally {
                this.isJoining = false;
            }
        },
        stopFaceScan() {
            this.isScanning = false;
            this.scanStatus = 'Da dung quet';
            this.detectedFaces = 0;
            this.faceSaved = false;

            // Dung vong lap nhan dien
            if (this.vong_lap_nhan_dien) {
                clearInterval(this.vong_lap_nhan_dien);
                this.vong_lap_nhan_dien = null;
            }

            // Tat camera
            if (this.luong_video) {
                this.luong_video.getTracks().forEach(track => track.stop());
                this.luong_video = null;
            }

            const video = this.$refs.videoElement;
            const canvas = this.$refs.overlayCanvas;
            if (video) {
                video.style.display = 'none';
                video.srcObject = null;
            }
            if (canvas) {
                const ctx = canvas.getContext('2d');
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                canvas.style.display = 'none';
            }
        }
    },
    // Dam bao tat camera neu nguoi dung chuyen Tab hoac dong trinh duyet
    beforeUnmount() {
        this.stopFaceScan();
    }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.user-profile-link:hover h6 {
    color: #ea580c !important;
    /* Đổi màu tên khi rê chuột vào */
}

.dropdown-item {
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background-color: #fff1f2;
    /* Màu đỏ rất nhạt */
    color: #be123c !important;
    /* Đỏ đậm hơn khi hover */
}

/* Hiệu ứng hiện ra mượt mà nếu không dùng thư viện animate.css */
.animate__fadeInUp {
    animation: fadeInUp 0.2s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Thanh laser cho khung hinh tron */
.scan-line-circle {
    position: absolute;
    width: 180px;
    /* Nho hon khung hinh mot chut */
    height: 3px;
    background: linear-gradient(to right, transparent, #ea580c, transparent);
    box-shadow: 0 0 12px #ea580c;
    z-index: 12;
    animation: scan-vertical 2s ease-in-out infinite;
}

.status-text-anim {
    font-weight: bold;
    color: #ea580c;
    transition: all 0.3s ease;
}

@keyframes scan-vertical {
    0% {
        top: 10%;
        opacity: 0;
    }

    50% {
        top: 50%;
        opacity: 1;
    }

    90% {
        top: 90%;
        opacity: 0;
    }

    100% {
        top: 10%;
        opacity: 0;
    }
}

/* Basic reset */
* {
    font-family: 'Inter', sans-serif;
}

/* Sidebar nav */
.active-tab {
    background-color: #fff7ed;
    color: #ea580c !important;
}

.nav-link.text-dark:hover {
    background-color: #f8fafc;
}

.text-muted-hover {
    color: #64748b !important;
}

.text-muted-hover:hover {
    color: #0f172a !important;
}

/* Input placeholder */
input::placeholder,
textarea::placeholder {
    color: #94a3b8 !important;
}

input:focus,
textarea:focus {
    box-shadow: none !important;
    border-color: #cbd5e1 !important;
    background-color: #fff !important;
}

/* Scrollbar styling */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: transparent;
}

::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Avatar grouping */
.avatar-group img {
    margin-left: -12px;
}

.avatar-group img:first-child {
    margin-left: 0;
}

.text-orange {
    color: #ea580c !important;
}

.biometric-activated-box {
    box-shadow: inset 0 2px 20px rgba(0, 0, 0, 0.4);
    border: 1px solid #334155;
    background-image: radial-gradient(circle at center, #1e293b 0%, #0f172a 100%);
}

.biometric-shield-icon {
    filter: drop-shadow(0 0 15px rgba(234, 88, 12, 0.2));
}

.shadow-orange {
    box-shadow: 0 10px 25px -5px rgba(234, 88, 12, 0.4);
}

.shadow-inner {
    box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.2);
}

.btn-orange-pro {
    background-color: #ea580c;
    color: white !important;
    transition: all 0.3s ease;
}

.btn-orange-pro:hover {
    background-color: #f97316;
    transform: translateY(-2px);
    box-shadow: 0 15px 30px -5px rgba(234, 88, 12, 0.5);
}

.fw-900 {
    font-weight: 900;
}

.rounded-4 {
    border-radius: 1rem !important;
}

.rounded-5 {
    border-radius: 2rem !important;
}
</style>
