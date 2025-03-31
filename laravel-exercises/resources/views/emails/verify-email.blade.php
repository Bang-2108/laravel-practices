<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận tài khoản</title>
</head>
<body>
    <h2>Xin chào, {{ $user->name }}!</h2>
    <p>Cảm ơn bạn đã đăng ký tài khoản tại chúng tôi. Đây là thông tin tài khoản của bạn:</p>
    <ul>
        <li><strong>Tên người dùng:</strong> {{ $user->username }}</li>
        <li><strong>Email:</strong> {{ $user->email }}</li>
    </ul>
    <p>Vui lòng nhấn vào nút dưới đây để xác nhận tài khoản của bạn:</p>
    <a href="{{ $verifyUrl }}" 
       style="display: inline-block; padding: 10px 20px; background-color: blue; color: white; text-decoration: none;">
       Xác nhận tài khoản
    </a>
    <p>Nếu bạn không đăng ký tài khoản, vui lòng bỏ qua email này.</p>
</body>
</html>