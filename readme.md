# Human Resource Management System

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)


Human Resource Management System is a combination of systems and processes that connect human resource management and information technology through HRMS software.

Each module performs a separate function within the HRMS that helps with information gathering or tracking. HRMS modules can assist with:
1. Employee Management
2. Leave Management
3. Attendance Management
4. Team Management
5. Asset/Resource Management 

## Official Documentation of Framework

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Contribution for the project


    1. Fork it
    2. Create your feature branch (git checkout -b my-new-feature)
    3. Make your changes
    4. Run the tests, adding new ones for your own code if necessary (phpunit)
    5. Commit your changes (git commit -am 'Added some feature')
    6. Push to the branch (git push origin my-new-feature)
    7. Create new Pull Request

## Project License

The project is available to be used freely for personal and educational purposes, cloning the project does not gives you any rights to sell it online/offline.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

## Requirement

1. PHP version 5.6+
2. [PHP Mcrypt](http://php.net/manual/en/book.mcrypt.php)
3. [PHP Mysql](http://php.net/manual/en/ref.pdo-mysql.php)
4. [Composer](https://getcomposer.org/)
5. [mbstring](http://php.net/manual/en/mbstring.installation.php)
6. [dom extention](http://php.net/manual/en/dom.setup.php)

## Installation

It is preferred to have git setup installed on your local system.

Once downloaded/cloned go to the project directory on terminal/command line and run composer install or composer.phar install

Once composer is installed, run migration: 

    php artisan migrate

After migration, run the database seeder: 

    php artisan db:seed
    
Once done migrating and seeding you will have default user:

    email: email@gmail.com
    password: 123456   
  
### Credit to the original developer, kmanjari - https://github.com/kmanjari/hrms
