@extends('layouts.blank')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-image: url(/assets/img/logo-TUS.png); padding:0;">
                    <h1 style="color: white; margin: 0;">Verifikasi Email</h1>
                </div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Link verifikasi baru telah dikirim ke email Anda.
                        </div>
                    @endif

                    @if (session('alert-success'))
                        <div class="alert alert-success">
                            {{ session('alert-success') }}
                        </div>
                    @endif

                    @if (session('alert-info'))
                        <div class="alert alert-info">
                            {{ session('alert-info') }}
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        <i class="fas fa-envelope" style="font-size: 48px; color: grey;"></i>
                    </div>

                    <h5 class="text-center mb-3">Silakan Verifikasi Email Anda</h5>

                    <p>Halo, <strong>{{ Auth::user()->name }}</strong>!</p>

                    <p>Kami telah mengirimkan link verifikasi ke email: <strong>{{ Auth::user()->email }}</strong></p>

                    <p>Silakan cek email Anda dan klik link verifikasi untuk mengaktifkan akun Anda.</p>

                    <p class="text-muted">Jika Anda tidak menerima email verifikasi, silakan klik tombol di bawah:</p>

                    <div class="text-center">
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn" style="background-color: green; color: white;"
                                    onmouseover="this.style.backgroundColor='darkgreen';"
                                    onmouseout="this.style.backgroundColor='green';">
                                <i class="fas fa-redo"></i> Kirim Ulang Link Verifikasi
                            </button>
                        </form>
                    </div>

                    <hr>

                    <p class="text-muted small">Link verifikasi akan berlaku selama 60 menit. Jika Anda mengalami kesulitan, hubungi administrator.</p>

                    <div class="text-center mt-3">
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-sm">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
