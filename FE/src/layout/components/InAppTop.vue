<template>
    <header>
        <div class="topbar d-flex align-items-center">
            <nav class="navbar navbar-expand gap-3">
                <!-- Toggle Button -->
                <div class="mobile-toggle-menu">
                    <i class='bx bx-menu'></i>
                </div>

                <!-- Search -->
                <div class="search-bar flex-grow-1">
                    <div class="position-relative search-bar-box">
                        <input type="text" class="form-control search-control" placeholder="Tìm kiếm...">
                        <span class="position-absolute top-50 search-show translate-middle-y"><i
                                class='bx bx-search'></i></span>
                    </div>
                </div>

                <!-- Right Side Info -->
                <div class="top-menu ms-auto">
                    <ul class="navbar-nav align-items-center gap-1">
                        <!-- Notifications -->
                        <li class="nav-item">
                            <a class="nav-link position-relative" href="#">
                                <span class="alert-count">7</span>
                                <i class='bx bx-bell'></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class='bx bx-shopping-bag'></i>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- User Profile -->
                <div class="user-box dropdown px-3">
                    <a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret" href="#"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img :src="getAvatar" class="user-img" alt="user avatar">
                        <div class="user-info d-none d-sm-block">
                            <p class="user-name mb-0">{{ profile.ho_ten || 'Đang tải...' }}</p>
                            <p class="designattion mb-0">{{ profile.ten_chuc_vu || '...' }}</p>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item d-flex align-items-center" href="/admin/profile"><i
                                    class="bx bx-user fs-5"></i><span>Hồ Sơ</span></a></li>
                        <li><a class="dropdown-item d-flex align-items-center" href="#"><i
                                    class="bx bx-cog fs-5"></i><span>Cài Đặt</span></a></li>
                        <li>
                            <div class="dropdown-divider mb-0"></div>
                        </li>
                        <li><a class="dropdown-item d-flex align-items-center" href="#" @click.prevent="logout"><i
                                    class="bx bx-log-out-circle fs-5"></i><span>Đăng Xuất</span></a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
</template>

<script>
import axios from 'axios';

export default {
    name: "InAppTop",
    data() {
        return {
            profile: {}
        };
    },
    computed: {
        getAvatar() {
            if (this.profile && this.profile.hinh_anh) {
                if (this.profile.hinh_anh.startsWith('http')) {
                    return this.profile.hinh_anh;
                }
                return 'http://127.0.0.1:8000' + this.profile.hinh_anh;
            }
            // Use a fallback avatar URL if not available or default from relative path might fail on dynamic bind.
            // Using a simple API placeholder or relative URL.
            // When using import it is safer, but returning a generic placeholder works if the relative path fails.
            return 'https://ui-avatars.com/api/?name=' + (this.profile.ho_ten || 'Admin') + '&background=random';
        }
    },
    mounted() {
        this.loadProfile();
        // Lắng nghe sự kiện cập nhật profile nếu có (tùy chọn)
        window.addEventListener('profile-updated', this.loadProfile);
    },
    beforeUnmount() {
        window.removeEventListener('profile-updated', this.loadProfile);
    },
    methods: {
        loadProfile() {
            const token = localStorage.getItem('token_admin');
            if (!token) return;
            
            axios.get('http://127.0.0.1:8000/api/admin/profile/data', {
                headers: {
                    Authorization: "Bearer " + token,
                },
            })
            .then(res => {
                if (res.data.status) {
                    this.profile = res.data.data;
                }
            })
            .catch((err) => {
                console.error('Lỗi khi tải profile InAppTop:', err);
            });
        },
        async logout() {
            try {
                const token = localStorage.getItem('token_admin');
                if (token) {
                    await axios.post('http://127.0.0.1:8000/api/admin/logout', {}, {
                        headers: {
                            Authorization: `Bearer ${token}`
                        }
                    });
                }
            } catch (error) {
                console.error("Lỗi khi đăng xuất:", error);
            } finally {
                localStorage.removeItem('token_admin');
                if (this.$toast) {
                    this.$toast.success("Đã đăng xuất thành công!");
                }
                this.$router.push('/admin/dang-nhap');
            }
        }
    }
}
</script>

<style scoped>
.topbar {
    position: fixed;
    top: 0;
    left: 250px;
    /* Same as sidebar width */
    right: 0;
    height: 60px;
    background: #ffffff;
    border-bottom: 1px solid #e5e7eb;
    z-index: 999;
}

.navbar {
    width: 100%;
    padding: 0 1.5rem;
}

.mobile-toggle-menu {
    display: none;
    font-size: 26px;
    cursor: pointer;
}

.search-bar {
    max-width: 300px;
}

.search-control {
    background-color: #f3f4f6;
    border: none;
    padding-left: 2.5rem;
    border-radius: 8px;
}

.search-show {
    left: 0.75rem;
    font-size: 18px;
    color: #9ca3af;
}

.nav-link {
    font-size: 22px;
    color: #4b5563;
}

.alert-count {
    position: absolute;
    top: 5px;
    right: 5px;
    width: 16px;
    height: 16px;
    background: #f36c5d;
    color: #fff;
    font-size: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

.user-img {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    object-fit: cover;
}

.user-name {
    font-size: 14px;
    font-weight: 600;
}

.designattion {
    font-size: 11px;
    color: #9ca3af;
}

@media (max-width: 1024px) {
    .topbar {
        left: 0;
    }

    .mobile-toggle-menu {
        display: block;
    }
}
</style>
