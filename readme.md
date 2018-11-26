
## About Project

Simple tool which let's to

- Make products by UPC,
- Make attachments for those products,
- make categories, subcategories, brands for that products.

## Released version 
- v1.0

## Requirements
- php version >= 7.1;
- laravel version >= 5.6
- postgresql version >= 9.5.14

## Installation
- git clone {this repo} {your folder name}
- in the project root run `sudo cp .env.example .env` to copy env.example data to .env file
- configure .env to the values related to your environment
- suggesting to change `QUEUE_DRIVER=database` in .env file
- run `sudo composer install` to install dependencies
- run `php artisan migrate` to migrate migration
- run `sudo chmod 777 -R storage/` to open rwe permissions for storage
- run `sudo chmod 777 -R bootstrap/cache/` to open rwe permissions for cache
- run `php artisan storage:link` to link storage folder to public/ folder
- run `php artisan serve`
- start playing, hope forget nothing.