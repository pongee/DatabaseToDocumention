<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\DataObject\Sql\Database;

use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\ColumnCollectionInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\ColumnInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\FulltextIndexCollectionInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\FulltextIndexInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\PrimaryKeyInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\SimpleIndexCollectionInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\SimpleIndexInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\SpatialIndexCollectionInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\SpatialIndexInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\UniqueIndexCollectionInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\UniqueIndexInterface;

interface TableInterface
{
    public function __construct();

    public function getName(): string;

    public function setName(string $name);

    public function setPrimaryKey(PrimaryKeyInterface $primaryKey);

    public function addColumn(ColumnInterface $column);

    public function addSimpleIndex(SimpleIndexInterface $index);

    public function addUniqueIndex(UniqueIndexInterface $unique);

    public function addFullTextIndex(FulltextIndexInterface $fulltextIndex);

    public function addSpatialIndex(SpatialIndexInterface $spatialIndex);

    public function getColumns(): ColumnCollectionInterface;

    public function getPrimaryKey(): ?PrimaryKeyInterface;

    public function getSimpleIndexes(): SimpleIndexCollectionInterface;

    public function getUniqueIndexes(): UniqueIndexCollectionInterface;

    public function getFulltextIndexes(): FulltextIndexCollectionInterface;

    public function getSpatialIndexes(): SpatialIndexCollectionInterface;
}
