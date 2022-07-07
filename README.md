
## How to install

- step 1: cd docker && cp .env.example .env
- step 2: cp .env.example .env // change your info to .env
- step 3: chmod +x ./api-start-dev.sh
- step 4: ./api-start-dev.sh
- step 5: docker exec -it laravel-exchange php artisan migrate.
- step 6: docker exec -it laravel-exchange php artisan exchange-make:get-currency-unit.

