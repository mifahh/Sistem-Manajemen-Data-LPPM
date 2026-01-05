@extends('layouts.blank')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-image: url(/assets/img/logo-TUS.png); padding:0;">
                    <h1 style="color: white; margin: 0;">Reset Password</h1>
                </div>

                <div class="card-body">
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
                        <i class="fas fa-key" style="font-size: 48px; color: grey;"></i>
                    </div>

                    <p class="text-center mb-4">Masukkan password baru Anda</p>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email Address</label>

                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus
                                   placeholder="Masukkan email Anda">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Password Baru</label>

                            <div class="input-group">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                       name="password" required autocomplete="new-password"
                                       placeholder="Masukkan password baru (minimal 6 karakter)">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye" id="togglePasswordIcon"></i>
                                </button>
                            </div>

                            @error('password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password-confirm" class="form-label">Konfirmasi Password</label>

                            <div class="input-group">
                                <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                       name="password_confirmation" required autocomplete="new-password"
                                       placeholder="Ulangi password baru Anda">
                                <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                    <i class="fas fa-eye" id="togglePasswordConfirmIcon"></i>
                                </button>
                            </div>

                            @error('password_confirmation')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row mb-0">
                            <div class="col-12">
                                <button type="submit" class="btn w-100" style="background-color: green; color: white;"
                                    onmouseover="this.style.backgroundColor='darkgreen';"
                                    onmouseout="this.style.backgroundColor='green';">
                                    <i class="fas fa-check"></i> Reset Password
                                </button>
                            </div>
                        </div>
                    </form>

                    <hr>

                    <div class="text-center">
                        <p class="mb-2">Kembali ke login? <a href="{{ route('menulogin') }}">Klik di sini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Toggle Password Visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePasswordIcon');

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

    // Toggle Password Confirmation Visibility
    document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
        const passwordConfirmInput = document.getElementById('password-confirm');
        const toggleConfirmIcon = document.getElementById('togglePasswordConfirmIcon');

        if (passwordConfirmInput.type === 'password') {
            passwordConfirmInput.type = 'text';
            toggleConfirmIcon.classList.remove('fa-eye');
            toggleConfirmIcon.classList.add('fa-eye-slash');
        } else {
            passwordConfirmInput.type = 'password';
            toggleConfirmIcon.classList.remove('fa-eye-slash');
            toggleConfirmIcon.classList.add('fa-eye');
        }
    });
});
</script>
@endsection
