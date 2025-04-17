<header class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="top-header-blk">
                    <nav class="navbar">
                        <a class="navbar-brand" href="{{ route('site.report.list') }}">
                            <img src="{{ !blank(setting('site_logo')) ? \Storage::url(setting('site_logo')) : asset('site/assets/images/logo.png') }}" class="img-fluid" alt="" />
                        </a>
                    </nav>
                <div class="right-corner-blk">
                    <ul class="list-unstyled list-inline">
                        <li class="list-inline-item"><i class="far fa-calendar-alt"></i>{{ \Carbon\Carbon::now()->format('d-m-Y') }}</li>
                        <li class="list-inline-item" id="current-time"></li>
                    </ul>
                    <ul class="nav user-menu">
                        <li class="nav-item dropdown has-arrow main-drop">
                            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                <span class="user-img">
                                    <img src="{{ auth()->user()->profile_url }}" alt="User">
                                    <span class="status online"></span>
                                </span>
                                <span>{{ auth()->user()->name }}</span>
                            </a>
                            <div class="dropdown-menu">
                                <!-- <a class="dropdown-item" href="#"><i data-feather="settings" class="mr-1"></i>Settings</a> -->
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i data-feather="log-out" class="mr-1"></i> Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>