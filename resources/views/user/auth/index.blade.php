<x-layouts.main>
    <div class='col-md-6'>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Thông tin tài khoản: {{ Auth::user()->name }}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form autocomplete="false">
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input class="form-control" readonly id="exampleInputEmail1" value="{{ Auth::user()->email}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Cập nhật mật khẩu</label>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <i for="current_password">Mật khẩu hiện tại</i>
                                    <input type="password" name="password" readonly onfocus="this.removeAttribute('readonly')" class="form-control" id="current_password" placeholder="Nhập mật khẩu hiện tại">
                                </div>
                                <div class="form-group">
                                    <i for="new_pass">Mật khẩu mới</i>
                                    <input type="password" class="form-control" readonly onfocus="this.removeAttribute('readonly')" id="new_password" placeholder="Nhập mật khẩu mới">
                                </div>
                                <div class="form-group">
                                    <i for="new_pass">Xác nhận mật khẩu mới</i>
                                    <input type="password" class="form-control" readonly onfocus="this.removeAttribute('readonly')" id="new_password" placeholder="Nhập lại mật khẩu mới">
                                </div>
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
                    <button type="submit" class="btn btn-default float-right"><a href="/logout">Đăng xuất <i class="fas fa-sign-out-alt"></i></a></button>
                </div>
            </form>
        </div>
    </div>

</x-layouts.main>
