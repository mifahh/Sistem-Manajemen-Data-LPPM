<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
        {{-- /assets/images/logo.png --}}
        <img src="{{ asset('assets/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light text-decoration-none">LPPM TUS </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        {{-- <div class="m-4">
            <div class="image" style="padding-top: 8px;">
                <img src="{{ asset('lte/dist/img/avatar04.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
        </div> --}}


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item has-treeview">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-th-large"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                </br>
                @if (Auth::user() === null)
                @else
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">

                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                Data User
                                <i class="fas fa-angle-left right"></i>
                            </p>

                        </a>

                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('profil') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Users</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endif
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">

                        <i class="nav-icon fas fa-exclamation-circle"></i>
                        <p>
                            TENTANG LPPM
                            <i class="fas fa-angle-left right"></i>
                        </p>

                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('tanggal') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kalender PPM</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">

                        <i class="nav-icon fas fa-landmark"></i>
                        <p>
                            PENELITIAN
                            <i class="fas fa-angle-left right"></i>
                        </p>

                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('plt_profil_penelitian') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Program Penelitian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('data_penelitian_table') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Penelitian</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">

                        <i class="nav-icon fas fa-people-carry"></i>
                        <p>
                            ABDIMAS
                            <i class="fas fa-angle-left right"></i>
                        </p>

                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('abdimas_program_abdimas') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Program ABDIMAS</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('data_abdimas_table') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Abdimas</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">

                        <i class="nav-icon fas fa-globe"></i>
                        <p>
                            PUBLIKASI
                            <i class="fas fa-angle-left right"></i>
                        </p>

                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('program_publikasi') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Program Publikasi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('data_publikasi_table') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Publikasi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('data_ki_table') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kekayaan Intelektual</p>
                            </a>
                        </li>
                    </ul>
                </li>

                @if (Auth::check() && Auth::user()->aktor_id == '1')
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">

                            <i class="nav-icon fas fa-folder-open"></i>
                            <p>
                                DATA
                                <i class="fas fa-angle-left right"></i>
                            </p>

                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('data_dosen_table') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data Dosen</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('data_mahasiswa_table') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data Mahasiswa</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif



                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
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
