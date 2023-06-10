# url-shortner
 Url shortner project made in laravel installation guide
##Syestem Requirements
-PHP >= PHP 8.1
-Apache Server
-Mysql Server
-(Recommended to use XAMPP https://www.apachefriends.org/download.html)

##Installation
- Create a database for the project
- Download composer https://getcomposer.org/download/
- Pull Laravel/php project from git provider.
- Rename `.env.example` file to `.env`inside your project root and fill the database information.
- Open the console and cd your project root directory
- Run `composer install` or ```php composer.phar install```
- Run `php artisan key:generate` 
- Run `php artisan migrate`
- Run `php artisan serve`
#####You can now access your project at localhost:8000 :)