<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index;

class FulltextIndexCollection implements FulltextIndexCollectionInterface
{
    /** @var FulltextIndexInterface[] */
    private $fulltextIndexs = [];

    public function add(FulltextIndexInterface $fulltextIndexs): self
    {
        $this->fulltextIndexs[] = $fulltextIndexs;

        return $this;
    }

    public function rewind(): void
    {
        reset($this->fulltextIndexs);
    }

    public function current(): ?FulltextIndexInterface
    {
        return current($this->fulltextIndexs) ?: null;
    }

    public function key(): ?int
    {
        return key($this->fulltextIndexs) ?: null;
    }

    public function next(): ?FulltextIndexInterface
    {
        return next($this->fulltextIndexs) ?: null;
    }

    public function valid(): bool
    {
        return $this->current() instanceof FulltextIndexInterface;
    }
}
