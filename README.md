## Requirements:
- Mysql 5.7 +
- PHP >=7.2.5
- Memcache 3.1.5
- see composer.json for PHP extensions and package requirements
## Features
- Download data on first access from https://mgtechtest.blob.core.windows.net/files/showcase.json
- Store data on two related entities: Movie and Image
- Cache images as base64 using Memcache
- Display paginated list of items with individual pages for each item
This project is based on the symfony 5 skeleton. 
    
## Installation
This is not a symfony bundle but a complete application built using the symfony skeleton    
First you will need to clone the repo (a new folder called showcase will be created):

    git clone https://github.com/romanady/showcase.git

Next you will need to install the package dependencies:

    composer install

#### Environment setup:
You will need to create an .env.local file in the root directory and update it with your configurations

    DATABASE_URL=mysql://user:password@host:port/databaseName?serverVersion=5.7
    MEMCAHE_DATA=memcached://localhost:11211
    DATA_URL=https://mgtechtest.blob.core.windows.net/files/showcase.json

Next you will have to create the database by running the following commands:

    #Create the database:
    bin/console doctrine:database:create
    
    #Create migrations
    bin/console make:migration
    
    #Run migrations
    bin/console doctrine:migrations:migrate
    
Or you can see the showcase here: http://adi.unisizero.ro/movie/