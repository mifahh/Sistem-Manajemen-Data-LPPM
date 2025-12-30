# 📧 SETUP EMAIL TELKOM UNIVERSITY & MICROSOFT ACCOUNT

## 🎓 OPSI 1: Telkom University Email (@telkomuniversity.ac.id)

### Prasyarat
- Email Telkom University aktif (@telkomuniversity.ac.id)
- Access ke IT Telkom untuk SMTP configuration (optional)
- 2-Factor Authentication (2FA) enabled (recommended)

### Step-by-Step Setup

#### 1. Enable 2-Factor Authentication (Recommended)
```
1. Buka https://account.microsoft.com/security
2. Pilih "Advanced security options"
3. Enable "2-step verification"
4. Follow instructions dan simpan recovery codes
```

#### 2. Generate App Password
```
1. Buka https://account.microsoft.com/security/app-passwords
   (Hanya muncul jika 2FA sudah enabled)
2. Select app: "Mail"
3. Select device: "Windows Computer" (atau sesuai)
4. Salin password 16 karakter yang diberikan
5. Copy tanpa spasi
```

#### 3. Update `.env`
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.office365.com
MAIL_PORT=587
MAIL_USERNAME=nama.anda@telkomuniversity.ac.id
MAIL_PASSWORD=xxxx xxxx xxxx xxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=nama.anda@telkomuniversity.ac.id
MAIL_FROM_NAME="LPPM - Telkom University"
```

#### 4. Test Configuration
```bash
php artisan tinker
Mail::raw('test', fn($m) => $m->to('test@telkomuniversity.ac.id'));
```

### Troubleshooting Telkom University

| Masalah | Solusi |
|---------|--------|
| SMTP Connection Error | Port bisa 587 atau 465, coba yang lain |
| Authentication Failed | Pastikan menggunakan App Password (bukan password biasa) |
| 2FA Not Available | Enable 2-step verification dulu |
| Email Bounced | Check MAIL_FROM_ADDRESS sudah benar |

### Tips Keamanan
- ✅ Gunakan App Password, bukan password akun
- ✅ Enable 2-Factor Authentication
- ✅ Keep App Password secure (jangan share)
- ✅ Regenerate App Password periodically
- ✅ Gunakan HTTPS untuk aplikasi

---

## 💻 OPSI 2: Microsoft 365 Enterprise

Untuk organisasi yang menggunakan Microsoft 365.

### Setup Steps

#### 1. Contact IT Administrator
```
Minta IT untuk memberikan:
- SMTP Server address
- Port (usually 587 or 465)
- Username (biasanya email Anda)
- Password atau App Password
```

#### 2. Update `.env`
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.office365.com
MAIL_PORT=587
MAIL_USERNAME=your-email@yourcompany.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@yourcompany.com
MAIL_FROM_NAME="LPPM - Company Name"
```

#### 3. Test Connection
```bash
php artisan config:cache
php artisan tinker
Mail::raw('test', fn($m) => $m->to('test@yourcompany.com'));
```

### Common Microsoft 365 Settings
```
SMTP Server: smtp.office365.com
Port: 587 (TLS) atau 465 (SSL)
Encryption: tls
Authentication: Yes (require username & password)
```

---

## 📩 OPSI 3: Outlook Personal

Untuk personal Outlook account (@outlook.com).

### Setup Steps

#### 1. Enable 2-Factor Authentication
```
1. Buka https://account.microsoft.com/security
2. Enable "2-step verification"
```

#### 2. Generate App Password
```
1. Buka https://account.microsoft.com/security/app-passwords
2. Select "Mail" dan "Windows Computer"
3. Salin 16-character password
```

#### 3. Update `.env`
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp-mail.outlook.com
MAIL_PORT=587
MAIL_USERNAME=your-email@outlook.com
MAIL_PASSWORD=xxxx xxxx xxxx xxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@outlook.com
MAIL_FROM_NAME="LPPM - Telkom University"
```

#### 4. Difference dari smtp.office365.com
```
Outlook Personal: smtp-mail.outlook.com
Microsoft 365:    smtp.office365.com
```

---

## 🔄 PERBANDINGAN KETIGA OPSI

| Fitur | Telkom Uni | Microsoft 365 | Outlook |
|-------|-----------|---------------|---------|
| Email | @telkomuniversity.ac.id | @company.com | @outlook.com |
| SMTP Server | smtp.office365.com | smtp.office365.com | smtp-mail.outlook.com |
| Port | 587 | 587 | 587 |
| Requires 2FA | Ya | Ya* | Ya |
| Requires App Pass | Ya | Ya* | Ya |
| Buat Alias | Ya | Ya | Ya |
| Organization Support | Ya | Ya | Tidak |
| Cost | Free (included) | Paid (Microsoft 365) | Free |

*) Tergantung IT policy organisasi

---

## 🚀 QUICK SETUP - TELKOM UNIVERSITY

Jika Anda adalah mahasiswa/staff Telkom University:

### 1 Menit Setup:
```bash
# 1. Update .env
MAIL_MAILER=smtp
MAIL_HOST=smtp.office365.com
MAIL_PORT=587
MAIL_USERNAME=your-email@telkomuniversity.ac.id
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@telkomuniversity.ac.id

