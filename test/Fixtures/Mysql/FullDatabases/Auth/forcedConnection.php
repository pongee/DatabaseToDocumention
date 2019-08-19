<?php declare(strict_types=1);

use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Connection\NotDefinedConnection;

return (new ConnectionCollection())
    ->add(
        new NotDefinedConnection(
            'log',
            'user',
            ['user_id'],
            ['user_id']
        )
    );
