<template>
  <div class="partner-dashboard-wrapper h-100">
    <div class="main-layout d-flex h-100">
      <!-- Sidebar -->
      <aside class="sidebar-business d-flex flex-column py-5 shadow-sm">
        <div class="logo-section px-4 mb-5">
          <div class="d-flex align-items-center gap-3" @click="$router.push('/doi-tac/trang-chinh')" style="cursor: pointer;">
            <div class="logo-icon-business"><i class="bx bxs-component fs-3"></i></div>
            <div>
              <h5 class="mb-0 fw-800 text-dark tracking-tighter">AI-Meet Business</h5>
              <small class="text-muted fw-bold text-uppercase" style="font-size: 0.6rem; letter-spacing: 1.5px;">Đối tác cao cấp</small>
            </div>
          </div>
        </div>

        <div class="nav-links d-flex flex-column gap-3 px-3 flex-grow-1 mt-3">
          <button @click="$router.push('/doi-tac/trang-chinh')" class="nav-business-item">
            <i class="bx bxs-dashboard"></i><span>Tổng quan</span>
          </button>
          <button @click="$router.push('/doi-tac/phong-hop')" class="nav-business-item">
            <i class="bx bxs-video"></i><span>Tham gia cuộc họp</span>
          </button>
          <button @click="$router.push('/doi-tac/quan-ly-phong-hop')" class="nav-business-item">
            <i class="bx bxs-megaphone"></i><span>Quản lý phòng họp</span>
          </button>
          <button @click="$router.push('/doi-tac/quan-ly-thanh-vien')" class="nav-business-item">
            <i class="bx bxs-group"></i><span>Thành viên</span>
          </button>
          <button class="nav-business-item active">
            <i class="bx bxs-receipt"></i><span>Hóa đơn</span>
          </button>
          <button @click="$router.push('/nguoi-dung/danh-sach-goi')" class="nav-business-item">
            <i class="bx bxs-package"></i><span>Mua gói</span>
          </button>
          <button @click="$router.push('/doi-tac/bao-cao')" class="nav-business-item">
            <i class="bx bxs-bar-chart-alt-2"></i><span>Báo cáo</span>
          </button>
          <button @click="$router.push('/doi-tac/profile')" class="nav-business-item">
            <i class="bx bxs-cog"></i><span>Cài đặt</span>
          </button>
        </div>

        <div class="px-3 mt-auto pt-5 border-top border-light">
          <button @click="logout" class="nav-business-item text-danger border-0 bg-transparent w-100">
            <i class="bx bx-log-out-circle"></i><span>Đăng xuất</span>
          </button>
        </div>
      </aside>

      <!-- Main Content -->
      <main class="flex-grow-1 p-0 overflow-auto" style="background: #fbf9f6; min-height: 100vh;">
        <header class="content-header px-5 py-4 d-flex justify-content-between align-items-center">
          <div>
            <h4 class="mb-0 fw-800 text-dark">Lịch sử Hóa đơn</h4>
            <p class="mb-0 text-muted small fw-500">Lịch sử thanh toán gói dịch vụ của các thành viên tổ chức</p>
          </div>
          <div class="profile-trigger-business d-flex align-items-center gap-3 cursor-pointer" @click="$router.push('/doi-tac/profile')">
            <img :src="avatarUrl" alt="Avatar" class="header-avatar-business shadow-sm">
          </div>
        </header>

        <div class="px-5 py-4">
          <!-- Summary Cards -->
          <div class="row g-4 mb-5">
            <div class="col-md-3">
              <div class="metric-card-business p-4 rounded-5 border-0">
                <div class="metric-icon bg-soft-orange text-orange mb-3"><i class="bx bxs-wallet-alt"></i></div>
                <label class="text-muted small fw-800 text-uppercase mb-1 d-block">Tổng giao dịch</label>
                <h2 class="fw-900 mb-0">{{ hoa_don.length }}</h2>
              </div>
            </div>
            <div class="col-md-3">
              <div class="metric-card-business p-4 rounded-5 border-0">
                <div class="metric-icon bg-soft-success text-success mb-3"><i class="bx bx-check-circle"></i></div>
                <label class="text-muted small fw-800 text-uppercase mb-1 d-block">Thành công</label>
                <h2 class="fw-900 mb-0 text-success">{{ hoa_don.filter(h => h.trang_thai_thanh_toan === 'success' || h.trang_thai_thanh_toan === 1).length }}</h2>
              </div>
            </div>
            <div class="col-md-3">
              <div class="metric-card-business p-4 rounded-5 border-0">
                <div class="metric-icon mb-3" style="background:#fef3c7; color:#d97706;"><i class="bx bx-time-five"></i></div>
                <label class="text-muted small fw-800 text-uppercase mb-1 d-block">Chờ xử lý</label>
                <h2 class="fw-900 mb-0" style="color:#d97706;">{{ hoa_don.filter(h => h.trang_thai_thanh_toan === 'pending' || h.trang_thai_thanh_toan === 0).length }}</h2>
              </div>
            </div>
            <div class="col-md-3">
              <div class="metric-card-business p-4 rounded-5 border-0">
                <div class="metric-icon bg-soft-orange text-orange mb-3"><i class="bx bx-money-withdraw"></i></div>
                <label class="text-muted small fw-800 text-uppercase mb-1 d-block">Tổng chi tiêu</label>
                <h2 class="fw-900 mb-0" style="font-size:1.4rem;">{{ formatMoney(tongChiTieu) }}</h2>
              </div>
            </div>
          </div>

          <!-- Invoice Table -->
          <div class="metric-card-business p-4 p-md-5 rounded-5 border-0 bg-white">
            <div class="d-flex align-items-center justify-content-between mb-4">
              <h4 class="fw-900 text-dark mb-0">Chi tiết giao dịch</h4>
              <div class="search-business" style="width: 280px; padding: 8px 15px;">
                <i class="bx bx-search text-muted"></i>
                <input type="text" v-model="keyword" placeholder="Tìm mã GD, tên thành viên..." style="font-size: 0.8rem;">
              </div>
            </div>

            <div v-if="isLoading" class="text-center py-5">
              <div class="spinner-border text-orange" role="status"></div>
              <p class="mt-3 text-muted fw-bold small">Đang tải dữ liệu...</p>
            </div>

            <div v-else class="table-responsive">
              <table class="table table-borderless premium-table align-middle w-100">
                <thead>
                  <tr class="text-muted small fw-800 text-uppercase border-bottom">
                    <th class="pb-3 ps-3">Mã giao dịch</th>
                    <th class="pb-3">Thành viên</th>
                    <th class="pb-3">Gói dịch vụ</th>
                    <th class="pb-3 text-center">Số tiền</th>
                    <th class="pb-3 text-center">Ngày thanh toán</th>
                    <th class="pb-3 text-center">Phương thức</th>
                    <th class="pb-3 text-end pe-3">Trạng thái</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="hd in filtered" :key="hd.id" class="floating-row">
                    <td class="ps-3">
                      <div class="code-box d-inline-flex align-items-center gap-2">
                        <i class="bx bxs-receipt text-orange"></i>
                        <span class="fw-800 text-dark" style="font-size: 0.82rem;">{{ hd.ma_giao_dich || '—' }}</span>
                      </div>
                    </td>
                    <td>
                      <div>
                        <div class="fw-800 text-dark small">{{ hd.ten_nguoi_dung }}</div>
                        <small class="text-muted">{{ hd.email_nguoi_dung }}</small>
                      </div>
                    </td>
                    <td>
                      <span class="goi-badge">{{ hd.ten_goi }}</span>
                    </td>
                    <td class="text-center">
                      <span class="fw-900 text-dark">{{ formatMoney(hd.so_tien) }}</span>
                    </td>
                    <td class="text-center">
                      <span class="fw-700 text-muted small">{{ formatDate(hd.ngay_tao) }}</span>
                    </td>
                    <td class="text-center">
                      <span class="phuong-thuc-badge">{{ hd.phuong_thuc_thanh_toan || 'N/A' }}</span>
                    </td>
                    <td class="text-end pe-3">
                      <span v-if="isSuccess(hd.trang_thai_thanh_toan)" class="status-hoadon success">
                        <i class="bx bxs-check-circle me-1"></i>Thành công
                      </span>
                      <span v-else-if="isPending(hd.trang_thai_thanh_toan)" class="status-hoadon pending">
                        <i class="bx bx-time me-1"></i>Chờ xử lý
                      </span>
                      <span v-else class="status-hoadon failed">
                        <i class="bx bx-x-circle me-1"></i>Thất bại
                      </span>
                    </td>
                  </tr>
                  <tr v-if="filtered.length === 0 && !isLoading">
                    <td colspan="7" class="text-center py-5">
                      <div class="feature-icon-bg-mini mx-auto mb-3" style="width: 60px; height: 60px; font-size: 2rem;">
                        <i class="bx bx-receipt text-muted"></i>
                      </div>
                      <h5 class="fw-800 text-dark">Chưa có giao dịch nào</h5>
                      <p class="text-muted fw-bold small">Khi thành viên mua gói dịch vụ, giao dịch sẽ hiển thị tại đây.</p>
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
const apiUrl = import.meta.env.VITE_API_URL;