# 2. Clear cache
php artisan config:cache

# 3. Done!
```

### Dapatkan App Password:
1. Buka https://account.microsoft.com/security/app-passwords
2. Pilih Mail → Windows Computer
3. Copy password
4. Paste di MAIL_PASSWORD

---

## 🆘 TROUBLESHOOTING

### Error: "SMTP connection refused"
```
Solusi:
1. Check port: Port 587 (TLS) atau 465 (SSL)?
2. Check MAIL_HOST: smtp.office365.com untuk Telkom Uni/Microsoft 365
3. Check firewall: Pastikan port 587/465 tidak diblock
```

### Error: "Authentication failed"
```
Solusi:
1. Pastikan menggunakan App Password (bukan password akun)
2. Check username: Harus email lengkap (nama@telkomuniversity.ac.id)
3. 2FA enabled? Jika belum, enable dulu
4. Copy exact: Jangan ada spasi di awal/akhir
```

### Error: "5.7.139 Authentication unsuccessful"
```
Solusi:
1. Regenerate App Password (Microsoft mungkin invalidate)
2. Check 2-step verification still enabled
3. Try different device app password
4. Check password: 16 characters, exact copy
```

### Emails sent tapi tidak sampai
```
Solusi:
1. Check MAIL_FROM_ADDRESS benar
2. Recipient email valid dan inbox buka
3. Check junk folder di recipient
4. Check logs: tail -f storage/logs/laravel.log
```

---

## 📋 CHECKLIST SETUP

- [ ] Access ke email Telkom University/Microsoft
- [ ] Enable 2-Factor Authentication
- [ ] Generate App Password
- [ ] Copy exact password (tanpa spasi)
- [ ] Update .env dengan benar
- [ ] Run `php artisan config:cache`
- [ ] Test send email dengan `php artisan tinker`
- [ ] Check email received
- [ ] Test aplikasi registrasi & forgot password
- [ ] Deploy to production

---

## 🔐 SECURITY BEST PRACTICES

### For Telkom University/Microsoft Accounts:

1. **Use App Passwords**
   - ✅ Lebih aman daripada password akun
   - ✅ Bisa di-revoke tanpa ubah password akun
   - ✅ Limited scope (hanya untuk email)

2. **Enable 2-Factor Authentication**
   - ✅ Prevent unauthorized access
   - ✅ Extra layer of security
   - ✅ Required untuk App Password

3. **Keep Password Secure**
   - ✅ Jangan push `.env` ke GitHub
   - ✅ Use `.env` yang di-ignore
   - ✅ Restrict file permissions (`chmod 600`)

4. **Monitor Activity**
   - ✅ Check login activity di account settings
   - ✅ Review recent sign-ins
   - ✅ Report suspicious activity

5. **Regenerate Periodically**
   - ✅ Generate new App Password setiap 3-6 bulan
   - ✅ Revoke old App Passwords
   - ✅ Update `.env` dengan yang baru

---

## 📞 SUPPORT RESOURCES

### Telkom University Students/Staff:
- Contact IT Telkom: [IT Support Email/Ticket]
- Ask IT untuk SMTP configuration jika butuh
- Get help dengan account settings

### Microsoft Account Support:
- https://account.microsoft.com/security
- https://support.microsoft.com/account-billing

### Laravel Mail Support:
- https://laravel.com/docs/11.x/mail

### Aplikasi Issues:
- Check logs: `tail -f storage/logs/laravel.log`
- Run tests: `php artisan test`

---

## 📝 CONTOH SETUP LENGKAP

### Scenario: Setup untuk Telkom University

```bash
# Step 1: Generate App Password
# - Buka https://account.microsoft.com/security/app-passwords
# - Select Mail → Windows Computer
# - Copy password: "abcd efgh ijkl mnop"

# Step 2: Update .env
MAIL_MAILER=smtp
MAIL_HOST=smtp.office365.com
MAIL_PORT=587
MAIL_USERNAME=rahman.saputra@telkomuniversity.ac.id
MAIL_PASSWORD=abcdefghijklmnop
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=rahman.saputra@telkomuniversity.ac.id
MAIL_FROM_NAME="LPPM Telkom University"

# Step 3: Clear cache
php artisan config:cache
php artisan cache:clear

# Step 4: Test
php artisan tinker
Mail::raw('Test Email', fn($m) => $m->to('test@telkomuniversity.ac.id'));

# Step 5: Deploy
php artisan migrate
php artisan serve

# Step 6: Test di browser
# - Registrasi user baru
# - Cek email untuk verification link
# - Klik link verification
# - Success! ✓
```

---

## ✅ VERIFIKASI SETUP

Jika setup benar, Anda akan bisa:

1. ✅ Registrasi user baru
2. ✅ Terima email verification dari @telkomuniversity.ac.id
3. ✅ Klik link verification di email
4. ✅ Email terverifikasi
5. ✅ Akses dashboard
6. ✅ Klik "Lupa Password?"
7. ✅ Terima email reset password
8. ✅ Reset password berhasil
9. ✅ Login dengan password baru

---

**Created:** 2025-11-24  
**Last Updated:** 2025-11-24  
**Version:** 1.0  
**Status:** ✅ Ready to Use
