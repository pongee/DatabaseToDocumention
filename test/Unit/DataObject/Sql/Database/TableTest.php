<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\Test\Unit\DataObject\Sql\Table\Database;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\ColumnInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\FulltextIndex;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\FulltextIndexInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\PrimaryKeyInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\SimpleIndex;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\SimpleIndexInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\SpatialIndex;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\SpatialIndexInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\UniqueIndex;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\UniqueIndexInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\TableInterface;

class TableTest extends TestCase
{
    public function getNamesProvider(): array
    {
        return [
            ['member'],
            ['account'],
        ];
    }

    public function getPrimaryKeysProvider(): array
    {
        return [
            [new PrimaryKey(['member'])],
            [new PrimaryKey(['account'], 'USING HASH')],
        ];
    }

    public function getColumnsDataProvider(): array
    {
        return [
            [
                new Column('id', 'INT', [10], 'NOT NULL', 'The id'),
            ],
            [
                new Column('type', 'VARCHAR', [64], 'NOT NULL', 'The type'),
            ],
            [
                new Column('id', 'INT', [10], 'NOT NULL', 'The id'),
                new Column('type', 'VARCHAR', [64], 'NOT NULL', 'The type'),
            ],
        ];
    }

    public function getKeysDataProvider(): array
    {
        return [
            [
                new SimpleIndex('idx_id', ['id']),
            ],
            [
                new SimpleIndex('idx_id', ['id']),
                new SimpleIndex('idx_id_name', ['id', 'name']),
            ],
        ];
    }

    public function getUniqueIndexesDataProvider(): array
    {
        return [
            [
                new UniqueIndex('idx_id', ['id']),
            ],
            [
                new UniqueIndex('idx_id', ['id']),
                new UniqueIndex('idx_id_name', ['id', 'name']),
            ],
        ];
    }

    public function getFulltextIndexesDataProvider(): array
    {
        return [
            [
                new FulltextIndex('idx_id', ['id']),
            ],
            [
                new FulltextIndex('idx_id', ['id']),
                new FulltextIndex('idx_id_name', ['id', 'name']),
            ],
        ];
    }

    public function getSpatialIndexesDataProvider(): array
    {
        return [
            [
                new SpatialIndex('idx_id', ['id']),
            ],
            [
                new SpatialIndex('idx_id', ['id']),
                new SpatialIndex('idx_id_name', ['id', 'name']),
            ],
        ];
    }

    public function testInstanceOf(): void
    {
        $sut = new Table();

        $this->assertInstanceOf(TableInterface::class, $sut);
    }

    /**
     * @dataProvider getNamesProvider
     */
    public function testName(string $name): void
    {
        $sut = new Table();
        $sut->setName($name);

        $this->assertEquals($name, $sut->getName());
    }

    /**
     * @dataProvider getPrimaryKeysProvider
     */
    public function testPrimaryKey(PrimaryKeyInterface $primaryKey): void
    {
        $sut = new Table();

        $sut->setPrimaryKey($primaryKey);
        $this->assertEquals($primaryKey, $sut->getPrimaryKey());
    }

    /**
     * @dataProvider getColumnsDataProvider
     */
    public function testColumn(ColumnInterface ...$columns): void
    {
        $sut = new Table();

        foreach ($columns as $column) {
            $sut->addColumn($column);
        }

        foreach ($sut->getColumns() as $column) {
            $this->assertInstanceOf(ColumnInterface::class, $column);
        }
    }

    /**
     * @dataProvider getKeysDataProvider
     */
    public function testKey(SimpleIndexInterface ...$simpleIndexes): void
    {
        $sut = new Table();

        foreach ($simpleIndexes as $simpleIndex) {
            $sut->addSimpleIndex($simpleIndex);
        }

        foreach ($sut->getSimpleIndexes() as $simpleIndex) {
            $this->assertInstanceOf(SimpleIndexInterface::class, $simpleIndex);
            $this->assertTrue(in_array($simpleIndex, $simpleIndexes, true));
        }
    }

    /**
     * @dataProvider getUniqueIndexesDataProvider
     */
    public function testUniqueKey(UniqueIndexInterface ...$uniquekeys): void
    {
        $sut = new Table();

        foreach ($uniquekeys as $uniquekey) {
            $sut->addUniqueIndex($uniquekey);
        }

        foreach ($sut->getUniqueIndexes() as $uniqueIndex) {
            $this->assertInstanceOf(UniqueIndexInterface::class, $uniqueIndex);
            $this->assertTrue(in_array($uniqueIndex, $uniquekeys));
        }
    }

    /**
     * @dataProvider getFulltextIndexesDataProvider
     */
    public function testFulltextKey(FulltextIndexInterface ...$fulltextIndexes): void
    {
        $sut = new Table();

        foreach ($fulltextIndexes as $fulltextIndex) {
            $sut->addFullTextIndex($fulltextIndex);
        }

        foreach ($sut->getFulltextIndexes() as $fulltextIndex) {
            $this->assertInstanceOf(FulltextIndexInterface::class, $fulltextIndex);
            $this->assertTrue(in_array($fulltextIndex, $fulltextIndexes));
        }
    }

    /**
     * @dataProvider getSpatialIndexesDataProvider
     */
    public function testSpatialKey(SpatialIndexInterface ...$spatialIndexes): void
    {
        $sut = new Table();

        foreach ($spatialIndexes as $spatialIndex) {
            $sut->addSpatialIndex($spatialIndex);
        }

        foreach ($sut->getSpatialIndexes() as $spatialIndex) {
            $this->assertInstanceOf(SpatialIndexInterface::class, $spatialIndex);
            $this->assertTrue(in_array($spatialIndex, $spatialIndexes));
        }
    }
}
