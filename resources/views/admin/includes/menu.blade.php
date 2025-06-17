<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
      <a href="@if(auth()->user()->role == 'user') {{ route('site.report.list') }} @else {{ route('admin.report.list') }} @endif" class="app-brand-link">
        <img class="img-fluid logo-dark mb-2" src="{{ !blank(setting('site_logo')) ? \Storage::disk('public')->url(setting('site_logo')) : asset('site/assets/images/logo.png') }}" alt="Logo">
  </a>

  <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
    <i class="bx bx-chevron-left bx-sm align-middle"></i>
  </a>
</div>

<div class="menu-inner-shadow"></div>

<ul class="menu-inner py-1">
  <!-- Dashboard -->
  <li class="menu-header small text-uppercase">
    <span class="menu-header-text">Menu</span>
  </li>

  @if(auth()->user()->role == 'admin')
  <li class="menu-item {{ Request::is('admin/report*') ? 'active open' : '' }}">
    <a href="{{ route('admin.report.list') }}" class="menu-link">
      <i class="menu-icon tf-icons bx bx-home-circle"></i>
      <div data-i18n="Analytics">Reports</div>
    </a>
  </li>
  <li class="menu-item {{ Request::is('admin/customer*') ? 'active open' : '' }}">
    <a href="{{ route('admin.customer.list') }}" class="menu-link">
      <i class="menu-icon tf-icons bx bx-home-circle"></i>
      <div data-i18n="Analytics">Customers</div>
    </a>
  </li>
  @endif

  @if(auth()->user()->role == 'user')
  <li class="menu-item {{ Request::is('report*') ? 'active open' : '' }}">
    <a href="{{ route('site.report.list') }}" class="menu-link">
      <i class="menu-icon tf-icons bx bx-home-circle"></i>
      <div data-i18n="Analytics">Reports</div>
    </a>
  </li>
  <li class="menu-item {{ Request::is('home*') ? 'active open' : '' }}">
    <a href="{{ route('home') }}" class="menu-link">
      <i class="menu-icon tf-icons bx bx-home-circle"></i>
      <div data-i18n="Analytics">New Packing List</div>
    </a>
  </li>
  @endif

  @if(auth()->user()->role == 'admin')
  <li class="menu-header small text-uppercase">
    <span class="menu-header-text">Settings</span>
  </li>
  <li class="menu-item {{ Request::is('admin/setting/account') ? 'active open' : '' }}">
    <a href="{{ route('admin.setting.account') }}" class="menu-link">
      <i class="menu-icon tf-icons bx bx-dock-top"></i>
      <div data-i18n="Account">Account Settings</div>
    </a>
  </li>
  <li class="menu-item {{ Request::is('admin/dc-master/list') ? 'active open' : '' }}">
    <a href="{{ route('admin.dc-master.list') }}" class="menu-link">
      <i class="menu-icon tf-icons bx bx-dock-top"></i>
      <div data-i18n="DC-Master">DC Master Settings</div>
    </a>
  </li>
  <li class="menu-item {{ Request::is('admin/setting/site') ? 'active open' : '' }}">
    <a href="{{ route('admin.setting.site') }}" class="menu-link">
      <i class="menu-icon tf-icons bx bx-dock-top"></i>
      <div data-i18n="Site">Site Settings</div>
    </a>
  </li>
  <li class="menu-item {{ Request::is('admin/setting/password') ? 'active open' : '' }}">
    <a href="{{ route('admin.setting.password') }}" class="menu-link">
      <i class="menu-icon tf-icons bx bx-dock-top"></i>
      <div data-i18n="Password">Password Settings</div>
    </a>
  </li>
  @endif

</ul>
</aside>
<!-- / Menu -->