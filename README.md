<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

# Laravel Library Management System

## Quick Start 
clone the repo
```
git clone **link**
```

change current directory

```
cd Laravel-libraray-management-system
```
install dependencies
```
composer install
````
install js dependencies
```
npm install && npm run dev
````
create .env file
```
cp (unix) or copy (Windows) .env.example .env
```
generate env key
```
php artisan key:generate
```
migrate the migration and seed the database
```
php artisan migrate:fresh --seed
```
start server
```
php artisan serve
```
