@extends('layouts.blank')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center">
                <div class="card-header" style="background-image: url(/assets/img/logo-TUS.png); padding:0;">
                    <h1 style="color: white; margin: 0;">Lupa Password</h1>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('alert-success'))
                        <div class="alert alert-success">
                            {{ session('alert-success') }}
                        </div>
                    @endif

                    @if (session('alert-danger'))
                        <div class="alert alert-danger">
                            {{ session('alert-danger') }}
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        <i class="fas fa-lock" style="font-size: 48px; color: grey;"></i>
                    </div>

                    <p class="text-center mb-4">Masukkan email Anda untuk menerima link reset password</p>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email Address</label>

                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                   placeholder="Masukkan email Anda">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row mb-0">
                            <div class="col-12">
                                <button type="submit" class="btn w-100" style="background-color: green; color: white;"
                                    onmouseover="this.style.backgroundColor='darkgreen';"
                                    onmouseout="this.style.backgroundColor='green';">
                                    <i class="fas fa-envelope"></i> Kirim Link Reset Password
                                </button>
                            </div>
                        </div>
                    </form>

                    <hr>

                    <div class="text-center">
                        <p class="mb-2">Sudah Punya Akun? <a href="{{ route('menulogin') }}" class="link-underline-primary link-underline-opacity-0 link-underline-opacity-75-hover">Login disini!</a></p>
                        <p class="mb-2">Belum punya akun? <a href="{{ route('daftarakun') }}" class="link-underline-primary link-underline-opacity-0 link-underline-opacity-75-hover">Registrasi disini!</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
