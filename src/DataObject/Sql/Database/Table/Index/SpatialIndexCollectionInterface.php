<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index;

use IteratorAggregate;

interface SpatialIndexCollectionInterface extends IteratorAggregate
{
    public function add(SpatialIndexInterface $key);

    public function getIterator(): SpatialIndexIterator;
}
