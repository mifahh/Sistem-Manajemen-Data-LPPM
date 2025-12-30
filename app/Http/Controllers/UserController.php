<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MasterTahun;

class UserController extends Controller
{

    public function menulogin()
    {
        return view('auth.login');
    }
    public function daftarakun()
    {
        return view('auth.register');
    }

    public function post_daftarakun(Request $request)
    {
        $id_login = $request->id;

        $messages = [
            'required' => ':attribute wajib diisi, tidak boleh kosong',
            'min' => ':attribute minimal :min karakter',
            'unique' => ':attribute sudah didaftarkan',
            'same' => ':attribute harus sama',
            'confirmed' => ':attribute tidak sesuai dengan konfirmasi',
        ];

        $this->validate($request, [
            'id' => 'required|numeric|unique:users',
            'name' => 'required|string|min:4',
            'email' => 'required|string|min:4|email:dns|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'no_hp' => 'required|numeric|regex:/^08[0-9]{8,12}$/',
            'role' => 'required|string|max:50',
            'keyword' => 'nullable|string|max:255',
        ], $messages);

        try{
            $user = new \App\Models\User();
            $user->id = $request->id;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->nomor_hp = $request->no_hp;

            if ($request->keyword == 'Admin@LPPM_2025' && $request->role == '1') {
                $user->role = $request->role;
                $user->key = $request->keyword;
            } else {
                $user->role = $request->role;
            }

            $user->save();

            // Kirim email verifikasi
            $user->sendEmailVerificationNotification();

            if ($request->keyword == 'Admin@LPPM_2025' && $request->role == '1') {
                return redirect(route('menulogin'))->with('alert-success', 'Registrasi berhasil! Silakan cek email Anda untuk memverifikasi akun Admin Anda.');
            } else {
                return redirect(route('menulogin'))->with('alert-success', 'Registrasi berhasil! Silakan cek email Anda untuk memverifikasi akun Anda.');
            }
        }catch(\Exception $e){
            return redirect(route('daftarakun'))->with('alert-danger', 'Registrasi gagal: ' . $e->getMessage());
        }
    }

    public function post_login(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib diisi, tidak boleh kosong',
            'min' => ':attribute minimal :min karakter',
        ];

        $this->validate($request, [
            'id' => 'required|min:4',
            'password' => 'required|min:6',
        ], $messages);
        // $cek_data = DB::table('users')->where('id', $request->id)->first();
        if (Auth::attempt(['id' => $request->id, 'password' => $request->password])) {
            $request->session()->regenerate();
            MasterTahun::ensureCurrentYear();
            return redirect()->intended()->with('alert-success', 'Kamu berhasil login');
        } else {
            return redirect()->back()->with('alert-danger', 'Username / Password Anda Salah !');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home')->with('alert-success', 'Kamu berhasil logout');
    }

    /**
     * Tampilkan form lupa password
     */
    public function showForgotPasswordForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Proses kirim link reset password
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email harus valid',
            'email.exists' => 'Email tidak ditemukan dalam sistem'
        ]);

        try {
            $user = \App\Models\User::where('email', $request->email)->first();

            if ($user) {
                // Kirim notifikasi reset password dengan token
                $token = \Illuminate\Support\Facades\Password::createToken($user);
                $user->sendPasswordResetNotification($token);

                return back()->with('alert-success', 'Link reset password telah dikirim ke email Anda. Silakan cek email Anda.');
            }
        } catch (\Exception $e) {
            return back()->with('alert-danger', 'Gagal mengirim link reset password: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan form reset password
     */
    public function showResetPasswordForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    /**
     * Proses reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ], [
            'token.required' => 'Token tidak valid',
            'email.required' => 'Email wajib diisi',
            'email.exists' => 'Email tidak ditemukan',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Password tidak sesuai dengan konfirmasi'
        ]);

        try {
            $user = \App\Models\User::where('email', $request->email)->first();

            if (!$user) {
                return back()->with('alert-danger', 'Email tidak ditemukan');
            }

            // Verifikasi token
            $tokenRecord = DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->first();

            if (!$tokenRecord || !hash_equals($request->token, $tokenRecord->token)) {
                return back()->with('alert-danger', 'Token reset password tidak valid atau telah kadaluarsa');
            }

            // Update password
            $user->password = bcrypt($request->password);
            $user->save();

            // Hapus token
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            return redirect(route('menulogin'))->with('alert-success', 'Password berhasil direset. Silakan login dengan password baru Anda.');
        } catch (\Exception $e) {
            return back()->with('alert-danger', 'Gagal mereset password: ' . $e->getMessage());
        }
    }
}
