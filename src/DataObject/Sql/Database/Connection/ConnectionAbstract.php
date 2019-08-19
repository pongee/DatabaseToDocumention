<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Connection;

abstract class ConnectionAbstract implements ConnectionInterface
{
    /** @var string */
    protected $childTablename;

    /** @var string */
    protected $parentTableName;

    /** @var array */
    protected $childTableColumns;

    /** @var array */
    protected $parentTableColumns;

    public function __construct(
        string $childTablename,
        string $parentTableName,
        array $childTableColumns,
        array $parentTableColumns
    ) {
        $this->childTablename     = $childTablename;
        $this->parentTableName    = $parentTableName;
        $this->childTableColumns  = $childTableColumns;
        $this->parentTableColumns = $parentTableColumns;
    }

    public function getChildTableName(): string
    {
        return $this->childTablename;
    }

    public function getParentTableName(): string
    {
        return $this->parentTableName;
    }

    public function getChildTableColumns(): array
    {
        return $this->childTableColumns;
    }

    public function getParentTableColumns(): array
    {
        return $this->parentTableColumns;
    }
}
