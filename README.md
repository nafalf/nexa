# Nexa Banking Portfolio

Nexa adalah aplikasi web banking simulasi untuk portofolio. Seluruh transaksi menggunakan data dummy.

## Demo

- Customer: `demo@nexa.id` / `Nexa1234`
- Admin: `admin@nexa.id` / `Nexa1234`
- OTP transfer: `123456`

## Menjalankan aplikasi

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm install
npm run build
php artisan serve
```

## API

| Metode | Endpoint | Fungsi |
|---|---|---|
| GET | `/api/accounts` | Daftar rekening |
| GET | `/api/beneficiaries` | Daftar rekening tujuan |
| POST | `/api/beneficiaries` | Tambah rekening tujuan |
| PUT | `/api/beneficiaries/{id}` | Ubah rekening tujuan |
| DELETE | `/api/beneficiaries/{id}` | Hapus rekening tujuan |
| GET | `/api/transactions` | Riwayat transaksi |
| GET | `/api/admin/statistics` | Statistik admin |

## Catatan

Nexa bukan aplikasi resmi BNI atau wondr. Nama, logo, dan data di dalamnya dibuat khusus untuk demonstrasi kemampuan teknis.
