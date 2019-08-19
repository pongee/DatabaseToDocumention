<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\DataObject\Sql\Database;

use IteratorAggregate;

interface TableCollectionInterface extends IteratorAggregate
{
    public function add(TableInterface $table);

    public function getIterator(): TableIterator;

    public function jsonSerialize(): array;
}
