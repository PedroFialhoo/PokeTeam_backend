## How to Run the Project

### Install dependencies
    composer install
    
### Create the .env file
    copy .env.example .env

### Set up the database in .env
    DB_CONNECTION=mysql
    DB_PORT=3306
    DB_DATABASE=poketeam
    DB_USERNAME=root
    DB_PASSWORD=

### Generate the application key
    php artisan key:generate

### Run migrations
    php artisan migrate

### Start the server
    php artisan serve

### Server running at:
    http://localhost:8000
