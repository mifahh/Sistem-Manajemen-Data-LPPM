# EMAIL VERIFICATION & PASSWORD RESET IMPLEMENTATION

## 📋 Ringkasan Implementasi

Sistem Email Verification dan Password Reset telah berhasil diimplementasikan ke aplikasi Manajemen Data LPPM. Sistem ini terdiri dari:

1. **Email Verification** - Pengguna baru harus memverifikasi email mereka setelah registrasi
2. **Password Reset** - Pengguna dapat mereset password mereka melalui email

---

## 📂 File-File yang Dibuat/Diubah

### File Baru ✨
```
app/
├── Notifications/
│   ├── VerifyEmailNotification.php        [BARU] Email verifikasi
│   └── ResetPasswordNotification.php      [BARU] Email reset password
│
database/
└── migrations/
    └── 2025_11_24_000000_add_email_verification_to_users.php  [BARU]

tests/
└── Feature/
    └── EmailVerificationTest.php          [BARU] Unit tests

.env.email.example                         [BARU] Template .env
EMAIL_VERIFICATION_AND_PASSWORD_RESET_GUIDE.md  [BARU] Panduan lengkap
QUICK_START_EMAIL_VERIFICATION.md         [BARU] Quick start
```

### File Yang Dimodifikasi ✏️
```
app/
└── Models/
    └── User.php                           [DIUBAH] Interface & methods

app/Http/Controllers/
├── Auth/
│   ├── VerificationController.php         [DIUBAH]
│   ├── ForgotPasswordController.php       [DIUBAH]
│   └── ResetPasswordController.php        [DIUBAH]
│
└── UserController.php                     [DIUBAH] Update registrasi

resources/views/auth/
├── verify.blade.php                       [DIUBAH] UI diperbaiki
├── login.blade.php                        [DIUBAH] Tambah link "Lupa Password"
│
└── passwords/
    ├── email.blade.php                    [DIUBAH] UI diperbaiki
    └── reset.blade.php                    [DIUBAH] UI diperbaiki

routes/
└── web.php                                [DIUBAH] Routes email verification & password reset
```

---

## 🚀 Quick Start

### 1. Update `.env`
Pilih salah satu konfigurasi email dari `.env.email.example` dan copy ke `.env`:

**Development (Cepat):**
```env
MAIL_MAILER=log
```

**Production/Testing (Gmail):**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Manajemen Data LPPM"
```

**Testing (Mailtrap):**
```env
MAIL_MAILER=smtp
MAIL_HOST=live.smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=your-mailtrap-user
MAIL_PASSWORD=your-mailtrap-pass
MAIL_ENCRYPTION=tls
```

### 2. Jalankan Migration
```bash
cd "d:\Web Manajemen Data LPPM\new"
php artisan migrate
```

### 3. Clear Cache
```bash
php artisan config:cache
php artisan cache:clear
```

### 4. Test Aplikasi

**Registrasi & Email Verification:**
1. Buka http://localhost:8000/register-page
2. Isi form registrasi
3. Cek email (lihat inbox atau storage/logs/laravel.log jika MAIL_MAILER=log)
4. Klik link verifikasi

**Lupa Password:**
1. Buka http://localhost:8000/login-page
2. Klik "Lupa Password?"
3. Input email
4. Cek email untuk link reset
5. Reset password dengan password baru

---

## 🔐 Fitur-Fitur

### Email Verification ✓
- [x] User registrasi → Email verifikasi dikirim otomatis
- [x] Link verifikasi berlaku 60 menit
- [x] User dapat minta kirim ulang link
- [x] Protected route: User tidak bisa akses sampai email diverifikasi
- [x] Middleware `verified` untuk protection

### Password Reset ✓
- [x] User bisa request reset password
- [x] Email reset password dikirim ke email terdaftar
- [x] Link reset password berlaku 60 menit
- [x] User harus verify token sebelum bisa reset
- [x] Password secara aman di-hash sebelum disimpan

### Security ✓
- [x] Signed URLs untuk email verification
- [x] Token hashing untuk password reset
- [x] Rate limiting (6x per menit)
- [x] CSRF protection
- [x] Password confirmation required

---

## 📧 Email yang Dikirim

### 1. Email Verifikasi
**Dipicu:** Setelah user registrasi  
**Berisi:**
- Greeting dengan nama user
- Link verifikasi yang sudah signed
- Informasi masa berlaku link (60 menit)
- Instruksi jika email tidak terkirim

**Template:** `app/Notifications/VerifyEmailNotification.php`

### 2. Email Reset Password
**Dipicu:** User request lupa password  
**Berisi:**
- Greeting dengan nama user
- Link reset password
- Informasi masa berlaku link (60 menit)
- Instruksi jika user tidak request
- URL alternatif jika link tidak bekerja

**Template:** `app/Notifications/ResetPasswordNotification.php`

---

## 🗄️ Database Schema

### Kolom Baru di `users` table:
```sql
ALTER TABLE users ADD COLUMN email_verified_at TIMESTAMP NULL;
```
- `NULL` = Email belum diverifikasi
- `Timestamp` = Email sudah diverifikasi + waktu verifikasi

### Tabel Baru `password_reset_tokens`:
```sql
CREATE TABLE password_reset_tokens (
    email VARCHAR(255) PRIMARY KEY,
    token TEXT,
    created_at TIMESTAMP NULL
);
```
- Menyimpan token reset password sementara
- Dihapus setelah user berhasil reset password
- Expired otomatis setelah 60 menit (configurable)

---

## 🔄 Alur Kerja

### Flow 1: Registrasi & Email Verification
```
User Register Form
        ↓
UserController.post_daftarakun()
        ↓
Create User in DB (email_verified_at = NULL)
        ↓
Send VerifyEmailNotification
        ↓
