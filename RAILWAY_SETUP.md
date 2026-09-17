# Panduan Deploy ke Railway

## 1. Setup Variables di Railway

### Cara Menambahkan Variables:

1. Login ke [railway.app](https://railway.app)
2. Buka project **novel_laravel**
3. Klik service **Laravel/PHP**
4. Klik tab **"Variables"**
5. Klik **"Raw Editor"** (pojok kanan atas)
6. Copy-paste semua variables di bawah ini:

```env
APP_NAME=NovelKu
APP_KEY=base64:OhIgum0YsT3yAEPNZWEeqcQvJBKOBFBC0woTURI1AEM=
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.up.railway.app

APP_LOCALE=en
APP_FALLBACK_LOCALE=en

LOG_CHANNEL=stderr
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_URL=${{MySQL.MYSQL_URL}}

SESSION_DRIVER=database
SESSION_LIFETIME=120

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database

MAIL_MAILER=log
MAIL_FROM_ADDRESS=hello@novelku.com
MAIL_FROM_NAME=NovelKu

MIDTRANS_SERVER_KEY=SB-Mid-server-Q5XnCQ-04g6WlDXwC9VWkZqo
MIDTRANS_CLIENT_KEY=SB-Mid-client-WqLrjjJQca_YKGSh
MIDTRANS_IS_PRODUCTION=false
```

7. Klik **"Update Variables"**
8. Railway akan otomatis redeploy

---

## 2. Update APP_URL

Setelah domain Railway di-generate:

1. Copy domain Anda (misal: `novel-laravel-production.up.railway.app`)
2. Update variable `APP_URL`:
   ```
   APP_URL=https://novel-laravel-production.up.railway.app
   ```

---

## 3. Setup Database MySQL

1. Di project canvas, klik **"+ New"**
2. Pilih **"Database"** → **"Add MySQL"**
3. Database akan otomatis terconnect
4. Pastikan variable `DB_URL=${{MySQL.MYSQL_URL}}` sudah ada

---

## 4. Generate Domain

1. Buka service Laravel
2. Tab **"Settings"**
3. Scroll ke **"Networking"**
4. Klik **"Generate Domain"**

---

## 5. Setup Midtrans Production (Opsional)

Jika sudah siap production:

1. Daftar akun production di [Midtrans](https://dashboard.midtrans.com)
2. Dapatkan Production Server Key & Client Key
3. Update variables:
   ```
   MIDTRANS_SERVER_KEY=Mid-server-xxxxx
   MIDTRANS_CLIENT_KEY=Mid-client-xxxxx
   MIDTRANS_IS_PRODUCTION=true
   ```
4. **PENTING**: Update Notification URL di Midtrans Dashboard ke:
   ```
   https://your-domain.up.railway.app/midtrans/callback
   ```

---

## 6. Testing

Setelah deploy sukses:

1. Buka domain Railway Anda
2. Register/Login
3. Test fitur:
   - Browse novel
   - Bookmark
   - **Top Up Coin** (di `/coins`)
   - Unlock chapter premium

---

## Troubleshooting

### Error: "No application encryption key has been specified"
- Pastikan `APP_KEY` sudah di-set di variables

### Database Connection Error
- Pastikan MySQL service sudah dibuat
- Cek variable `DB_URL=${{MySQL.MYSQL_URL}}`

### Midtrans Payment Error
- Pastikan MIDTRANS keys sudah benar
- Untuk sandbox, pastikan `MIDTRANS_IS_PRODUCTION=false`

### 500 Internal Server Error
- Cek logs di Railway Dashboard
- Pastikan `LOG_CHANNEL=stderr`
- Jalankan `php artisan migrate` jika belum

---

## Paket Coin Tersedia

| Paket | Coins | Harga |
|-------|-------|--------|
| Basic | 50 | Rp 10.000 |
| Standard | 120 | Rp 20.000 |
| Premium | 320 | Rp 50.000 |
| Ultimate | 700 | Rp 100.000 |

---

## Support

Jika ada masalah, cek:
- Railway logs: klik service → tab "Deployments" → klik deployment → "View Logs"
- Laravel logs akan muncul di Railway console
