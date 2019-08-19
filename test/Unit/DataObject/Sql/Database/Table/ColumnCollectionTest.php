<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\Test\Unit\DataObject\Sql\Database\Table;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\ColumnCollection;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\ColumnCollectionInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\ColumnInterface;

class ColumnCollectionTest extends TestCase
{
    public function getColumnsProvider(): array
    {
        return [
            [
                new Column('member_id', 'INT', [10], 'NOT NULL', 'The member id'),
            ],
            [
                new Column('member_id', 'INT', [10], 'NOT NULL', 'The member id'),
                new Column('type', 'VARCHAR', [64], 'DEFAULT NULL', 'The type'),
            ],
            [
                new Column('member_id', 'INT', [10], 'NOT NULL', 'The member id'),
                new Column('type', 'VARCHAR', [64], 'NOT NULL', 'The type'),
                new Column('status', 'ENUM', ['enabled', 'deleted'], 'DEFAULT NUL', 'The status'),
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
