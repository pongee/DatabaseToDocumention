<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index;

interface SpatialIndexCollectionInterface extends \Iterator
{
    public function add(SpatialIndexInterface $key);

    public function rewind(): void;

    public function current(): ?SpatialIndexInterface;

    public function key(): ?int;

    public function next(): ?SpatialIndexInterface;

    public function valid(): bool;
}
