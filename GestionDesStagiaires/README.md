commandes : 
composer install 
composer require phpoffice/phpword
rm public\storage
php artisan storage:link
php artisan db:seed --class=usersSeeder 
php artisan route:cache
php artisan config:cache
