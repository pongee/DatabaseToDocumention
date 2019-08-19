<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\DataObject\Sql\Database;

use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\ColumnCollection;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\ColumnCollectionInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\ColumnInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\FulltextIndexCollection;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\FulltextIndexCollectionInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\FulltextIndexInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\PrimaryKeyInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\SimpleIndexCollection;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\SimpleIndexCollectionInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\SimpleIndexInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\SpatialIndexCollection;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\SpatialIndexCollectionInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\SpatialIndexInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\UniqueIndexCollection;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\UniqueIndexCollectionInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\UniqueIndexInterface;

class Table implements TableInterface
{
    /** @var string */
    private $name = '';

    /** @var ColumnCollectionInterface */
    private $columns;

    /** @var PrimaryKeyInterface */
    private $primaryKey;

    /** @var SimpleIndexCollectionInterface */
    private $simpleIndexs;

    /** @var UniqueIndexCollectionInterface */
    private $uniqueIndexs;

    /** @var FulltextIndexCollectionInterface */
    private $fulltextIndexs;

    /** @var SpatialIndexCollectionInterface */
    private $spatialIndexs;

    public function __construct()
    {
        $this->columns        = new ColumnCollection();
        $this->simpleIndexs   = new SimpleIndexCollection();
        $this->uniqueIndexs   = new UniqueIndexCollection();
        $this->fulltextIndexs = new FulltextIndexCollection();
        $this->spatialIndexs  = new SpatialIndexCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setPrimaryKey(PrimaryKeyInterface $primaryKey): self
    {
        $this->primaryKey = $primaryKey;

        return $this;
    }

    public function addColumn(ColumnInterface $column): self
    {
        $this->columns->add($column);

        return $this;
    }

    public function addSimpleIndex(SimpleIndexInterface $index): self
    {
        $this->simpleIndexs->add($index);

        return $this;
    }

    public function addUniqueIndex(UniqueIndexInterface $unique): self
    {
        $this->uniqueIndexs->add($unique);

        return $this;
    }

    public function addFullTextIndex(FulltextIndexInterface $fulltextIndex): self
    {
        $this->fulltextIndexs->add($fulltextIndex);

        return $this;
    }

    public function addSpatialIndex(SpatialIndexInterface $spatialIndex): self
    {
        $this->spatialIndexs->add($spatialIndex);

        return $this;
    }

    public function getColumns(): ColumnCollectionInterface
    {
        return $this->columns;
    }

    public function getPrimaryKey(): ?PrimaryKeyInterface
    {
        return $this->primaryKey;
    }

    public function getSimpleIndexs(): SimpleIndexCollectionInterface
    {
        return $this->simpleIndexs;
    }

    public function getUniqueIndexs(): UniqueIndexCollectionInterface
    {
        return $this->uniqueIndexs;
    }

    public function getFulltextIndexs(): FulltextIndexCollectionInterface
    {
        return $this->fulltextIndexs;
    }

    public function getSpatialIndexs(): SpatialIndexCollectionInterface
    {
        return $this->spatialIndexs;
    }
}
