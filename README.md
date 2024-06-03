# Register Dokumen

<a href="https://idx.google.com/import?url=https%3A%2F%2Fgithub.com%2Farifnd%2Fregister-dokumen">
  <picture>
    <source media="(prefers-color-scheme: dark)" srcset="https://cdn.idx.dev/btn/try_dark_32.svg">
    <source media="(prefers-color-scheme: light)" srcset="https://cdn.idx.dev/btn/try_light_32.svg">
    <img height="32" alt="Try in IDX" src="https://cdn.idx.dev/btn/try_purple_32.svg">
  </picture>
</a>

Aplikasi web sederhana untuk pencatatan nomor register dokumen, dibangun dengan [Laravel](https://laravel.com) dan [Filament](https://filamentphp.com).

![Tangkapan layar](https://i.ibb.co/hHG6Zc4/image.png)

## Pemasangan

Unduh kode sumber

```bash
git clone https://github.com/arifnd/register-dokumen.git
cd register-dokumen
composer install
cp .env.example .env
php artisan key:generate
```

Sesuaikan koneksi database pada berkas **.env**

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan migrasi database
```bash
php artisan migrate --seed
```

Jalankan aplikasi
```bash
php artisan serve
```

Login dengan
> Username: admin@admin.com  
> Password: 123456

## Kontribusi

Anda dapat berkontribusi pada pengembangan aplikasi ini dengan melakukan pull request dan melaporkan masalah.

## Lisensi

Aplikasi ini dilisensikan di bawah [lisensi MIT](LICENSE).