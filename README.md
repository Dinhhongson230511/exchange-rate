
## How to install

- step 1: cd docker && cp .env.example .env
- step 1: cp .env.example .env // thay các thông số vào .env
- step 1: chmod +x ./api-start-dev.sh
- step 2: ./api-start-dev.sh
- step 2: docker exec -it laravel-exchange php artisan migrate.
- step 3: docker exec -it laravel-exchange php artisan exchange-make:get-currency-unit.

