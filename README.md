## Steps to run this Backend in your local machine --


Requirements -     
    1. Composer >v2 installed   
    2. Xampp installed    
    3. PHP version >8
    
## Steps - 

1. Start Apache and MySQL from your Xampp Control panel      
2. open PHPMyadmin and create database named - 'shaadi-admin'     
3. Clone this project in Xampp/htdocs folder
4. Open project in command panel
5. put Following commands one by one -     
    1. `composer install` or `composer update`     
    2.  for windows run - `copy .env.example .env` , others - make file copy all text from .env.example to .env (make new if not there)     
    3. run `php artisan shramik:install` -- this custom command will create all tables in database and create storage links with seeding database so just enter for every question.


