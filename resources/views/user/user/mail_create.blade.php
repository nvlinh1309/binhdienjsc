<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Binh Dien JSC</title>
</head>
<body>
    <h1>Xin chào {{ $data['name'] }}</h1>
    <p>Thông tin đăng nhập hệ thống</p>
    <div>Đường dẫn: <strong>{{ env('APP_URL') }}</strong></div>
    <div>Email: <strong>{{ $data['email'] }}</strong></div>
    <div>Mật khẩu: <strong>{{ $data['password'] }}</strong></div>

    <p>Lưu ý mail được gửi tự động từ hệ thống. Vui lòng không phản hồi lại. Xin cảm ơn!</p>
    <p>Trân trọng</p>
</body>
</html>