export default {
  name: 'HoaDonDoiTac',
  data() {
    return {
      avatarUrl: 'https://i.pravatar.cc/150?u=partner',
      hoa_don: [],
      keyword: '',
      isLoading: false,
    };
  },
  computed: {
    filtered() {
      if (!this.keyword.trim()) return this.hoa_don;
      const kw = this.keyword.toLowerCase();
      return this.hoa_don.filter(h =>
        h.ma_giao_dich?.toLowerCase().includes(kw) ||
        h.ten_nguoi_dung?.toLowerCase().includes(kw) ||
        h.email_nguoi_dung?.toLowerCase().includes(kw) ||
        h.ten_goi?.toLowerCase().includes(kw)
      );
    },
    tongChiTieu() {
      return this.hoa_don
        .filter(h => this.isSuccess(h.trang_thai_thanh_toan))
        .reduce((sum, h) => sum + parseFloat(h.so_tien || 0), 0);
    }
  },
  async mounted() {
    await this.loadProfile();
    await this.loadHoaDon();
  },
  methods: {
    async loadProfile() {
      try {
        const token = localStorage.getItem('token_doi_tac');
        if (!token) { this.$router.push('/dang-nhap'); return; }
        const res = await axios.get(`${apiUrl}/doi-tac/me`, { headers: { Authorization: 'Bearer ' + token } });
        if (res.data.status) {
          const h = res.data.data.hinh_anh;
          if (h) {
            const base = apiUrl.replace('/api', '');
            this.avatarUrl = h.startsWith('http') ? h : `${base}/${h.includes('uploads/') ? h : 'uploads/avatars/' + h}`;
          }
        }
      } catch {}
    },
    async loadHoaDon() {
      this.isLoading = true;
      try {
        const token = localStorage.getItem('token_doi_tac');
        const res = await axios.get(`${apiUrl}/doi-tac/lich-su-hoa-don`, { headers: { Authorization: 'Bearer ' + token } });
        if (res.data.status) this.hoa_don = res.data.data;
      } catch (e) {
        this.$toast?.error('Lỗi tải lịch sử hóa đơn!');
      } finally {
        this.isLoading = false;
      }
    },
    isSuccess(status) { return status === 'success' || status === 1 || status === '1'; },
    isPending(status) { return status === 'pending' || status === 0 || status === '0'; },
    formatDate(dateStr) {
      if (!dateStr) return '—';
      return new Date(dateStr).toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit', year: 'numeric' });
    },
    formatMoney(amount) {
      if (!amount) return '0 ₫';
      return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
    },
    logout() {
      localStorage.removeItem('token_nguoi_dung');
      localStorage.removeItem('thong_tin_user');
      localStorage.removeItem('token_doi_tac');
      this.$toast && this.$toast.success("Đăng xuất thành công!");
      this.$router.push('/');
    }
  }
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap');

.partner-dashboard-wrapper { background-color: #fff; font-family: 'Plus Jakarta Sans', sans-serif; color: #1a1e29; }
.sidebar-business { width: 320px; background: #fbf9f6; border-right: 1px solid #f0ece6; z-index: 1000; }
.logo-icon-business { width: 48px; height: 48px; background: #ea580c; color: white; border-radius: 12px; display: flex; justify-content: center; align-items: center; box-shadow: 0 8px 16px rgba(234,88,12,0.15); }
.nav-business-item { width: 100%; padding: 18px 25px; border: none; background: transparent; border-radius: 14px; color: #5a5a5a; font-size: 0.95rem; font-weight: 700; display: flex; align-items: center; gap: 15px; transition: 0.3s; text-align: left; }
.nav-business-item i { font-size: 1.5rem; color: #7a7a7a; }
.nav-business-item:hover { background: rgba(234,88,12,0.05); color: #ea580c; }
.nav-business-item:hover i { color: #ea580c; }
.nav-business-item.active { background: #fff; color: #ea580c; box-shadow: 0 10px 20px rgba(0,0,0,0.04); }
.nav-business-item.active i { color: #ea580c; }

.content-header { background: white; border-bottom: 1px solid rgba(0,0,0,0.02); }
.header-avatar-business { width: 46px; height: 46px; border-radius: 50%; object-fit: cover; border: 2px solid #fff; box-shadow: 0 0 0 1px #f0ece6; }

.metric-card-business { background: #fbf9f6; border: 1px solid #f0ece6 !important; transition: 0.4s; }
.metric-card-business:hover { background: white; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.06); transform: translateY(-8px); border-color: #fee7d1 !important; }
.metric-icon { width: 52px; height: 52px; border-radius: 16px; display: flex; justify-content: center; align-items: center; font-size: 1.6rem; }
.bg-soft-orange { background: #fee7d1; } .text-orange { color: #ea580c; }
.bg-soft-success { background: #dcfce7; } .text-success { color: #10b981 !important; }

.search-business { background: #f3f0eb; border-radius: 16px; display: flex; align-items: center; gap: 10px; transition: 0.3s; }
.search-business:focus-within { background: #fff; box-shadow: 0 0 0 2px #ea580c20; }
.search-business input { background: transparent; border: none; outline: none; font-size: 0.9rem; font-weight: 600; width: 100%; color: #1a1e29; }

.premium-table { border-collapse: separate; border-spacing: 0 10px; margin-top: -10px; }
.floating-row { background: white; transition: 0.3s; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); }
.floating-row td { vertical-align: middle; border-top: 1px solid #f0ece6; border-bottom: 1px solid #f0ece6; padding: 14px 10px; }
.floating-row td:first-child { border-left: 1px solid #f0ece6; border-top-left-radius: 16px; border-bottom-left-radius: 16px; }
.floating-row td:last-child { border-right: 1px solid #f0ece6; border-top-right-radius: 16px; border-bottom-right-radius: 16px; }
.floating-row:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(234,88,12,0.08); }

.code-box { background: #fbf9f6; padding: 6px 12px; border-radius: 10px; border: 1px solid #f0ece6; }

.goi-badge { background: #fff7ed; color: #ea580c; padding: 4px 12px; border-radius: 100px; font-size: 0.72rem; font-weight: 800; border: 1px solid #fed7aa; }
.phuong-thuc-badge { background: #f1f5f9; color: #475569; padding: 4px 12px; border-radius: 100px; font-size: 0.72rem; font-weight: 800; }

.status-hoadon { padding: 5px 12px; border-radius: 100px; font-size: 0.7rem; font-weight: 800; display: inline-flex; align-items: center; }
.status-hoadon.success { background: #dcfce7; color: #15803d; }
.status-hoadon.pending { background: #fef3c7; color: #92400e; }
.status-hoadon.failed { background: #fef2f2; color: #b91c1c; }

.feature-icon-bg-mini { width: 44px; height: 44px; background: #fff; border-radius: 12px; display: flex; justify-content: center; align-items: center; font-size: 1.3rem; color: #ea580c; box-shadow: 0 4px 10px rgba(0,0,0,0.02); }
.fw-900 { font-weight: 900; } .fw-800 { font-weight: 800; }
.tracking-tighter { letter-spacing: -1.2px; }
</style>
