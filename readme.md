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

## Contribution for the framework

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Contribution for the project


    1. Fork it
    2. Create your feature branch (git checkout -b my-new-feature)
    3. Make your changes
    4. Run the tests, adding new ones for your own code if necessary (phpunit)
    5. Commit your changes (git commit -am 'Added some feature')
    6. Push to the branch (git push origin my-new-feature)
    7. Create new Pull Request


## Security Vulnerabilities of framework

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## Security Vulnerabilities of project

If you discover a security vulnerability within the project, please send an e-mail to Kanak Manjari at kanakmanjari@gmail.com. All security vulnerabilities will be promptly addressed.


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

## How can I support developers ?
* Star our GitHub repo :star:
* Create pull requests, submit bugs, suggest new features or documentation updates :wrench:
* Hire us for your next project :heart:

## Installation

It is preferred to have git setup installed on your local system.

If you have git on your local, run git clone https://github.com/kmanjari/hrms.git else you can download the zip https://github.com/kmanjari/hrms/archive/master.zip

Once downloaded/cloned go to the project directory on terminal/command line and run composer install or composer.phar install

Once composer is installed, run migration: 

    php artisan migrate

After migration, run the database seeder: 

    php artisan db:seed
    
Once done migrating and seeding you will have default user:

    email: test@demo.com
    password: 123456
    
Demo version of the project can be found over [here](http://hrms.kanakmanjari.com)    
  
