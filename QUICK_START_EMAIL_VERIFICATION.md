# Quick Start Guide - Email Verification & Password Reset

## ⚡ Setup Cepat (5 Menit)

### Step 1: Update `.env` File
```env
# Gunakan salah satu dari opsi di bawah

# Opsi A: Gmail SMTP
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Manajemen Data LPPM"

# Opsi B: Telkom University (@telkomuniversity.ac.id) ⭐
# Baca: TELKOM_UNIVERSITY_MICROSOFT_ACCOUNT_SETUP.md
MAIL_MAILER=smtp
MAIL_HOST=smtp.office365.com
MAIL_PORT=587
MAIL_USERNAME=your-email@telkomuniversity.ac.id
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@telkomuniversity.ac.id
MAIL_FROM_NAME="LPPM - Telkom University"

# Opsi C: Mailtrap (Testing)
MAIL_MAILER=smtp
MAIL_HOST=live.smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=your-mailtrap-user
MAIL_PASSWORD=your-mailtrap-pass
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME="Manajemen Data LPPM"

# Opsi D: Log Driver (Development)
MAIL_MAILER=log
```

### Step 2: Jalankan Migration
```bash
cd "d:\Web Manajemen Data LPPM\new"

# Jalankan semua migration
php artisan migrate

# ATAU hanya migration email verification
php artisan migrate --path=database/migrations/2025_11_24_000000_add_email_verification_to_users.php
```

### Step 3: Clear Cache
```bash
php artisan config:cache
php artisan cache:clear
```

### Step 4: Test

#### Buka aplikasi:
```
http://localhost:8000
```

#### Coba Registrasi:
1. Klik "Registrasi" atau buka `/register-page`
2. Isi form
3. Submit
4. Cek email inbox Anda
5. Klik link verifikasi

#### Coba Lupa Password:
1. Klik "Lupa Password?" di halaman login
2. Masukkan email
3. Cek email inbox
4. Klik link reset password
5. Isi password baru

---

## 📧 Konfigurasi Email Step-by-Step

### Menggunakan Gmail (RECOMMENDED)

#### 1. Enable 2FA di Google Account
- Buka https://myaccount.google.com
- Pilih "Security" di sidebar
- Enable "2-Step Verification"

#### 2. Generate App Password
- Di halaman Security, scroll ke bawah
- Klik "App passwords"
- Pilih Mail → Windows Computer
- Salin password yang diberikan
- Copy tanpa spasi

#### 3. Update `.env`
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=namamu@gmail.com
MAIL_PASSWORD=xxxx xxxx xxxx xxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=namamu@gmail.com
MAIL_FROM_NAME="Manajemen Data LPPM"
```

#### 4. Test
```bash
php artisan tinker
Mail::raw('test', fn($m) => $m->to('test-email@example.com'));
```

### Menggunakan Mailtrap (untuk Testing)

#### 1. Buat Account
- Daftar di https://mailtrap.io
- Buat project baru

#### 2. Copy SMTP Credentials
- Di Mailtrap, pilih "Email Testing"
- Pilih project
- Klik "Laravel" di Show Integrations
- Copy SMTP credentials

#### 3. Update `.env`
```env
MAIL_MAILER=smtp
MAIL_HOST=live.smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=your-user
MAIL_PASSWORD=your-pass
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME="Manajemen Data LPPM"
```

#### 4. Cek Email di Mailtrap
- Buka https://mailtrap.io
- Email akan muncul di inbox Mailtrap

### 🎓 Menggunakan Telkom University Email (@telkomuniversity.ac.id)

**RECOMMENDED untuk production di Telkom University!**

Baca dokumentasi lengkap: [`TELKOM_UNIVERSITY_MICROSOFT_ACCOUNT_SETUP.md`](TELKOM_UNIVERSITY_MICROSOFT_ACCOUNT_SETUP.md)

#### Quick Setup (2 langkah):

1. **Generate App Password:**
   - Buka https://account.microsoft.com/security/app-passwords
   - Select "Mail" → "Windows Computer"
   - Copy 16-character password

2. **Update `.env`:**
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.office365.com
   MAIL_PORT=587
   MAIL_USERNAME=your-email@telkomuniversity.ac.id
   MAIL_PASSWORD=xxxx xxxx xxxx xxxx
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=your-email@telkomuniversity.ac.id
   MAIL_FROM_NAME="LPPM - Telkom University"
   ```

