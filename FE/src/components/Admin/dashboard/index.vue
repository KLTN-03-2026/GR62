<template>
    <div class="row">
        <!-- Tiêu đề & Thống kê Tóm tắt -->
        <div class="col-12 mb-4 text-center mt-3">
            <h3 class="mb-0 text-uppercase fw-bold text-primary" style="letter-spacing: 1px;">Biểu Đồ & Thống Kê Nền
                Tảng</h3>
            <p class="text-secondary mt-2">Bảng điều khiển quản trị trực quan với các báo cáo động</p>
            <hr class="mx-auto" style="width: 200px; border-width: 3px; border-radius: 5px; opacity: 0.2">
        </div>

        <!-- WOW CHART -->
        <div class="col-12 mb-5">
            <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                <div
                    class="card-header bg-white border-bottom-0 pb-0 pt-4 px-4 d-flex flex-wrap justify-content-between align-items-center">
                    <h4 class="mb-0 fw-bold text-dark">
                        <i :class="chartIcon" class="text-primary me-2"></i>{{ chartTitle }}
                    </h4>
                    <div class="d-flex align-items-center gap-2 mt-2 mt-sm-0">
                        <button v-if="selectedCategory !== 'all'" @click="selectCard('all')"
                            class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm hover-up">
                            <i class="fa-solid fa-house-chimney me-1"></i> Quay lại tổng thể
                        </button>
                        <span class="badge bg-primary bg-gradient px-4 py-2 rounded-pill shadow-sm">
                            <i class="fa-solid fa-bolt text-warning me-1"></i> Trực tiếp nhanh
                        </span>
                    </div>
                </div>
                <div class="card-body px-4 pb-4">
                    <div v-if="loadingCount > 0"
                        class="d-flex justify-content-center align-items-center flex-column py-5"
                        style="min-height: 400px;">
                        <div class="spinner-grow text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                        </div>
                        <span class="text-secondary fw-semibold">Đang tổng hợp dữ liệu...</span>
                    </div>
                    <apexchart v-else :key="selectedCategory" :type="chartType" height="420" :options="chartOptions"
                        :series="chartSeries">
                    </apexchart>
                </div>
            </div>
        </div>

        <!-- Thống kê Người Dùng -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <div @click="selectCard('nguoi-dung')"
                class="card radius-10 border-start border-0 border-4 border-info shadow-sm h-100 summary-card clickable"
                :class="{ 'active-card': selectedCategory === 'nguoi-dung' }">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary fw-semibold">Tổng Người Dùng</p>
                            <h4 class="my-1 text-info">{{ list_nguoi_dung.length }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-light-info text-info ms-auto">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thống kê Đối Tác -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <div @click="selectCard('doi-tac')"
                class="card radius-10 border-start border-0 border-4 border-danger shadow-sm h-100 summary-card clickable"
                :class="{ 'active-card': selectedCategory === 'doi-tac' }">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary fw-semibold">Tổng Đối Tác</p>
                            <h4 class="my-1 text-danger">{{ list_doi_tac.length }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-light-danger text-danger ms-auto">
                            <i class="fa-solid fa-handshake"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thống kê Phòng Họp -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <div @click="selectCard('phong-hop')"
                class="card radius-10 border-start border-0 border-4 border-success shadow-sm h-100 summary-card clickable"
                :class="{ 'active-card': selectedCategory === 'phong-hop' }">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary fw-semibold">Tổng Phòng Họp</p>
                            <h4 class="my-1 text-success">{{ list_phong_hop.length }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-light-success text-success ms-auto">
                            <i class="fa-solid fa-door-open"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thống kê Gói Dịch Vụ -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <div @click="selectCard('goi')"
                class="card radius-10 border-start border-0 border-4 border-warning shadow-sm h-100 summary-card clickable"
                :class="{ 'active-card': selectedCategory === 'goi' }">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary fw-semibold">Tổng Gói Dịch Vụ</p>
                            <h4 class="my-1 text-warning">{{ list_goi.length }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-light-warning text-warning ms-auto">
                            <i class="fa-solid fa-gem"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thống kê Hóa Đơn -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <div @click="selectCard('hoa-don')"
                class="card radius-10 border-start border-0 border-4 border-primary shadow-sm h-100 summary-card clickable"
                :class="{ 'active-card': selectedCategory === 'hoa-don' }">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary fw-semibold">Tổng Hóa Đơn</p>
                            <h4 class="my-1 text-primary">{{ list_hoa_don.length }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-light-primary text-primary ms-auto">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thống kê Chat Room -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <div @click="selectCard('chat-room')"
                class="card radius-10 border-start border-0 border-4 border-secondary shadow-sm h-100 summary-card clickable"
                :class="{ 'active-card': selectedCategory === 'chat-room' }">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary fw-semibold">Tổng Chat Room</p>
                            <h4 class="my-1 text-secondary">{{ list_chat_room.length }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-light-secondary text-secondary ms-auto">
                            <i class="fa-solid fa-comments"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thống kê Chức Vụ -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <div @click="selectCard('chuc-vu')"
                class="card radius-10 border-start border-0 border-4 border-dark shadow-sm h-100 summary-card clickable"
                :class="{ 'active-card': selectedCategory === 'chuc-vu' }">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary fw-semibold">Tổng Chức Vụ</p>
                            <h4 class="my-1 text-dark">{{ list_chuc_vu.length }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-light-dark text-dark ms-auto">
                            <i class="fa-solid fa-user-shield"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thống kê Chức Năng -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <div @click="selectCard('chuc-nang')"
                class="card radius-10 border-start border-0 border-4 border-primary-dark shadow-sm h-100 summary-card clickable"
                :class="{ 'active-card': selectedCategory === 'chuc-nang' }">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary fw-semibold">Tổng Chức Năng</p>
                            <h4 class="my-1 text-primary-dark">{{ list_chuc_nang.length }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-light-primary-dark text-primary-dark ms-auto">
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import axios from 'axios';
import VueApexCharts from "vue3-apexcharts";

export default {
    components: {
        apexchart: VueApexCharts,
    },
    data() {
        return {
            loadingCount: 1,
            selectedCategory: 'all',
            chartTitle: 'Phân Tích Quy Mô Hệ Thống',
            chartIcon: 'fa-solid fa-chart-column',
            chartType: 'bar',
            list_nguoi_dung: [],
            list_doi_tac: [],
            list_phong_hop: [],
            list_goi: [],
            list_hoa_don: [],
            list_chat_room: [],
            list_chuc_vu: [],
            list_chuc_nang: [],

            chartSeries: [],
            chartOptions: {
                chart: {
                    id: 'main-chart',
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800
                    },
                    dropShadow: {
                        enabled: true,
                        top: 2,
                        left: 0,
                        blur: 4,
                        opacity: 0.1
                    }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 8,
                        columnWidth: '55%',
                        distributed: true,
                        dataLabels: {
                            position: 'top',
                        },
                    }
                },
                dataLabels: {
                    enabled: true,
                    offsetY: -20,
                    style: {
                        fontSize: '14px',
                        colors: ["#304758"],
                        fontWeight: 'bold',
                    }
                },
                xaxis: {
                    categories: [],
                    labels: {
                        style: {
                            colors: [],
                            fontSize: '13px',
                            fontWeight: 600
                        }
                    }
                },
                colors: ['#0dcaf0', '#dc3545', '#198754', '#ffc107', '#0d6efd', '#6c757d', '#212529', '#4b5563'],
                grid: {
                    borderColor: '#f1f1f1',
                    strokeDashArray: 4,
                },
                tooltip: {
                    theme: 'light'
                },
                legend: {
                    show: false
                }
            }
        }
    },
    mounted() {
        this.loadData();
    },
    methods: {
        loadData() {
            this.loadingCount = 1;
            const baseUrl = 'http://127.0.0.1:8000/api';

            Promise.all([
                axios.get(`${baseUrl}/nguoi-dung/data`).catch(() => ({ data: { data: [] } })),
                axios.get(`${baseUrl}/doi-tac/data`).catch(() => ({ data: { data: [] } })),
                axios.get(`${baseUrl}/phong-hop/data`).catch(() => ({ data: { data: [] } })),
                axios.get(`${baseUrl}/goi/data`).catch(() => ({ data: { data: [] } })),
                axios.get(`${baseUrl}/hoa-don/data`).catch(() => ({ data: { data: [] } })),
                axios.get(`${baseUrl}/chat-room/data`).catch(() => ({ data: { data: [] } })),
                axios.get(`${baseUrl}/chuc-vu/data`).catch(() => ({ data: { data: [] } })),
                axios.get(`${baseUrl}/chuc-nang/data`).catch(() => ({ data: { data: [] } }))
            ]).then((responses) => {
                this.list_nguoi_dung = responses[0].data.data;
                this.list_doi_tac = responses[1].data.data;
                this.list_phong_hop = responses[2].data.data;
                this.list_goi = responses[3].data.data;
                this.list_hoa_don = responses[4].data.data;
                this.list_chat_room = responses[5].data.data;
                this.list_chuc_vu = responses[6].data.data;
                this.list_chuc_nang = responses[7].data.data;

                this.selectCard('all');
                this.loadingCount = 0;
            });
        },
        selectCard(category) {
            this.selectedCategory = category;

            // Initial common configuration update
            const newOptions = { ...this.chartOptions };

            if (category === 'all') {
                this.chartType = 'bar';
                this.chartTitle = 'Phân Tích Quy Mô Hệ Thống';
                this.chartIcon = 'fa-solid fa-chart-column';
                this.chartSeries = [{
                    name: 'Tổng số lượng',
                    data: [
                        this.list_nguoi_dung.length,
                        this.list_doi_tac.length,
                        this.list_phong_hop.length,
                        this.list_goi.length,
                        this.list_hoa_don.length,
                        this.list_chat_room.length
                    ]
                }];
                newOptions.xaxis = {
                    categories: ['Người Dùng', 'Đối Tác', 'Phòng Họp', 'Gói', 'Hóa Đơn', 'Chat'],
                    labels: {
                        style: {
                            colors: ['#0dcaf0', '#dc3545', '#198754', '#ffc107', '#0d6efd', '#6c757d'],
                            fontSize: '13px',
                            fontWeight: 600
                        }
                    }
                };
                newOptions.stroke = { curve: 'straight' };
                newOptions.markers = { size: 0 };
            }
            else if (['nguoi-dung', 'doi-tac', 'phong-hop', 'goi'].includes(category)) {
                this.chartType = 'area'; // Sử dụng area chart cho cảm giác "đi lên đi xuống" cao cấp
                const map = {
                    'nguoi-dung': { list: this.list_nguoi_dung, label: 'Người Dùng', icon: 'fa-solid fa-users' },
                    'doi-tac': { list: this.list_doi_tac, label: 'Đối Tác', icon: 'fa-solid fa-handshake' },
                    'phong-hop': { list: this.list_phong_hop, label: 'Phòng Họp', icon: 'fa-solid fa-door-open' },
                    'goi': { list: this.list_goi, label: 'Gói Dịch Vụ', icon: 'fa-solid fa-gem' }
                };
                const data = map[category];
                this.chartTitle = `Tình Trạng ${data.label}`;
                this.chartIcon = data.icon;

                const active = data.list.filter(i => i.trang_thai == 1).length;
                const inactive = data.list.length - active;

                this.chartSeries = [{
                    name: 'Số lượng',
                    data: [active, inactive]
                }];
                newOptions.xaxis = {
                    categories: ['Đang Hoạt động', 'Tạm Ngưng'],
                    labels: {
                        style: {
                            colors: ['#198754', '#dc3545'],
                            fontSize: '13px',
                            fontWeight: 600
                        }
                    }
                };
                newOptions.stroke = { curve: 'smooth', width: 3 };
                newOptions.markers = { size: 5, strokeWidth: 3, hover: { size: 7 } };
            }
            else if (category === 'hoa-don') {
                this.chartType = 'area';
                this.chartTitle = 'Thống Kê Trạng Thái Hóa Đơn';
                this.chartIcon = 'fa-solid fa-file-invoice-dollar';

                if (this.list_hoa_don.length === 0) {
                    this.chartSeries = [{ name: 'Số lượng', data: [0] }];
                    newOptions.xaxis = {
                        categories: ['Không có dữ liệu'],
                        labels: { style: { colors: ['#6c757d'], fontSize: '13px', fontWeight: 600 } }
                    };
                } else {
                    const groups = this.list_hoa_don.reduce((acc, curr) => {
                        const status = curr.trang_thai_thanh_toan || 'Chưa xác định';
                        acc[status] = (acc[status] || 0) + 1;
                        return acc;
                    }, {});

                    this.chartSeries = [{
                        name: 'Số lượng',
                        data: Object.values(groups)
                    }];
                    newOptions.xaxis = {
                        categories: Object.keys(groups),
                        labels: {
                            style: {
                                colors: ['#0d6efd', '#ffc107', '#dc3545', '#198754'],
                                fontSize: '13px',
                                fontWeight: 600
                            }
                        }
                    };
                }
                newOptions.stroke = { curve: 'smooth', width: 3 };
                newOptions.markers = { size: 5, strokeWidth: 3, hover: { size: 7 } };
            }
            else {
                this.chartType = 'line';
                const map = {
                    'chat-room': { list: this.list_chat_room, label: 'Chat Room', icon: 'fa-solid fa-comments' },
                    'chuc-vu': { list: this.list_chuc_vu, label: 'Chức Vụ', icon: 'fa-solid fa-user-shield' },
                    'chuc-nang': { list: this.list_chuc_nang, label: 'Chức Năng', icon: 'fa-solid fa-screwdriver-wrench' }
                };
                const data = map[category];
                this.chartTitle = `Chi Tiết ${data.label}`;
                this.chartIcon = data.icon;
                this.chartSeries = [{
                    name: 'Tổng số',
                    data: [data.list.length]
                }];
                newOptions.xaxis = {
                    categories: ['Tổng cộng'],
                    labels: {
                        style: {
                            colors: ['#304758'],
                            fontSize: '13px',
                            fontWeight: 600
                        }
                    }
                };
                newOptions.stroke = { curve: 'smooth', width: 3 };
                newOptions.markers = { size: 5, strokeWidth: 3, hover: { size: 7 } };
            }

            // Re-assign to trigger reactivity
            this.chartOptions = newOptions;
        }
    }
}
</script>

<style scoped>
.widgets-icons {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #ededed;
    font-size: 28px;
    border-radius: 12px;
}

.bg-light-info {
    background-color: #e0f7ff !important;
}

.text-info {
    color: #0dcaf0 !important;
}

.bg-light-danger {
    background-color: #ffe5e8 !important;
}

.text-danger {
    color: #dc3545 !important;
}

.bg-light-success {
    background-color: #e0f8eb !important;
}

.text-success {
    color: #198754 !important;
}

.bg-light-warning {
    background-color: #fff8e1 !important;
}

.text-warning {
    color: #ffc107 !important;
}

.bg-light-primary {
    background-color: #e6f0ff !important;
}

.text-primary {
    color: #0d6efd !important;
}

.bg-light-secondary {
    background-color: #e9ecef !important;
}

.text-secondary {
    color: #6c757d !important;
}

.bg-light-dark {
    background-color: #e2e3e5 !important;
}

.text-dark {
    color: #212529 !important;
}

.bg-light-primary-dark {
    background-color: #f1f5f9 !important;
}

.text-primary-dark {
    color: #475569 !important;
}

.border-primary-dark {
    border-color: #475569 !important;
}

.summary-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

.summary-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12) !important;
}

.active-card {
    transform: translateY(-8px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15) !important;
    border-width: 2px !important;
    scale: 1.02;
}

.hover-up {
    transition: transform 0.2s ease;
}

.hover-up:hover {
    transform: translateY(-2px);
}

.bg-gradient {
    background-image: linear-gradient(135deg, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0) 100%);
}
</style>
