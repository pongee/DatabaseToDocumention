<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumention\DataObject\Sql\Database;

use Iterator;

interface TableCollectionInterface extends Iterator
{
    public function add(TableInterface $table);

    public function rewind(): void;

    public function current(): ?TableInterface;

    public function key(): string;

    public function next(): ?TableInterface;

    public function valid(): bool;

    public function offsetGet(string $tableName): ?TableInterface;

    public function toArray(): array;
}
