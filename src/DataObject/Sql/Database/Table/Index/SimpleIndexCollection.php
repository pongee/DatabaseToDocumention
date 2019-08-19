<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index;

class SimpleIndexCollection implements SimpleIndexCollectionInterface
{
    /** @var SimpleIndexInterface[] */
    private $simpleIndexs = [];

    public function add(SimpleIndexInterface $simpleIndex): self
    {
        $this->simpleIndexs[] = $simpleIndex;

        return $this;
    }

    public function getIterator(): SimpleIndexIterator
    {
        return new SimpleIndexIterator($this->simpleIndexs);
    }
}
