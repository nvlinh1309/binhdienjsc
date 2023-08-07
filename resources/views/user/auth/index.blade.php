<x-layouts.main>
    <div class='col-md-6'>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Thông tin tài khoản: {{ Auth::user()->name }}</h3>
            </div>
            @if (Session::has('error'))
                <div class="alert alert-danger mt-2" role="alert">
                    {{ Session::get('error') }}
                </div>
            @endif
            @if (Session::has('success'))
                <div class="alert alert-success mt-2" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('changePasswordPost') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input class="form-control" readonly id="exampleInputEmail1" value="{{ Auth::user()->email }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Cập nhật mật khẩu</label>
                        <div class="col-md-12">
                            <div class="form-group">
                                <i for="current_password">Mật khẩu hiện tại</i>
                                <input type="password" name="current_password" readonly
                                    onfocus="this.removeAttribute('readonly')" class="form-control"
                                    id="current_password" placeholder="Nhập mật khẩu hiện tại" value="{{old('current_password')}}">
                            </div>
                             @if ($errors->has('current_password'))
                            <div class="input-group-append  mb-3">
                                <div class="input-group-text">
                                    <span class="text-danger">{{ $errors->first('current_password') }}</span>
                                </div>
                            </div>
                        @endif
                            <div class="form-group">
                                <i for="new_pass">Mật khẩu mới</i>
                                <input type="password" name="new_password" value="{{old('new_password')}}" class="form-control" readonly
                                    onfocus="this.removeAttribute('readonly')" id="new_password"
                                    placeholder="Nhập mật khẩu mới">
                            </div>
                              @if ($errors->has('new_password'))
                            <div class="input-group-append  mb-3">
                                <div class="input-group-text">
                                    <span class="text-danger">{{ $errors->first('new_password') }}</span>
                                </div>
                            </div>
                        @endif
                            <div class="form-group">
                                <i for="new_pass">Xác nhận mật khẩu mới</i>
                                <input type="password" class="form-control" name="new_password_confirmation" readonly
                                    onfocus="this.removeAttribute('readonly')" id="new_password"
                                    placeholder="Nhập lại mật khẩu mới" value="{{old('new_password_confirmation')}}">
                            </div>
                                 @if ($errors->has('new_password_confirmation'))
                            <div class="input-group-append  mb-3">
                                <div class="input-group-text">
                                    <span class="text-danger">{{ $errors->first('new_password_confirmation') }}</span>
                                </div>
                            </div>
                        @endif
                        </div>
                    </div>
                    {{-- <div class="form-group">
                        <label for="exampleInputFile">Avatar</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text">Upload</span>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                    <button type="submit" class="btn btn-default float-right"><a href="/logout">Đăng xuất <i
                                class="fas fa-sign-out-alt"></i></a></button>
                </div>
            </form>
        </div>
    </div>

</x-layouts.main>
