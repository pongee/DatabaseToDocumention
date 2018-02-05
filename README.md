# Database documention generator

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
