<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\DataObject\Sql;

use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Connection\ConnectionCollectionInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Connection\ConnectionInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\TableCollection;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\TableCollectionInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\TableInterface;

class Schema implements SchemaInterface
{
    /** @var TableCollectionInterface */
    protected $tableCollection;

    /** @var ConnectionCollectionInterface */
    protected $connectionCollection;

    public function __construct()
    {
        $this->tableCollection = new TableCollection();
        $this->connectionCollection = new ConnectionCollection();
    }

    public function addTable(TableInterface $table): self
    {
        $this->tableCollection->add($table);

        return $this;
    }

    public function getTables(): TableCollectionInterface
    {
        return $this->tableCollection;
    }

    public function addConnection(ConnectionInterface $connection): self
    {
        $this->connectionCollection->add($connection);

        return $this;
    }

    public function getConnections(): ConnectionCollection
    {
        return $this->connectionCollection;
    }
}
