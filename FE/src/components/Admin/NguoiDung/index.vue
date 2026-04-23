<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card radius-10 border-top border-0 border-3 border-info">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="mt-2"><b>DANH SÁCH NGƯỜI DÙNG</b></h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        Thêm người dùng
                    </button>
                </div>
                <div class="row m-2">
                    <div class="col-lg-12">
                        <div class="position-relative search-bar-box input-group" style="width: 100%;">
                            <input @keyup="timKiem()" v-model="tu_khoa" type="text"
                                class="form-control search-control" placeholder="Tìm kiếm theo tên, email, SĐT...">
                            <button v-on:click="timKiem()" class="btn btn-primary">Tìm Kiếm</button>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr class="bg-primary text-light text-nowrap">
                                <th class="text-center">#</th>
                                <th class="text-center">Họ Và Tên</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Số Điện Thoại</th>
                                <th class="text-center">Chức Vụ</th>
                                <th class="text-center">Trạng Thái</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                             <template v-for="(value, index) in list_nguoi_dung" :key="index">
                                <tr class="text-nowrap">
                                    <th class="align-middle text-center">{{ index + 1 }}</th>
                                    <td class="align-middle">{{ value.ho_va_ten }}</td>
                                    <td class="align-middle">{{ value.email }}</td>
                                    <td class="align-middle text-center">{{ value.so_dien_thoai }}</td>
                                    <td class="align-middle text-center">
                                        {{ value.chuc_vu ? value.chuc_vu.ten_chuc_vu : 'N/A' }}
                                    </td>
                                    <td class="align-middle text-center" v-on:click="doiTrangThai(value)">
                                        <button v-if="value.trang_thai == 1" class="btn btn-info w-100"
                                            style="color: white;">
                                            Hoạt động
                                        </button>
                                        <button v-else class="btn btn-secondary w-100">
                                            Tạm tắt
                                        </button>
                                    </td>
                                    <td class="align-middle text-center">
                                        <button v-on:click="edit_nguoi_dung = Object.assign({}, value)"
                                            class="btn btn-success me-2" data-bs-toggle="modal"
                                            data-bs-target="#updateModal">
                                            Cập nhật
                                        </button>
                                        <button v-on:click="del_nguoi_dung = value" class="btn btn-danger"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            Xóa
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            <tr v-if="list_nguoi_dung.length == 0">
                                <td colspan="7" class="text-center text-muted p-5">
                                    <i class="bx bx-info-circle fs-1 d-block mb-2"></i>
                                    Không tìm thấy người dùng nào phù hợp.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Thêm Mới -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm Người Dùng Mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Họ Và Tên</label>
                            <input v-model="create_nguoi_dung.ho_va_ten" type="text" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input v-model="create_nguoi_dung.email" type="email" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mật Khẩu</label>
                            <input v-model="create_nguoi_dung.password" type="password" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Xác Nhận Mật Khẩu</label>
                            <input v-model="create_nguoi_dung.re_password" type="password" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số Điện Thoại</label>
                            <input v-model="create_nguoi_dung.so_dien_thoai" type="text" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Chức Vụ</label>
                            <select v-model="create_nguoi_dung.id_chuc_vu" class="form-select">
                                <option value="">Chọn chức vụ</option>
                                <template v-for="(v, k) in list_chuc_vu" :key="k">
                                    <option :value="v.id">{{ v.ten_chuc_vu }}</option>
                                </template>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Trạng Thái</label>
                            <select v-model="create_nguoi_dung.trang_thai" class="form-select">
                                <option value="1">Hoạt động</option>
                                <option value="0">Tạm tắt</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" v-on:click="themNguoiDung()">
                        Thêm mới
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cập Nhật -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cập Nhật Thông Tin Người Dùng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Họ Và Tên</label>
                            <input v-model="edit_nguoi_dung.ho_va_ten" type="text" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input v-model="edit_nguoi_dung.email" type="email" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mật Khẩu Mới</label>
                            <input v-model="edit_nguoi_dung.password" type="password" class="form-control" placeholder="Để trống nếu không đổi" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Xác Nhận Mật Khẩu Mới</label>
                            <input v-model="edit_nguoi_dung.re_password" type="password" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Chức Vụ</label>
                            <select v-model="edit_nguoi_dung.id_chuc_vu" class="form-select">
                                <option value="">Chọn chức vụ</option>
                                <template v-for="(v, k) in list_chuc_vu" :key="k">
                                    <option :value="v.id">{{ v.ten_chuc_vu }}</option>
                                </template>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số Điện Thoại</label>
                            <input v-model="edit_nguoi_dung.so_dien_thoai" type="text" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Trạng Thái</label>
                            <select v-model="edit_nguoi_dung.trang_thai" class="form-select">
                                <option value="1">Hoạt động</option>
                                <option value="0">Tạm tắt</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal"
                        v-on:click="capNhatNguoiDung()">
                        Cập nhật
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Xóa -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xóa Người Dùng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                        Bạn có chắc chắn muốn xóa người dùng
                        <strong>{{ del_nguoi_dung.ho_va_ten }}</strong>?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" v-on:click="xoaNguoiDung()">
                        Xác nhận
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
const API = import.meta.env.VITE_API_URL;
export default {
    data() {
        return {
            list_nguoi_dung: [],
            list_nguoi_dung_goc: [],
            list_doi_tac: [],
            list_chuc_vu: [],
            create_nguoi_dung: {
                ho_va_ten: "",
                email: "",
                avatar: "",
                password: "",
                re_password: "",
                so_dien_thoai: "",
                id_chuc_vu: "",
                trang_thai: "1",
            },
            edit_nguoi_dung: {
                ho_va_ten: "",
                email: "",
                avatar: "",
                password: "",
                re_password: "",
                so_dien_thoai: "",
                id_chuc_vu: "",
                trang_thai: "",
            },
            del_nguoi_dung: {},
            tu_khoa: "",
        };
    },
    mounted() {
        this.loadData();
        this.loadDataPartner();
        this.loadDataChucVu();
    },
    methods: {
        headers() {
            return { Authorization: 'Bearer ' + localStorage.getItem('token_admin') };
        },
        timKiem() {
            const ds = this.list_nguoi_dung_goc || [];
            if (!this.tu_khoa) {
                this.list_nguoi_dung = [...ds];
                return;
            }
            const kw = this.tu_khoa.trim().toLowerCase();
            this.list_nguoi_dung = ds.filter(v =>
                (v.ho_va_ten && v.ho_va_ten.toLowerCase().includes(kw)) ||
                (v.email && v.email.toLowerCase().includes(kw)) ||
                (v.so_dien_thoai && v.so_dien_thoai.includes(kw))
            );
        },
        loadData() {
            axios.get(`${API}/nguoi-dung/data`, { headers: this.headers() })
                .then((res) => {
                    this.list_nguoi_dung = res.data.data || [];
                    this.list_nguoi_dung_goc = [...this.list_nguoi_dung];
                    if (this.tu_khoa) this.timKiem();
                });
        },
        loadDataPartner() {
            axios.get(`${API}/doi-tac/data`, { headers: this.headers() })
                .then((res) => {
                    this.list_doi_tac = res.data.data || [];
                });
        },
        loadDataChucVu() {
            axios.get(`${API}/chuc-vu/data`, { headers: this.headers() })
                .then((res) => {
                    this.list_chuc_vu = res.data.data || [];
                });
        },
        themNguoiDung() {
            if (this.create_nguoi_dung.password !== this.create_nguoi_dung.re_password) {
                this.$toast.error("Mật khẩu xác nhận không khớp!");
                return;
            }
            axios.post(`${API}/nguoi-dung/create`, this.create_nguoi_dung, { headers: this.headers() })
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.create_nguoi_dung = { ho_va_ten: "", email: "", password: "", re_password: "", so_dien_thoai: "", id_chuc_vu: "", trang_thai: "1" };
                        this.loadData();
                    } else {
                        this.$toast.error(res.data.message);
                    }
                })
                .catch(res => {
                    if (res.response?.data?.errors)
                        Object.values(res.response.data.errors).forEach(v => this.$toast.error(v[0]));
                });
        },
        capNhatNguoiDung() {
            if (this.edit_nguoi_dung.password && this.edit_nguoi_dung.password !== this.edit_nguoi_dung.re_password) {
                this.$toast.error("Mật khẩu xác nhận không khớp!");
                return;
            }
            axios.post(`${API}/nguoi-dung/update`, this.edit_nguoi_dung, { headers: this.headers() })
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.loadData();
                    } else {
                        this.$toast.error(res.data.message);
                    }
                })
                .catch(res => {
                    if (res.response?.data?.errors)
                        Object.values(res.response.data.errors).forEach(v => this.$toast.error(v[0]));
                });
        },
        xoaNguoiDung() {
            axios.post(`${API}/nguoi-dung/delete`, this.del_nguoi_dung, { headers: this.headers() })
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.loadData();
                    } else {
                        this.$toast.error(res.data.message);
                    }
                })
                .catch(res => {
                    if (res.response?.data?.errors)
                        Object.values(res.response.data.errors).forEach(v => this.$toast.error(v[0]));
                });
        },
        doiTrangThai(value) {
            axios.post(`${API}/nguoi-dung/change-status`, value, { headers: this.headers() })
                .then((res) => {
                    if (res.data.status) {
                        this.loadData();
                        this.$toast.success(res.data.message);
                    } else {
                        this.$toast.error(res.data.message);
                    }
                })
                .catch(res => {
                    if (res.response?.data?.errors)
                        Object.values(res.response.data.errors).forEach(v => this.$toast.error(v[0]));
                });
        },
    },
};
</script>

<style scoped></style>
