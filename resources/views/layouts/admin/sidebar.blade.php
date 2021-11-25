 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('vendor/admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">SIJELAPP <i class="badge badge-danger ml-3">new</i></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('vendor/admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Admin</a>
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
            <a href="{{ route('dashboard') }}" class="nav-link @if(Request::is('admin')) active @endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item @if(Request::is('admin/master/*')) menu-open @endif">
            <a href="#" class="nav-link @if(Request::is('admin/master/*')) active @endif">
              <i class="nav-icon fas fa-server"></i>
              <p>
                Master Data
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('pemiliksampel.index') }}" class="nav-link @if(Request::is('admin/master/pemiliksampel')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pemilik Sampel</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('kategori.index') }}" class="nav-link @if(Request::is('admin/master/kategori')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kategori</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('metodeuji.index') }}" class="nav-link @if(Request::is('admin/master/metodeuji')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Metode Uji</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('parameteruji.index') }}" class="nav-link @if(Request::is('admin/master/parameteruji')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Parameter Uji</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ route('terimasampel.index') }}" class="nav-link @if(Request::is('admin/terimasampel')) active @endif">
              <i class="nav-icon fab fa-500px"></i>
              <p>
                Terima Sampel
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('statussampel.index') }}" class="nav-link @if(Request::is('admin/statussampel')) active @endif">
              <i class="nav-icon fas fa-thermometer-half"></i>
              <p>
                Status Sampel
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('statussampel.index') }}" class="nav-link @if(Request::is('admin/sampelsudahdiambil')) active @endif">
              <i class="nav-icon fas fa-check-double"></i>
              <p>
                Sampel Selesai
              </p>
            </a>
          </li>
          <li class="nav-item @if(Request::is('admin/master/*')) menu-open @endif">
            <a href="#" class="nav-link @if(Request::is('admin/master/*')) active @endif">
              <i class="nav-icon fas fa-clipboard-list"></i>
              <p>
                Laporan
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('pemiliksampel.index') }}" class="nav-link @if(Request::is('admin/master/pemiliksampel')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pemilik Sampel</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('kategori.index') }}" class="nav-link @if(Request::is('admin/master/kategori')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kategori</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('metodeuji.index') }}" class="nav-link @if(Request::is('admin/master/metodeuji')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Metode Uji</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('parameteruji.index') }}" class="nav-link @if(Request::is('admin/master/parameteruji')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Parameter Uji</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ route('statussampel.index') }}" class="nav-link @if(Request::is('admin/sampelsudahdiambil')) active @endif">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Pengaturan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('statussampel.index') }}" class="nav-link @if(Request::is('admin/sampelsudahdiambil')) active @endif">
              <i class="nav-icon fas fa-door-open"></i>
              <p>
                Keluar
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>