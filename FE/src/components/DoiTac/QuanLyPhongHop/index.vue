<template>
  <div class="partner-dashboard-wrapper h-100">
    <div class="main-layout d-flex h-100">

      <!-- Sidebar (AI-Meet Business Branding) -->
      <aside class="sidebar-business d-flex flex-column py-5 shadow-sm">
        <div class="logo-section px-4 mb-5">
          <div class="d-flex align-items-center gap-3" @click="$router.push('/doi-tac/trang-chinh')"
            style="cursor: pointer;">
            <div class="logo-icon-business">
              <i class="bx bxs-component fs-3"></i>
            </div>
            <div>
              <h5 class="mb-0 fw-800 text-dark tracking-tighter">AI-Meet Business</h5>
              <small class="text-muted fw-bold text-uppercase" style="font-size: 0.6rem; letter-spacing: 1.5px">Đối tác
                cao cấp</small>
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
          <button class="nav-business-item active">
            <i class="bx bxs-megaphone"></i>
            <span>Quản lý phòng họp</span>
          </button>
          <button @click="$router.push('/doi-tac/quan-ly-thanh-vien')" class="nav-business-item">
            <i class="bx bxs-group"></i>
            <span>Thành viên</span>
          </button>
<<<<<<< HEAD
          <button @click="$router.push('/doi-tac/hoa-don')" class="nav-business-item">
            <i class="bx bxs-receipt"></i>
            <span>Hóa đơn</span>
          </button>
