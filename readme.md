# Declick Server v2

This component is part of [Declick v2 platform](https://github.com/colombbus/declick-v2).

## Requirements

Declick Server is built on [Lumen platform](http://lumen.laravel.com/). Therefore the following requirements should be met:
* PHP >= 5.6.4
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Database engine: MySQL, Postgres, SQLite or SQL Server

## Installation

### Server

1. Install [composer](https://getcomposer.org)
2. At the application root, run `composer install`

### Database

3. Copy .env.example into .env
4. Set your parameters to access database server:
    * DB_CONNECTION the database category (mysql, postgres, sqlite, sqlsrv)
    * DB_HOST the database server address
    * DB_PORT the server port
    * DB_DATABASE database name
    * DB_USERNAME database user
    * DB_PASSWORD password
5. Run `php artisan migrate` to initialize database

### Configuration

6.  Give your webserver write access to folder "storage/app"
7.  Copy public/htaccess.example into public/.htaccess - set RewriteBase according to your server configuration
8.  Browse to *server_adress*/public/ and check that it returns Lumen version

```
Lumen (5.3.2) (Laravel Components 5.3.*)
```