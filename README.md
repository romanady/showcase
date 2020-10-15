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
To install the framework run this command:

     composer create-project symfony/skeleton my_project_name

To install the module, you'll need to be sure that your root `composer.json` file contains a reference to the Showcase repository.  To do so, run the following command:

    composer config repositories.roman vcs https://github.com/romanady/showcase.git

Next, add the required package your root `composer.json` file:

    composer require romanady/showcase

#### Database connection
You will need to edit the .env file in the root directory and update the node DATABASE_URL:

    DATABASE_URL=mysql://user:password@host:port/databaseName?serverVersion=5.7

Next you will have to create the database by running the following commands:

    #Create the database:
    bin/console doctrine:database:create
    
    #Create migrations
    bin/console make:migration
    
    #Run migrations
    bin/console doctrine:migrations:migrate
    
#### Environment setup:

Add the following lines inside .env 

    MEMCAHE_DATA=memcached://localhost:11211
    DATA_URL=https://mgtechtest.blob.core.windows.net/files/showcase.json

    

    