=======
>>>>>>> cc9aab11d2a2ee70d8c628529683290d7177015d
          <button @click="$router.push('/doi-tac/bao-cao')" class="nav-business-item">
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

      <main class="flex-grow-1 p-0 overflow-auto" style="background: #fbf9f6; min-height: 100vh;">
        <header class="content-header px-5 py-4 d-flex justify-content-between align-items-center">
          <div class="search-business d-none d-lg-flex">
            <i class="bx bx-search text-muted fs-5"></i>
            <input type="text" placeholder="Tìm kiếm dữ liệu, nhân viên..." />
          </div>

          <div class="header-right d-flex align-items-center gap-4">
            <div class="header-icon-btns d-flex gap-3">
              <div class="icon-btn-plain"><i class="bx bxs-bell fs-4"></i><span class="dot-badge"></span></div>
              <div class="icon-btn-plain"><i class="bx bxs-calendar fs-4"></i></div>
            </div>

            <div class="profile-trigger-business d-flex align-items-center gap-3 cursor-pointer"
              @click="$router.push('/doi-tac/profile')">
              <div class="text-end d-none d-md-block">
                <h6 class="mb-0 fw-800 text-dark" style="font-size: 0.9rem">{{ partnerName }}</h6>
                <small class="text-muted" style="font-size: 0.75rem">{{ partnerPosition }}</small>
              </div>
              <img :src="avatarUrl" alt="Avatar" class="header-avatar-business shadow-sm" />
            </div>
          </div>
        </header>

        <div class="px-5 py-4">
          <div class="d-flex justify-content-between align-items-center mb-5">
            <div class="greeting-section">
              <div class="d-flex align-items-center gap-3 mb-2">
                <div class="feature-icon-bg-mini"><i class='bx bxs-megaphone fs-4'></i></div>
                <h2 class="fw-900 text-dark mb-0">Quản lý phòng họp</h2>
              </div>
              <p class="text-muted fw-500 mb-0 ms-5 ps-2">Thiết lập, điều hành và giám sát chất lượng cuộc họp AI.</p>
            </div>
            <div class="header-actions-business d-flex gap-3">
              <button data-bs-toggle="modal" data-bs-target="#modalJoinNhanh"
                class="btn btn-light-orange-pro px-4 py-3 fw-800 rounded-4 border-0">
                <i class="bx bx-key me-2"></i> Tham gia bằng mã
              </button>
              <button data-bs-toggle="modal" data-bs-target="#modalTaoPhong"
                class="btn btn-orange-pro px-4 py-3 fw-800 rounded-4 border-0 text-white shadow-orange">
                <i class="bx bx-plus-circle me-2"></i> Khởi tạo phòng mới
              </button>
            </div>
          </div>

          <div class="row g-4 mb-5">
            <div class="col-md-4">
              <div
                class="metric-card-business p-4 rounded-5 border-0 d-flex align-items-center justify-content-between">
                <div>
                  <label class="text-muted small fw-800 text-uppercase mb-2 d-block">Phòng đang trực tuyến</label>
                  <div class="d-flex align-items-baseline gap-2">
                    <h2 class="fw-900 mb-0">{{ds_phong.filter(p => p.trang_thai == 1).length}}</h2>
                    <span class="text-success small fw-bold">Live</span>
                  </div>
                </div>
                <div class="metric-icon bg-soft-success text-success mb-0"><i class='bx bx-broadcast'></i></div>
              </div>
            </div>
            <div class="col-md-4">
              <div
                class="metric-card-business p-4 rounded-5 border-0 d-flex align-items-center justify-content-between">
                <div>
                  <label class="text-muted small fw-800 text-uppercase mb-2 d-block">Tổng sức chứa</label>
                  <div class="d-flex align-items-baseline gap-2">
                    <h2 class="fw-900 mb-0">{{ds_phong.reduce((sum, p) => sum + p.so_nguoi_toi_da, 0)}}</h2>
                    <span class="text-muted small fw-bold">Thành viên</span>
                  </div>
                </div>
                <div class="metric-icon bg-soft-orange text-orange mb-0"><i class='bx bxs-group'></i></div>
              </div>
            </div>
            <div class="col-md-4">
              <div
                class="metric-card-business p-4 rounded-5 border-0 d-flex align-items-center justify-content-between">
                <div>
                  <label class="text-muted small fw-800 text-uppercase mb-2 d-block">Phòng đã đóng</label>
                  <div class="d-flex align-items-baseline gap-2">
                    <h2 class="fw-900 mb-0">{{ds_phong.filter(p => p.trang_thai == 0).length}}</h2>
                    <span class="text-muted small fw-bold">Lịch sử</span>
                  </div>
                </div>
                <div class="metric-icon bg-light text-secondary mb-0"><i class='bx bx-archive-in'></i></div>
              </div>
            </div>
          </div>

          <div class="metric-card-business p-4 p-md-5 rounded-5 border-0 mb-5 shadow-premium-lite bg-white">
            <div class="d-flex align-items-center justify-content-between mb-4">
              <h4 class="fw-900 text-dark mb-0">Danh sách phiên làm việc</h4>
              <div class="search-business" style="width: 300px; padding: 8px 15px;">
                <i class="bx bx-search text-muted"></i>
                <input type="text" placeholder="Tìm tên phòng..." style="font-size: 0.8rem;" />
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-borderless premium-table align-middle w-100">
                <thead>
                  <tr class="text-muted small fw-800 text-uppercase border-bottom">
                    <th class="pb-3 ps-3">Thông tin phòng</th>
                    <th class="pb-3">Người tạo</th>
                    <th class="pb-3">Mã tham gia</th>
                    <th class="pb-3">Thời gian</th>
                    <th class="pb-3 text-center">Người tối đa</th>
                    <th class="pb-3 text-center">Trạng thái</th>
                    <th class="pb-3 text-end pe-3">Thao tác</th>
                  </tr>
                </thead>
                <tbody class="pt-3">
                  <tr v-for="(v, k) in ds_phong" :key="k" class="floating-row">
                    <td class="ps-3">
                      <div class="d-flex align-items-center gap-3">
                        <div class="room-avatar"><i class='bx bxs-video'></i></div>
                        <div>
                          <h6 class="fw-800 text-dark mb-0">{{ v.ten_phong }}</h6>
                          <small class="text-orange fw-bold" style="font-size: 0.7rem;"><i
                              class='bx bxs-shield-check me-1'></i>Bảo mật AI</small>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="d-flex align-items-center gap-2">
                        <div class="creator-avatar-mini">{{ v.chu_phong?.ho_va_ten?.charAt(0) }}</div>
                        <span class="fw-700 text-dark small">{{ v.chu_phong?.ho_va_ten }}</span>
                      </div>
                    </td>
                    <td>
                      <div class="code-box d-inline-flex align-items-center gap-2" @click="copyCode(v.ma_phong)"
                        title="Nhấn để copy">
                        <span class="fw-900 text-dark">{{ v.ma_phong }}</span>
                        <i class='bx bx-copy text-muted'></i>
                      </div>
                    </td>
                    <td>
                      <div class="d-flex flex-column">
                        <span class="fw-800 text-dark" style="font-size: 0.85rem;">{{
                          formatDate(v.thoi_gian_bat_dau).date }}</span>
                        <small class="text-muted fw-bold">{{ formatDate(v.thoi_gian_bat_dau).time }}</small>
                      </div>
                    </td>
                    <td class="text-center">
                      <div class="capacity-badge">
                        <i class='bx bxs-user-detail me-1'></i> {{ v.so_nguoi_toi_da }}
                      </div>
                    </td>
                    <td class="text-center">
                      <div v-if="v.trang_thai == 1" class="status-pill-business live d-inline-flex">
                        <span class="pulse-dot-mini me-1"></span> LIVE
                      </div>
                      <div v-else class="status-pill-business idle d-inline-flex">
                        <span class="dot"></span> ĐÃ ĐÓNG
                      </div>
                    </td>
                    <td class="text-end pe-3">
                      <button @click="vàoPhong(v.ma_phong)" class="btn btn-action-pro primary me-2"
                        v-if="v.trang_thai == 1" title="Vào phòng">
                        <i class='bx bx-play'></i>
                      </button>
                      <button class="btn btn-action-pro secondary me-2" v-else title="Xem báo cáo">
                        <i class='bx bx-bar-chart-alt-2'></i>
                      </button>
                      <button @click="dongPhong(v)" class="btn btn-action-pro danger"
                        :title="v.trang_thai == 1 ? 'Đóng phòng họp' : 'Mở lại phòng'">
                        <i :class="v.trang_thai == 1 ? 'bx bx-stop-circle' : 'bx bx-revision'"></i>
                      </button>
                    </td>
                  </tr>
                  <tr v-if="ds_phong.length === 0">
                    <td colspan="7" class="text-center py-5">
                      <div class="feature-icon-bg-mini mx-auto mb-3"
                        style="width: 60px; height: 60px; font-size: 2rem;"><i class='bx bx-folder-open text-muted'></i>
                      </div>
                      <h5 class="fw-800 text-dark">Chưa có dữ liệu phòng họp</h5>
                      <p class="text-muted fw-bold small">Bạn chưa tạo cuộc họp nào. Nhấn "Khởi tạo phòng mới" để bắt
                        đầu.</p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </main>
    </div>

    <div class="modal fade" id="modalTaoPhong" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-5 border-0 shadow-lg overflow-hidden" style="background: #fbf9f6;">
          <div class="modal-header border-0 px-5 pt-5 pb-2">
            <div class="d-flex align-items-center gap-3">
              <div class="feature-icon-bg-mini"><i class='bx bx-video-plus'></i></div>
              <h4 class="modal-title fw-900 text-dark mb-0">Khởi tạo phòng họp</h4>
            </div>
            <button type="button" class="btn-close" id="closeModalTaoPhong" data-bs-dismiss="modal"
              aria-label="Close"></button>
          </div>
          <div class="modal-body px-5 py-4">
            <div class="mb-4">
              <label class="fw-800 small text-muted mb-2">Tên cuộc họp <span class="text-danger">*</span></label>
              <div class="input-premium-group">
                <i class='bx bx-bookmark'></i>
                <input v-model="formTaoPhong.ten_phong" type="text"
                  placeholder="Ví dụ: Họp báo cáo tiến độ dự án AI...">
              </div>
            </div>
            <div class="row g-4">
              <div class="col-md-6">
                <label class="fw-800 small text-muted mb-2">Sức chứa tối đa</label>
                <div class="input-premium-group bg-light-faint">
                  <i class='bx bx-group'></i>
                  <input v-model="formTaoPhong.so_nguoi_toi_da" type="number" placeholder="Theo gói" class="text-muted">
                </div>
              </div>
              <div class="col-md-6">
                <label class="fw-800 small text-muted mb-2">Thời gian bắt đầu</label>
                <div class="input-premium-group">
                  <input v-model="formTaoPhong.thoi_gian_bat_dau" type="datetime-local" style="padding-left: 20px;">
                </div>
              </div>
              <div class="col-12">
                <label class="fw-800 small text-muted mb-2">Gửi lời mời qua Email <span class="text-muted fw-500">(tùy
                    chọn)</span></label>
                <div class="input-premium-group">
                  <i class='bx bx-envelope'></i>
                  <input v-model="formTaoPhong.email_khach_moi" type="text"
                    placeholder="email1@domain.com, email2@domain.com (cách nhau bằng dấu phẩy)">
                </div>
                <small class="text-muted fw-600 ms-2 mt-1 d-block" style="font-size: 0.72rem;"><i
                    class="bx bx-info-circle me-1"></i>Hệ thống sẽ tự động gửi email thông báo kèm mã phòng đến những
                  địa chỉ này.</small>
              </div>
            </div>
          </div>
          <div class="modal-footer border-0 px-5 pb-5 pt-0">
            <button type="button" class="btn btn-light-orange-pro py-3 px-4 rounded-4 fw-800 border-0 flex-grow-1"
              data-bs-dismiss="modal">Hủy thao tác</button>
            <button @click="taoPhong" type="button"
              class="btn btn-orange-pro py-3 px-4 rounded-4 fw-800 text-white shadow-orange flex-grow-1">
              Khởi tạo hệ thống
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Join Modal -->
    <div class="modal fade" id="modalJoinNhanh" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-5 border-0 shadow-lg overflow-hidden" style="background: #fbf9f6;">
          <div class="modal-header border-0 px-5 pt-5 pb-2">
            <div class="d-flex align-items-center gap-3">
              <div class="feature-icon-bg-mini"><i class='bx bx-key'></i></div>
              <h4 class="modal-title fw-900 text-dark mb-0">Tham gia cuộc họp</h4>
            </div>
            <button type="button" class="btn-close" id="closeModalJoinNhanh" data-bs-dismiss="modal"
              aria-label="Close"></button>
          </div>
          <div class="modal-body px-5 py-4">
            <div class="mb-4">
              <label class="fw-800 small text-muted mb-2">Mã phòng họp <span class="text-danger">*</span></label>
              <div class="input-premium-group">
                <i class='bx bx-hash'></i>
                <input v-model="ma_phong_join_nhanh" type="text" placeholder="Nhập mã phòng (VD: u2c-c1t5-etj)...">
              </div>
            </div>
          </div>
          <div class="modal-footer border-0 px-5 pb-5 pt-0">
            <button type="button" class="btn btn-light-orange-pro py-3 px-4 rounded-4 fw-800 border-0 flex-grow-1"
              data-bs-dismiss="modal">Hủy</button>
            <button @click="xácNhậnJoinNhanh" data-bs-dismiss="modal" type="button"
              class="btn btn-orange-pro py-3 px-4 rounded-4 fw-800 text-white shadow-orange flex-grow-1">
              Xác thực & Tham gia
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
const apiUrl = import.meta.env.VITE_API_URL;

