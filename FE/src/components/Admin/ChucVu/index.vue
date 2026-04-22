<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card radius-10 border-top border-0 border-3 border-info">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="mt-2"><b>QUẢN LÝ CHỨC VỤ</b></h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addChucVuModal">
                        Thêm chức vụ
                    </button>
                </div>
                <div class="row m-2">
                    <div class="col-lg-12">
                        <div class="input-group">
                            <input @keyup="timKiem()" v-model="tu_khoa" type="text" class="form-control"
                                placeholder="Tìm kiếm theo tên chức vụ...">
                            <button v-on:click="timKiem()" class="btn btn-primary">Tìm Kiếm</button>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover shadow-sm">
                        <thead>
                            <tr class="bg-primary text-light text-nowrap">
                                <th class="text-center align-middle">#</th>
                                <th class="text-center align-middle">Tên Chức Vụ</th>
                                <th class="text-center align-middle">Mô Tả</th>
                                <th class="text-center align-middle">Tình Trạng</th>
                                <th class="text-center align-middle">Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                             <template v-for="(value, index) in list_chuc_vu" :key="index">
                                <tr class="text-nowrap">
                                    <th class="align-middle text-center">{{ index + 1 }}</th>
                                    <td class="align-middle">{{ value.ten_chuc_vu }}</td>
                                    <td class="align-middle">{{ value.mo_ta || '(Chưa có mô tả)' }}</td>
                                    <td class="align-middle text-center" v-on:click="doiTrangThai(value)">
                                        <button v-if="value.trang_thai == 1" class="btn btn-info w-100"
                                            style="color:white">Hoạt động</button>
                                        <button v-else class="btn btn-secondary w-100">Tạm tắt</button>
                                    </td>
                                    <td class="align-middle text-center">
                                        <button v-on:click="edit_chuc_vu = Object.assign({}, value)"
                                            class="btn btn-success me-2" data-bs-toggle="modal"
                                            data-bs-target="#updateChucVuModal">
                                            Cập Nhật
                                        </button>
                                        <button v-on:click="del_chuc_vu = value" class="btn btn-danger"
                                            data-bs-toggle="modal" data-bs-target="#deleteChucVuModal">
                                            Xóa
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            <tr v-if="list_chuc_vu.length == 0">
                                <td colspan="5" class="text-center text-muted p-5">
                                    <i class="bx bx-info-circle fs-1 d-block mb-2"></i>
                                    Không tìm thấy dữ liệu chức vụ nào phù hợp.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Thêm Mới -->
        <div class="modal fade" id="addChucVuModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm Chức Vụ Mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Tên Chức Vụ</label>
                                <input v-model="create_chuc_vu.ten_chuc_vu" type="text" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Tình Trạng</label>
                                <select v-model="create_chuc_vu.trang_thai" class="form-select">
                                    <option value="1">Hoạt động</option>
                                    <option value="0">Tạm tắt</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label font-weight-bold">Mô Tả</label>
                                <textarea v-model="create_chuc_vu.mo_ta" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                            v-on:click="themChucVu()">Thêm
                            Mới</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Cập Nhật -->
        <div class="modal fade" id="updateChucVuModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cập Nhật Chức Vụ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Tên Chức Vụ</label>
                                <input v-model="edit_chuc_vu.ten_chuc_vu" type="text" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Tình Trạng</label>
                                <select v-model="edit_chuc_vu.trang_thai" class="form-select">
                                    <option value="1">Hoạt động</option>
                                    <option value="0">Tạm tắt</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label font-weight-bold">Mô Tả</label>
                                <textarea v-model="edit_chuc_vu.mo_ta" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal"
                            v-on:click="capNhatChucVu()">Cập
                            Nhật</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Xóa -->
        <div class="modal fade" id="deleteChucVuModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger">Xác nhận xóa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center p-4">
                        <i class="bx bx-error-circle text-danger mb-3" style="font-size: 3rem;"></i>
                        <h5 class="text-dark">Bạn có chắc chắn muốn xóa chức vụ này?</h5>
                        <p class="text-muted">Chức vụ <strong>{{ del_chuc_vu.ten_chuc_vu }}</strong> sẽ bị xóa khỏi hệ thống.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                            v-on:click="xoaChucVu()">Xác nhận xóa</button>
                    </div>
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
            list_chuc_vu: [],
            list_chuc_vu_goc: [],
            tu_khoa: '',
            create_chuc_vu: {
                ten_chuc_vu: "",
                mo_ta: "",
                trang_thai: 1
            },
            edit_chuc_vu: {
                ten_chuc_vu: "",
                mo_ta: "",
                trang_thai: 1
            },
            del_chuc_vu: {},
        };
    },
    mounted() {
        this.loadData();
    },
    methods: {
        headers() {
            return { Authorization: 'Bearer ' + localStorage.getItem('token_admin') };
        },
        timKiem() {
            const ds = this.list_chuc_vu_goc || [];
            if (!this.tu_khoa) {
                this.list_chuc_vu = [...ds];
                return;
            }
            const kw = this.tu_khoa.trim().toLowerCase();
            this.list_chuc_vu = ds.filter(v =>
                v.ten_chuc_vu && v.ten_chuc_vu.toLowerCase().includes(kw)
            );
        },
        loadData() {
            axios.get(`${API}/chuc-vu/data`, { headers: this.headers() })
                .then((res) => {
                    this.list_chuc_vu = res.data.data || [];
                    this.list_chuc_vu_goc = [...this.list_chuc_vu];
                });
        },
        themChucVu() {
            axios.post(`${API}/chuc-vu/create`, this.create_chuc_vu, { headers: this.headers() })
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.create_chuc_vu = { ten_chuc_vu: "", mo_ta: "", trang_thai: 1 };
                        this.loadData();
                    } else {
                        this.$toast.error(res.data.message);
                    }
                })
                .catch(err => {
                    if (err.response?.data?.errors)
                        Object.values(err.response.data.errors).forEach(v => this.$toast.error(v[0]));
                });
        },
        capNhatChucVu() {
            axios.post(`${API}/chuc-vu/update`, this.edit_chuc_vu, { headers: this.headers() })
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.loadData();
                    } else {
                        this.$toast.error(res.data.message);
                    }
                });
        },
        xoaChucVu() {
            axios.post(`${API}/chuc-vu/delete`, { id: this.del_chuc_vu.id }, { headers: this.headers() })
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.loadData();
                    } else {
                        this.$toast.error(res.data.message);
                    }
                });
        },
        doiTrangThai(value) {
            axios.post(`${API}/chuc-vu/change-status`, { id: value.id }, { headers: this.headers() })
                .then((res) => {
                    if (res.data.status) {
                        this.loadData();
                        this.$toast.success('Đã cập nhật trạng thái');
                    } else {
                        this.$toast.error(res.data.message);
                    }
                });
        },
    },
};
</script>

<style scoped>
.radius-10 {
    border-radius: 10px;
}
.card-header b {
    color: #333;
}
.font-weight-bold {
    font-weight: 600;
}
</style>
