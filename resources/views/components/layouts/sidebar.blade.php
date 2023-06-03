<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{ asset('images/logo.png') }}" alt="Binh Dien JSC" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">BD JSC</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('images/avatar-default.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{ route('user.index') }}" class="d-block">{{ Auth::user()->name }}</a>
          {{-- <a class="d-block" href="">Cập nhật</a> --}}
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Thống kê
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('order.index') }}" class="nav-link {{ request()->is('order*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Đơn hàng
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('product.index') }}" class="nav-link {{ request()->is('product*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-archive"></i>
              <p>
                Sản phẩm
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('supplier.index') }}" class="nav-link {{ request()->is('supplier*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-briefcase"></i>
              <p>
                Nhà cung cấp
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('customer.index') }}" class="nav-link">
              <i class="nav-icon fas fa-handshake {{ request()->is('customer*') ? 'active' : '' }}"></i>
              <p>
                Khách hàng
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('storage.index') }}" class="nav-link">
              <i class="nav-icon fa fa-warehouse {{ request()->is('storage*') ? 'active' : '' }}"></i>
              <p>
                Kho
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link">
              <i class="nav-icon fa fa-users {{ request()->is('user*') ? 'active' : '' }}"></i>
              <p>
                Người dùng
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
