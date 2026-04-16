<template>
    <div class="sidebar-wrapper" data-simplebar="true">
        <div class="sidebar-header">
            <div>
                <img src="../../assets/images/logo.pnj.png" alt="" class="img-fluid" style="width: 50px;">
            </div>
            <div>
                <h4 class="logo-text">Admin</h4>
            </div>
            <div class="toggle-icon ms-auto">
                <i class='bx bx-arrow-to-left'></i>
            </div>
        </div>

        <!-- Navigation -->
        <ul class="metismenu" id="menu">
            <li class="menu-label">Trang Chủ</li>
            <li>
                <router-link to="/">
                    <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
                    <div class="menu-title">Bảng Điều Khiển</div>
                </router-link>
            </li>

            <li class="menu-label">Quản Lý Hệ Thống</li>
            <li>


                <router-link to="/admin/dashboard">
                    <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
                    <div class="menu-title">dashboard</div>
                </router-link>
            </li>
            <li>
                <router-link to="/admin/nhan-vien">
                    <div class="parent-icon"><i class='bx bx-user'></i></div>
                    <div class="menu-title">Nhân Viên</div>
                </router-link>
            </li>
            <li>
                <router-link to="/admin/phong-hop">
                    <div class="parent-icon"><i class='bx bx-door-open'></i></div>
                    <div class="menu-title">Phòng Họp</div>
                </router-link>
            </li>
            <li>
                <router-link to="/admin/goi-dich-vu">
                    <div class="parent-icon"><i class='bx bx-cube'></i></div>
                    <div class="menu-title">Gói Dịch Vụ</div>
                </router-link>
            </li>
            <li>
                <router-link to="/admin/doi-tac">
                    <div class="parent-icon"><i class='bx bx-group'></i></div>
                    <div class="menu-title">Đối Tác</div>
                </router-link>
            </li>
            <li>
                <router-link to="/admin/nguoi-dung">
                    <div class="parent-icon"><i class='bx bx-user-pin'></i></div>
                    <div class="menu-title">Người Dùng</div>
                </router-link>
            </li>
            <li>
                <router-link to="/admin/quan-ly-hoa-don">
                    <div class="parent-icon"><i class='bx bx-receipt'></i></div>
                    <div class="menu-title">Hóa Đơn</div>
                </router-link>
            </li>

            <li class="menu-label">Hệ Thống Phân Quyền</li>
            <li>
                <router-link to="/admin/chuc-vu">
                    <div class="parent-icon"><i class='bx bx-user-circle'></i></div>
                    <div class="menu-title">Chức Vụ</div>
                </router-link>
            </li>
            <li>
                <router-link to="/admin/chuc-nang">
                    <div class="parent-icon"><i class='bx bx-code-block'></i></div>
                    <div class="menu-title">Chức Năng</div>
                </router-link>
            </li>
            <li>
                <router-link to="/admin/phan-quyen">
                    <div class="parent-icon"><i class='bx bx-shield-quarter'></i></div>
                    <div class="menu-title">Phân Quyền</div>
                </router-link>
            </li>

        </ul>
    </div>
</template>

<script>
export default {
    name: "InAppMenu"
}
</script>

<style scoped>
.sidebar-wrapper {
    width: 250px;
    height: 100%;
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    background: #ffffff;
    border-right: 1px solid #e5e7eb;
    z-index: 1000;
    transition: all 0.3s ease;
}

.sidebar-header {
    width: 250px;
    height: 60px;
    display: flex;
    align-items: center;
    padding: 0 15px;
    border-bottom: 1px solid #e5e7eb;
}

.logo-icon {
    width: 35px;
}

.logo-text {
    font-size: 22px;
    margin-left: 10px;
    margin-bottom: 0;
    font-weight: 700;
    color: #f36c5d;
    /* InApp Coral Color */
}

.toggle-icon {
    font-size: 22px;
    cursor: pointer;
    color: #9ca3af;
}

.metismenu {
    display: flex;
    flex-direction: column;
    padding: 15px 0;
    margin: 0;
    list-style: none;
}

.menu-label {
    padding: 10px 20px;
    font-size: 11px;
    text-transform: uppercase;
    font-weight: 600;
    letter-spacing: 0.5px;
    color: #9ca3af;
}

.metismenu li a {
    display: flex;
    align-items: center;
    padding: 8px 15px;
    margin: 2px 15px;
    border-radius: 8px;
    color: #4b5563;
    text-decoration: none;
    transition: all 0.2s;
}

.metismenu li a:hover {
    background-color: rgba(243, 108, 93, 0.05);
    color: #f36c5d;
}

.metismenu li a.router-link-active {
    background-color: #f36c5d;
    color: #ffffff;
}

.parent-icon {
    font-size: 20px;
    line-height: 1;
}

.menu-title {
    margin-left: 10px;
    font-size: 14px;
    font-weight: 500;
}
</style>
