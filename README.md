Symfony2 CMS
============

This is a CMS with Symfony 2.1.x

Features
============

1) How to create a Symfony Bundle
2) Controller
--- How to render twig
--- How to use Doctrine
--- How to get request data
3) Entity
--- Normal Entity and Form
--- Entity and Form with Doctrine ORM
--- Validate entity
--- CRUD
4) Twig
--- usage of Twig
--- How to create a Twig extension
5) ...

Installing
============

Step 1:
============
Download Symfony2 CMS
git clone https://github.com/winds1983/symfony2-cms.git

Step 2:
============
rename app/config/parameters.yml.dist to app/config/parameters.yml
then modify the database and email configuration

and set app/cache and app/logs folder
777 or 755 or 644

Step 3:
============
create database
php app/console doctrine:schema:create

Step 4:
config apache ...


Please write your questions to [issues](https://github.com/winds1983/symfony2-cms/issues) if you have some questions.