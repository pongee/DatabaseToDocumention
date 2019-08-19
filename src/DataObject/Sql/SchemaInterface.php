<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\DataObject\Sql;

use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Connection\ConnectionInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\TableCollectionInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\TableInterface;

interface SchemaInterface
{
    public function addTable(TableInterface $table);

    public function getTables(): TableCollectionInterface;

    public function addConnection(ConnectionInterface $connection);

    public function getConnections(): ConnectionCollection;
}
