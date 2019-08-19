<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\DataObject\Sql\Database;

use ArrayIterator;

class TableIterator extends ArrayIterator
{
    public function current(): ?TableInterface
    {
        return parent::current();
    }
}
