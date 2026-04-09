<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card radius-10 border-top border-0 border-3 border-info">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="mt-2"><b>DANH SÁCH NHÂN VIÊN</b></h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        Thêm nhân viên
                    </button>
                </div>
                <div class="row m-2">
                    <div class="col-lg-12">
                        <div class="input-group">
                            <input @keyup="timKiem()" v-model="tu_khoa" type="text"
                                class="form-control" placeholder="Tìm kiếm theo tên, email, SĐT...">
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
                            <template v-for="(value, index) in list_nhan_vien" :key="index">
                                <tr class="text-nowrap">
                                    <th class="align-middle text-center">{{ index + 1 }}</th>
                                    <td class="align-middle">{{ value.ho_va_ten }}</td>
                                    <td class="align-middle">{{ value.email }}</td>
                                    <td class="align-middle text-center">{{ value.so_dien_thoai }}</td>
                                    <td class="align-middle">{{ tenChucVu(value.id_chuc_vu) }}</td>
                                    <td class="align-middle text-center">
                                        <button v-if="value.trang_thai == 1" class="btn btn-info w-100" style="color:white">
                                            Hoạt động
                                        </button>
                                        <button v-else class="btn btn-secondary w-100">
                                            Tạm tắt
                                        </button>
                                    </td>
                                    <td class="align-middle text-center">
                                        <button v-on:click="edit_nhan_vien = Object.assign({}, value)"
                                            class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#updateModal">
                                            Cập nhật
                                        </button>
                                        <button v-on:click="del_nhan_vien = value" class="btn btn-danger"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            Xóa
                                        </button>
                                    </td>
                                </tr>
                            </template>
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
                    <h5 class="modal-title">Thêm Nhân Viên Mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Họ Và Tên</label>
                            <input v-model="create_nhan_vien.ho_va_ten" type="text" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input v-model="create_nhan_vien.email" type="email" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mật Khẩu</label>
                            <input v-model="create_nhan_vien.password" type="password" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Xác Nhận Mật Khẩu</label>
                            <input v-model="create_nhan_vien.re_password" type="password" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số Điện Thoại</label>
                            <input v-model="create_nhan_vien.so_dien_thoai" type="text" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Trạng Thái</label>
                            <select v-model="create_nhan_vien.trang_thai" class="form-select">
                                <option value="1">Hoạt động</option>
                                <option value="0">Tạm tắt</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Chức Vụ</label>
                            <select v-model="create_nhan_vien.id_chuc_vu" class="form-select">
                                <option value="">-- Chọn chức vụ --</option>
                                <template v-for="(cv, i) in list_chuc_vu" :key="i">
                                    <option :value="cv.id">{{ cv.ten_chuc_vu }}</option>
                                </template>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" v-on:click="themNhanVien()">Thêm mới</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cập Nhật -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cập Nhật Thông Tin Nhân Viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Họ Và Tên</label>
                            <input v-model="edit_nhan_vien.ho_va_ten" type="text" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input v-model="edit_nhan_vien.email" type="email" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mật Khẩu Mới (để trống nếu không đổi)</label>
                            <input v-model="edit_nhan_vien.password" type="password" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số Điện Thoại</label>
                            <input v-model="edit_nhan_vien.so_dien_thoai" type="text" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Trạng Thái</label>
                            <select v-model="edit_nhan_vien.trang_thai" class="form-select">
                                <option value="1">Hoạt động</option>
                                <option value="0">Tạm tắt</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Chức Vụ</label>
                            <select v-model="edit_nhan_vien.id_chuc_vu" class="form-select">
                                <option value="">-- Chọn chức vụ --</option>
                                <template v-for="(cv, i) in list_chuc_vu" :key="i">
                                    <option :value="cv.id">{{ cv.ten_chuc_vu }}</option>
                                </template>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" v-on:click="capNhatNhanVien()">Cập nhật</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Xóa -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xóa Nhân Viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                        Bạn có chắc chắn muốn xóa nhân viên <strong>{{ del_nhan_vien.ho_va_ten }}</strong>?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" v-on:click="xoaNhanVien()">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

const API = 'http://127.0.0.1:8000/api';

export default {
    data() {
        return {
            list_nhan_vien: [],
            list_chuc_vu: [],
            tu_khoa: '',
            create_nhan_vien: {
                ho_va_ten: "", email: "", password: "", re_password: "",
                so_dien_thoai: "", id_chuc_vu: "", trang_thai: "1",
            },
            edit_nhan_vien: {
                ho_va_ten: "", email: "", password: "", so_dien_thoai: "",
                id_chuc_vu: "", trang_thai: "",
            },
            del_nhan_vien: {},
        };
    },
    mounted() {
        this.loadData();
        this.loadChucVu();
    },
    methods: {
        headers() {
            return { Authorization: 'Bearer ' + localStorage.getItem('token_admin') };
        },
        tenChucVu(id) {
            const cv = this.list_chuc_vu.find(x => x.id == id);
            return cv ? cv.ten_chuc_vu : '';
        },
        timKiem() {
            const ds = this.list_nhan_vien_goc || [];
            if (!this.tu_khoa) {
                this.list_nhan_vien = ds;
                return;
            }
            const kw = this.tu_khoa.toLowerCase();
            this.list_nhan_vien = ds.filter(v =>
                (v.ho_va_ten && v.ho_va_ten.toLowerCase().includes(kw)) ||
                (v.email && v.email.toLowerCase().includes(kw)) ||
                (v.so_dien_thoai && v.so_dien_thoai.includes(kw))
            );
        },
        loadData() {
            axios.get(`${API}/admin/data`, { headers: this.headers() })
                .then((res) => {
                    this.list_nhan_vien = res.data.data || [];
                    this.list_nhan_vien_goc = [...this.list_nhan_vien];
                });
        },
        loadChucVu() {
            axios.get(`${API}/chuc-vu/data`)
                .then((res) => { this.list_chuc_vu = res.data.data || []; });
        },
        themNhanVien() {
            axios.post(`${API}/admin/create`, this.create_nhan_vien, { headers: this.headers() })
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.create_nhan_vien = { ho_va_ten: "", email: "", password: "", re_password: "", so_dien_thoai: "", id_chuc_vu: "", trang_thai: "1" };
                        this.loadData();
                    } else {
                        this.$toast.error(res.data.message);
                    }
                })
                .catch(res => {
                    if (res.response && res.response.data && res.response.data.errors)
                        Object.values(res.response.data.errors).forEach(v => this.$toast.error(v[0]));
                });
        },
        capNhatNhanVien() {
            axios.post(`${API}/admin/update`, this.edit_nhan_vien, { headers: this.headers() })
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.loadData();
                    } else {
                        this.$toast.error(res.data.message);
                    }
                })
                .catch(res => {
                    if (res.response && res.response.data && res.response.data.errors)
                        Object.values(res.response.data.errors).forEach(v => this.$toast.error(v[0]));
                });
        },
        xoaNhanVien() {
            axios.post(`${API}/admin/delete`, { id: this.del_nhan_vien.id }, { headers: this.headers() })
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.loadData();
                    } else {
                        this.$toast.error(res.data.message);
                    }
                })
                .catch(res => {
                    if (res.response && res.response.data && res.response.data.errors)
                        Object.values(res.response.data.errors).forEach(v => this.$toast.error(v[0]));
                });
        },
    },
};
</script>

<style scoped></style>
