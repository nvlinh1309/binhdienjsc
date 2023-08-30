<h1>Chào mừng bạn đến Hệ thống Quản lý Bán hàng Binh Dien JSC</h1>
<h4>Thông tin tài khoản:</h4>

<p>- Họ tên: {{$data['name']}} </p>
<p>- Email đăng nhập: {{$data['email']}} </p>
<p>- Mật khẩu: {{$data['password']}} </p>
<p>- Vai trò: {{$data['role']}} </p>
<p>- Link truy cập: <a href="{{ route('reset.password.get', $data['token']) }}">Reset Password</a> </p>