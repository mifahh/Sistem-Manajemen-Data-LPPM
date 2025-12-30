@extends('layouts.blank')

@section('content')
    <div class="container position-absolute top-50 start-50 translate-middle">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">
                    <div class="card-header" style="background-image: url(/assets/img/logo-TUS.png); padding:0;">
                        <h1 style="color: white;">
                            Login
                        </h1>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('post_login') }}">
                            @csrf
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            @if(Session::has('alert-danger'))
                                    <div class="alert alert-danger">
                                        <div>{{Session::get('alert-danger')}}</div>
                                    </div>
                            @endif
                            <div class="row mb-3">
                                <div class="col-md-8 offset-md-2">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-8 offset-md-2">
                                    <label for="id" class="form-label">{{ __('ID Login Number') }}</label>

                                    <input id="id" type="number" class="form-control @error('id') is-invalid @enderror"
                                        name="id" value="{{ old('id') }}" required autofocus
                                        placeholder="Enter ID Login Number Using NIP : 259400xx">

                                    @error('id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-8 offset-md-2">
                                    <label for="password" class="form-label">{{ __('Password') }}</label>
                                    <div class="input-group">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password"
                                            placeholder="Enter Password">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fab fa-eye" id="toggleIcon"></i>
                                        </button>
                                    </div>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            {{-- <div class="row mb-3">
                                <div class="col-md-8 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{
                                            old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="row mb-3">
                                <div class="col-md-8 offset-md-2 text-center">
                                    <button type="submit" class="btn w-100" style="background-color: green; color: white;"
                                    onmouseover="this.style.backgroundColor='darkgreen';"
                                    onmouseout="this.style.backgroundColor='green';">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-8 offset-md-2 text-center">
                                    <a href="{{ route('password.request') }}" class="link-underline-primary link-underline-opacity-0 link-underline-opacity-75-hover">
                                        Lupa Password?
                                    </a>
                                </div>
                            </div>

                            @if (Route::has('register'))
                                <div class="row mb-3">
                                    <div class="col-md-8 offset-md-2 text-center">
                                        <p class="mt-2 mb-0">Ingin Membuat Akun Baru?</p>
                                        <a class="link-underline-primary link-underline-opacity-0 link-underline-opacity-75-hover"
                                            href="{{ route('daftarakun') }}">{{ __('Registrasi disini!') }}</a>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle Password Visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        });
    </script>
@endsection
