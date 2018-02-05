<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumention\Test\Unit\DataObject\Sql\Database\Table;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\ColumnCollection;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\ColumnCollectionInterface;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\ColumnInterface;

class ColumnCollectionTest extends TestCase
{
    public function getColumnsProvider(): array
    {
        return [
            [
                new Column('member_id', 'INT', [10], 'NOT NULL'),
            ],
            [
                new Column('member_id', 'INT', [10], 'NOT NULL'),
                new Column('type', 'VARCHAR', [64], 'DEFAULT NULL'),
            ],
            [
                new Column('member_id', 'INT', [10], 'NOT NULL'),
                new Column('type', 'VARCHAR', [64], 'NOT NULL'),
                new Column('status', 'ENUM', ['enabled', 'deleted'], 'DEFAULT NUL'),
            ],
        ];
    }

    public function testInstanceOf(): void
    {
        $columnCollection = new ColumnCollection();

        $this->assertInstanceOf(ColumnCollectionInterface::class, $columnCollection);
    }

    /**
     * @dataProvider getColumnsProvider
     */
    public function testColumns(ColumnInterface ...$columns): void
    {
        $columnCollection = new ColumnCollection();

        $columnNames = [];
        foreach ($columns as $column) {
            $columnNames[] = $column->getName();

            $columnCollection->add($column);

            $this->assertEquals($column, $columnCollection->offsetGet($column->getName()));
        }

        foreach ($columnCollection as $oolumnName => $column) {
            $this->assertEquals($oolumnName, $column->getName());
        }

        $this->assertTrue(empty(array_diff($columnNames, $columnCollection->getColumnsName())));
    }
}
