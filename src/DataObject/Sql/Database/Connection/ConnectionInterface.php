<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Connection;

interface ConnectionInterface
{
    public function __construct(
        string $childTableName,
        string $parentTableName,
        array $childTableColumns,
        array $parentTableColumns
    );

    public function getChildTableName(): string;

    public function getParentTableName(): string;

    public function getType(): string;

    public function getChildTableColumns(): array;

    public function getParentTableColumns(): array;
}
