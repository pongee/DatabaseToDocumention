<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index;

class SimpleIndexCollection implements SimpleIndexCollectionInterface
{
    /** @var SimpleIndexInterface[] */
    private $simpleIndexs = [];

    public function add(SimpleIndexInterface $simpleIndex): self
    {
        $this->simpleIndexs[] = $simpleIndex;

        return $this;
    }

    public function rewind(): void
    {
        reset($this->simpleIndexs);
    }

    public function current(): ?SimpleIndexInterface
    {
        return current($this->simpleIndexs) ?: null;
    }

    public function key(): ?int
    {
        return key($this->simpleIndexs) ?: null;
    }

    public function next(): ?SimpleIndexInterface
    {
        return next($this->simpleIndexs) ?: null;
    }

    public function valid(): bool
    {
        return $this->current() instanceof SimpleIndexInterface;
    }
}
