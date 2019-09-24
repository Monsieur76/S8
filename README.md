ToDoList
========

## Install

### In the app/config/parameters.yml file
1. In DATABASE URL put your database url.
2. Download dependencies to compose.

### Before you put the site online
* Type the command `php bin/console doctrine:schema:create` this will create the database.
* Make the `php bin/console doctrine:schema:update ` command for the migration.
* Launch fixtures with the `php bin/console doctrine:fixture:load` command if you want to do some testing.
*If you want to test . Make the `vendor\bin\phpunit` for windows and 
`vendor/bin/phpunit` for linux
* Do your tests.

### Test for quality
[![Maintainability](https://api.codeclimate.com/v1/badges/b5d1516c3f762f72ec5f/maintainability)](https://codeclimate.com/github/Monsieur76/S8/maintainability)

### Contributing
[Contribut](https://github.com/Monsieur76/S8/blob/master/Contributing.md)
Github https://github.com/Monsieur76/S8
