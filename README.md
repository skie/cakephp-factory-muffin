# CakePHP FactoryMuffin Integration Plugin

Plugin integrates FactoryMuffin and Faker for seeding and testing.


### Provided features
- CakePHP ORM integration for FactoryMuffin.
- Easy to inject into your project.

## Installing

[PHP](https://php.net) 5.6+ and [Composer](https://getcomposer.org) are required.

In your composer.json, simply add `"skie/cakephp-factory-muffin": "*"` to your `"require"` section:
```json
{
    "require": {
        "skie/cakephp-factory-muffin": "*"
    }
}
```

## Factory definition.

Define factory classes in `App\Model\Factory` namespace for application level, in `${PluginScope}\Model\Factory` for plugins.

Each factory class should contain definition method that describe how to create entity.

By convention factory classes should match with Table classes name but with `Factory` suffix.

```php

namespace App\Model\Factory;

use CakephpFactoryMuffin\Model\Factory\AbstractFactory;
use League\FactoryMuffin\Faker\Facade as Faker;

class UsersFactory extends AbstractFactory {

    public function definition()
    {
        return [
            'first_name' => Faker::firstName(),
            'last_name' => Faker::lastName(),
            'username' => function ($object, $saved) {
                return strtolower($object['last_name'] . '_' . $object['first_name']);
            },
            'password' => Faker::word(),
        ];
    }
}
```

## Usage

In tests or seed files you can use `CakephpFactoryMuffin\FactoryLoader` objects that manage Factory loading and 
dispatch creation process to FactoryMuffin.

This class perform cakephp orm integration with FactoryMuffin and serve cakephp tables naming conventions like 'Users', or 'Plugin.Records'.

To load factory definition one can use ```FactoryLoader::load('Users')```.
To load all applicaiton level factories use ```FactoryLoader::loadAll()```.
And to load factories for plugin Plugin/Name use ```FactoryLoader::loadAll('Plugin/Name')```.

## Example

```php
FactoryLoader::load('Users');
$user = FactoryLoader::create('Users');
$users = FactoryLoader::seed(10, 'Users');
```

Here created 11 users records in database.

## In tests we need to flush created objects. It could be achieved by call

```php
FactoryLoader::getInstance()->getFactoryMuffin()->deleteSaved();
```
