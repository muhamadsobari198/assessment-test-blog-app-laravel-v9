# Blog App - Laravel 9

## Tampilan Applikasi

![preview img](/ss1.png)

![preview img](/ss2.png)

![preview img](/ss3.png)

![preview img](/ss4.png)

![preview img](/ss5.png)

## Cara Install

Setup environment dilocal :
```bash
$ git clone git@github.com:muhamadsobari198/blog-app-laravel-v9-by-m-sobari.git
$ cd blog-app-laravel-v9-by-m-sobari
$ cp .env.example .env
$ composer install
$ php artisan key:generate
$ php artisan storage:link
```

## Jika berhasil diinstall lalu jalankan perintah berikut
Diperlukan menjalankan migration & seeder:
```bash
$ php  artisan migrate --seed
```

Lalu akan ada user ter create, dan user ini dipakai untuk Login ke Admin Panel :
```yaml
email: admin@admin.com
password: password
```

setelah itu jalankan aplikasi :
```bash
$ php artisan serve
```
