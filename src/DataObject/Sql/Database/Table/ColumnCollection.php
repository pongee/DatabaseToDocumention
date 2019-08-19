<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table;

class ColumnCollection implements ColumnCollectionInterface
{
    /** @var ColumnInterface[] */
    private $columns = [];

    public function add(ColumnInterface $column)
    {
        $this->columns[$column->getName()] = $column;
    }

    public function rewind(): void
    {
        reset($this->columns);
    }

    public function current(): ?ColumnInterface
    {
        return current($this->columns) ?: null;
    }

    public function key(): string
    {
        return key($this->columns);
    }

    public function next(): ?ColumnInterface
    {
        return next($this->columns) ?: null;
    }

    public function valid(): bool
    {
        return $this->current() instanceof ColumnInterface;
    }

    public function offsetGet(string $columnName): ?ColumnInterface
    {
        return isset($this->columns[$columnName]) ? $this->columns[$columnName] : null;
    }

    public function getColumnsName(): array
    {
        return array_keys($this->columns);
    }
}
