# login-test

# Cara penggunaan
- Lakukan git clone
- Buka file

# Setting .env root
- cari .env.production
- replace .env.production menjadi .env
- isi semua yg ada di .env (mysql, redis)

# Setting .env src
- buka file src cari .env.example
- replace .env.example menjadi .env
- isikan .env yang kosong dengan settingan yang ada di .env root

# Menjalankan
- jalankan docker compose up -d
- jalankan docker compose exec app composer install
- jalankan docker compose exec app php artisan key:generate
- jalankan docker comopose exec app php artisan migrate --seed
- akses di browser dengan link http://localhost