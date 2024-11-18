<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đăng ký</title>
</head>
<body>
    <h2>Chào {{ $email }}</h2>
    <p>Cảm ơn bạn đã đăng ký tài khoản tại <strong>FoxTales</strong>.</p>
    <p>Để xác nhận tài khoản, vui lòng nhấp vào liên kết dưới đây:</p>
    <a href="{{ route('verifyEmail', ['token' => $token]) }}">Xác nhận tài khoản</a>
    <p>Thân ái,</p>
    <p>Đội ngũ FoxTales</p>
</body>
</html>
