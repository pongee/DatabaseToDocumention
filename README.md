# Database documentation generator

[![Latest Stable Version](https://img.shields.io/packagist/v/pongee/database-to-documentation.svg)](https://packagist.org/packages/pongee/database-to-documentation)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.1-8892BF.svg)](https://php.net/)
[![License](https://poser.pugx.org/pongee/database-to-documentation/license)](https://packagist.org/packages/pongee/database-to-documentation)
[![Build Status](https://travis-ci.org/pongee/database-to-documentation.svg?branch=master)](https://travis-ci.org/pongee/database-to-documentation)

## Project goal
The aim of this project is to generate database documentation from sql schema.

## Supported databases
- MySQL
- MariaDB

## Supported Output formats
- Plantuml diagram
- Json

## Installation
```bash
$ composer require pongee/database-to-documentation
or add it the your composer.json and make a composer update pongee/database-to-documentation.
```
## Usage
### In console
#### Json export

```bash
$  php71 ./database-to-documentation mysql:json ./my_mysql_schema_export.sql
```

#### Plantuml export
```bash
$  php71 ./database-to-documentation mysql:plantuml ./my_mysql_schema_export.sql
```

### PHP
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
$jsonExport                 = new Json(); // or use new Plantuml();
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
