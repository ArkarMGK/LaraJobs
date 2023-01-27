### Database Setup
This app uses MySQL. To use something different, open up config/Database.php and change the default driver.

To use MySQL, make sure you install it, setup a database and then add your db credentials(database, username and password) to the .env.example file and rename it to .env

### Run These commands after database set up..
composer install (OR composer update if your php version is lower)

php artisan key:generate

php artisan migrate

php artisan db:seed

php artisan serve


## License

The LaraGigs app is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
