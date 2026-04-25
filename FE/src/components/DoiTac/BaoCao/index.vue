<template>
    <div class="partner-dashboard-wrapper h-100">
        <div class="main-layout d-flex h-100">
            <!-- Sidebar (AI-Meet Business Branding) -->
            <aside class="sidebar-business d-flex flex-column py-5 shadow-sm">
                <div class="logo-section px-4 mb-5">
                    <div class="d-flex align-items-center gap-3" @click="$router.push('/doi-tac/trang-chinh')" style="cursor: pointer;">
                        <div class="logo-icon-business">
                            <i class="bx bxs-component fs-3"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-800 text-dark tracking-tighter">AI-Meet Business</h5>
                            <small class="text-muted fw-bold text-uppercase" style="font-size: 0.6rem; letter-spacing: 1.5px;">Đối tác cao cấp</small>
                        </div>
                    </div>
                </div>

                <div class="nav-links d-flex flex-column gap-3 px-3 flex-grow-1 mt-3">
                    <button @click="$router.push('/doi-tac/trang-chinh')" class="nav-business-item">
                        <i class="bx bxs-dashboard"></i>
                        <span>Tổng quan</span>
                    </button>
                    
                    <button @click="$router.push('/doi-tac/phong-hop')" class="nav-business-item">
                        <i class="bx bxs-video"></i>
                        <span>Tham gia cuộc họp</span>
                    </button>
                    <button @click="$router.push('/doi-tac/quan-ly-phong-hop')" class="nav-business-item">
                        <i class="bx bxs-megaphone"></i>
                        <span>Quản lý phòng họp</span>
                    </button>
                    <button @click="$router.push('/doi-tac/quan-ly-thanh-vien')" class="nav-business-item">
                        <i class="bx bxs-group"></i>
                        <span>Thành viên</span>
                    </button>
                    <button class="nav-business-item active">
                        <i class="bx bxs-bar-chart-alt-2"></i>
                        <span>Báo cáo</span>
                    </button>
                    <button @click="$router.push('/doi-tac/profile')" class="nav-business-item">
                        <i class="bx bxs-cog"></i>
                        <span>Cài đặt</span>
                    </button>
                </div>

                <div class="px-3 mt-auto pt-5 border-top border-light">
                    <button class="nav-business-item mb-2 border-0 bg-transparent w-100">
                        <i class="bx bx-help-circle"></i>
                        <span>Hỗ trợ</span>
                    </button>
                    <button @click="logout" class="nav-business-item text-danger border-0 bg-transparent w-100">
                        <i class="bx bx-log-out-circle"></i>
                        <span>Đăng xuất</span>
                    </button>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-grow-1 p-0 overflow-auto bg-fbf9f6">
                <!-- Header -->
                <header class="content-header px-5 py-4 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <h4 class="mb-0 fw-800 text-dark">Phân tích hệ thống</h4>
                        <span class="badge bg-soft-orange text-orange rounded-pill px-3 py-2 fw-800" style="font-size: 0.7rem;">Real-time Data</span>
                    </div>

                    <div class="header-right d-flex align-items-center gap-4">
                        <div class="header-actions-business d-flex gap-2">
                            <button class="btn-icon-business"><i class="bx bx-printer"></i></button>
                            <button class="btn btn-orange-pro px-4 py-2 fw-800 rounded-4 border-0 text-white shadow-orange">
                                <i class="bx bx-export me-2"></i> Xuất CSV
                            </button>
                        </div>
                        <div class="profile-trigger-business d-flex align-items-center gap-3 cursor-pointer"
                            @click="$router.push('/doi-tac/profile')">
                            <img :src="avatarUrl" alt="Avatar" class="header-avatar-business shadow-sm">
                        </div>
                    </div>
                </header>

                <div class="p-5 pt-4">
                    <!-- Analytics Header -->
                    <div class="d-flex justify-content-between align-items-end mb-5">
                        <div class="report-title-section">
                            <h2 class="fw-900 text-dark mb-2">Báo cáo hiệu suất Đối tác</h2>
                            <p class="text-muted mb-0 fw-500">Phân tích chuyên sâu về tần suất cuộc họp và tương tác nhân viên.</p>
                        </div>
                        <div class="date-filters d-flex gap-2">
                            <button class="btn-filter-pill active">30 ngày qua</button>
                            <button class="btn-filter-pill">Quý này</button>
                            <select class="form-select filter-select border-0 shadow-none rounded-pill px-4 fw-800">
                                <option>Tháng 4, 2026</option>
                                <option>Tháng 3, 2026</option>
                            </select>
                        </div>
                    </div>

                    <!-- Metric Highlights -->
                    <div class="row g-4 mb-5 text-center">
                        <div v-for="metric in metrics" :key="metric.label" class="col-md-3">
                            <div class="metric-card-report p-4 rounded-5 border-0">
                                <div class="metric-label-report text-muted small fw-800 text-uppercase mb-2">{{ metric.label }}</div>
                                <h2 class="fw-900 mb-2">{{ metric.value }}</h2>
                                <div :class="['grow-indicator', metric.trend === 'up' ? 'text-success' : 'text-danger']">
                                    <i :class="['bx', metric.trend === 'up' ? 'bx-trending-up' : 'bx-trending-down', 'me-1']"></i>
                                    {{ metric.change }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Section -->
                    <div class="row g-5 mb-5">
                        <div class="col-xl-8">
                            <div class="glass-section-business p-5 rounded-5 shadow-faint border-0">
                                <div class="d-flex justify-content-between align-items-center mb-5">
                                    <h4 class="fw-800 text-dark mb-0">Tần suất cuộc họp hàng ngày</h4>
                                    <div class="chart-legend d-flex gap-3 small fw-800">
                                        <span class="d-flex align-items-center gap-2"><div class="dot bg-orange"></div> Tháng này</span>
                                        <span class="d-flex align-items-center gap-2 opacity-50"><div class="dot bg-secondary"></div> Tháng trước</span>
                                    </div>
                                </div>
                                <div id="activity-chart">
                                    <apexchart type="area" height="350" :options="activityChartOptions" :series="activitySeries"></apexchart>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="glass-section-business p-5 rounded-5 shadow-faint border-0 h-100">
                                <h4 class="fw-800 text-dark mb-5">Hiệu suất Phòng ban</h4>
                                <div id="dept-chart">
                                    <apexchart type="bar" height="350" :options="deptChartOptions" :series="deptSeries"></apexchart>
                                </div>
                                <div class="mt-4 p-4 rounded-4 bg-white border border-light">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted small fw-800">DẪN ĐẦU THÁNG</span>
                                        <span class="text-orange fw-900 small">+85%</span>
                                    </div>
                                    <h6 class="fw-900 mb-0 text-dark">Phòng Kỹ thuật (KT)</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detailed Logs Table -->
                    <div class="glass-section-business p-5 rounded-5 shadow-faint border-0">
                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <h4 class="fw-800 text-dark mb-0">Nhật ký cuộc họp chi tiết</h4>
                            <div class="table-actions d-flex gap-2">
                                <div class="search-mini">
                                    <i class="bx bx-search"></i>
                                    <input type="text" placeholder="Tìm theo host...">
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-borderless table-business align-middle">
                                <thead>
                                    <tr class="text-muted small fw-800 text-uppercase border-bottom">
                                        <th class="pb-3 ps-0">Tên phòng / Chủ trì</th>
                                        <th class="pb-3">Mã phòng</th>
                                        <th class="pb-3 text-center">Thời lượng</th>
                                        <th class="pb-3 text-center">Tham gia</th>
                                        <th class="pb-3 text-end pe-0">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="log in meetingLogs" :key="log.roomId" class="border-bottom-faint">
                                        <td class="py-4 ps-0">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="room-icon-mini bg-soft-orange text-orange"><i class="bx bxs-video"></i></div>
                                                <div>
                                                    <div class="fw-800 text-dark">{{ log.title }}</div>
                                                    <small class="text-muted">{{ log.host }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 fw-bold text-muted">{{ log.roomId }}</td>
                                        <td class="py-4 text-center fw-800 text-dark">{{ log.duration }}</td>
                                        <td class="py-4 text-center">
                                            <div class="attendee-count">{{ log.attendees }}</div>
                                        </td>
                                        <td class="py-4 text-end pe-0">
                                            <span :class="['status-badge-report', log.status]">
                                                {{ log.status === 'live' ? 'Đang diễn ra' : 'Đã kết thúc' }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import VueApexCharts from "vue3-apexcharts";

const apiUrl = import.meta.env.VITE_API_URL;

export default {
    name: 'PartnerReport',
    components: {
        apexchart: VueApexCharts,
    },
    data() {
        return {
            partnerId: null,
            partnerName: 'Admin Đối tác',
            avatarUrl: 'https://i.pravatar.cc/150?u=partner_default',
            metrics: [
                { label: 'Tổng cuộc họp', value: '0', change: '+0%', trend: 'up' },
                { label: 'Tổng giờ họp', value: '0h', change: '+0%', trend: 'up' },
                { label: 'Người tham gia', value: '0', change: '+0%', trend: 'up' },
                { label: 'TG Trung bình', value: '0 phút', change: '+0%', trend: 'up' }
            ],
            meetingLogs: [],

            activitySeries: [{ name: 'Cuộc họp', data: [0, 0, 0, 0, 0, 0, 0] }],
            activityChartOptions: {
                chart: { type: 'area', toolbar: { show: false }, zoom: { enabled: false }, fontFamily: 'Plus Jakarta Sans' },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 3, colors: ['#ea580c'] },
                fill: {
                    type: 'gradient',
                    gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0, stops: [0, 90, 100] }
                },
                colors: ['#ea580c'],
                xaxis: {
                    categories: ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'],
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                },
                yaxis: { show: false },
                grid: { borderColor: '#f1ede8', strokeDashArray: 4, padding: { left: 0, right: 0 } },
                tooltip: { theme: 'light', x: { show: true }, marker: { show: false } }
            },

            deptSeries: [{ name: 'Số người', data: [0, 0, 0] }],
            deptChartOptions: {
                chart: { type: 'bar', toolbar: { show: false }, fontFamily: 'Plus Jakarta Sans' },
                plotOptions: { bar: { borderRadius: 10, columnWidth: '45%', distributed: true } },
                dataLabels: { enabled: false },
                colors: ['#ea580c', '#0ea5e9', '#f59e0b'],
                legend: { show: false },
                xaxis: {
                    categories: ['—', '—', '—'],
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                },
                grid: { show: false }
            }
        }
    },
    mounted() {
        this.fetchPartnerData();
    },
    methods: {
        async fetchPartnerData() {
            try {
                const token = localStorage.getItem('token_doi_tac');
                if (!token) return;
                const res = await axios.get(`${apiUrl}/doi-tac/me`, {
                    headers: { Authorization: 'Bearer ' + token }
                });
                if (res.data.status) {
                    this.partnerId = res.data.data.id;
                    this.partnerName = res.data.data.ho_va_ten;
                    const hinh_anh = res.data.data.hinh_anh;
                    if (hinh_anh) {
                        const baseUrl = apiUrl.replace('/api', '');
                        this.avatarUrl = hinh_anh.startsWith('http') ? hinh_anh : `${baseUrl}/uploads/avatars/${hinh_anh}`;
                    }
                    await this.fetchThongKeBaoCao();
                }
            } catch (e) {
                console.error("Error fetching partner data");
            }
        },

        async fetchThongKeBaoCao() {
            if (!this.partnerId) return;
            try {
                const res = await axios.get(`${apiUrl}/phong-hop/thong-ke-bao-cao`, {
                    params: { id_chu_phong: this.partnerId }
                });

                if (res.data.status) {
                    const d = res.data.data;

                    // Cập nhật metrics từ dữ liệu thực
                    this.metrics[0].value = d.tong_cuoc_hop.toString();
                    this.metrics[1].value = d.tong_gio + 'h';
                    this.metrics[2].value = d.tong_nguoi.toString();
                    this.metrics[3].value = d.tb_phut + ' phút';

                    // Cập nhật bảng nhật ký từ dữ liệu thực
                    this.meetingLogs = d.logs.map(log => ({
                        title: log.ten_phong,
                        host: this.partnerName,
                        roomId: log.ma_phong,
                        duration: log.thoi_luong,
                        attendees: log.so_nguoi,
                        status: log.trang_thai ? 'live' : 'ended'
                    }));

                    // Cập nhật biểu đồ area từ dữ liệu 7 ngày thực
                    this.activitySeries = [{ name: 'Cuộc họp', data: d.chart_data }];
                    this.activityChartOptions = {
                        ...this.activityChartOptions,
                        xaxis: {
                            ...this.activityChartOptions.xaxis,
                            categories: d.chart_labels
                        }
                    };

                    // Biểu đồ bar: top 3 phòng nhiều người nhất
                    const topRooms = [...d.logs]
                        .sort((a, b) => b.so_nguoi - a.so_nguoi)
                        .slice(0, 3);
                    if (topRooms.length > 0) {
                        this.deptSeries = [{ name: 'Số người', data: topRooms.map(r => r.so_nguoi) }];
                        this.deptChartOptions = {
                            ...this.deptChartOptions,
                            xaxis: {
                                ...this.deptChartOptions.xaxis,
                                categories: topRooms.map(r => r.ten_phong.substring(0, 10))
                            }
                        };
                    }
                }
            } catch (error) {
                console.error("Error fetching báo cáo:", error);
            }
        },

        logout() {
            localStorage.removeItem('token_nguoi_dung');
            localStorage.removeItem('thong_tin_user');
            localStorage.removeItem('token_doi_tac');
            this.$toast && this.$toast.success("Đăng xuất thành công!");
            this.$router.push('/');
        }
    }
}   
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap');

.partner-dashboard-wrapper {
    background-color: #fff;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: #1a1e29;
}

.bg-fbf9f6 { background-color: #fbf9f6; }

/* Sidebar Re-styling */
.sidebar-business { width: 320px; background: #fbf9f6; border-right: 1px solid #f0ece6; z-index: 1000; }
.logo-icon-business { width: 48px; height: 48px; background: #ea580c; color: white; border-radius: 12px; display: flex; justify-content: center; align-items: center; box-shadow: 0 8px 16px rgba(234, 88, 12, 0.15); }
.nav-business-item { width: 100%; padding: 18px 25px; border: none; background: transparent; border-radius: 14px; color: #5a5a5a; font-size: 0.95rem; font-weight: 700; display: flex; align-items: center; gap: 15px; transition: 0.3s; text-align: left; }
.nav-business-item i { font-size: 1.5rem; color: #7a7a7a; }
.nav-business-item:hover { background: rgba(234, 88, 12, 0.05); color: #ea580c; }
.nav-business-item.active { background: #fff; color: #ea580c; box-shadow: 0 10px 20px rgba(0,0,0,0.04); }
.nav-business-item.active i { color: #ea580c; }

/* Header Business Styling */
.content-header { background: white; border-bottom: 2px solid #fbf9f6; }
.btn-icon-business { width: 44px; height: 44px; background: #fbf9f6; border: 1.5px solid #f0ece6; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #5a5a5a; transition: 0.2s; }
.btn-icon-business:hover { background: #fff; color: #ea580c; }
.header-avatar-business { width: 46px; height: 46px; border-radius: 50%; object-fit: cover; border: 2px solid #fff; box-shadow: 0 0 0 1px #f0ece6; }

/* Metrics Section */
.metric-card-report { background: #fbf9f6; border: 1px solid #f0ece6 !important; transition: 0.3s; }
.metric-card-report:hover { background: white; box-shadow: 0 15px 30px rgba(0,0,0,0.04); transform: translateY(-5px); border-color: #fee7d1 !important; }
.grow-indicator { font-size: 0.75rem; font-weight: 800; display: flex; align-items: center; justify-content: center; }

/* Glass Sections */
.glass-section-business { background: #fbf9f6; border: 1px solid #f0ece6 !important; }
.btn-filter-pill { padding: 8px 20px; border-radius: 100px; border: none; font-weight: 800; font-size: 0.75rem; color: #7a7a7a; background: transparent; transition: 0.3s; }
.btn-filter-pill.active { background: #fee7d1; color: #ea580c; }
.filter-select { background-color: #fbf9f6; color: #ea580c; font-size: 0.8rem; height: 40px; cursor: pointer; border: 1.5px solid #f0ece6 !important; }

/* Chart UI */
.dot { width: 8px; height: 8px; border-radius: 50%; }
.bg-orange { background-color: #ea580c; }

/* Table Styling */
.table-business thead th { border-top: none !important; color: #7a7a7a; }
.border-bottom-faint { border-bottom: 1.5px solid #fbf9f6; }
.room-icon-mini { width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
.bg-soft-orange { background: #fee7d1; }
.text-orange { color: #ea580c; }
.attendee-count { background: white; border: 1px solid #f0ece6; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 900; color: #1a1e29; }

.status-badge-report { padding: 6px 14px; border-radius: 100px; font-size: 0.7rem; font-weight: 800; }
.status-badge-report.live { background: #dcfce7; color: #15803d; }
.status-badge-report.ended { background: #f1f5f9; color: #64748b; }

/* Search Mini */
.search-mini { background: #fff; border: 1.5px solid #f0ece6; border-radius: 12px; padding: 10px 18px; display: flex; align-items: center; gap: 8px; }
.search-mini input { border: none; outline: none; font-size: 0.85rem; font-weight: 600; width: 220px; }
.search-mini i { color: #7a7a7a; }

/* Buttons Pro */
.btn-orange-pro { background: #ea580c; color: #fff !important; transition: 0.3s; }
.btn-orange-pro:hover { filter: brightness(1.1); transform: translateY(-2px); box-shadow: 0 15px 35px rgba(234, 88, 12, 0.35); }
.shadow-orange { box-shadow: 0 10px 25px rgba(234, 88, 12, 0.2); }

/* Utilities */
.fw-900 { font-weight: 900; }
.fw-800 { font-weight: 800; }
.tracking-tighter { letter-spacing: -1.2px; }
.text-orange { color: #ea580c; }
</style>
