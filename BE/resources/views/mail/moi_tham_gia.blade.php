<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lời mời tham gia cuộc họp</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: #f5f5f5; font-family: 'Segoe UI', Arial, sans-serif; color: #1a1e29; }
        .wrapper { max-width: 580px; margin: 40px auto; }
        .card { background: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 8px 40px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #ea580c 0%, #f97316 100%); padding: 48px 40px; text-align: center; }
        .header-icon { width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 24px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px; }
        .header-icon svg { width: 40px; height: 40px; fill: white; }
        .header h1 { color: white; font-size: 26px; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 8px; }
        .header p { color: rgba(255,255,255,0.85); font-size: 14px; font-weight: 500; }
        .body { padding: 40px; }
        .greeting { font-size: 16px; color: #374151; margin-bottom: 24px; line-height: 1.6; }
        .greeting strong { color: #ea580c; }
        .meeting-card { background: #fff7ed; border: 2px solid #fed7aa; border-radius: 18px; padding: 28px; margin: 28px 0; }
        .meeting-card .label { font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #9ca3af; margin-bottom: 6px; }
        .meeting-card .value { font-size: 15px; font-weight: 700; color: #1a1e29; margin-bottom: 18px; }
        .meeting-card .value:last-child { margin-bottom: 0; }
        .code-box { background: #1a1e29; border-radius: 14px; padding: 20px 28px; text-align: center; margin: 20px 0 0 0; }
        .code-box .code-label { font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; color: #9ca3af; margin-bottom: 10px; }
        .code-box .code { font-size: 28px; font-weight: 900; color: #f97316; letter-spacing: 4px; }
        .btn-join { display: block; text-align: center; background: linear-gradient(135deg, #ea580c, #f97316); color: white !important; text-decoration: none; padding: 18px 36px; border-radius: 16px; font-size: 15px; font-weight: 800; margin: 32px 0; box-shadow: 0 8px 24px rgba(234,88,12,0.3); }
        .note { background: #f8fafc; border-left: 4px solid #ea580c; border-radius: 0 12px 12px 0; padding: 16px 20px; font-size: 13px; color: #64748b; font-weight: 500; line-height: 1.6; margin-bottom: 28px; }
        .footer { border-top: 1px solid #f0ece6; padding: 28px 40px; text-align: center; }
        .footer p { font-size: 12px; color: #9ca3af; font-weight: 500; line-height: 1.7; }
        .footer strong { color: #ea580c; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="card">
        <div class="header">
            <div class="header-icon">
                <svg viewBox="0 0 24 24"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg>
            </div>
            <h1>Bạn nhận được lời mời họp!</h1>
            <p>AI-Meet Business — Hệ thống họp trực tuyến bảo mật AI</p>
        </div>

        <div class="body">
            <p class="greeting">
                Xin chào <strong>{{ $ho_va_ten_nguoi_nhan }}</strong>,<br><br>
                <strong>{{ $ten_nguoi_moi }}</strong> đã mời bạn tham gia vào cuộc họp trực tuyến trên hệ thống <strong>AI-Meet</strong>. Vui lòng xem thông tin bên dưới:
            </p>

            <div class="meeting-card">
                <div class="label">Tên cuộc họp</div>
                <div class="value">{{ $ten_phong }}</div>
                <div class="label">Người tổ chức</div>
                <div class="value">{{ $ten_nguoi_moi }}</div>
                <div class="code-box">
                    <div class="code-label">Mã tham gia phòng</div>
                    <div class="code">{{ $ma_phong }}</div>
                </div>
            </div>

            <a href="{{ env('FRONTEND_URL', 'http://localhost:5173') }}/nguoi-dung/trang-chinh" class="btn-join">
                🚀 Truy cập hệ thống để tham gia
            </a>

            <div class="note">
                <strong>💡 Hướng dẫn:</strong> Đăng nhập vào hệ thống AI-Meet, chọn "Tham gia phòng họp" và nhập mã phòng ở trên. Bạn cần thiết lập <strong>Face ID</strong> trước khi vào phòng.
            </div>
        </div>

        <div class="footer">
            <p>
                Email này được gửi tự động từ hệ thống <strong>AI-Meet Business</strong>.<br>
                Nếu bạn không muốn nhận email này, vui lòng liên hệ người tổ chức.
            </p>
        </div>
    </div>
</div>
</body>
</html>
