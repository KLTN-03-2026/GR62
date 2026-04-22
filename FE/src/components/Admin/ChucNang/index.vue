<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card radius-10 border-top border-0 border-3 border-info">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="mt-2"><b>QUẢN LÝ CHỨC NĂNG</b></h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addChucNangModal">
                        Thêm chức năng
                    </button>
                </div>
                <div class="row m-2">
                    <div class="col-lg-12">
                        <div class="input-group">
                            <input @keyup="timKiem()" v-model="tu_khoa" type="text" class="form-control"
                                placeholder="Tìm kiếm theo tên hoặc mã chức năng...">
                            <button v-on:click="timKiem()" class="btn btn-primary">Tìm Kiếm</button>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover shadow-sm">
                        <thead>
                            <tr class="bg-primary text-light text-nowrap">
                                <th class="text-center align-middle">#</th>
                                <th class="text-center align-middle">Tên Chức Năng</th>
                                <th class="text-center align-middle">Mã Chức Năng</th>
                                <th class="text-center align-middle">Tên Slug</th>
                                <th class="text-center align-middle">URL</th>
                                <th class="text-center align-middle">Mô Tả</th>
                                <th class="text-center align-middle">Trạng Thái</th>
                                <th class="text-center align-middle">Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                             <template v-for="(value, index) in list_chuc_nang" :key="index">
                                <tr class="text-nowrap">
                                    <th class="align-middle text-center">{{ index + 1 }}</th>
                                    <td class="align-middle">{{ value.ten_chuc_nang }}</td>
                                    <td class="align-middle text-center">{{ value.ma_chuc_nang }}</td>
                                    <td class="align-middle">{{ value.ten_slug }}</td>
                                    <td class="align-middle small">{{ value.url }}</td>
                                    <td class="align-middle">{{ value.mo_ta }}</td>
                                    <td class="align-middle text-center" v-on:click="doiTrangThai(value)">
                                        <button v-if="value.trang_thai == 1" class="btn btn-info w-100"
                                            style="color:white">Hoạt động</button>
                                        <button v-else class="btn btn-secondary w-100">Tạm tắt</button>
                                    </td>
                                    <td class="align-middle text-center">
                                        <button v-on:click="edit_chuc_nang = Object.assign({}, value)"
                                            class="btn btn-success me-2" data-bs-toggle="modal"
                                            data-bs-target="#updateChucNangModal">
                                            Cập Nhật
                                        </button>
                                        <button v-on:click="del_chuc_nang = value" class="btn btn-danger"
                                            data-bs-toggle="modal" data-bs-target="#deleteChucNangModal">
                                            Xóa
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            <tr v-if="list_chuc_nang.length == 0">
                                <td colspan="8" class="text-center text-muted p-5">
                                    <i class="bx bx-info-circle fs-1 d-block mb-2"></i>
                                    Không tìm thấy dữ liệu chức năng nào phù hợp.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Thêm Mới -->
        <div class="modal fade" id="addChucNangModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm Chức Năng Mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Tên Chức Năng</label>
                                <input v-model="create_chuc_nang.ten_chuc_nang" type="text" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Mã Chức Năng</label>
                                <input v-model="create_chuc_nang.ma_chuc_nang" type="text" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Tên Slug</label>
                                <input v-model="create_chuc_nang.ten_slug" type="text" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">URL</label>
                                <input v-model="create_chuc_nang.url" type="text" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Trạng Thái</label>
                                <select v-model="create_chuc_nang.trang_thai" class="form-select">
                                    <option value="1">Hoạt động</option>
                                    <option value="0">Tạm tắt</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label font-weight-bold">Mô Tả</label>
                                <textarea v-model="create_chuc_nang.mo_ta" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                            v-on:click="themChucNang()">Thêm
                            Mới</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Cập Nhật -->
        <div class="modal fade" id="updateChucNangModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cập Nhật Chức Năng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Tên Chức Năng</label>
                                <input v-model="edit_chuc_nang.ten_chuc_nang" type="text" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Mã Chức Năng</label>
                                <input v-model="edit_chuc_nang.ma_chuc_nang" type="text" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Tên Slug</label>
                                <input v-model="edit_chuc_nang.ten_slug" type="text" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">URL</label>
                                <input v-model="edit_chuc_nang.url" type="text" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Trạng Thái</label>
                                <select v-model="edit_chuc_nang.trang_thai" class="form-select">
                                    <option value="1">Hoạt động</option>
                                    <option value="0">Tạm tắt</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label font-weight-bold">Mô Tả</label>
                                <textarea v-model="edit_chuc_nang.mo_ta" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal"
                            v-on:click="capNhatChucNang()">Cập
                            Nhật</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Xóa -->
        <div class="modal fade" id="deleteChucNangModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Xác nhận xóa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center p-4">
                        <i class="bx bx-error-circle text-danger mb-3" style="font-size: 3rem;"></i>
                        <h5 class="text-dark">Bạn có chắc chắn muốn xóa chức năng này?</h5>
                        <p class="text-muted">Chức năng <strong>{{ del_chuc_nang.ten_chuc_nang }}</strong> sẽ bị xóa khỏi hệ thống.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                            v-on:click="xoaChucNang()">Xác nhận xóa</button>
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
            list_chuc_nang: [],
            list_chuc_nang_goc: [],
            tu_khoa: '',
            create_chuc_nang: {
                ten_chuc_nang: "",
                ma_chuc_nang: "",
                ten_slug: "",
                url: "",
                mo_ta: "",
                trang_thai: 1
            },
            edit_chuc_nang: {
                ten_chuc_nang: "",
                ma_chuc_nang: "",
                ten_slug: "",
                url: "",
                mo_ta: "",
                trang_thai: 1
            },
            del_chuc_nang: {},
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
            const ds = this.list_chuc_nang_goc || [];
            if (!this.tu_khoa) {
                this.list_chuc_nang = [...ds];
                return;
            }
            const kw = this.tu_khoa.trim().toLowerCase();
            this.list_chuc_nang = ds.filter(v =>
                (v.ten_chuc_nang && v.ten_chuc_nang.toLowerCase().includes(kw)) ||
                (v.ma_chuc_nang && v.ma_chuc_nang.toLowerCase().includes(kw)) ||
                (v.ten_slug && v.ten_slug.toLowerCase().includes(kw))
            );
        },
        loadData() {
            axios.get(`${API}/chuc-nang/data`, { headers: this.headers() })
                .then((res) => {
                    this.list_chuc_nang = res.data.data || [];
                    this.list_chuc_nang_goc = [...this.list_chuc_nang];
                });
        },
        themChucNang() {
            axios.post(`${API}/chuc-nang/create`, this.create_chuc_nang, { headers: this.headers() })
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.create_chuc_nang = {
                            ten_chuc_nang: "",
                            ma_chuc_nang: "",
                            ten_slug: "",
                            url: "",
                            mo_ta: "",
                            trang_thai: 1
                        };
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
        capNhatChucNang() {
            axios.post(`${API}/chuc-nang/update`, this.edit_chuc_nang, { headers: this.headers() })
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.loadData();
                    } else {
                        this.$toast.error(res.data.message);
                    }
                });
        },
        xoaChucNang() {
            axios.post(`${API}/chuc-nang/delete`, { id: this.del_chuc_nang.id }, { headers: this.headers() })
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
            axios.post(`${API}/chuc-nang/change-status`, { id: value.id }, { headers: this.headers() })
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
