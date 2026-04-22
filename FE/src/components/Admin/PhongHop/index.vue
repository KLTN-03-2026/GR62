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
                            <input @keyup="timKiem()" v-model="tu_khoa" type="text" class="form-control"
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
                             <template v-for="(value, index) in list_phong_hop" :key="index">
                                <tr class="text-nowrap">
                                    <th class="align-middle text-center">{{ index + 1 }}</th>
                                    <td class="align-middle text-center">{{ value.ma_phong }}</td>
                                    <td class="align-middle">{{ value.ten_phong }}</td>
                                    <td class="align-middle text-center">{{ value.chu_phong?.ho_va_ten || 'Hệ thống' }}</td>
                                    <td class="align-middle text-center">{{ value.so_nguoi_toi_da }}</td>
                                    <td class="align-middle text-center">{{ value.thoi_gian_bat_dau }}</td>
                                    <td class="align-middle text-center">
                                        {{ value.thoi_gian_ket_thuc || 'Đang diễn ra' }}
                                    </td>
                                    <td class="align-middle text-center" v-on:click="doiTrangThai(value)">
                                        <button v-if="value.trang_thai == 1" class="btn btn-info w-100"
                                            style="color:white">Hoạt động</button>
                                        <button v-else class="btn btn-secondary w-100">Tạm tắt</button>
                                    </td>
                                    <td class="align-middle text-center">
                                        <button v-on:click="edit_phong_hop = Object.assign({}, value)"
                                            class="btn btn-success me-2" data-bs-toggle="modal"
                                            data-bs-target="#updateModal">Cập nhật</button>
                                        <button v-on:click="del_phong_hop = value" class="btn btn-danger"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal">Xóa</button>
                                    </td>
                                </tr>
                            </template>
                            <tr v-if="list_phong_hop.length == 0">
                                <td colspan="9" class="text-center text-muted p-5">
                                    <i class="bx bx-info-circle fs-1 d-block mb-2"></i>
                                    Không tìm thấy dữ liệu phòng họp nào phù hợp.
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
const API = import.meta.env.VITE_API_URL;
export default {
    data() {
        return {
            list_phong_hop: [],
            list_phong_hop_goc: [],
            list_doi_tac: [],
            create_phong_hop: { ma_phong: "", ten_phong: "", so_nguoi_toi_da: "", thoi_gian_bat_dau: "", thoi_gian_ket_thuc: "", trang_thai: "1", id_doi_tac: "" },
            edit_phong_hop: { ma_phong: "", ten_phong: "", so_nguoi_toi_da: "", thoi_gian_bat_dau: "", thoi_gian_ket_thuc: "", trang_thai: "", id_doi_tac: "" },
            del_phong_hop: {},
            tu_khoa: "",
        };
    },
    mounted() {
        this.loadData();
        this.loadDoiTac();
    },
    methods: {
        headers() {
            return { Authorization: 'Bearer ' + localStorage.getItem('token_admin') };
        },
        loadDoiTac() {
            axios.get(`${API}/doi-tac/data`, { headers: this.headers() })
                .then((res) => { this.list_doi_tac = res.data.data || []; });
        },
        timKiem() {
            const ds = this.list_phong_hop_goc || [];
            if (!this.tu_khoa) {
                this.list_phong_hop = [...ds];
                return;
            }
            const kw = this.tu_khoa.trim().toLowerCase();
            this.list_phong_hop = ds.filter(v =>
                (v.ten_phong && v.ten_phong.toLowerCase().includes(kw)) ||
                (v.ma_phong && v.ma_phong.toLowerCase().includes(kw)) ||
                (v.ten_chu_phong && v.ten_chu_phong.toLowerCase().includes(kw))
            );
        },
        loadData() {
            axios.get(`${API}/phong-hop/data`, { headers: this.headers() })
                .then((res) => {
                    this.list_phong_hop = res.data.data || [];
                    this.list_phong_hop_goc = [...this.list_phong_hop];
                    if (this.tu_khoa) this.timKiem();
                });
        },
        themPhongHop() {
            axios.post(`${API}/phong-hop/create`, this.create_phong_hop, { headers: this.headers() })
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.create_phong_hop = { ma_phong: "", ten_phong: "", so_nguoi_toi_da: "", thoi_gian_bat_dau: "", thoi_gian_ket_thuc: "", trang_thai: "1", id_doi_tac: "" };
                        this.loadData();
                    }
                    else this.$toast.error(res.data.message);
                }).catch(res => {
                    if (res.response?.data?.errors)
                        Object.values(res.response.data.errors).forEach(v => this.$toast.error(v[0]));
                });
        },
        capNhatPhongHop() {
            axios.post(`${API}/phong-hop/update`, this.edit_phong_hop, { headers: this.headers() })
                .then((res) => {
                    if (res.data.status) { this.$toast.success(res.data.message); this.loadData(); }
                    else this.$toast.error(res.data.message);
                }).catch(res => {
                    if (res.response?.data?.errors)
                        Object.values(res.response.data.errors).forEach(v => this.$toast.error(v[0]));
                });
        },
        xoaPhongHop() {
            axios.post(`${API}/phong-hop/delete`, this.del_phong_hop, { headers: this.headers() })
                .then((res) => {
                    if (res.data.status) { this.$toast.success(res.data.message); this.loadData(); }
                    else this.$toast.error(res.data.message);
                }).catch(res => {
                    if (res.response?.data?.errors)
                        Object.values(res.response.data.errors).forEach(v => this.$toast.error(v[0]));
                });
        },
        doiTrangThai(value) {
            axios.post(`${API}/phong-hop/change-status`, value, { headers: this.headers() })
                .then((res) => { if (res.data.status) { this.loadData(); this.$toast.success(res.data.message); } });
        },
    },
};
</script>
<style scoped></style>
