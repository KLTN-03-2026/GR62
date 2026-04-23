<template>
    <div class="row" v-if="current_admin && current_admin.is_master == 1">
        <!-- Cột 1: Danh Sách Chức Vụ -->
        <div class="col-lg-4">
            <div class="card radius-10 border-top border-0 border-3 border-primary shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold">DANH SÁCH CHỨC VỤ</h6>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#themMoiModal">
                        Thêm Mới
                    </button>
                </div>
                <div class="card-body p-2">
                    <div class="input-group mb-2">
                        <input type="text" v-model="search" class="form-control" placeholder="Tìm kiếm chức vụ...">
                        <button class="btn btn-primary" type="button"><i class="fa-solid fa-magnifying-glass"></i>
                            Tìm</button>
                    </div>
                    <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="text-center align-middle bg-primary text-light sticky-top">
                                <tr class="text-nowrap">
                                    <th>#</th>
                                    <th>Tên Chức Vụ</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(value, index) in danhSachLocChucVu" :key="index" class="align-middle"
                                    :class="{ 'table-info': chuc_vu_dang_chon && chuc_vu_dang_chon.id === value.id }">
                                    <th class="text-center">{{ index + 1 }}</th>
                                    <td class="fw-bold " @click="chonChucVuPhanQuyen(value)">
                                        {{ value.ten_chuc_vu }}
                                    </td>
                                    <td class="text-center text-nowrap">
                                        <button class="btn btn-sm btn-info text-white me-1"
                                            @click="chonChucVuPhanQuyen(value)" title="Phân Quyền">
                                            Quyền
                                        </button>
                                        <button @click="update_chuc_vu = Object.assign({}, value)"
                                            class="btn btn-sm btn-success me-1" data-bs-toggle="modal"
                                            data-bs-target="#updateModal">Sửa</button>

                                        <!-- Không cho phép xoá nếu là Super Admin hoặc chính mình -->
                                        <button
                                            v-if="value.id !== current_admin?.id_chuc_vu && value.ten_chuc_vu.toLowerCase() !== 'super admin'"
                                            @click="delete_quyen = value" class="btn btn-sm btn-danger"
                                            data-bs-toggle="modal" data-bs-target="#xoaQuyenModal">
                                            Xóa
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cột 2: Danh Sách Chức Năng -->
        <div class="col-lg-4">
            <div class="card radius-10 border-top border-0 border-3 border-primary shadow-sm">
                <div class="card-header">
                    <h6 class="mb-0 fw-bold">DANH SÁCH CHỨC NĂNG</h6>
                </div>
                <div class="card-body p-2">
                    <div class="table-responsive" style="max-height: 545px; overflow-y: auto;">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="text-center align-middle bg-primary text-light sticky-top">
                                <tr class="text-nowrap">
                                    <th>#</th>
                                    <th>Tên Chức Năng</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(value, index) in list_chuc_nang" :key="index" class="align-middle">
                                    <th class="text-center">{{ index + 1 }}</th>
                                    <td class="text-wrap">{{ value.ten_chuc_nang }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-success w-100" :disabled="!chuc_vu_dang_chon"
                                            @click="themPhanQuyen(value)">
                                            Cấp Quyền
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cột 3: Quyền Đang Phân -->
        <div class="col-lg-4">
            <div class="card radius-10 border-top border-0 border-3 border-primary shadow-sm">
                <div class="card-header">
                    <h6 class="mb-0 fw-bold">
                        ĐANG PHÂN QUYỀN:
                        <span class="text-primary">{{ chuc_vu_dang_chon ? chuc_vu_dang_chon.ten_chuc_vu : '...'
                            }}</span>
                    </h6>
                </div>
                <div class="card-body p-2">
                    <div class="table-responsive" style="max-height: 545px; overflow-y: auto;">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="text-center align-middle bg-primary text-light sticky-top">
                                <tr class="text-nowrap">
                                    <th>#</th>
                                    <th>Chức Năng Hỗ Trợ</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(value, index) in list_phan_quyen_hien_thi" :key="index"
                                    class="align-middle">
                                    <th class="text-center">{{ index + 1 }}</th>
                                    <td class="text-wrap fw-bold text-secondary">{{ tenChucNang(value.id_chuc_nang) }}
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-danger w-100" @click="deletePhanQuyen(value)">
                                            Xóa Quyền
                                        </button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Access Denied View -->
    <div class="row mt-5" v-else-if="current_admin && current_admin.is_master == 0">
        <div class="col-12 mt-5">
            <div class="alert alert-danger text-center p-5 shadow-sm rounded">
                <i class="fa-solid fa-triangle-exclamation text-danger mb-3" style="font-size: 5rem;"></i>
                <h3 class="fw-bold">TỪ CHỐI TRUY CẬP</h3>
                <p class="fs-5 mt-3 mb-0">Chức năng Phân Quyền thuộc dạng dữ liệu cốt lõi của hệ thống.</p>
                <p class="fs-5 text-muted">Chỉ đặc quyền của <strong class="text-danger">Super Admin (is_master)</strong> mới có thể truy cập nội dung này.</p>
            </div>
        </div>
    </div>

    <!-- Modal Thêm Chức Vụ -->
    <div class="modal fade" id="themMoiModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-start border-0 border-4 border-primary">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Thêm Mới Chức Vụ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên Chức Vụ</label>
                        <input v-model="create_chuc_vu.ten_chuc_vu" type="text" class="form-control"
                            placeholder="Nhập tên chức vụ">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mô Tả</label>
                        <textarea v-model="create_chuc_vu.mo_ta" class="form-control" rows="3"
                            placeholder="Nhập mô tả"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" @click="themChucVu()" data-bs-dismiss="modal">Tạo
                        Mới</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cập Nhật Chức Vụ -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-start border-0 border-4 border-info">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Cập Nhật Chức Vụ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên Chức Vụ</label>
                        <input v-model="update_chuc_vu.ten_chuc_vu" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mô Tả</label>
                        <textarea v-model="update_chuc_vu.mo_ta" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-success text-white" @click="updateChucVu()"
                        data-bs-dismiss="modal">Xác Nhận</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Xóa Chức Vụ -->
    <div class="modal fade" id="xoaQuyenModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-start border-0 border-4 border-danger">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Xóa Chức Vụ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="py-3">
                        <i class="fa-solid fa-circle-exclamation text-danger fa-4x mb-3"></i>
                        <h5>Bạn có chắc muốn xóa chức vụ <b>{{ delete_quyen.ten_chuc_vu }}</b>?</h5>
                        <p class="text-secondary">Lưu ý: Hành động này không thể hoàn tác!</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-danger" @click="deleteChucVu()" data-bs-dismiss="modal">Xóa
                        Chức Vụ</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modals -->
</template>

<script>
import axios from 'axios';

const API = import.meta.env.VITE_API_URL;

export default {
    data() {
        return {
            list_chuc_nang: [],
            list_chuc_vu: [],
            list_phan_quyen: [],
            create_chuc_vu: { ten_chuc_vu: '', mo_ta: '' },
            update_chuc_vu: {},
            delete_quyen: {},
            chuc_vu_dang_chon: null,
            search: '',
            current_admin: null,
        };
    },
    computed: {
        danhSachLocChucVu() {
            if (!this.search) return this.list_chuc_vu;
            const kw = this.search.toLowerCase();
            return this.list_chuc_vu.filter(v => v.ten_chuc_vu.toLowerCase().includes(kw));
        },
        list_phan_quyen_hien_thi() {
            if (!this.chuc_vu_dang_chon) return [];
            return this.list_phan_quyen.filter(v => v.id_chuc_vu == this.chuc_vu_dang_chon.id);
        },
    },
    mounted() {
        this.layDataChucVu();
        this.layDataChucNang();
        this.layDataPhanQuyen();
        this.layAdminHienTai();
    },
    methods: {
        headers() {
            return { Authorization: 'Bearer ' + localStorage.getItem('token_admin') };
        },
        layAdminHienTai() {
            axios.get(`${API}/admin/profile/data`, { headers: this.headers() })
                .then(res => {
                    if (res.data.status) {
                        this.current_admin = res.data.data;
                    }
                });
        },
        tenChucNang(id) {
            const cn = this.list_chuc_nang.find(x => x.id == id);
            return cn ? cn.ten_chuc_nang : '(Không xác định)';
        },
        chonChucVuPhanQuyen(value) {
            this.chuc_vu_dang_chon = value;
        },
        layDataChucVu() {
            axios.get(`${API}/chuc-vu/data`, { headers: this.headers() })
                .then(res => { this.list_chuc_vu = res.data.data || []; });
        },
        layDataChucNang() {
            axios.get(`${API}/chuc-nang/data`, { headers: this.headers() })
                .then(res => { this.list_chuc_nang = res.data.data || []; });
        },
        layDataPhanQuyen() {
            axios.get(`${API}/chi-tiet-phan-quyen/data`, { headers: this.headers() })
                .then(res => {
                    if (res.data.status) {
                        this.list_phan_quyen = res.data.data || [];
                    } else {
                        this.$toast.error(res.data.message || 'Không thể tải danh sách quyền');
                    }
                })
                .catch(() => {
                    this.$toast.error('Lỗi kết nối khi tải danh sách quyền');
                });
        },
        themChucVu() {
            axios.post(`${API}/chuc-vu/create`, this.create_chuc_vu, { headers: this.headers() })
                .then(res => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.create_chuc_vu = { ten_chuc_vu: '', mo_ta: '' };
                        this.layDataChucVu();
                    } else { this.$toast.error(res.data.message); }
                })
                .catch(res => {
                    if (res.response?.data?.errors)
                        Object.values(res.response.data.errors).forEach(v => this.$toast.error(v[0]));
                });
        },
        updateChucVu() {
            axios.post(`${API}/chuc-vu/update`, this.update_chuc_vu, { headers: this.headers() })
                .then(res => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.layDataChucVu();
                    } else { this.$toast.error(res.data.message); }
                })
                .catch(res => {
                    if (res.response?.data?.errors)
                        Object.values(res.response.data.errors).forEach(v => this.$toast.error(v[0]));
                });
        },
        deleteChucVu() {
            axios.post(`${API}/chuc-vu/delete`, { id: this.delete_quyen.id }, { headers: this.headers() })
                .then(res => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        if (this.chuc_vu_dang_chon?.id === this.delete_quyen.id) this.chuc_vu_dang_chon = null;
                        this.layDataChucVu();
                    } else { this.$toast.error(res.data.message); }
                })
                .catch(res => {
                    if (res.response?.data?.errors)
                        Object.values(res.response.data.errors).forEach(v => this.$toast.error(v[0]));
                });
        },
        themPhanQuyen(chucNang) {
            if (!this.chuc_vu_dang_chon) {
                this.$toast.error('Vui lòng chọn chức vụ trước!');
                return;
            }
            const da_co = this.list_phan_quyen.find(
                v => v.id_chuc_vu == this.chuc_vu_dang_chon.id && v.id_chuc_nang == chucNang.id
            );
            if (da_co) {
                this.$toast.error('Chức năng này đã được cấp quyền!');
                return;
            }
            const payload = {
                id_chuc_nang: chucNang.id,
                id_chuc_vu: this.chuc_vu_dang_chon.id,
            };
            axios.post(`${API}/chi-tiet-phan-quyen/create`, payload, { headers: this.headers() })
                .then(res => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.layDataPhanQuyen();
                    } else { this.$toast.error(res.data.message); }
                })
                .catch(res => {
                    if (res.response?.data?.errors)
                        Object.values(res.response.data.errors).forEach(v => this.$toast.error(v[0]));
                });
        },
        deletePhanQuyen(value) {
            axios.post(`${API}/chi-tiet-phan-quyen/delete`, { id: value.id }, { headers: this.headers() })
                .then(res => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.layDataPhanQuyen();
                    } else { this.$toast.error(res.data.message); }
                })
                .catch(res => {
                    if (res.response?.data?.errors)
                        Object.values(res.response.data.errors).forEach(v => this.$toast.error(v[0]));
                });
        },
    },
};
</script>

<style scoped>
.cursor-pointer {
    cursor: pointer;
}

.cursor-pointer:hover {
    text-decoration: underline;
}
</style>