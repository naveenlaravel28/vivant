<ul class="nav nav-pills flex-column flex-md-row mb-3">
  <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/setting/account') ? 'active' : '' }}" href="{{ route('admin.setting.account') }}"><i class="bx bx-user me-1"></i> Account</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/setting/dc-master') ? 'active' : '' }}" href="{{ route('admin.setting.dc-master') }}"
      ><i class="bx bx-bell me-1"></i> DC Master</a
    >
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/setting/site') ? 'active' : '' }}" href="{{ route('admin.setting.site') }}"><i class="bx bx-user me-1"></i> Site</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('admin/setting/password') ? 'active' : '' }}" href="{{ route('admin.setting.password') }}"
      ><i class="bx bx-bell me-1"></i> Password</a
    >
  </li>
</ul>