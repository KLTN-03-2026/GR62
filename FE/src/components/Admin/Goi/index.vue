<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card radius-10 border-top border-0 border-3 border-info">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="mt-2"><b>DANH SÁCH GÓI</b></h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        Thêm gói
                    </button>
                </div>
                <div class="row m-2">
                    <div class="col-lg-12">
                        <div class="input-group">
                            <input @keyup="timKiem()" v-model="tim_kiem.noi_dung_tim" type="text"
                                class="form-control" placeholder="Tìm kiếm theo tên gói...">
                            <button v-on:click="timKiem()" class="btn btn-primary">Tìm Kiếm</button>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr class="bg-primary text-light text-nowrap">
                                <th class="text-center">#</th>
                                <th class="text-center">Tên Gói</th>
                                <th class="text-center">Số Người Tối Đa</th>
                                <th class="text-center">Số Phòng Tối Đa</th>
                                <th class="text-center">Thời Hạn (ngày)</th>
                                <th class="text-center">Mô Tả</th>
                                <th class="text-center">Trạng Thái</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(value, index) in list_goi" :key="index">
                                <tr class="text-nowrap">
                                    <th class="align-middle text-center">{{ index + 1 }}</th>
                                    <td class="align-middle">{{ value.ten_goi }}</td>
                                    <td class="align-middle text-center">{{ value.so_nguoi_toi_da }}</td>
                                    <td class="align-middle text-center">{{ value.so_phong_toi_da }}</td>
                                    <td class="align-middle text-center">{{ value.thoi_han }}</td>
                                    <td class="align-middle">{{ value.mo_ta }}</td>
                                    <td class="align-middle text-center" v-on:click="changeStatus(value)">
                                        <button v-if="value.trang_thai == 1" class="btn btn-info w-100" style="color:white">Hoạt động</button>
                                        <button v-else class="btn btn-secondary w-100">Tạm tắt</button>
                                    </td>
                                    <td class="align-middle text-center">
                                        <button v-on:click="edit_goi = Object.assign(edit_goi, value)"
                                            class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#updateModal">Cập nhật</button>
                                        <button v-on:click="del_goi = value" class="btn btn-danger"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal">Xóa</button>
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
                    <h5 class="modal-title">Thêm Gói Mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tên Gói</label>
                            <input v-model="create_goi.ten_goi" type="text" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số Người Tối Đa</label>
                            <input v-model="create_goi.so_nguoi_toi_da" type="number" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số Phòng Tối Đa</label>
                            <input v-model="create_goi.so_phong_toi_da" type="number" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Thời Hạn (ngày)</label>
                            <input v-model="create_goi.thoi_han" type="number" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Trạng Thái</label>
                            <select v-model="create_goi.trang_thai" class="form-select">
                                <option value="1">Hoạt động</option>
                                <option value="0">Tạm tắt</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Mô Tả</label>
                            <textarea v-model="create_goi.mo_ta" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" v-on:click="themGoi()">Thêm mới</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cập Nhật -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cập Nhật Gói</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tên Gói</label>
                            <input v-model="edit_goi.ten_goi" type="text" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số Người Tối Đa</label>
                            <input v-model="edit_goi.so_nguoi_toi_da" type="number" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số Phòng Tối Đa</label>
                            <input v-model="edit_goi.so_phong_toi_da" type="number" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Thời Hạn (ngày)</label>
                            <input v-model="edit_goi.thoi_han" type="number" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Trạng Thái</label>
                            <select v-model="edit_goi.trang_thai" class="form-select">
                                <option value="1">Hoạt động</option>
                                <option value="0">Tạm tắt</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Mô Tả</label>
                            <textarea v-model="edit_goi.mo_ta" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" v-on:click="capNhatGoi()">Cập nhật</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Xóa -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xóa Gói</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        Bạn có chắc chắn muốn xóa gói <strong>{{ del_goi.ten_goi }}</strong>?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" v-on:click="xoaGoi()">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            list_goi: [],
            create_goi: { ten_goi: "", so_nguoi_toi_da: "", so_phong_toi_da: "", thoi_han: "", mo_ta: "", trang_thai: "1" },
            edit_goi: { ten_goi: "", so_nguoi_toi_da: "", so_phong_toi_da: "", thoi_han: "", mo_ta: "", trang_thai: "" },
            del_goi: {},
            tim_kiem: {},
        };
    },
    mounted() { this.loadData(); },
    methods: {
        timKiem() {
            axios.post("http://127.0.0.1:8000/api/goi/tim-kiem", this.tim_kiem)
                .then((res) => { this.list_goi = res.data.data; });
        },
        loadData() {
            axios.get('http://127.0.0.1:8000/api/goi/data')
                .then((res) => { this.list_goi = res.data.data; });
        },
        themGoi() {
            axios.post('http://127.0.0.1:8000/api/goi/create', this.create_goi)
                .then((res) => {
                    if (res.data.status) { this.$toast.success(res.data.message); this.loadData(); }
                    else this.$toast.error(res.data.message);
                }).catch(res => Object.values(res.response.data.errors).forEach(v => this.$toast.error(v[0])));
        },
        capNhatGoi() {
            axios.post('http://127.0.0.1:8000/api/goi/update', this.edit_goi)
                .then((res) => {
                    if (res.data.status) { this.$toast.success(res.data.message); this.loadData(); }
                    else this.$toast.error(res.data.message);
                }).catch(res => Object.values(res.response.data.errors).forEach(v => this.$toast.error(v[0])));
        },
        xoaGoi() {
            axios.post('http://127.0.0.1:8000/api/goi/delete', this.del_goi)
                .then((res) => {
                    if (res.data.status) { this.$toast.success(res.data.message); this.loadData(); }
                    else this.$toast.error(res.data.message);
                }).catch(res => Object.values(res.response.data.errors).forEach(v => this.$toast.error(v[0])));
        },
        changeStatus(value) {
            axios.post("http://127.0.0.1:8000/api/goi/change-status", value)
                .then((res) => { if (res.data.status) { this.loadData(); this.$toast.success(res.data.message); } });
        },
    },
};
</script>
<style scoped></style>
