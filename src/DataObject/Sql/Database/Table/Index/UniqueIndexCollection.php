<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index;

class UniqueIndexCollection implements UniqueIndexCollectionInterface
{
    /** @var UniqueIndexInterface[] */
    private $uniqueIndexs = [];

    public function add(UniqueIndexInterface $uniqueIndex): self
    {
        $this->uniqueIndexs[] = $uniqueIndex;

        return $this;
    }

    public function rewind(): void
    {
        reset($this->uniqueIndexs);
    }

    public function current(): ?UniqueIndexInterface
    {
        return current($this->uniqueIndexs) ?: null;
    }

    public function key(): ?int
    {
        return key($this->uniqueIndexs) ?: null;
    }

    public function next(): ?UniqueIndexInterface
    {
        return next($this->uniqueIndexs) ?: null;
    }

    public function valid(): bool
    {
        return $this->current() instanceof UniqueIndexInterface;
    }
}
