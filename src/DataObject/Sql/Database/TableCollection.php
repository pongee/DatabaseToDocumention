<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumention\DataObject\Sql\Database;

class TableCollection implements TableCollectionInterface
{
    /** @var TableInterface[] */
    private $tables = [];

    public function add(TableInterface $table): self
    {
        $this->tables[$table->getName()] = $table;

        return $this;
    }

    public function remove(TableInterface $table): self
    {
        unset($this->tables[$table->getName()]);

        return $this;
    }

    public function rewind(): void
    {
        reset($this->tables);
    }

    public function current(): ?TableInterface
    {
        return current($this->tables) ?: null;
    }

    public function key(): string
    {
        return key($this->tables);
    }

    public function next(): ?TableInterface
    {
        return next($this->tables) ?:null;
    }

    public function valid(): bool
    {
        return $this->current() instanceof TableInterface;
    }

    public function offsetGet(string $tableName): ?TableInterface
    {
        return isset($this->tables[$tableName]) ? $this->tables[$tableName] :null;
    }

    public function toArray(): array
    {
        return $this->tables;
    }
}
