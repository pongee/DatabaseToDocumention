# Database documention generator

[![Latest Stable Version](https://img.shields.io/packagist/v/pongee/database-to-documention.svg?style=flat-square)](https://packagist.org/packages/pongee/database-to-documention)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.1-8892BF.svg?style=flat-square)](https://php.net/)
[![Build Status](https://travis-ci.org/pongee/database-to-documention.svg?branch=master)](https://travis-ci.org/pongee/database-to-documention)

## Project goal
The aim of this project is to generate database documention from sql schema.

## Supported databases
- MySQL
- MariaDB

## Supported Output formats
- Plantuml diagram
- Json

## Installation
```bash
$ composer require pongee/database-to-documentation "^0.1"
```
## Usage
### In console
#### Json export

```bash
$  php71 ./database-to-documention mysql:json ./my_mysql_schema_export.sql
```

#### Plantuml export
```bash
$  php71 ./database-to-documention mysql:plantuml ./my_mysql_schema_export.sql
```

### PHP
```php
<?php

use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseToDocumention\Export\Json;
use Pongee\DatabaseToDocumention\Parser\MysqlParser;

include './vendor/autoload.php';

$sqlSchema = '
  CREATE TABLE IF NOT EXISTS `foo` (
    `id` INT(10) UNSIGNED NOT NULL
   ) ENGINE=innodb DEFAULT CHARSET=utf8;
';

$mysqlParser                = new MysqlParser();
$jsonExport                 = new Json(); // or use new Plantuml();
$forcedConnectionCollection = new ConnectionCollection();

$schema = $mysqlParser->run($sqlSchema, $forcedConnectionCollection);

print $jsonExport->export($schema);
```

This will generate:

```json
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
                    "otherParameters": "UNSIGNED NOT NULL"
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
```
