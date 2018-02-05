<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumention\DataObject\Sql;

use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Connection\ConnectionInterface;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\TableCollectionInterface;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\TableInterface;

interface SchemaInterface
{
    public function addTable(TableInterface $table);

    public function getTables(): TableCollectionInterface;

    public function addConnection(ConnectionInterface $connection);

    public function getConnections(): ConnectionCollection;
}
