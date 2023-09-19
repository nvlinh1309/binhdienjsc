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

          <li class="nav-item {{ request()->is('order*') || request()->is('stock-in*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('order*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Đơn hàng
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('order-seller.index') }}" class="nav-link {{ request()->is('order-seller*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Đơn bán (Xuất kho)</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('order-buyer.index') }}" class="nav-link {{ request()->is('order-buyer*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Đơn mua (Nhập kho)</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- <li class="nav-item {{ request()->is('packaging*') || request()->is('packaging*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('packaging*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Bao bì
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('packaging.index') }}" class="nav-link {{ request()->is('input*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Nhập kho</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('packaging.index') }}" class="nav-link {{ request()->is('output*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Xuất kho</p>
                </a>
              </li>
            </ul>
          </li> --}}


          <li class="nav-item">
            <a href="{{ route('packaging.index') }}" class="nav-link {{ request()->is('packaging*') || request()->is('warehouse-receipt*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-solid fa-dolly"></i>
              {{-- <i class=""></i> --}}
              <p>
                Bao bì
              </p>
            </a>
          </li>

          @canany(['product-view', 'product-create', 'product-edit', 'product-delete'])
          <li class="nav-item">
            <a href="{{ route('product.index') }}" class="nav-link {{ request()->is('product*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-archive"></i>
              <p>
                Sản phẩm
              </p>
            </a>
          </li>
          @endcanany
          @canany(['supplier-view', 'supplier-create', 'supplier-edit', 'supplier-delete'])
          <li class="nav-item">
            <a href="{{ route('supplier.index') }}" class="nav-link {{ request()->is('supplier*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-briefcase"></i>
              <p>
                Nhà cung cấp
              </p>
            </a>
          </li>
          @endcanany
          @canany(['brand-view', 'brand-create', 'brand-edit', 'brand-delete'])
          <li class="nav-item">
            <a href="{{ route('brand.index') }}" class="nav-link {{ request()->is('brand*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-bookmark"></i>
              <p>
                Thương hiệu
              </p>
            </a>
          </li>
          @endcanany
          @canany(['customer-view', 'customer-create', 'customer-edit', 'customer-delete'])
          <li class="nav-item">
            <a href="{{ route('customer.index') }}" class="nav-link {{ request()->is('customer*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-handshake"></i>
              <p>
                Khách hàng
              </p>
            </a>
          </li>
          @endcanany
          @canany(['warehouse-view', 'warehouse-create', 'warehouse-edit', 'warehouse-delete'])
          <li class="nav-item">
            <a href="{{ route('store.index') }}" class="nav-link {{ request()->is('store*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-warehouse"></i>
              <p>
                Kho
              </p>
            </a>
          </li>
          @endcanany
          @canany(['user-view', 'user-create', 'user-edit', 'user-delete', 'role-view', 'role-create', 'role-edit', 'role-delete'])
          <li class="nav-item {{ request()->is('user*') || request()->is('role-and-permission*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('user*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>
                Quản trị
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @canany(['user-view', 'user-create', 'user-edit', 'user-delete'])
              <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('user*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Người dùng</p>
                </a>
              </li>
              @endcanany
              @canany(['role-view', 'role-create', 'role-edit', 'role-delete'])
              <li class="nav-item">
                <a href="{{ route('users.indexRaP') }}" class="nav-link {{ request()->is('role-and-permission*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Vai trò và quyền</p>
                </a>
              </li>
              @endcanany
            </ul>
          </li>
          @endcanany
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
