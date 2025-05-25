## PROJECT STRUCTURE
 backend   -> Laravel API

## PREREQUISITES
Make sure you have PHP (v8.1 or later)
1.Composer
2.MySQL or any database of your choice
3.Laravel CLI (composer global require laravel/installer)

## INSTALLATION GUIDE
1.git clone https://github.com/RickDerick/ArticleLMS-Backend.git
2.cd your-project
3.create a .env file in the src folder and copy paste the content from env.example file
4.composer install
5.php artisan key:generate
php artisan migrate --seed
php artisan serve or php artisan -S localhost:8000 -t public


## USER AUTHENTICATION
Note:on your .env file you will need to setup any free mail service provider for otp verification eg mailtrap 
For Admin Login use; 
Email: admin@example.com
Password: password123
2.For user login use;
Email: user@example.com or create an account
Password: password123