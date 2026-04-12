# 🚀 AI-Meet: Nền tảng Họp Trực tuyến Thông minh

<div align="center">
  <img src="FE/public/ai_login_v2.png" alt="AI-Meet UI Banner" width="100%" />
  <p><i>Kiến tạo không gian số thông minh - Kết nối mọi lúc, mọi nơi.</i></p>
</div>

---

## 🌟 Tổng quan dự án

**AI-Meet** là nền tảng hội nghị truyền hình thế hệ mới, được thiết kế để mang lại trải nghiệm cộng tác đỉnh cao. Tích hợp trí tuệ nhân tạo (AI) giúp tối ưu hóa luồng công việc, từ việc quản lý hồ sơ đối tác đến việc tạo ra các không gian họp 4K HDR bảo mật và chuyên nghiệp.

> [!TIP]
> Hệ thống sử dụng giao diện **Neo-Futuristic** với hiệu ứng kính mờ (Glassmorphism) và Cyber-animations độc quyền, mang lại cảm giác công nghệ tương lai trên từng khung hình.

---

## ✨ Tính năng nổi bật

| Tính năng | Mô tả | Trạng thái |
| :--- | :--- | :---: |
| 🛡️ **Bảo mật đa tầng** | Xác thực OTP & JWT cho người dùng và đối tác. | ✅ |
| 🤖 **Trợ lý AI** | Tích hợp xử lý ngôn ngữ tự nhiên trong phòng họp. | 🚧 |
| 🎨 **Neo-UI Design** | Giao diện hiện đại, tối ưu trải nghiệm (UX). | ✅ |
| ☁️ **Cloud Sync** | Đồng bộ hóa hồ sơ và lịch họp trên đám mây. | ✅ |
| 📽️ **4K HDR Video** | Chất lượng truyền tải hình ảnh độ phân giải cao. | ✅ |

---

## 🛠️ Công nghệ sử dụng

### **Frontend**
![Vue.js](https://img.shields.io/badge/vuejs-%2335495e.svg?style=for-the-badge&logo=vuedotjs&logoColor=%234FC08D)
![Vite](https://img.shields.io/badge/vite-%23646CFF.svg?style=for-the-badge&logo=vite&logoColor=white)
![Bootstrap](https://img.shields.io/badge/bootstrap-%238511f2.svg?style=for-the-badge&logo=bootstrap&logoColor=white)
![CSS3](https://img.shields.io/badge/css3-%231572B6.svg?style=for-the-badge&logo=css3&logoColor=white)

### **Backend**
![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)
![Sanctum](https://img.shields.io/badge/Sanctum-Auth-orange?style=for-the-badge)

---

## 🏗️ Kiến trúc hệ thống

```mermaid
graph TD
    User((Người dùng)) -->|Vue Router| Frontend[Frontend - Vue 3 + Vite]
    Frontend -->|Axios API Requests| Backend[Backend - Laravel API]
    Backend -->|Model Interaction| Database[(MySQL Database)]
    Backend -->|Authentication| Sanctum[Laravel Sanctum / JWT]
    
    subgraph "Dịch vụ AI"
        Backend --> AI_Service[AI Summarization/Analysis]
    end
    
    subgraph "Video Streaming"
        Frontend --> WebRTC[Real-time Video / WebRTC]
    end
```

---

## ⚙️ Hướng dẫn cài đặt

### 1. Yêu cầu hệ thống
- PHP >= 8.1
- Node.js >= 16.x
- Composer & NPM / Yarn
- MySQL / MariaDB

### 2. Thiết lập Backend (BE)
```bash
# Di chuyển vào thư mục BE
cd BE

# Cài đặt dependencies
composer install

# Tạo file cấu hình môi trường
cp .env.example .env

# Tạo application key
php artisan key:generate

# Khởi tạo database & seed dữ liệu
php artisan migrate --seed

# Chạy server
php artisan serve
```

### 3. Thiết lập Frontend (FE)
```bash
# Di chuyển vào thư mục FE
cd FE

# Cài đặt dependencies
npm install

# Cấu hình API URL trong .env
vibr VITE_API_URL=http://127.0.0.1:8000/api

# Chạy ứng dụng ở chế độ development
npm run dev
```

---

## 📸 Ảnh chụp giao diện

### Trang đăng nhập (Neo-Futuristic UI)
<div align="center">
  <img src="FE/public/ai_login_v2.png" width="80%" alt="Login UI" />
</div>

---

## 📄 Giấy phép
Distributed under the **MIT License**. See `LICENSE` for more information.

---
<div align="center">
  <p>Được xây dựng với ❤️ bởi Nhóm Phát triển GR62</p>
</div>