**Note:** Setup @telkomuniversity.ac.id = Setup Microsoft 365. Lihat `TELKOM_UNIVERSITY_MICROSOFT_ACCOUNT_SETUP.md` untuk troubleshooting & tips.

---

## 🔍 Fitur yang Tersedia

### 1. Email Verification setelah Registrasi
✅ User registrasi  
✅ Email verifikasi dikirim otomatis  
✅ User harus klik link verifikasi  
✅ Link berlaku 60 menit  
✅ User bisa minta kirim ulang  

### 2. Protected Routes (Harus Verifikasi Email)
- `/dashboard` (dan routes lain)
- User akan di-redirect ke `/email/verify` jika email belum diverifikasi

### 3. Forgot Password
✅ User klik "Lupa Password?" di login  
✅ Input email  
✅ Email reset password dikirim  
✅ Klik link di email  
✅ Isi password baru  
✅ Password berhasil diubah  

---

## 🛠️ Troubleshooting

| Masalah | Solusi |
|---------|--------|
| Email tidak terkirim | Cek `.env`, pastikan MAIL_MAILER, MAIL_HOST, PORT benar |
| Link verifikasi expired | Minta kirim ulang atau tunggu token baru |
| Token invalid | Token hanya 60 menit, request ulang |
| "Class not found" error | Jalankan `composer dump-autoload` |
| Migration error | Pastikan database sudah create, jalankan `php artisan migrate` |
| Forgot password tidak bekerja | Cek `.env` dan jalankan migration |

---

## 📝 File yang Diubah/Dibuat

### Dibuat Baru:
- `app/Notifications/VerifyEmailNotification.php`
- `app/Notifications/ResetPasswordNotification.php`
- `database/migrations/2025_11_24_000000_add_email_verification_to_users.php`

### Diubah:
- `app/Models/User.php`
- `app/Http/Controllers/Auth/VerificationController.php`
- `app/Http/Controllers/Auth/ForgotPasswordController.php`
- `app/Http/Controllers/Auth/ResetPasswordController.php`
- `app/Http/Controllers/UserController.php`
- `resources/views/auth/verify.blade.php`
- `resources/views/auth/passwords/email.blade.php`
- `resources/views/auth/passwords/reset.blade.php`
- `resources/views/auth/login.blade.php`
- `routes/web.php`

---

## 🚀 Production Checklist

Sebelum go live:
- [ ] Update `.env` dengan email production
- [ ] Test semua flow (registrasi, verifikasi, lupa password)
- [ ] Pastikan email SMTP credentials benar
- [ ] Setup SSL certificate untuk keamanan
- [ ] Update `APP_URL` di `.env` (gunakan HTTPS)
- [ ] Test signed URLs bekerja dengan domain production
- [ ] Backup database sebelum production
- [ ] Monitor `storage/logs/laravel.log` untuk errors

---

## 🎯 Next Steps

1. ✅ Setup `.env` dengan email configuration
2. ✅ Jalankan `php artisan migrate`
3. ✅ Test dengan registrasi baru
4. ✅ Test dengan forgot password
5. ✅ Customize UI sesuai branding
6. ✅ Deploy ke production

---

**Need Help?**
- Lihat `EMAIL_VERIFICATION_AND_PASSWORD_RESET_GUIDE.md` untuk panduan lengkap
- Check Laravel docs: https://laravel.com/docs/11.x
