@extends('layouts.blank')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">
                    <div class="card-header" style="background-image: url(/assets/img/logo-TUS.png); padding:0;">
                        <h1 style="color: white;">
                            Registrasi
                        </h1>
                    </div>

                    <div class="card-body">
                        <!-- menampilkan error validasi -->
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('post_daftarakun') }}">
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
                                <label for="id" class="col-md-4 col-form-label text-md-end">{{ __('ID Login Number') }}</label>

                                <div class="col-md-6">
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
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nama Lengkap') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('nama') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" required autocomplete="name"
                                        placeholder="Enter Name">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Alamat Email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email"
                                        placeholder="Enter Email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password" placeholder="Enter Password">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fas fa-eye" id="togglePasswordIcon"></i>
                                        </button>
                                    </div>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Konfirmasi Password') }}</label>

                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="new-password"
                                            placeholder="Enter Confirm Password">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                            <i class="fas fa-eye" id="togglePasswordConfirmIcon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="no_hp"
                                    class="col-md-4 col-form-label text-md-end">{{ __('No. HP') }}</label>

                                <div class="col-md-6">
                                    <input id="no_hp" type="tel"
                                        class="form-control @error('number') is-invalid @enderror" name="no_hp"
                                        required autocomplete="tel" pattern="[0-9]+" value="{{ old('no_hp') }}" placeholder="Enter No. HP : 0852303603xx">

                                    @error('no_hp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="mb-3 row">
                                <label class="col-md-4 col-form-label text-md-end">
                                    {{ __('Pilih Role') }}
                                </label>
                                <div class="col-md-6 d-flex align-items-center gap-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role" id="role_non_admin" value="2" required>
                                        <label class="form-check-label" for="role_non_admin">Non-Admin</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role" id="role_admin" value="1" required>
                                        <label class="form-check-label" for="role_admin">Admin</label>
                                    </div>
                                </div>
                            </div> --}}

{{--
                            <div class="row mb-3">
                                <label for="keyword"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Keyword Admin') }}</label>

                                <div class="col-md-6">
                                    <input id="keyword" type="text"
                                        class="form-control @error('keyword') is-invalid @enderror" name="keyword"
                                        value="{{ old('keyword') }}" placeholder="Enter keyword">

                                    @error('keyword')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <h7 style="color: red"> * Keyword Hanya Diperoleh Oleh Admin LPPM ITTS </h7>
                                </div>
                            </div> --}}


                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-3">
                                    <button type="submit" class="btn w-100" style="background-color: green; color: white;">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>

                            @if (Route::has('login'))
                                <div class="row">
                                    <div class="col-md-6 offset-md-3 text-center">
                                        <p class="mt-3 mb-0">Sudah Punya Akun?</p>
                                        <a class="link-underline-primary link-underline-opacity-0 link-underline-opacity-75-hover"
                                            href="{{ route('menulogin') }}">{{ __('Login Disini!') }}</a>
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
document.addEventListener('DOMContentLoaded', function () {
    // const keywordInput = document.getElementById('keyword');
    // const roleRadios = document.querySelectorAll('input[name="role"]');

    // function toggleKeyword() {
    //     const selectedRole = document.querySelector('input[name="role"]:checked');
    //     if (selectedRole && selectedRole.id === 'role_non_admin') {
    //         keywordInput.disabled = true;
    //         keywordInput.value = ''; // optional: clear input
    //     } else {
    //         keywordInput.disabled = false;
    //     }
    // }

    // roleRadios.forEach(radio => {
    //     radio.addEventListener('change', toggleKeyword);
    // });

    // // Initial check on page load
    // toggleKeyword();

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
