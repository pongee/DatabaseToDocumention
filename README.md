# Database documentation generator

[![Latest Stable Version](https://img.shields.io/packagist/v/pongee/database-to-documentation.svg)](https://packagist.org/packages/pongee/database-to-documentation)
[![Minimum PHP Version](https://img.shields.io/packagist/php-v/pongee/database-to-documentation)](https://php.net/)
[![License](https://img.shields.io/github/license/pongee/database-to-documentation)](https://github.com/pongee/database-to-documentation/blob/master/LICENSE)
[![Build Status](https://travis-ci.org/pongee/database-to-documentation.svg?branch=master)](https://travis-ci.org/pongee/database-to-documentation)
![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/pongee/database-to-documentation)

## Project goal
The aim of this project is to generate database documentation from sql schema.

## Supported databases
- MySQL
- MariaDB

## Supported Output formats
- PNG, SVG image
- Plantuml raw text
- Json

## Pre Installation
- https://graphviz.gitlab.io/download/

## Installation

```bash
$ composer require pongee/database-to-documentation
or add it the your composer.json and make a composer update pongee/database-to-documentation.
```
## Usage
### In console
#### PNG export
```bash
$  php ./database-to-documentation mysql:image ./example/schema/sakila.sql > ./example/img/sakila.png
$  php ./database-to-documentation mysql:image --type png ./example/schema/sakila.sql > ./example/img/sakila.png
```
Output:
![Example output](example/img/sakila.png?raw=true "Output")

#### SVG export
```bash
$  php ./database-to-documentation mysql:image --type svg ./example/schema/sakila.sql > ./example/img/sakila.svg
```

#### Json export
```bash
$  php ./database-to-documentation mysql:json ./example/schema/sakila.sql
```
#### Plantuml export
```bash
$  php ./database-to-documentation mysql:plantuml ./example/schema/sakila.sql
```

### PHP
#### Png export
```php
<?php declare(strict_types=1);

use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseToDocumentation\Export\Plantuml;
use Pongee\DatabaseToDocumentation\Generator\ImageGenerator;
use Pongee\DatabaseToDocumentation\Parser\MysqlParser;

include __DIR__ . '/../../vendor/autoload.php';

$sqlSchema = '
  CREATE TABLE IF NOT EXISTS `foo` (
    `id` INT(10) UNSIGNED NOT NULL COMMENT "The id"
   ) ENGINE=innodb DEFAULT CHARSET=utf8;
';

$mysqlParser                = new MysqlParser();
$plantumlExport             = new Plantuml(file_get_contents(__DIR__ . '/../../src/Template/Plantuml/v1.twig'));
$forcedConnectionCollection = new ConnectionCollection();
$imageGenerator             = new ImageGenerator(
    'png',
    __DIR__ . '/../../bin/plantuml.jar',
    __DIR__ . '/../../tmp/'
);

$schema = $mysqlParser->run($sqlSchema, $forcedConnectionCollection);

print $imageGenerator->generate($plantumlExport->export($schema));
```
#### Json export
```php
<?php declare(strict_types=1);

use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseToDocumentation\Export\Json;
use Pongee\DatabaseToDocumentation\Parser\MysqlParser;

include './vendor/autoload.php';

$sqlSchema = '
  CREATE TABLE IF NOT EXISTS `foo` (
    `id` INT(10) UNSIGNED NOT NULL COMMENT "The id"
   ) ENGINE=innodb DEFAULT CHARSET=utf8;
';

$mysqlParser                = new MysqlParser();
$jsonExport                 = new Json();
$forcedConnectionCollection = new ConnectionCollection();

$schema = $mysqlParser->run($sqlSchema, $forcedConnectionCollection);

print $jsonExport->export($schema);
```

<details>
  <summary>This will generate:</summary>
  <div>
    <pre>
{
    "tables": {
        "foo": {
            "columns": [
                {
                    "name": "id",
                    "type": "INT",
                    "typeParameters": [
                        "10"
                    ],
                    "otherParameters": "UNSIGNED NOT NULL",
                    "comment": "The id"
                }
            ],
            "indexs": {
                "simple": [],
                "spatial": [],
                "fulltext": [],
                "unique": []
            },
            "primaryKey": []
        }
    },
    "connections": []
}
    <pre>
   <div>
</details>
