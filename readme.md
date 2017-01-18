# Declick Platform - server part

Declick Server is built on [Lumen platform](http://lumen.laravel.com/)

## Installing Declick Server

* Run `composer install`
* Copy .env.example into .env
* Set your parameters to access database server
* Run `php artisan migrate` to initialize database
* Give your webserver write access to folder "storage/app"
* Browse to *server_adress/public/* and check that it returns Lumen version

