# ENVIRONMENT

- sudo apt install mysql-server
- sudo apt install apache2
- sudo apt install php8.3

- composer install
- touch .env, and paste .env.example content into .env file
- php artisan key:generate
- php artisan migrate:fresh --seed
- php artisan config:cache
- php artisan optimize:clear