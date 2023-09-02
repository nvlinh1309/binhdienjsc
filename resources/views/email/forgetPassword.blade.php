<div style="text-align: center;border-bottom: 7px solid gainsboro">
<h1>Binh Dien JSC</h1>
<span style="margin-bottom: 10px;
    display: block;">Reset Password</span><br/>
</div>
<div>
<p>Hi {{$name}},</p>


<span>Bạn quên mật khẩu?</span><br>
<span>Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.</span>

<br>
<br>
<span>Để đặt lại mật khẩu của bạn, hãy nhấp vào nút bên dưới:</span><br>
<a href="{{ route('reset.password.get', $token) }}" class="button" style="padding: 10px 25px;text-decoration: none; cursor: pointer; background-color: #A9A9A9; display: inline-block;border-radius: 5px; color: white;">Reset Password</a><br><br>

<div>Hoặc sao chép và dán URL vào trình duyệt của bạn:</div>
<a href="{{ route('reset.password.get', $token) }}">{{ route('reset.password.get', $token) }}</a>
</div>
   
{{-- <a href="{{ route('reset.password.get', $token) }}">Reset Password</a> --}}