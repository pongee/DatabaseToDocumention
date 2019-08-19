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

    public function getUniqueIndexsDataProvider(): array
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

    public function getFulltextIndexsDataProvider(): array
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

    public function getSpatialIndexsDataProvider(): array
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
        $table = new Table();

        $this->assertInstanceOf(TableInterface::class, $table);
    }

    /**
     * @dataProvider getNamesProvider
     */
    public function testName(string $name): void
    {
        $table = new Table();
        $table->setName($name);

        $this->assertEquals($name, $table->getName());
    }

    /**
     * @dataProvider getPrimaryKeysProvider
     */
    public function testPrimaryKey(PrimaryKeyInterface $primaryKey): void
    {
        $table = new Table();

        $table->setPrimaryKey($primaryKey);
        $this->assertEquals($primaryKey, $table->getPrimaryKey());
    }

    /**
     * @dataProvider getColumnsDataProvider
     */
    public function testColumn(ColumnInterface ...$columns): void
    {
        $table = new Table();

        foreach ($columns as $column) {
            $table->addColumn($column);
        }

        foreach ($table->getColumns() as $column) {
            $this->assertInstanceOf(ColumnInterface::class, $column);
        }
    }

    /**
     * @dataProvider getKeysDataProvider
     */
    public function testKey(SimpleIndexInterface ...$simpleIndexs): void
    {
        $table = new Table();

        foreach ($simpleIndexs as $simpleIndex) {
            $table->addSimpleIndex($simpleIndex);
        }

        foreach ($table->getSimpleIndexs() as $simpleIndex) {
            $this->assertInstanceOf(SimpleIndexInterface::class, $simpleIndex);
            $this->assertTrue(in_array($simpleIndex, $simpleIndexs, true));
        }
    }

    /**
     * @dataProvider getUniqueIndexsDataProvider
     */
    public function testUniqueKey(UniqueIndexInterface ...$uniquekeys): void
    {
        $table = new Table();

        foreach ($uniquekeys as $uniquekey) {
            $table->addUniqueIndex($uniquekey);
        }

        foreach ($table->getUniqueIndexs() as $uniqueIndex) {
            $this->assertInstanceOf(UniqueIndexInterface::class, $uniqueIndex);
            $this->assertTrue(in_array($uniqueIndex, $uniquekeys));
        }
    }

    /**
     * @dataProvider getFulltextIndexsDataProvider
     */
    public function testFulltextKey(FulltextIndexInterface ...$fulltextIndexs): void
    {
        $table = new Table();

        foreach ($fulltextIndexs as $fulltextIndex) {
            $table->addFullTextIndex($fulltextIndex);
        }

        foreach ($table->getFulltextIndexs() as $fulltextIndex) {
            $this->assertInstanceOf(FulltextIndexInterface::class, $fulltextIndex);
            $this->assertTrue(in_array($fulltextIndex, $fulltextIndexs));
        }
    }

    /**
     * @dataProvider getSpatialIndexsDataProvider
     */
    public function testSpatialKey(SpatialIndexInterface ...$spatialIndexs): void
    {
        $table = new Table();

        foreach ($spatialIndexs as $spatialIndex) {
            $table->addSpatialIndex($spatialIndex);
        }

        foreach ($table->getSpatialIndexs() as $spatialIndex) {
            $this->assertInstanceOf(SpatialIndexInterface::class, $spatialIndex);
            $this->assertTrue(in_array($spatialIndex, $spatialIndexs));
        }
    }
}
