<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Home - LPPM TUS</title>

    <!-- Favicon-->
    <link rel="icon" type="image/png" href="assets/img/logo.png" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <link href="/css/styles2.css" rel="stylesheet">
    <!-- Scripts -->
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script></head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark shadow-sm fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="/"><img src="assets/img/logo-TUS.png" alt="..." style="height: 60px"/></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                    aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                        <li class="nav-item">
                            {{-- <a class="nav-link" href="#tentang">Tentang LPPM</a> --}}
                            <div class="dropdown">
                                <button class="nav-link btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Tentang LPPM
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#tentang">Profil</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin_fullcalender') }}">Kalender PPM</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#contact">Contact Us</a></li>
                                    <li ><a class="dropdown-item" href="#team">Struktur</a></li>

                                </ul>
                            </div>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#pengumuman">Pengumuman</a></li>
                        <li class="nav-item">
                            {{-- <a class="nav-link" href="#penelitian">Penelitian</a> --}}
                            <div class="dropdown">
                                <button class="nav-link btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Penelitian
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#penelitian">Program Penelitian</a></li>
                                    <li><a class="dropdown-item" href="{{ route('data_penelitian_table') }}">Data Penelitian</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            {{-- <a class="nav-link" href="#abdimas">Abdimas</a> --}}
                            <div class="dropdown">
                                <button class="nav-link btn  dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    ABDIMAS
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#abdimas">Program Abdimas</a></li>
                                    <li><a class="dropdown-item" href="{{ route('data_abdimas_table') }}">Data Abdimas</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <div class="dropdown">
                                <button class="nav-link btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Publikasi
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('program_publikasi') }}">Program
                                            Publikasi</a></li>
                                    <li><a class="dropdown-item" href="{{ route('data_publikasi_table') }}">Data
                                            Publikasi</a></li>
                                    <li><a class="dropdown-item" href="{{ route('data_ki_table') }}">Data
                                            Kekayaan Intelektual</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <div class="dropdown">
                                <button class="nav-link btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Start-up
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="">Program
                                            Start-up</a></li>
                                    <li><a class="dropdown-item" href="">Data
                                            Start-up</a></li>
                                </ul>
                            </div>
                        </li>

                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-primary btn-lg" href="{{ route('menulogin') }}">Login</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        Dashboard
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
<script>

    //eror
    // $(function () {
    //     // Show toastr messages
    //     @if(session('success'))
    //         toastr.success('{{ session('success') }}');
    //     @endif

    //     @if($errors->any())
    //         @foreach($errors->all() as $error)
    //             toastr.error('{{ $error }}');
    //         @endforeach
    //     @endif

    //     @if(session('error'))
    //         toastr.error('{{ session('error') }}');
    //     @endif
    // })
</script>
</html>
