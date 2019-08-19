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

    public function getIterator(): UniqueIndexIterator
    {
        return new UniqueIndexIterator($this->uniqueIndexs);
    }
}
