# FileUpload
File Upload written in PHP and Laravel

## Technologies used
PHP 8
Laravel 8
Composer
Jetstream
Laravel Sail
Jquery
Bootstrap
Xdebug
docker
MySQL

## Install 
Just clone the project, and run the commands
```
  composer install
  vendor/bin/sail up
```

Also, you must set the ROOT_FILES_PATH on .env file,
poiting to the directory where the files will be stored.

## Login
After install it, you can register at this URL:
    http://localhost/register
After register, if the page doesn't redirect correctly, you can access it at this URL:
    http://localhost/files
If you have problems uploading files, verify if a directory with your ID was created at the ROOT_FILES_PATH directory.
 
## Project explanation
I used my new Laravel skills to build this application.
I created a database table to store uploaded files info, as well as unit tests, migrations, and factories to test the models.
Also, I created a service library, where lives all the application's business logic.
For docker, I used Laravel Sail to create the docker-compose file. But I modified the default Sail configuration to install Xdebug, so I could
debug it better on VSCode. Also, all the forms are implemented with CRSF token.
