web: vendor/bin/heroku-php-apache2 public/
worker: php artisan migrate
worker: php artisan queue:work database --queue=contract_upload,import_report_email