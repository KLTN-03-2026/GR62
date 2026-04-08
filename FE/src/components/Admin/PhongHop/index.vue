<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card radius-10 border-top border-0 border-3 border-info">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="mt-2"><b>DANH SÁCH PHÒNG HỌP</b></h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        Thêm phòng họp
                    </button>
                </div>
                <div class="row m-2">
                    <div class="col-lg-12">
                        <div class="input-group">
                            <input @keyup="timKiem()" v-model="tim_kiem.noi_dung_tim" type="text" class="form-control"
                                placeholder="Tìm kiếm theo tên, mã phòng...">
                            <button v-on:click="timKiem()" class="btn btn-primary">Tìm Kiếm</button>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr class="bg-primary text-light text-nowrap">
                                <th class="text-center">#</th>
                                <th class="text-center">Mã Phòng</th>
                                <th class="text-center">Tên Phòng</th>
                                <th class="text-center">Người Tạo</th>
                                <th class="text-center">Số Người Tối Đa</th>
                                <th class="text-center">Thời Gian Bắt Đầu</th>
                                <th class="text-center">Thời Gian Kết Thúc</th>
                                <th class="text-center">Trạng Thái</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-nowrap" v-for="(value, index) in list_phong_hop" :key="index">
                                <th class="align-middle text-center">{{ index + 1 }}</th>
                                <td class="align-middle text-center">{{ value.ma_phong }}</td>
                                <td class="align-middle">{{ value.ten_phong }}</td>
                                <td class="align-middle text-center">{{ value.ten_chu_phong }}</td>
                                <td class="align-middle text-center">{{ value.so_nguoi_toi_da }}</td>
                                <td class="align-middle text-center">{{ value.thoi_gian_bat_dau }}</td>
                                <td class="align-middle text-center">{{ value.thoi_gian_ket_thuc }}</td>
                                <td class="align-middle text-center" v-on:click="changeStatus(value)">
                                    <button v-if="value.trang_thai == 1" class="btn btn-info w-100"
                                        style="color:white">Hoạt động</button>
                                    <button v-else class="btn btn-secondary w-100">Tạm tắt</button>
                                </td>
                                <td class="align-middle text-center">
                                    <button v-on:click="edit_phong_hop = Object.assign(edit_phong_hop, value)"
                                        class="btn btn-success me-2" data-bs-toggle="modal"
                                        data-bs-target="#updateModal">Cập nhật</button>
                                    <button v-on:click="del_phong_hop = value" class="btn btn-danger"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal">Xóa</button>
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
                    <h5 class="modal-title">Thêm Phòng Họp Mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mã Phòng</label>
                            <input v-model="create_phong_hop.ma_phong" type="text" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tên Phòng</label>
                            <input v-model="create_phong_hop.ten_phong" type="text" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Người Tạo (Đối Tác)</label>
                            <select v-model="create_phong_hop.id_doi_tac" class="form-select">
                                <option value="" disabled>-- Chọn Đối Tác --</option>
                                <option v-for="(dt, idx) in list_doi_tac" :key="idx" :value="dt.id">{{ dt.ho_va_ten }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số Người Tối Đa</label>
                            <input v-model="create_phong_hop.so_nguoi_toi_da" type="number" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Trạng Thái</label>
                            <select v-model="create_phong_hop.trang_thai" class="form-select">
                                <option value="1">Hoạt động</option>
                                <option value="0">Tạm tắt</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Thời Gian Bắt Đầu</label>
                            <input v-model="create_phong_hop.thoi_gian_bat_dau" type="datetime-local"
                                class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Thời Gian Kết Thúc</label>
                            <input v-model="create_phong_hop.thoi_gian_ket_thuc" type="datetime-local"
                                class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                        v-on:click="themPhongHop()">Thêm
                        mới</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cập Nhật -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cập Nhật Phòng Họp</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mã Phòng</label>
                            <input v-model="edit_phong_hop.ma_phong" type="text" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tên Phòng</label>
                            <input v-model="edit_phong_hop.ten_phong" type="text" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Người Tạo (Đối Tác)</label>
                            <select v-model="edit_phong_hop.id_doi_tac" class="form-select">
                                <option value="" disabled>-- Chọn Đối Tác --</option>
                                <option v-for="(dt, idx) in list_doi_tac" :key="idx" :value="dt.id">{{ dt.ho_va_ten }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số Người Tối Đa</label>
                            <input v-model="edit_phong_hop.so_nguoi_toi_da" type="number" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Trạng Thái</label>
                            <select v-model="edit_phong_hop.trang_thai" class="form-select">
                                <option value="1">Hoạt động</option>
                                <option value="0">Tạm tắt</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Thời Gian Bắt Đầu</label>
                            <input v-model="edit_phong_hop.thoi_gian_bat_dau" type="datetime-local"
                                class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Thời Gian Kết Thúc</label>
                            <input v-model="edit_phong_hop.thoi_gian_ket_thuc" type="datetime-local"
                                class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal"
                        v-on:click="capNhatPhongHop()">Cập
                        nhật</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Xóa -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xóa Phòng Họp</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        Bạn có chắc chắn muốn xóa phòng họp <strong>{{ del_phong_hop.ten_phong }}</strong>?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" v-on:click="xoaPhongHop()">Xác
                        nhận</button>
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
            list_phong_hop: [],
            list_doi_tac: [],
            create_phong_hop: { ma_phong: "", ten_phong: "", so_nguoi_toi_da: "", thoi_gian_bat_dau: "", thoi_gian_ket_thuc: "", trang_thai: "1", id_doi_tac: "" },
            edit_phong_hop: { ma_phong: "", ten_phong: "", so_nguoi_toi_da: "", thoi_gian_bat_dau: "", thoi_gian_ket_thuc: "", trang_thai: "", id_doi_tac: "" },
            del_phong_hop: {},
            tim_kiem: {},
        };
    },
    mounted() {
        this.loadData();
        this.loadDoiTac();
    },
    methods: {
        loadDoiTac() {
            axios.get('http://127.0.0.1:8000/api/doi-tac/data')
                .then((res) => { this.list_doi_tac = res.data.data; });
        },
        timKiem() {
            axios.post("http://127.0.0.1:8000/api/phong-hop/tim-kiem", this.tim_kiem)
                .then((res) => { this.list_phong_hop = res.data.data; });
        },
        loadData() {
            axios.get('http://127.0.0.1:8000/api/phong-hop/data')
                .then((res) => { this.list_phong_hop = res.data.data; });
        },
        themPhongHop() {
            axios.post('http://127.0.0.1:8000/api/phong-hop/create', this.create_phong_hop)
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.create_phong_hop = { ma_phong: "", ten_phong: "", so_nguoi_toi_da: "", thoi_gian_bat_dau: "", thoi_gian_ket_thuc: "", trang_thai: "1", id_doi_tac: "" };
                        this.loadData();
                    }
                    else this.$toast.error(res.data.message);
                }).catch(res => Object.values(res.response.data.errors).forEach(v => this.$toast.error(v[0])));
        },
        capNhatPhongHop() {
            axios.post('http://127.0.0.1:8000/api/phong-hop/update', this.edit_phong_hop)
                .then((res) => {
                    if (res.data.status) { this.$toast.success(res.data.message); this.loadData(); }
                    else this.$toast.error(res.data.message);
                }).catch(res => Object.values(res.response.data.errors).forEach(v => this.$toast.error(v[0])));
        },
        xoaPhongHop() {
            axios.post('http://127.0.0.1:8000/api/phong-hop/delete', this.del_phong_hop)
                .then((res) => {
                    if (res.data.status) { this.$toast.success(res.data.message); this.loadData(); }
                    else this.$toast.error(res.data.message);
                }).catch(res => Object.values(res.response.data.errors).forEach(v => this.$toast.error(v[0])));
        },
        changeStatus(value) {
            axios.post("http://127.0.0.1:8000/api/phong-hop/change-status", value)
                .then((res) => { if (res.data.status) { this.loadData(); this.$toast.success(res.data.message); } });
        },
    },
};
</script>
<style scoped></style>
