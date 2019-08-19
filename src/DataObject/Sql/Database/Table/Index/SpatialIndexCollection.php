<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index;

class SpatialIndexCollection implements SpatialIndexCollectionInterface
{
    /** @var SpatialIndexInterface[] */
    private $spatialIndexs = [];

    public function add(SpatialIndexInterface $spatialIndex): self
    {
        $this->spatialIndexs[] = $spatialIndex;

        return $this;
    }

    public function rewind(): void
    {
        reset($this->spatialIndexs);
    }

    public function current(): ?SpatialIndexInterface
    {
        return current($this->spatialIndexs) ?: null;
    }

    public function key(): ?int
    {
        return key($this->spatialIndexs) ?: null;
    }

    public function next(): ?SpatialIndexInterface
    {
        return next($this->spatialIndexs) ?: null;
    }

    public function valid(): bool
    {
        return $this->current() instanceof SpatialIndexInterface;
    }
}
