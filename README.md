# Ioannis Chantzis Assignment


## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [Running Migrations](#running-migrations)
- [Start schedule worker](#start-schedule-worker)
- [Serve the Application](#serve-the-application)
- [Technology Stack](#technology-stack)


## Requirements

- PHP 8.3
- Redis
- MariaDB


## Installation


1. **Clone the Repository**:

   To clone the repo, run the following: `git clone https://github.com/ichantzi/aylo_exercise.git`


2. **Install Composer Dependencies**:

   Navigate to the project directory and install composer with: `composer install`


3. **Create Environment File**:

   run the following command to create the .env file: `cp .env.example .env`

   Paste the following inside the .env file you created:


    APP_NAME=PornstarFeed
    APP_ENV=local
    APP_KEY= <your generated key>
    APP_DEBUG=true
    APP_TIMEZONE=UTC
    APP_URL=http://localhost

    APP_LOCALE=en
    APP_FALLBACK_LOCALE=en
    APP_FAKER_LOCALE=en_US
    
    APP_MAINTENANCE_DRIVER=file
    APP_MAINTENANCE_STORE=database
    
    BCRYPT_ROUNDS=12
    
    LOG_CHANNEL=stack
    LOG_STACK=single
    LOG_DEPRECATIONS_CHANNEL=null
    LOG_LEVEL=debug
    
    DB_CONNECTION=mariadb
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=pornstarfeed
    DB_USERNAME= U
    DB_PASSWORD= P
    
    SESSION_DRIVER=database
    SESSION_LIFETIME=120
    SESSION_ENCRYPT=false
    SESSION_PATH=/
    SESSION_DOMAIN=null
    
    BROADCAST_CONNECTION=log
    FILESYSTEM_DISK=local
    QUEUE_CONNECTION=database
    
    CACHE_STORE=database
    CACHE_PREFIX=
    
    MEMCACHED_HOST=127.0.0.1
    
    REDIS_CLIENT=phpredis
    REDIS_HOST=127.0.0.1
    REDIS_PASSWORD=null
    REDIS_PORT=6379
    
    MAIL_MAILER=log
    MAIL_HOST=127.0.0.1
    MAIL_PORT=2525
    MAIL_USERNAME=null
    MAIL_PASSWORD=null
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS="hello@example.com"
    MAIL_FROM_NAME="${APP_NAME}"
    
    AWS_ACCESS_KEY_ID=
    AWS_SECRET_ACCESS_KEY=
    AWS_DEFAULT_REGION=us-east-1
    AWS_BUCKET=
    AWS_USE_PATH_STYLE_ENDPOINT=false
    
    VITE_APP_NAME="${APP_NAME}"


4. **Generate Application Key**:
   run the following command and replace the APP_KEY value with the one generated: `php artisan key:generate`

## Database Setup

1. **Database Creation**:

   Make sure MariaDB is installed and running on your system.
   Access the MySQL shell and type the following: `mysql -u root -p`

2. **Create a new database**:

   After you successfully into the MySQL Shell, create the DataBase: CREATE DATABASE pornstarfeed;

3. **DB User**

   If necessary, create a database user and grant privileges:

   `CREATE USER 'username'@'localhost' IDENTIFIED BY 'password';`

   `GRANT ALL PRIVILEGES ON pornstarfeed.* TO 'username'@'localhost';`

   `FLUSH PRIVILEGES;`


    NOTE: the <username> <password> values you enter above, must be assigned as values to the DB_USERNAME, DB_PASSWORD variables

## Running Migrations & Seed database/redis

To migrate the Database, run the following command: `php artisan migrate`

To fetch data and seed the Database with data from the json file, run : `php artisan fetch:pornstardata`

After the previous command has fihished, download and cache images with the following command: `php artisan download:pornstar-images`

## Start schedule worker

Open a new terminal window for the scheduler ad run the following: `php artisan schedule:work`. 

The worker will run the fetch command to update data every hour.

## Serve the Application

Finally, to serve the application run: `php artisan serve`

On a separate terminal window, also run `npm run dev` for the frontend 

The app will run on 127.0.0.1 (localhost)

## Technology Stack

The technology stack used for this application was:

- Laravel 11
- Vue3
- MariaDB
- Redis
