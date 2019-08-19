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

    public function getIterator(): SpatialIndexIterator
    {
        return new SpatialIndexIterator($this->spatialIndexs);
    }
}