export default {
  name: "QuanLyPhongHop",
  data() {
    return {
      partnerId: null,
      partnerName: "Công ty Đối tác",
      partnerPosition: "Đối tác",
      avatarUrl: "https://i.pravatar.cc/150?u=admin_anhkim",
      ds_phong: [],
      formTaoPhong: { ten_phong: '', so_nguoi_toi_da: null, thoi_gian_bat_dau: '', email_khach_moi: '' },
      ma_phong_join_nhanh: '',
      hasFaceId: false
    };
  },
  async mounted() {
    await this.fetchPartnerData();
    this.loadPhong();
  },
  methods: {
    async fetchPartnerData() {
      try {
        const token = localStorage.getItem('token_doi_tac');
        if (!token) {
          this.$router.push('/dang-nhap');
          return;
        }
        const res = await axios.get(`${apiUrl}/doi-tac/me`, {
          headers: { Authorization: 'Bearer ' + token }
        });
        if (res.data.status) {
          this.partnerId = res.data.data.id;
          this.partnerName = res.data.data.ho_va_ten;
          this.partnerPosition = res.data.data.chuc_vu?.ten_chuc_vu || (res.data.data.id_doi_tac == 1 ? "Quản trị viên Đối tác" : "Đối tác");
          this.hasFaceId = !!res.data.data.du_lieu_khuon_mat;
          const hinh_anh = res.data.data.hinh_anh;
          if (hinh_anh) {
            const baseUrl = apiUrl.replace('/api', '');
            const cleanPath = hinh_anh.includes('uploads/') ? hinh_anh : `uploads/avatars/${hinh_anh}`;
            this.avatarUrl = hinh_anh.startsWith('http') ? hinh_anh : `${baseUrl}/${cleanPath}`;
          }
        }
      } catch (e) {
        this.$router.push('/dang-nhap');
      }
    },
    async loadPhong() {
      if (!this.partnerId) return;
      try {
        const res = await axios.get(`${apiUrl}/phong-hop/data-by-chu-phong`, {
          params: { id_chu_phong: this.partnerId }
        });
        if (res.data.status) {
          this.ds_phong = res.data.data;
        }
      } catch (error) { console.error("Lỗi tải phòng:", error); }
    },
    vàoPhong(ma_phong) {
      if (!this.checkFaceId()) return;
      sessionStorage.setItem('join_ma_phong_tmp', ma_phong);
      this.$router.push('/doi-tac/phong-hop');
    },
    checkFaceId() {
      if (!this.hasFaceId) {
        this.$toast.warning("Bạn chưa thiết lập Face ID! Vui lòng vào mục Cài đặt để thiết lập trước khi sử dụng tính năng này.");
        this.$router.push('/doi-tac/profile');
        return false;
      }
      return true;
    },
    xácNhậnJoinNhanh() {
      if (!this.checkFaceId()) return;
      if (!this.ma_phong_join_nhanh.trim()) {
        this.$toast.warning("Vui lòng nhập mã phòng!");
        return;
      }

      this.vàoPhong(this.ma_phong_join_nhanh.trim());
    },
    async taoPhong() {
      if (!this.checkFaceId()) {
        // Đóng modal nếu đang mở
        const modalElement = document.getElementById('modalTaoPhong');
        const modal = bootstrap.Modal.getInstance(modalElement);
        if (modal) modal.hide();
        return;
      }
      try {
        if (!this.formTaoPhong.ten_phong) return this.$toast.warning("Vui lòng nhập tên cuộc họp!");
        const id_chu_phong = this.partnerId;
        const payload = { ...this.formTaoPhong, id_chu_phong: id_chu_phong };
        const res = await axios.post(`${apiUrl}/phong-hop/create`, payload);

        if (res.data.status) {
          this.$toast.success("Tạo phòng thành công!");
          document.getElementById('closeModalTaoPhong').click();
          this.formTaoPhong = { ten_phong: '', so_nguoi_toi_da: null, thoi_gian_bat_dau: '', email_khach_moi: '' };
          this.loadPhong();
        }
      } catch (error) {
        this.$toast.error(error.response?.data?.message || "Có lỗi xảy ra");
      }
    },
    copyCode(code) {
      navigator.clipboard.writeText(code);
      this.$toast.success("Đã copy mã: " + code);
    },
    formatDate(dateString) {
      if (!dateString) return { date: 'Hôm nay', time: 'Ngay bây giờ' };
      const d = new Date(dateString);
      return {
        date: d.toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit', year: 'numeric' }),
        time: d.toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' })
      };
    },
    async dongPhong(item) {
      const isClosing = item.trang_thai == 1;
      const message = isClosing
        ? "Bạn có chắc chắn muốn ĐỐNG phòng họp này? Người tham gia sẽ không thể tiếp tục truy cập."
        : "Bạn có chắc chắn muốn MỞ LẠI phòng họp này?";

      if (!confirm(message)) {
        return;
      }

      try {
        const res = await axios.post(`${apiUrl}/phong-hop/change-status`, {
          id: item.id
        });

        if (res.data.status) {
          this.$toast.success("Đã cập nhật trạng thái phòng họp!");
          this.loadPhong(); // Load lại dữ liệu để bảng tự động cập nhật
        } else {
          this.$toast.error(res.data.message || "Không thể thực hiện thao tác này.");
        }
      } catch (error) {
        console.error("Lỗi đóng phòng:", error);
        this.$toast.error("Có lỗi xảy ra khi đóng phòng!");
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
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap');

.partner-dashboard-wrapper {
  background-color: #fff;
  font-family: 'Plus Jakarta Sans', sans-serif;
  color: #1a1e29;
}

.sidebar-business {
  width: 320px;
  background: #fbf9f6;
  border-right: 1px solid #f0ece6;
  z-index: 1000;
}

.logo-icon-business {
  width: 48px;
  height: 48px;
  background: #ea580c;
  color: white;
  border-radius: 12px;
  display: flex;
  justify-content: center;
  align-items: center;
  box-shadow: 0 8px 16px rgba(234, 88, 12, 0.15);
}

.nav-business-item {
  width: 100%;
  padding: 18px 25px;
  border: none;
  background: transparent;
  border-radius: 14px;
  color: #5a5a5a;
  font-size: 0.95rem;
  font-weight: 700;
  display: flex;
  align-items: center;
  gap: 15px;
  transition: 0.3s;
  text-align: left;
}

.nav-business-item i {
  font-size: 1.5rem;
  color: #7a7a7a;
}

.nav-business-item:hover {
  background: rgba(234, 88, 12, 0.05);
  color: #ea580c;
}

.nav-business-item:hover i {
  color: #ea580c;
}

.nav-business-item.active {
  background: #fff;
  color: #ea580c;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.04);
}

.nav-business-item.active i {
  color: #ea580c;
}

.content-header {
  border-bottom: 1px solid rgba(0, 0, 0, 0.02);
}

.search-business {
  background: #f3f0eb;
  border-radius: 16px;
  padding: 12px 25px;
  width: 480px;
  align-items: center;
  gap: 12px;
  transition: 0.3s;
}

.search-business:focus-within {
  background: #fff;
  box-shadow: 0 0 0 2px #ea580c20;
}

.search-business input {
  background: transparent;
  border: none;
  outline: none;
  font-size: 0.9rem;
  font-weight: 600;
  width: 100%;
  color: #1a1e29;
}

.header-avatar-business {
  width: 46px;
  height: 46px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid #fff;
  box-shadow: 0 0 0 1px #f0ece6;
}

.icon-btn-plain {
  width: 46px;
  height: 46px;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  color: #5a5a5a;
  position: relative;
  border-radius: 12px;
  transition: 0.2s;
}

.icon-btn-plain:hover {
  background: #fbf9f6;
  color: #1a1e29;
}

.dot-badge {
  position: absolute;
  top: 10px;
  right: 10px;
  width: 9px;
  height: 9px;
  background: #ea580c;
  border-radius: 50%;
  border: 2.5px solid white;
}

.metric-card-business {
  background: #fbf9f6;
  border: 1px solid #f0ece6 !important;
  transition: 0.4s;
}

.metric-card-business:hover {
  background: white;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.06);
  transform: translateY(-8px);
  border-color: #fee7d1 !important;
}

.metric-icon {
  width: 52px;
  height: 52px;
  border-radius: 16px;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 1.6rem;
}

.bg-soft-orange {
  background: #fee7d1;
}

.text-orange {
  color: #ea580c;
}

.bg-soft-success {
  background: #dcfce7;
}

.text-success {
  color: #10b981;
}

.feature-icon-bg-mini {
  width: 44px;
  height: 44px;
  background: #fff;
  border-radius: 12px;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 1.3rem;
  color: #ea580c;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
}

.input-premium-group {
  position: relative;
  display: flex;
  align-items: center;
}

.input-premium-group i {
  position: absolute;
  left: 20px;
  color: #ea580c;
  font-size: 1.3rem;
}

.input-premium-group input {
  width: 100%;
  padding: 16px 20px 16px 55px;
  border-radius: 18px;
  border: 2px solid #f0ece6;
  background: #fff;
  outline: none;
  font-weight: 600;
  transition: 0.3s;
}

.input-premium-group input:focus {
  border-color: #ea580c;
  box-shadow: 0 0 0 4px rgba(234, 88, 12, 0.05);
}

.btn-orange-pro {
  background: #ea580c;
  color: #fff !important;
}

.btn-light-orange-pro {
  background: #fbf9f6;
  color: #ea580c;
  border: 1.5px solid #f0ece6 !important;
}

.shadow-orange {
  box-shadow: 0 12px 30px rgba(234, 88, 12, 0.25);
}

.premium-table {
  border-collapse: separate;
  border-spacing: 0 12px;
  margin-top: -12px;
}

.floating-row {
  background: white;
  transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  border-radius: 18px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
}

.floating-row td {
  vertical-align: middle;
  border-top: 1px solid #f0ece6;
  border-bottom: 1px solid #f0ece6;
  padding: 16px 10px;
}

.floating-row td:first-child {
  border-left: 1px solid #f0ece6;
  border-top-left-radius: 18px;
  border-bottom-left-radius: 18px;
}

.floating-row td:last-child {
  border-right: 1px solid #f0ece6;
  border-top-right-radius: 18px;
  border-bottom-right-radius: 18px;
}

.floating-row:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 25px rgba(234, 88, 12, 0.1);
  border-color: transparent;
}

.room-avatar {
  width: 44px;
  height: 44px;
  background: #f8fafc;
  border-radius: 14px;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 1.4rem;
  color: #64748b;
  border: 1px solid #e2e8f0;
}

.code-box {
  background: #fbf9f6;
  padding: 6px 12px;
  border-radius: 8px;
  cursor: pointer;
  transition: 0.2s;
  border: 1px solid #f0ece6;
}

.code-box:hover {
  background: #fee7d1;
  border-color: #fdba74;
}

.capacity-badge {
  background: #f8fafc;
  color: #475569;
  padding: 6px 12px;
  border-radius: 8px;
  font-weight: 800;
  font-size: 0.8rem;
  border: 1px solid #e2e8f0;
}

.status-pill-business {
  padding: 6px 14px;
  border-radius: 100px;
  font-size: 0.65rem;
  font-weight: 900;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  letter-spacing: 0.5px;
}

.status-pill-business.live {
  background: #fef2f2;
  color: #ef4444;
  border: 1px solid #fecaca;
}

.status-pill-business.idle {
  background: #f8fafc;
  color: #64748b;
  border: 1px solid #e2e8f0;
}

.pulse-dot-mini {
  width: 6px;
  height: 6px;
  background: #ef4444;
  border-radius: 50%;
  animation: pulse 1.5s infinite;
}

@keyframes pulse {
  0% {
    transform: scale(0.95);
    box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
  }

  70% {
    transform: scale(1);
    box-shadow: 0 0 0 4px rgba(239, 68, 68, 0);
  }

  100% {
    transform: scale(0.95);
    box-shadow: 0 0 0 0 rgba(0, 0, 0, 0);
  }
}

.btn-action-pro {
  width: 38px;
  height: 38px;
  border-radius: 12px;
  border: none;
  display: inline-flex;
  justify-content: center;
  align-items: center;
  font-size: 1.2rem;
  transition: 0.2s;
}

.btn-action-pro.primary {
  background: #fee7d1;
  color: #ea580c;
}

.btn-action-pro.primary:hover {
  background: #ea580c;
  color: white;
}

.btn-action-pro.secondary {
  background: #f8fafc;
  color: #475569;
  border: 1px solid #e2e8f0;
}

.btn-action-pro.secondary:hover {
  background: #e2e8f0;
}

.btn-action-pro.danger {
  background: transparent;
  color: #cbd5e1;
}

.btn-action-pro.danger:hover {
  color: #ef4444;
  background: #fef2f2;
}

/* UTILITIES */
.fw-900 {
  font-weight: 900;
}

.fw-800 {
  font-weight: 800;
}

.tracking-tighter {
  letter-spacing: -1.2px;
}

.bg-light-faint {
  background-color: #fbf9f6 !important;
}

.creator-avatar-mini {
  width: 28px;
  height: 28px;
  background: #ea580c;
  color: white;
  border-radius: 8px;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 0.7rem;
  font-weight: 800;
  box-shadow: 0 4px 8px rgba(234, 88, 12, 0.15);
}
</style>