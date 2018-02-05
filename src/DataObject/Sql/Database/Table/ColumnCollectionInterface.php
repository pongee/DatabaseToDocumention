<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table;

interface ColumnCollectionInterface extends \Iterator
{
    public function add(ColumnInterface $column);

    public function rewind(): void;

    public function current(): ?ColumnInterface;

    public function key(): string;

    public function next(): ?ColumnInterface;

    public function valid(): bool;

    public function offsetGet(string $columnName): ?ColumnInterface;

    public function getColumnsName(): array;
}
