<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumention\DataObject\Sql\Database;

use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\ColumnCollection;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\ColumnCollectionInterface;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\ColumnInterface;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\FulltextIndexCollection;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\FulltextIndexCollectionInterface;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\FulltextIndexInterface;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\PrimaryKeyInterface;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\SimpleIndexCollection;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\SimpleIndexCollectionInterface;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\SimpleIndexInterface;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\SpatialIndexCollection;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\SpatialIndexCollectionInterface;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\SpatialIndexInterface;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\UniqueIndexCollection;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\UniqueIndexCollectionInterface;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\UniqueIndexInterface;

class Table implements TableInterface
{
    /** @var string */
    private $name = '';

    /** @var ColumnCollectionInterface */
    private $columns;

    /** @var PrimaryKeyInterface */
    private $primaryKey = null;

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
        $this->primaryKey     = null;
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
