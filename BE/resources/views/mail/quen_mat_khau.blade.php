<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác minh tài khoản</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f1f5f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f1f5f9;
            padding-bottom: 60px;
            padding-top: 40px;
        }
        .main-card {
            background-color: #ffffff;
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }
        .header {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            padding: 40px 20px;
            text-align: center;
        }
        .logo-text {
            color: #ffffff;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.5px;
            text-transform: uppercase;
        }
        .content {
            padding: 40px 35px;
            background-color: #ffffff;
            color: #334155;
            line-height: 1.6;
        }
        .greeting {
            font-size: 20px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 20px;
        }
        .message {
            font-size: 16px;
            color: #64748b;
            margin-bottom: 30px;
        }
        .otp-container {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            margin-bottom: 30px;
        }
        .otp-label {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            margin-bottom: 15px;
            display: block;
        }
        .otp-code {
            font-size: 42px;
            font-weight: 800;
            color: #f97316;
            letter-spacing: 8px;
            margin: 0;
        }
        .warning {
            font-size: 13px;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
            padding-top: 25px;
            font-style: italic;
        }
        .footer {
            text-align: center;
            padding: 30px;
            color: #94a3b8;
            font-size: 13px;
        }
        .footer a {
            color: #f97316;
            text-decoration: none;
        }
        @media screen and (max-width: 600px) {
            .content { padding: 30px 20px; }
            .otp-code { font-size: 36px; letter-spacing: 5px; }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="main-card">
            <!-- Header with Gradient -->
            <div class="header">
                <div class="logo-text">AI-MEET SYSTEM</div>
            </div>

            <!-- Main Content -->
            <div class="content">
                <div class="greeting">Xin chào {{ $ho_va_ten }},</div>
                <p class="message">
                    Bạn đã gửi yêu cầu khôi phục mật khẩu. Vui lòng sử dụng mã xác nhận bên dưới để tiếp tục quy trình thiết lập lại mật khẩu cho tài khoản của mình.
                </p>

                <!-- OTP Code Block -->
                <div class="otp-container">
                    <span class="otp-label">Mã xác thực của bạn là</span>
                    <div class="otp-code">{{ $ma_otp }}</div>
                </div>

                <p class="message" style="margin-bottom: 10px;">
                    Mã này sẽ hết hạn sau <strong>10 phút</strong>. Vì lý do bảo mật, tuyệt đối không chia sẻ mã này cho bất kỳ ai.
                </p>

                <div class="warning">
                    Nếu bạn không thực hiện yêu cầu này, bạn có thể an tâm bỏ qua email này. Tài khoản của bạn vẫn được bảo mật.
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                &copy; 2024 AI-Meet. Đã đăng ký bản quyền.<br>
                Hệ thống Quản lý Phòng họp Thông minh.
            </div>
        </div>
    </div>
</body>
</html>
