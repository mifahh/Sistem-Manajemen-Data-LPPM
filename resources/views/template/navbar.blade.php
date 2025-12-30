<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            @if (Auth::user() === null)
            <a class="nav-link">Pengguna : User | Waktu : {{ date('Y-m-d H:i:s') }}</a>
            @else
            <a class="nav-link">Pengguna : {{ Auth::user()->name }} | Waktu : {{ date('Y-m-d H:i:s') }}</a>
            @endif
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->

        <!-- Notifications Dropdown Menu -->

        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
                    class="fas fa-th-large"></i></a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
