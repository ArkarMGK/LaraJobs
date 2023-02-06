### Database Setup
This app uses MySQL. To use something different, open up config/Database.php and change the default driver.

To use MySQL, make sure you install it, setup a database and then add your db credentials(database, username and password) to the .env.example file and rename it to .env

### Run These commands after database set up..
composer install (OR composer update if your php version is lower)

php artisan key:generate

php artisan migrate

php artisan db:seed

php artisan serve

#Note
After database seeding, two user accounts (admin and testuser) are already provided
Use 'localhost:8000/admin' to log in as admin.

## License

The LaraJobs app is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
