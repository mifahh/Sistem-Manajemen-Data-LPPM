# Panduan Implementasi Email Verification dan Password Reset

## Daftar Isi
1. [Ikhtisar Fitur](#ikhtisar-fitur)
2. [File-File yang Diubah](#file-file-yang-diubah)
3. [Setup Awal](#setup-awal)
4. [Konfigurasi Email](#konfigurasi-email)
5. [Alur Kerja](#alur-kerja)
6. [Testing](#testing)

---

## Ikhtisar Fitur

Sistem ini menyediakan dua fitur utama untuk keamanan akun pengguna:

### 1. **Email Verification**
- Pengguna baru harus memverifikasi email mereka sebelum dapat mengakses aplikasi
- Link verifikasi dikirim otomatis setelah registrasi
- Link verifikasi berlaku selama 60 menit
- Pengguna dapat meminta ulang link verifikasi

### 2. **Password Reset / Lupa Password**
- Pengguna dapat mereset password jika lupa
- Link reset password dikirim ke email terdaftar
- Link reset password berlaku selama 60 menit
- Pengguna harus memasukkan password baru dan konfirmasi password

---

## File-File yang Diubah

### Models
- ✅ `app/Models/User.php` - Menambahkan interface `MustVerifyEmail` dan method custom notification

### Controllers
- ✅ `app/Http/Controllers/Auth/VerificationController.php` - Menangani verifikasi email
- ✅ `app/Http/Controllers/Auth/ForgotPasswordController.php` - Menampilkan form lupa password
- ✅ `app/Http/Controllers/Auth/ResetPasswordController.php` - Menangani reset password
- ✅ `app/Http/Controllers/UserController.php` - Update registrasi dengan email verification

### Notifications (Baru)
- ✅ `app/Notifications/VerifyEmailNotification.php` - Notifikasi verifikasi email
- ✅ `app/Notifications/ResetPasswordNotification.php` - Notifikasi reset password

### Views
- ✅ `resources/views/auth/verify.blade.php` - Halaman verifikasi email (ditingkatkan)
- ✅ `resources/views/auth/passwords/email.blade.php` - Form lupa password (ditingkatkan)
- ✅ `resources/views/auth/passwords/reset.blade.php` - Form reset password (ditingkatkan)
- ✅ `resources/views/auth/login.blade.php` - Tambah link "Lupa Password"

### Routes
- ✅ `routes/web.php` - Tambah routes untuk email verification dan password reset

### Database
- ✅ `database/migrations/2025_11_24_000000_add_email_verification_to_users.php` - Migration untuk email_verified_at

---

## Setup Awal

### 1. Jalankan Database Migration

```bash
php artisan migrate
```

Atau jika Anda hanya ingin menjalankan migration tertentu:

```bash
php artisan migrate --path=database/migrations/2025_11_24_000000_add_email_verification_to_users.php
```

### 2. Perbarui User Model (Sudah Dilakukan)

Model User sudah diupdate dengan:
- Interface `MustVerifyEmail`
- Method `sendEmailVerificationNotification()`
- Method `sendPasswordResetNotification($token)`

### 3. Konfigurasi Environment Variables

Update file `.env` Anda dengan pengaturan email yang sesuai.

---

## Konfigurasi Email

### Konfigurasi SMTP (Recommended)

**File: `.env`**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com (atau host email provider lainnya)
MAIL_PORT=587 (atau 465 untuk SSL)
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls (atau ssl)
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Nama Aplikasi Anda"
```

### Menggunakan Gmail (SMTP)

1. **Enable 2-Step Verification** di Google Account Anda
2. **Buat App Password**: 
   - Buka [myaccount.google.com/security](https://myaccount.google.com/security)
   - Pilih "App passwords"
   - Pilih "Mail" dan "Windows Computer" (atau device Anda)
   - Salin password yang diberikan
3. **Update `.env`**:
   ```
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your-email@gmail.com
   MAIL_PASSWORD=xxxx xxxx xxxx xxxx (App Password - tanpa spasi)
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=your-email@gmail.com
   MAIL_FROM_NAME="Manajemen Data LPPM"
   ```

### Menggunakan Mailtrap (untuk Testing)

1. Daftar di [mailtrap.io](https://mailtrap.io)
2. Copy SMTP credentials dari Mailtrap
3. Update `.env`:
   ```
   MAIL_MAILER=smtp
   MAIL_HOST=live.smtp.mailtrap.io
   MAIL_PORT=587
   MAIL_USERNAME=your-username
   MAIL_PASSWORD=your-password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=hello@example.com
   MAIL_FROM_NAME="Manajemen Data LPPM"
   ```

### Testing Mode (Development)

Untuk testing tanpa benar-benar mengirim email:

```env
MAIL_MAILER=log
```

Email akan tersimpan di `storage/logs/laravel.log`

---

## Alur Kerja

### 1. REGISTRASI DENGAN EMAIL VERIFICATION

**Flow:**
1. User mengklik "Registrasi"
2. User mengisi form registrasi
3. Data tersimpan di database
4. Email verifikasi dikirim otomatis
5. User diarahkan ke halaman login dengan pesan sukses
6. User cek email dan klik link verifikasi
7. Email terverifikasi, user bisa login

**File yang Terlibat:**
- `routes/web.php` → Route `post_daftarakun`
- `UserController.php` → `post_daftarakun()` method
- `User.php` → `sendEmailVerificationNotification()` method
- `VerifyEmailNotification.php` → Email template
- Database → Email tersimpan di `password_reset_tokens`

### 2. MEMVERIFIKASI EMAIL

**Flow:**
1. User klik link di email verifikasi
2. Link berisi `{id}` dan `{hash}` yang sudah signed
3. Sistem verifikasi mengecek signature dan hash
4. Jika valid, `email_verified_at` diisi dengan timestamp
5. User diarahkan ke dashboard dengan pesan sukses

**File yang Terlibat:**
- `routes/web.php` → Route `verification.verify` (signed)
- `VerificationController.php` → `verify()` method
- Database → Update `users.email_verified_at`

### 3. MEMINTA ULANG EMAIL VERIFIKASI

**Flow:**
1. User di halaman verify klik "Kirim Ulang Link Verifikasi"
2. Email verifikasi baru dikirim ke email user
3. User kembali ke halaman verify

**File yang Terlibat:**
- `routes/web.php` → Route `verification.resend`
- `VerificationController.php` → `resend()` method
- `VerifyEmailNotification.php` → Email template

### 4. LUPA PASSWORD

**Flow:**
1. User klik "Lupa Password" di halaman login
2. User masuk ke form "Forgot Password"
3. User input email terdaftar
4. Sistem kirim email dengan link reset password
5. User cek email dan klik link reset password

**File yang Terlibat:**
- `routes/web.php` → Route `password.request`
- `ForgotPasswordController.php` → `showLinkRequestForm()`, `sendResetLinkEmail()`
- Email tersimpan di `password_reset_tokens` table
- `ResetPasswordNotification.php` → Email template

### 5. RESET PASSWORD

**Flow:**
1. User klik link di email reset password
2. User dibawa ke halaman "Reset Password"
3. User input password baru dan konfirmasi
4. Sistem validasi token dan kirim ulang password
5. Password berhasil direset, `password_reset_tokens` entry dihapus
6. User diarahkan ke login dengan pesan sukses

**File yang Terlibat:**
- `routes/web.php` → Route `password.reset`, `password.update`
- `ResetPasswordController.php` → `showResetForm()`, `reset()`
- Database → Verify dari `password_reset_tokens`, delete setelah sukses

---

## Testing

### Test dengan Mailtrap atau Gmail SMTP

#### 1. Registrasi Baru
```
1. Buka http://localhost:8000/register-page
2. Isi form registrasi
3. Submit
4. Cek email (di Mailtrap inbox atau Gmail)
5. Klik link verifikasi
6. Akan redirect ke dashboard jika belum login (dengan pesan sukses)
```

#### 2. Login tanpa Verifikasi Email
```
1. Buka http://localhost:8000/login-page
2. Input username dan password
3. Akan redirect ke /email/verify (halaman verifikasi)
4. Tidak bisa akses halaman lain sampai email diverifikasi
```

#### 3. Lupa Password
```
1. Buka http://localhost:8000/password/reset
2. Input email
3. Klik "Kirim Link Reset Password"
4. Cek email, klik link reset
5. Input password baru
6. Submit
7. Redirect ke login dengan pesan sukses
```

### Test dengan Log Driver

Jika menggunakan `MAIL_MAILER=log`:

```bash
# Lihat file log
tail -f storage/logs/laravel.log

# Atau buka file di text editor
storage/logs/laravel.log
```

Email akan ditampilkan sebagai text dalam format:
```
From: sender@example.com
To: recipient@example.com
Subject: ...
Body: ...
```

---

## Troubleshooting

### 1. Email Tidak Terkirim
- **Cek konfigurasi `.env`**: Pastikan MAIL_MAILER, MAIL_HOST, PORT, USERNAME, PASSWORD benar
- **Test koneksi**: `php artisan tinker` → `Mail::raw('test', fn($m) => $m->to('test@example.com'));`
- **Lihat log**: `tail -f storage/logs/laravel.log`

### 2. Link Verifikasi Expired
- Link hanya berlaku 60 menit
- User bisa klik "Kirim Ulang Link Verifikasi"
- Atau ganti waktu di `VerifyEmailNotification.php` line 66

### 3. Token Reset Password Invalid
- Token hanya berlaku 60 menit
- Token disimpan di `password_reset_tokens` table
- Check database: `SELECT * FROM password_reset_tokens;`

### 4. User Tidak Bisa Login
- Pastikan email sudah diverifikasi (`email_verified_at` tidak NULL)
- Check database: `SELECT * FROM users WHERE email='...'`
- Verifikasi manual di database jika perlu

### 5. Terjadi Error "Class not found"
- Pastikan semua file telah dibuat di lokasi yang benar
- Run: `composer dump-autoload`
- Run migration: `php artisan migrate`

---

## Customization

### 1. Mengubah Waktu Ekspirasi Link

**Email Verification** - File: `app/Notifications/VerifyEmailNotification.php`
```php
Carbon::now()->addMinutes(60), // Ubah 60 menjadi menit yang diinginkan
```

**Password Reset** - Di migration atau konfigurasi auth:
```php
'expire' => 60, // Dalam config/auth.php
```

### 2. Mengubah Redirect URL

**Setelah Verifikasi** - File: `app/Http/Controllers/Auth/VerificationController.php`
```php
protected $redirectTo = '/dashboard'; // Ubah ke URL yang diinginkan
```

**Setelah Reset Password** - File: `app/Http/Controllers/Auth/ResetPasswordController.php`
```php
protected $redirectTo = '/dashboard'; // Ubah ke URL yang diinginkan
```

### 3. Mengubah Template Email

**Email Verifikasi** - File: `app/Notifications/VerifyEmailNotification.php`
- Ubah subject, greeting, line, action text

**Email Reset Password** - File: `app/Notifications/ResetPasswordNotification.php`
- Ubah subject, greeting, line, action text

---

## Keamanan

1. **Link Signed**: Verifikasi email menggunakan Laravel Signed URLs untuk keamanan
2. **Token Hashing**: Password reset token di-hash sebelum disimpan
3. **Rate Limiting**: Verifikasi dan resend dibatasi 6 kali per menit (configurable)
4. **Expiring Links**: Semua link memiliki waktu kadaluarsa (60 menit)

---

## Database Schema

### users table (Updated)
```sql
ALTER TABLE users ADD COLUMN email_verified_at TIMESTAMP NULL;
```

### password_reset_tokens table (New)
```sql
CREATE TABLE password_reset_tokens (
    email VARCHAR(255) PRIMARY KEY,
    token TEXT,
    created_at TIMESTAMP NULL
);
```

---

## Next Steps

1. ✅ Update `.env` dengan konfigurasi email
2. ✅ Jalankan migration: `php artisan migrate`
3. ✅ Test registrasi dan email verifikasi
4. ✅ Test forgot password dan reset password
5. ✅ Customize sesuai kebutuhan

---

## Support

Untuk pertanyaan atau masalah, silakan:
1. Check troubleshooting section
2. Lihat Laravel documentation: https://laravel.com/docs/11.x/verification
3. Cek file log: `storage/logs/laravel.log`

---

**Created**: 2025-11-24
**Last Updated**: 2025-11-24
