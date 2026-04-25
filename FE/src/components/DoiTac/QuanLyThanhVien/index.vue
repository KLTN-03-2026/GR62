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
          <button class="nav-business-item active">
            <i class="bx bxs-group"></i><span>Thành viên</span>
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
            <h4 class="mb-0 fw-800 text-dark">Quản lý Thành viên</h4>
            <p class="mb-0 text-muted small fw-500">Cấp và thu hồi quyền thành viên tổ chức</p>
          </div>
          <div class="d-flex align-items-center gap-3">
            <button @click="showModal = true" class="btn btn-orange-pro px-4 py-2 fw-800 rounded-4 border-0 text-white shadow-orange">
              <i class="bx bx-user-plus me-2"></i>Thêm thành viên
            </button>
            <div class="profile-trigger-business d-flex align-items-center gap-3 cursor-pointer" @click="$router.push('/doi-tac/profile')">
              <img :src="avatarUrl" alt="Avatar" class="header-avatar-business shadow-sm">
            </div>
          </div>
        </header>

        <div class="px-5 py-4">
          <!-- Stats Row -->
          <div class="row g-4 mb-5">
            <div class="col-md-4">
              <div class="metric-card-business p-4 rounded-5 border-0 d-flex align-items-center justify-content-between">
                <div>
                  <label class="text-muted small fw-800 text-uppercase mb-2 d-block">Tổng thành viên</label>
                  <h2 class="fw-900 mb-0">{{ danh_sach.length }}</h2>
                </div>
                <div class="metric-icon bg-soft-orange text-orange mb-0"><i class="bx bxs-group"></i></div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="metric-card-business p-4 rounded-5 border-0 d-flex align-items-center justify-content-between">
                <div>
                  <label class="text-muted small fw-800 text-uppercase mb-2 d-block">Đang hoạt động</label>
                  <h2 class="fw-900 mb-0 text-success">{{ danh_sach.filter(m => m.trang_thai).length }}</h2>
                </div>
                <div class="metric-icon bg-soft-success text-success mb-0"><i class="bx bx-check-circle"></i></div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="metric-card-business p-4 rounded-5 border-0 d-flex align-items-center justify-content-between">
                <div>
                  <label class="text-muted small fw-800 text-uppercase mb-2 d-block">Bị khóa</label>
                  <h2 class="fw-900 mb-0 text-danger">{{ danh_sach.filter(m => !m.trang_thai).length }}</h2>
                </div>
                <div class="metric-icon bg-soft-danger text-danger mb-0"><i class="bx bx-block"></i></div>
              </div>
            </div>
          </div>

          <!-- Member Table -->
          <div class="metric-card-business p-4 p-md-5 rounded-5 border-0 shadow-premium-lite bg-white">
            <div class="d-flex align-items-center justify-content-between mb-4">
              <h4 class="fw-900 text-dark mb-0">Danh sách thành viên</h4>
              <div class="search-business" style="width: 280px; padding: 8px 15px;">
                <i class="bx bx-search text-muted"></i>
                <input type="text" v-model="keyword" placeholder="Tìm tên, email..." style="font-size: 0.8rem;">
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
                    <th class="pb-3 ps-3">Thành viên</th>
                    <th class="pb-3">Email</th>
                    <th class="pb-3">Số điện thoại</th>
                    <th class="pb-3 text-center">Trạng thái</th>
                    <th class="pb-3 text-center">Ngày tham gia</th>
                    <th class="pb-3 text-end pe-3">Thao tác</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="tv in filtered" :key="tv.id" class="floating-row">
                    <td class="ps-3">
                      <div class="d-flex align-items-center gap-3">
                        <div class="member-avatar">
                          <img v-if="tv.avatar" :src="tv.avatar" class="w-100 h-100 object-fit-cover rounded-circle">
                          <span v-else>{{ tv.ho_va_ten?.charAt(0) }}</span>
                        </div>
                        <div>
                          <h6 class="fw-800 text-dark mb-0">{{ tv.ho_va_ten }}</h6>
                          <small class="text-orange fw-bold" style="font-size: 0.7rem;"><i class="bx bxs-check-shield me-1"></i>Thành viên tổ chức</small>
                        </div>
                      </div>
                    </td>
                    <td><span class="fw-700 text-muted small">{{ tv.email }}</span></td>
                    <td><span class="fw-700 text-muted small">{{ tv.so_dien_thoai || '—' }}</span></td>
                    <td class="text-center">
                      <div v-if="tv.trang_thai" class="status-pill-business active d-inline-flex"><span class="dot"></span>Hoạt động</div>
                      <div v-else class="status-pill-business idle d-inline-flex"><span class="dot"></span>Bị khóa</div>
                    </td>
                    <td class="text-center">
                      <span class="fw-700 text-muted small">{{ formatDate(tv.ngay_tham_gia) }}</span>
                    </td>
                    <td class="text-end pe-3">
                      <button @click="openEdit(tv)" class="btn btn-action-pro edit me-2" title="Chỉnh sửa">
                        <i class="bx bx-edit"></i>
                      </button>
                      <button @click="confirmRevoke(tv)" class="btn btn-action-pro danger" title="Thu hồi quyền">
                        <i class="bx bx-user-minus"></i>
                      </button>
                    </td>
                  </tr>
                  <tr v-if="filtered.length === 0 && !isLoading">
                    <td colspan="6" class="text-center py-5">
                      <div class="feature-icon-bg-mini mx-auto mb-3" style="width: 60px; height: 60px; font-size: 2rem;">
                        <i class="bx bx-user-x text-muted"></i>
                      </div>
                      <h5 class="fw-800 text-dark">Chưa có thành viên nào</h5>
                      <p class="text-muted fw-bold small">Nhấn "Thêm thành viên" để cấp quyền cho người dùng.</p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </main>
    </div>

    <!-- Modal Thêm Thành Viên -->
    <div v-if="showModal" class="modal-overlay" @click.self="showModal = false">
      <div class="modal-business animate__animated animate__fadeInUp">
        <div class="d-flex align-items-center gap-3 mb-4">
          <div class="feature-icon-bg-mini"><i class="bx bx-user-plus"></i></div>
          <h4 class="fw-900 text-dark mb-0">Thêm thành viên</h4>
          <button @click="showModal = false" class="btn-close ms-auto shadow-none"></button>
        </div>
        <p class="text-muted small fw-500 mb-4">Nhập email của người dùng để cấp quyền thành viên tổ chức.</p>

        <label class="fw-800 small text-muted mb-2">Email người dùng <span class="text-danger">*</span></label>
        <div class="input-premium-group mb-4">
          <i class="bx bx-envelope"></i>
          <input v-model="emailCapQuyen" type="email" placeholder="example@email.com" @keyup.enter="capQuyen">
        </div>

        <div class="d-flex gap-3">
          <button @click="showModal = false" class="btn btn-light-orange-pro flex-grow-1 py-3 fw-800 rounded-4 border-0">Hủy</button>
          <button @click="capQuyen" :disabled="isCapQuyen" class="btn btn-orange-pro flex-grow-1 py-3 fw-800 rounded-4 border-0 text-white shadow-orange">
            <span v-if="isCapQuyen" class="spinner-border spinner-border-sm me-2"></span>
            {{ isCapQuyen ? 'Đang xử lý...' : 'Cấp quyền' }}
          </button>
        </div>
      </div>
    </div>

    <!-- Modal Chỉnh sửa Thành Viên -->
    <div v-if="showEditModal" class="modal-overlay" @click.self="showEditModal = false">
      <div class="modal-business animate__animated animate__fadeInUp">
        <div class="d-flex align-items-center gap-3 mb-4">
          <div class="feature-icon-bg-mini"><i class="bx bx-edit"></i></div>
          <h4 class="fw-900 text-dark mb-0">Chỉnh sửa thành viên</h4>
          <button @click="showEditModal = false" class="btn-close ms-auto shadow-none"></button>
        </div>
        <p class="text-muted small fw-500 mb-4">Cập nhật họ tên và số điện thoại của thành viên.</p>

        <label class="fw-800 small text-muted mb-2">Họ và tên <span class="text-danger">*</span></label>
        <div class="input-premium-group mb-3">
          <i class="bx bx-user"></i>
          <input v-model="editForm.ho_va_ten" type="text" placeholder="Nguyễn Văn A">
        </div>

        <label class="fw-800 small text-muted mb-2 mt-1">Số điện thoại</label>
        <div class="input-premium-group mb-4">
          <i class="bx bx-phone"></i>
          <input v-model="editForm.so_dien_thoai" type="text" placeholder="0901234567">
        </div>

        <div class="d-flex gap-3">
          <button @click="showEditModal = false" class="btn btn-light-orange-pro flex-grow-1 py-3 fw-800 rounded-4 border-0">Hủy</button>
          <button @click="saveEdit" :disabled="isSaving" class="btn btn-orange-pro flex-grow-1 py-3 fw-800 rounded-4 border-0 text-white shadow-orange">
            <span v-if="isSaving" class="spinner-border spinner-border-sm me-2"></span>
            {{ isSaving ? 'Đang lưu...' : 'Lưu thay đổi' }}
          </button>
        </div>
      </div>
    </div>

    <!-- Confirm Revoke Modal -->
    <div v-if="showRevokeConfirm" class="modal-overlay" @click.self="showRevokeConfirm = false">
      <div class="modal-business animate__animated animate__fadeInUp" style="max-width: 420px;">
        <div class="text-center mb-4">
          <div class="mx-auto mb-3 d-flex justify-content-center align-items-center rounded-circle" style="width: 72px; height: 72px; background: #fef2f2;">
            <i class="bx bx-user-minus" style="font-size: 2.2rem; color: #ef4444;"></i>
          </div>
          <h4 class="fw-900 text-dark mb-2">Thu hồi quyền thành viên?</h4>
          <p class="text-muted small fw-500 mb-0">Bạn có chắc muốn thu hồi quyền thành viên của <strong>{{ selectedMember?.ho_va_ten }}</strong>? Họ sẽ không còn thuộc tổ chức của bạn.</p>
        </div>
        <div class="d-flex gap-3">
          <button @click="showRevokeConfirm = false" class="btn btn-light-orange-pro flex-grow-1 py-3 fw-800 rounded-4 border-0">Hủy</button>
          <button @click="thuHoiQuyen" :disabled="isRevoking" class="btn flex-grow-1 py-3 fw-800 rounded-4 border-0 text-white" style="background: #ef4444;">
            <span v-if="isRevoking" class="spinner-border spinner-border-sm me-2"></span>
            {{ isRevoking ? 'Đang xử lý...' : 'Thu hồi' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
const apiUrl = import.meta.env.VITE_API_URL;

export default {
  name: 'QuanLyThanhVien',
  data() {
    return {
      avatarUrl: 'https://i.pravatar.cc/150?u=partner',
      danh_sach: [],
      keyword: '',
      isLoading: false,
      showModal: false,
      emailCapQuyen: '',
      isCapQuyen: false,
      showEditModal: false,
      editForm: { id_nguoi_dung: null, ho_va_ten: '', so_dien_thoai: '' },
      isSaving: false,
      showRevokeConfirm: false,
      selectedMember: null,
      isRevoking: false,
    };
  },
  computed: {
    filtered() {
      if (!this.keyword.trim()) return this.danh_sach;
      const kw = this.keyword.toLowerCase();
      return this.danh_sach.filter(m =>
        m.ho_va_ten?.toLowerCase().includes(kw) ||
        m.email?.toLowerCase().includes(kw)
      );
    }
  },
  async mounted() {
    await this.loadProfile();
    await this.loadThanhVien();
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
    async loadThanhVien() {
      this.isLoading = true;
      try {
        const token = localStorage.getItem('token_doi_tac');
        const res = await axios.get(`${apiUrl}/doi-tac/thanh-vien`, { headers: { Authorization: 'Bearer ' + token } });
        if (res.data.status) this.danh_sach = res.data.data;
      } catch (e) {
        this.$toast?.error('Lỗi tải danh sách thành viên!');
      } finally {
        this.isLoading = false;
      }
    },
    async capQuyen() {
      if (!this.emailCapQuyen.trim()) { this.$toast?.warning('Vui lòng nhập email!'); return; }
      this.isCapQuyen = true;
      try {
        const token = localStorage.getItem('token_doi_tac');
        const res = await axios.post(`${apiUrl}/doi-tac/thanh-vien/cap-quyen`,
          { email: this.emailCapQuyen },
          { headers: { Authorization: 'Bearer ' + token } }
        );
        if (res.data.status) {
          this.$toast?.success('Cấp quyền thành công!');
          this.showModal = false;
          this.emailCapQuyen = '';
          await this.loadThanhVien();
        }
      } catch (e) {
        this.$toast?.error(e.response?.data?.message || 'Lỗi khi cấp quyền!');
      } finally {
        this.isCapQuyen = false;
      }
    },
    confirmRevoke(member) {
      this.selectedMember = member;
      this.showRevokeConfirm = true;
    },
    openEdit(member) {
      this.editForm = {
        id_nguoi_dung: member.id,
        ho_va_ten: member.ho_va_ten,
        so_dien_thoai: member.so_dien_thoai || '',
      };
      this.showEditModal = true;
    },
    async saveEdit() {
      if (!this.editForm.ho_va_ten.trim()) { this.$toast?.warning('Vui lòng nhập họ tên!'); return; }
      this.isSaving = true;
      try {
        const token = localStorage.getItem('token_doi_tac');
        const res = await axios.post(`${apiUrl}/doi-tac/thanh-vien/cap-nhat`, this.editForm, {
          headers: { Authorization: 'Bearer ' + token }
        });
        if (res.data.status) {
          this.$toast?.success('Cập nhật thành công!');
          this.showEditModal = false;
          await this.loadThanhVien();
        }
      } catch (e) {
        this.$toast?.error(e.response?.data?.message || 'Lỗi khi cập nhật!');
      } finally {
        this.isSaving = false;
      }
    },
    async thuHoiQuyen() {
      if (!this.selectedMember) return;
      this.isRevoking = true;
      try {
        const token = localStorage.getItem('token_doi_tac');
        const res = await axios.post(`${apiUrl}/doi-tac/thanh-vien/thu-hoi`,
          { id_nguoi_dung: this.selectedMember.id },
          { headers: { Authorization: 'Bearer ' + token } }
        );
        if (res.data.status) {
          this.$toast?.success('Đã thu hồi quyền thành viên!');
          this.showRevokeConfirm = false;
          this.selectedMember = null;
          await this.loadThanhVien();
        }
      } catch (e) {
        this.$toast?.error(e.response?.data?.message || 'Lỗi khi thu hồi quyền!');
      } finally {
        this.isRevoking = false;
      }
    },
    formatDate(dateStr) {
      if (!dateStr) return '—';
      return new Date(dateStr).toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit', year: 'numeric' });
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
.bg-soft-danger { background: #fef2f2; } .text-danger { color: #ef4444 !important; }

.search-business { background: #f3f0eb; border-radius: 16px; display: flex; align-items: center; gap: 10px; transition: 0.3s; }
.search-business:focus-within { background: #fff; box-shadow: 0 0 0 2px #ea580c20; }
.search-business input { background: transparent; border: none; outline: none; font-size: 0.9rem; font-weight: 600; width: 100%; color: #1a1e29; }

.premium-table { border-collapse: separate; border-spacing: 0 10px; margin-top: -10px; }
.floating-row { background: white; transition: 0.3s; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); }
.floating-row td { vertical-align: middle; border-top: 1px solid #f0ece6; border-bottom: 1px solid #f0ece6; padding: 14px 10px; }
.floating-row td:first-child { border-left: 1px solid #f0ece6; border-top-left-radius: 16px; border-bottom-left-radius: 16px; }
.floating-row td:last-child { border-right: 1px solid #f0ece6; border-top-right-radius: 16px; border-bottom-right-radius: 16px; }
.floating-row:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(234,88,12,0.08); }

.member-avatar { width: 44px; height: 44px; border-radius: 14px; background: #fee7d1; color: #ea580c; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.1rem; overflow: hidden; flex-shrink: 0; }

.status-pill-business { padding: 5px 12px; border-radius: 100px; font-size: 0.65rem; font-weight: 900; display: inline-flex; align-items: center; gap: 6px; letter-spacing: 0.5px; }
.status-pill-business.active { background: #dcfce7; color: #166534; }
.status-pill-business.idle { background: #fef3c7; color: #92400e; }
.status-pill-business .dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

.btn-action-pro { width: 36px; height: 36px; border-radius: 10px; border: none; display: inline-flex; align-items: center; justify-content: center; font-size: 1rem; transition: 0.2s; }
.btn-action-pro.danger { background: #fef2f2; color: #ef4444; border: 1px solid #fecaca; }
.btn-action-pro.danger:hover { background: #ef4444; color: white; }
.btn-action-pro.edit { background: #eff6ff; color: #3b82f6; border: 1px solid #bfdbfe; }
.btn-action-pro.edit:hover { background: #3b82f6; color: white; }

.feature-icon-bg-mini { width: 44px; height: 44px; background: #fff; border-radius: 12px; display: flex; justify-content: center; align-items: center; font-size: 1.3rem; color: #ea580c; box-shadow: 0 4px 10px rgba(0,0,0,0.02); }

/* Modal */
.modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15,23,42,0.6); backdrop-filter: blur(8px); display: flex; align-items: center; justify-content: center; z-index: 9999; }
.modal-business { background: #fff; border-radius: 28px; padding: 40px; width: 100%; max-width: 520px; box-shadow: 0 40px 80px rgba(0,0,0,0.15); }

.input-premium-group { position: relative; display: flex; align-items: center; }
.input-premium-group i { position: absolute; left: 20px; color: #94a3b8; font-size: 1.3rem; }
.input-premium-group input { width: 100%; padding: 16px 20px 16px 55px; border-radius: 18px; border: 2px solid #f0ece6; background: #fbf9f6; outline: none; font-weight: 600; transition: 0.3s; font-family: 'Plus Jakarta Sans', sans-serif; }
.input-premium-group input:focus { border-color: #ea580c; box-shadow: 0 0 0 4px rgba(234,88,12,0.05); background: #fff; }

.btn-orange-pro { background: #ea580c; color: #fff !important; }
.btn-light-orange-pro { background: #fbf9f6; color: #ea580c; border: 1.5px solid #f0ece6 !important; }
.shadow-orange { box-shadow: 0 12px 30px rgba(234,88,12,0.25); }
.fw-900 { font-weight: 900; } .fw-800 { font-weight: 800; }
.tracking-tighter { letter-spacing: -1.2px; }
</style>
