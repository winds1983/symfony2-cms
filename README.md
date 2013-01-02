Symfony2 CMS
============

This is a CMS with Symfony 2.1.x

Features
--------

 - How to create a Symfony Bundle
 - Controller
    - How to render twig
    -- How to use Doctrine
    - How to get request data
 - Entity
    - Normal Entity and Form
    - Entity and Form with Doctrine ORM
    - Validate entity
    - CRUD
 - Twig
    - usage of Twig
    - How to create a Twig extension
 - To be continued

Installing
--------

## Step 1:

Download Symfony2 CMS 
* git clone https://github.com/winds1983/symfony2-cms.git

## Step 2:

To install symfony2-cms, do the following:

* cd symfony2-cms
* cp app/config/parameters.yml.dist app/config/parameters.yml
* curl -s https://getcomposer.org/installer | php
* php composer.phar install
* app/console assetic:dump

NOTE: you can use the following command:
* php composer.phar update

## Step 3:

* modify the database and email configuration in app/config/parameters.yml

* and set app/cache and app/logs folder
777 or 755 or 644

## Step 4:

 - create database:
    - php app/console doctrine:database:create
 - create table:
    - php app/console doctrine:schema:create

## Step 5:

config apache ...

It should now work. If you run into any issues, feel free to open a new issue or make a new pull request.
Please write your questions to [issues](https://github.com/winds1983/symfony2-cms/issues) if you have some questions.