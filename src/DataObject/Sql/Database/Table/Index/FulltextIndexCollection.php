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

    public function getIterator(): FulltextIndexIterator
    {
        return new FulltextIndexIterator($this->fulltextIndexs);
    }
}
