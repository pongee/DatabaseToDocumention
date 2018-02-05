<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumention\Test\Unit\DataObject\Sql\Database;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\TableCollection;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\TableCollectionInterface;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\TableInterface;

class TableCollectionTest extends TestCase
{
    public function getTablesProvider(): array
    {
        return [
            [
                new Table('member'),
            ],
            [
                new Table('account'),
            ],
            [
                new Table('member'),
                new Table('account'),
                new Table('log'),
            ],
        ];
    }

    public function testInstanceOf(): void
    {
        $tableCollection = new TableCollection();

        $this->assertInstanceOf(TableCollectionInterface::class, $tableCollection);
    }

    /**
     * @dataProvider getTablesProvider
     */
    public function testTables(TableInterface ...$tables): void
    {
        $tableCollection = new TableCollection();

        $tableNames = [];
        foreach ($tables as $table) {
            $tableNames[] = $table->getName();

            $tableCollection->add($table);

            $this->assertEquals($table, $tableCollection->offsetGet($table->getName()));
        }

        foreach ($tableCollection as $tableName => $table) {
            $this->assertEquals($tableName, $table->getName());
            $this->assertTrue(in_array($table->getName(), $tableNames));
        }

        $this->assertTrue(is_array($tableCollection->toArray()));
    }
}