User cek email & klik link
        ↓
VerificationController.verify()
        ↓
Verify signed URL & hash
        ↓
Update users.email_verified_at = NOW()
        ↓
Redirect ke dashboard ✓
```

### Flow 2: Lupa Password & Reset
```
Login Page → Klik "Lupa Password?"
        ↓
ForgotPasswordController.showLinkRequestForm()
        ↓
User input email
        ↓
ForgotPasswordController.sendResetLinkEmail()
        ↓
Create token di password_reset_tokens
        ↓
Send ResetPasswordNotification
        ↓
User cek email & klik link
        ↓
ResetPasswordController.showResetForm()
        ↓
User input password baru
        ↓
ResetPasswordController.reset()
        ↓
Verify token dari DB
        ↓
Hash password & update users
        ↓
Delete token dari DB
        ↓
Redirect ke login ✓
```

---

## 🧪 Testing

### Manual Testing

**Test 1: Registrasi & Email Verifikasi**
```bash
1. Buka /register-page
2. Isi form lengkap
3. Submit
4. Cek email/log (storage/logs/laravel.log)
5. Klik link verifikasi
6. Seharusnya redirect ke dashboard
```

**Test 2: Login tanpa verifikasi**
```bash
1. Registrasi user baru
2. Coba login tanpa klik link verifikasi
3. Seharusnya redirect ke /email/verify (verification notice)
```

**Test 3: Resend Verification Email**
```bash
1. Di halaman /email/verify
2. Klik "Kirim Ulang Link Verifikasi"
3. Email baru seharusnya dikirim
4. Cek inbox/log lagi
```

**Test 4: Lupa Password**
```bash
1. Buka /login-page
2. Klik "Lupa Password?"
3. Input email yang ada
4. Cek email/log
5. Klik link reset password
6. Input password baru
7. Submit
8. Seharusnya redirect ke login
9. Login dengan password baru ✓
```

### Automated Testing

File test sudah disiapkan di `tests/Feature/EmailVerificationTest.php`:

```bash
php artisan test tests/Feature/EmailVerificationTest.php
```

---

## ⚙️ Konfigurasi

### Mengubah Waktu Expirasi Link

**Email Verification** (default 60 menit):
```php
// File: app/Notifications/VerifyEmailNotification.php
// Line 66
Carbon::now()->addMinutes(60) // Ubah 60 ke menit lain
```

**Password Reset** (default 60 menit):
```php
// File: config/auth.php (jika ada)
'expire' => 60 // Ubah ke menit lain
```

### Mengubah Redirect URL

**Setelah Email Verified:**
```php
// File: app/Http/Controllers/Auth/VerificationController.php
protected $redirectTo = '/dashboard'; // Ubah ke route lain
```

**Setelah Password Reset:**
```php
// File: app/Http/Controllers/Auth/ResetPasswordController.php
protected $redirectTo = '/dashboard'; // Ubah ke route lain
```

### Mengubah Template Email

Edit file notification di `app/Notifications/`:
- `VerifyEmailNotification.php` - Email verifikasi
- `ResetPasswordNotification.php` - Email reset password

---

## 🐛 Troubleshooting

| Masalah | Solusi |
|---------|--------|
| Email tidak terkirim | 1. Cek .env (MAIL_MAILER, HOST, PORT, USER, PASS) 2. Jalankan `php artisan config:cache` 3. Cek log: `storage/logs/laravel.log` |
| Link verifikasi expired | Minta kirim ulang email atau tunggu email baru (max 60 menit) |
| "Class not found" error | Jalankan `composer dump-autoload` |
| Migration error | Pastikan: 1. Database sudah create 2. Credentials benar di .env 3. Jalankan `php artisan migrate` |
| User tidak bisa login | Cek: 1. Email sudah diverifikasi? 2. Password benar? 3. Check DB: `SELECT * FROM users` |
| Signed URL invalid | 1. Cek APP_KEY di .env 2. Cek APP_URL sudah sesuai domain 3. Clear cache: `php artisan cache:clear` |

---

## 📚 Dokumentasi Lanjutan

Untuk dokumentasi lebih detail, lihat:

1. **EMAIL_VERIFICATION_AND_PASSWORD_RESET_GUIDE.md** - Panduan lengkap & detailed
2. **QUICK_START_EMAIL_VERIFICATION.md** - Quick start guide
3. **.env.email.example** - Template konfigurasi email

---

## ✅ Pre-Production Checklist

Sebelum production:
- [ ] Email SMTP sudah dikonfigurasi dengan benar
- [ ] Test send email berhasil
- [ ] Database migration sudah dijalankan
- [ ] APP_URL di .env sesuai domain production (HTTPS)
- [ ] APP_KEY di .env sudah di-generate
- [ ] Test signed URL (verification link) bekerja
- [ ] Test password reset flow
- [ ] Backup database sebelum deploy
- [ ] Setup email provider (Gmail, Mailtrap, dll)
- [ ] Monitor logs untuk errors: `tail -f storage/logs/laravel.log`

---

## 📞 Support

Untuk pertanyaan atau masalah:

1. **Lihat dokumentasi:**
   - EMAIL_VERIFICATION_AND_PASSWORD_RESET_GUIDE.md
   - QUICK_START_EMAIL_VERIFICATION.md

2. **Check troubleshooting** di dokumentasi di atas

3. **Laravel Documentation:**
   - https://laravel.com/docs/11.x/verification
   - https://laravel.com/docs/11.x/passwords
   - https://laravel.com/docs/11.x/mail

4. **Check logs:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

---

**Implementasi Selesai! 🎉**

Tanggal: 2025-11-24  
Status: ✅ Siap untuk Testing & Production

Untuk memulai: Baca **QUICK_START_EMAIL_VERIFICATION.md**
