<aside class="main-sidebar sidebar-dark-primary elevation-4">

<div style="display: flex; justify-content: center">
    <a href="index3.html">
        <img src="{{ asset('storage/img/bali-tv.png') }}" alt="AdminLTE Logo" class="brand-image"
        style="opacity: .8; justify-content: center; width: 75px; height: 75px;">
        {{-- <span class="brand-text font-weight-light">Bali Tv</span> --}}
    </a>
</div>

    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                {{-- <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> --}}
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>

        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                {{-- <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Starter Pages
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Active Page</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Inactive Page</p>
                            </a>
                        </li>
                    </ul>
                </li> --}}
                <li class="nav-item">
                    <a href="/" class="nav-link">
                        <i class="fas fa-home"></i>
                        <p>
                            Home
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/user" class="nav-link">
                        <i class="fas fa-user"></i>
                        <p>
                            Users
                        </p>
                    </a>
                </li>
            </ul>
        </nav>

    </div>

</aside>
{{-- Right Aside --}}
<aside class="control-sidebar control-sidebar-dark">

    <div class="p-3">
        <h5></h5>
        <p>User</p>
        <button type="button" class="btn btn-block btn-danger">Logout</button>
    </div>
</aside>