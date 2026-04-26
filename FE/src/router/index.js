import { createRouter, createWebHistory } from "vue-router"; // cài vue-router: npm install vue-router@next --save

import { createToaster } from "@meforma/vue-toaster";

const toaster = createToaster({ position: "top-right" });
// middleware Admin
const checkAdmin = (to, from, next) => {
    const tokenAdmin = localStorage.getItem('token_admin');
    if (!tokenAdmin) {
        toaster.error('Bạn không có quyền truy cập! Vui lòng đăng nhập.');
        next('/admin/dang-nhap');
    } else {
        next();
    }
};
// middleware user trước khi vào phòng họp
const checkUserMeeting = (to, from, next) => {
    // 1. Kiểm tra xem đã đăng nhập chưa
    const thong_tin = localStorage.getItem('thong_tin_user');

    // 2. Kiểm tra xem có vé (token) LiveKit chưa
    const livekitToken = sessionStorage.getItem('livekit_token');

    if (!thong_tin) {
        toaster.warning('Vui lòng đăng nhập để sử dụng tính năng này!');
        next('/dang-nhap');
    } else if (!livekitToken) {
        toaster.error('Lỗi bảo mật: Bạn chưa được cấp quyền truy cập phòng họp này!');
        next('/nguoi-dung/trang-chinh'); // Đuổi về trang chủ để quét Face ID lại
    } else {
        next(); // Cho phép qua cửa
    }
};

const routes = [
    {
        path: '/',
        component: () => import('../components/TrangChu/index.vue'),
        meta: { layout: 'client' }
    },

    {
        path: '/admin/quan-ly-hoa-don',
        component: () => import('../components/Admin/QuanLyHoaDon/index.vue'),
        meta: { layout: 'inapp' },
        beforeEnter: checkAdmin
    },
    {
        path: '/admin/dashboard',
        component: () => import('../components/Admin/dashboard/index.vue'),
        meta: { layout: 'inapp' },
        beforeEnter: checkAdmin
    },
    {
        path: '/admin/phong-hop',
        component: () => import('../components/Admin/PhongHop/index.vue'),
        meta: { layout: 'inapp' },
        beforeEnter: checkAdmin
    },
    {
        path: '/admin/goi-dich-vu',
        component: () => import('../components/Admin/Goi/index.vue'),
        meta: { layout: 'inapp' },
        beforeEnter: checkAdmin
    },
    {
        path: '/admin/doi-tac',
        component: () => import('../components/Admin/DoiTac/index.vue'),
        meta: { layout: 'inapp' },
        beforeEnter: checkAdmin
    },
    {
        path: '/admin/nguoi-dung',
        component: () => import('../components/Admin/NguoiDung/index.vue'),
        meta: { layout: 'inapp' },
        beforeEnter: checkAdmin
    },
    {
        path: '/admin/phan-quyen',
        component: () => import('../components/Admin/PhanQuyen/index.vue'),
        meta: { layout: 'inapp' },
        beforeEnter: checkAdmin
    },
    {
        path: '/admin/chuc-vu',
        component: () => import('../components/Admin/ChucVu/index.vue'),
        meta: { layout: 'inapp' },
        beforeEnter: checkAdmin
    },
    {
        path: '/admin/chuc-nang',
        component: () => import('../components/Admin/ChucNang/index.vue'),
        meta: { layout: 'inapp' },
        beforeEnter: checkAdmin
    },
    {
        path: '/admin/dang-nhap',
        component: () => import('../components/Admin/DangNhap/index.vue'),
        meta: { layout: 'black' }
    },
    {
        path: '/admin/nhan-vien',
        component: () => import('../components/Admin/NhanVien/index.vue'),
        meta: { layout: 'inapp' },
        beforeEnter: checkAdmin
    },
    {
        path: '/admin/profile',
        component: () => import('../components/Admin/Profile/index.vue'),
        meta: { layout: 'inapp' },
        beforeEnter: checkAdmin
    },

    // Auth Chung
    {
        path: '/dang-nhap',
        component: () => import('../components/DangNhap/index.vue'),
        meta: { layout: 'black' }
    },

    //Nguoi Dung
    {
        path: '/nguoi-dung/quen-mat-khau',
        component: () => import('../components/NguoiDung/QuenMatKhau/index.vue'),
        meta: { layout: 'black' }
    },
    {
        path: '/nguoi-dung/dang-ky',
        component: () => import('../components/NguoiDung/DangKy/index.vue'),
        meta: { layout: 'black' }
    },
    {
        path: '/nguoi-dung/lay-lai-mat-khau',
        component: () => import('../components/NguoiDung/LayLaiMatKhau/index.vue'),
        meta: { layout: 'black' }
    },
    {
        path: '/nguoi-dung/hoa-don',
        component: () => import('../components/NguoiDung/HoaDon/index.vue')
    },
    {
        path: '/nguoi-dung/trang-chinh',
        component: () => import('../components/NguoiDung/TrangChinhNguoiDung/index.vue'),
        meta: { layout: 'black' }
    },
    {
        path: '/nguoi-dung/danh-sach-goi',
        component: () => import('../components/NguoiDung/DanhSachGoi/index.vue'),
        meta: { layout: 'black' }
    },
    {
        path: '/nguoi-dung/thanh-toan/:id_goi?',
        component: () => import('../components/NguoiDung/ThanhToan/index.vue'),
        meta: { layout: 'black' }
    },
    // Phong Hop
    {
        path: '/phong-hop/:id', // :id là tham số động (mã phòng)
        component: () => import('../components/NguoiDung/PhongHopVideo/index.vue'),
        meta: { layout: 'black' }, // Dùng layout đen cho ngầu, giống Zoom
        beforeEnter: checkUserMeeting
    },

    //Doi Tac
    {
        path: '/doi-tac/quen-mat-khau',
        component: () => import('../components/DoiTac/QuenMatKhau/index.vue'),
        meta: { layout: 'black' }
    },
    {
        path: '/doi-tac/lay-lai-mat-khau',
        component: () => import('../components/DoiTac/LayLaiMatKhau/index.vue'),
        meta: { layout: 'black' }
    },
    {
        path: '/doi-tac/trang-chinh',
        component: () => import('../components/DoiTac/TrangChinhDoiTac/index.vue'),
        meta: { layout: 'black' }
    },
    {
        path: '/doi-tac/phong-hop',
        component: () => import('../components/DoiTac/PhongHop/index.vue'),
        meta: { layout: 'black' }
    },
    {
        path: '/doi-tac/bao-cao',
        component: () => import('../components/DoiTac/BaoCao/index.vue'),
        meta: { layout: 'black' }
    },
    {
        path: '/doi-tac/profile',
        component: () => import('../components/DoiTac/Profile/index.vue'),
        meta: { layout: 'black' }
    },
    {
    path: '/doi-tac/quan-ly-phong-hop',
    component: () => import('../components/DoiTac/QuanLyPhongHop/index.vue'),
    meta: { layout: 'black' }
    },
    {
    path: '/doi-tac/quan-ly-thanh-vien',
    component: () => import('../components/DoiTac/QuanLyThanhVien/index.vue'),
    meta: { layout: 'black' }
    },
    {
    path: '/doi-tac/hoa-don',
    component: () => import('../components/DoiTac/HoaDon/index.vue'),
    meta: { layout: 'black' }
    },

]

const router = createRouter({
    history: createWebHistory(),
    routes: routes
})

export default router