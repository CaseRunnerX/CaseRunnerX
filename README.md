## Project Status

:construction: Working in Progress

---

[![Laravel](https://img.shields.io/badge/Laravel-v9.x-FF2D20?style=for-the-badge&logo=laravel)](https://img.shields.io/badge/Laravel-v8.x-FF2D20?style=for-the-badge&logo=laravel)
[![Laravel Livewire](https://img.shields.io/badge/Livewire-v2.x-FB70A9?style=for-the-badge)](https://img.shields.io/badge/Livewire-v2.x-FB70A9?style=for-the-badge)
[![PHP](https://img.shields.io/badge/PHP-8.0-777BB4?style=for-the-badge&logo=php)](https://img.shields.io/badge/PHP-8.0-777BB4?style=for-the-badge&logo=php)
[![Filament ](https://img.shields.io/badge/Filamentphp-v2.x-yellow?style=for-the-badge&logo=filamentphp)](https://img.shields.io/badge/PHP-8.0-777BB4?style=for-the-badge&logo=php)

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:
Laravel is accessible, powerful, and provides tools required for large, robust applications.


---

## Prerequisite

Enable this additionals php extension:
```
1. sqlite

```

## Installation

Step 1. and then cd to your clone repo and run this on your command
```bash
composer install
```
Step 2.
> Copy the .env.example to ".env" and update the database credential

Step 3. add the vendor required by running this command
```bash
php artisan generate:key
```
Step 4. migrate the database tables
```bash
php artisan migrate
```
Step 5. generate roles and permissions
```bash
php artisan shield:generate --all
```
Step 6. and generate Super-Admin account
```bash
php artisan make:filament-user
```
Step 7.
```bash
php artisan shield:super-admin --user=1
```

Step 8.
```bash
php artisan storage:link
```

Step 9. install npm dependency

```bash
npm install
```

Step 10. Build the front end

```bash
npm run build
```

Step 9. once done you can now navigate to the system

```link
http://127.0.0.1:8000/ 
or
http://server-ip/
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.


## Credits

- [MarJose](https://github.com/MarJose123)
- [All Contributors](../../contributors)


## License
software licensed under the [Apache License 2.0 license](https://opensource.org/license/apache-2-0/).
